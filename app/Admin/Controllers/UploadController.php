<?php

namespace App\Admin\Controllers;

use App\Exceptions\SelfException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PictureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * 上传skimage图片处理
     * @param Request $request
     * @param PictureController $pictureController
     * @return array
     * Author: fatetis
     * Date:2019/10/11 001116:21
     */
    public function index(Request $request, PictureController $pictureController)
    {
        $path = $request->input('upload_url', '');
        $is_lock = $request->input('is_lock', 0);
        try {
            $file_key = key($request->file());
            if (!$request->file($file_key)->isValid()) {
                throw new SelfException('文件无效');
            }
            $file_extension = $request->$file_key->extension();
            $size = ceil($request->$file_key->getSize() / 1024); //转换为kb单位
            $filename = randStr() . "." . $file_extension;

            $filepath = urlStandard('skimage') . '/';
            if (!empty($path)) {
                $filepath = $path . '/';
            }

            if (!Storage::exists($filepath)) {
                Storage::makeDirectory($filepath);
            }
            $savepath = $filepath . $filename;

            $bool = Storage::put($savepath, file_get_contents($request->$file_key->getRealPath()));//上传
            if (!$bool) {
                throw new SelfException('文件保存失败');
            }
            //skimage图片form组件
            $createData = [
                'link' => $savepath,
                'size' => $size,
                'file_ext' => $file_extension,
                'file_name' => $filename,
                'is_lock' => $is_lock,
            ];
            // 保存图片数据
            $savepath = $pictureController->createMedia($createData);
            //约定处理接口
            if ($savepath->getstatusCode() !== $this->getStatusCode()) {
                throw new SelfException($savepath->getstatusText());
            }
            $data = $savepath->getData()->data->id;
            $src = Storage::url($savepath->getData()->data->link);
            return [
                "uploaded" => true,
                "fileName" => $filename,
                "url" => $data,
                "src" => $src,
                "error" => [
                    "message" => ''
                ]
            ];
        } catch (SelfException $e) {
            return [
                "uploaded" => false,
                "fileName" => '',
                "url" => '',
                "error" => [
                    "message" => '上传出错！' . $e->getMessage()
                ]
            ];
        }
    }
}

<?php

namespace App\Admin\Controllers;

use App\Exceptions\SelfException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * 上传skimage图片处理
     * @param Request $request
     * @param MediaController $MediaController
     * @return array
     * Author: fatetis
     * Date:2021/3/1216:12
     */
    public function index(Request $request, MediaController $MediaController)
    {
        try {
            $savepath = $this->uploadImageRequest($request, $MediaController);
            $data = $savepath->getData()->data->id;
            $src = $savepath->getData()->data->link;
            $filename = $savepath->getData()->data->file_name;
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
        } catch (\Exception $exception) {
            elog('图片上传抛出异常', $exception);
            return [
                "uploaded" => false,
                "fileName" => '',
                "url" => '',
                "error" => [
                    "message" => '上传出错！' . $exception->getMessage()
                ]
            ];
        }

    }


    /**
     * 富文本框wangeditor图片上传
     * @param Request $request
     * @param MediaController $MediaController
     * @return array|string[]
     * Author: fatetis
     * Date:2021/4/2410:44
     */
    public function editUploadImg(Request $request, MediaController $MediaController)
    {
        try {
            $savepath = $this->UploadMultiImageRequest($request, $MediaController);
            $data = collect($savepath)->map(function ($value) {
                return $value->getData()->data->link;
            });
            return [
                "errno" => 0,
                "data" => $data->toArray()
            ];
        } catch (SelfException $e) {
            return [
                'errno' => '上传出错！' . $e->getMessage()
            ];
        } catch (\Exception $exception) {
            elog('图片上传抛出异常', $exception);
            return [
                'errno' => '上传出错！' . $exception->getMessage()
            ];
        }

    }

    /**
     * 富文本wangeditor多图上传
     * @param $request
     * @param $mediaController
     * @return array
     * @throws SelfException
     * Author: fatetis
     * Date:2021/4/2410:44
     */
    public function UploadMultiImageRequest($request, $mediaController)
    {
        $path = $request->input('upload_url', '');
        $is_lock = $request->input('is_lock', 0);
        $file_key = key($request->file());
        $file = $request->$file_key;
        foreach ($file as $value){
            $arr[] = $this->uploadImage($path, $is_lock, $value, $mediaController);
        }
        return $arr ?? [];
    }

    /**
     * 单图图片上传
     * @param $request
     * @param $mediaController
     * @return mixed
     * @throws SelfException
     * Author: fatetis
     * Date:2021/3/1216:12
     */
    public function uploadImageRequest($request, $mediaController)
    {
        $path = $request->input('upload_url', '');
        $is_lock = $request->input('is_lock', 0);
        $file_key = key($request->file());
        $file = $request->$file_key;
        return $this->uploadImage($path, $is_lock, $file, $mediaController);
    }

    /**
     * 图片上传接口
     * @param $path
     * @param $is_lock
     * @param $file
     * @param $mediaController
     * @return mixed
     * @throws SelfException
     * Author: fatetis
     * Date:2021/4/2410:45
     */
    public function uploadImage($path, $is_lock, $file, $mediaController)
    {
        if (!$file->isValid())
            throw new SelfException('文件无效');
        $file_extension = $file->extension();
        $size = ceil($file->getSize() / 1024); //转换为kb单位
        $filename = randStr() . "." . $file_extension;
        /**
         * 自定义上传地址
         */
        $filepath = !empty($path) ? $path . '/' : urlStandard('skimage') . '/';
        /**
         * 校验目录是否存在，不存咋则创建上传目录
         */
        !Storage::exists($filepath) && Storage::makeDirectory($filepath);
        /**
         * 将图片内容导入指定文件
         */
        $savepath = $filepath . $filename;
        $bool = Storage::put($savepath, file_get_contents($file->getRealPath()));//上传
        if (!$bool) throw new SelfException('文件保存失败');
        /**
         * 数据组装
         */
        $createData = [
            'link' => $savepath,
            'size' => $size,
            'file_ext' => $file_extension,
            'file_name' => $filename,
            'is_lock' => $is_lock,
        ];
        /**
         * 保存图片数据
         */
        $savepath = $mediaController->createMedia($createData);
        /**
         * 约定处理接口
         */
        if ($savepath->getstatusCode() !== $this->getStatusCode()) {
            throw new SelfException($savepath->getstatusText());
        }

        return $savepath;
    }


    /**
     * 视频上传方法
     * @param Request $request
     * @param MediaController $mediaController
     * @return mixed
     * Author: fatetis
     * Date:2020/2/25 002517:08
     */
    public function video(Request $request, MediaController $mediaController)
    {
        $file_key = key($request->file());
        $path = $request->input('upload_url', '');
        $is_lock = $request->input('is_lock', 0);
        try {
            if (!$request->file($file_key)->isValid()) {
                throw new SelfException('文件无效');
            }
            $name = $request->input('name');
            $chunk = $request->input('chunk');
            $chunks = $request->input('chunks');
            if (!$name || !$chunks) {
                throw new SelfException('缺少必要参数，请刷新重试');
            }
            $ext = $request->input('file_ext', '');
            $exts = ['video/mp4'];
            if (!in_array($ext, $exts)) {
                throw new SelfException('视频不支持的格式，仅支持mp4格式');
            }

            $size = ceil($request->$file_key->getSize() / 1024); //转换为kb单位

            $filepath = videoUrlStandard('skmedia') . '/';
            if (!empty($path)) {
                $filepath = $path . '/';
            }

            if (!Storage::exists($filepath)) {
                Storage::makeDirectory($filepath);
            }
            $savepath = $filepath . $name;
//            Storage::append这个函数会往已经存在的文件里添加0X0A，也就是\n换行符。导致大文件分片上传合并无法完成
//            $result = Storage::append($savepath, file_get_contents($request->$file_key->getRealPath()), FILE_APPEND);//上传
            $uploadSavePath = public_path('uploads/' . $savepath);
            $result = file_put_contents($uploadSavePath, file_get_contents($request->$file_key->getRealPath()), FILE_APPEND);
            if ($chunk == $chunks - 1) {

                $createData = [
                    'link' => $savepath,
                    'size' => $size,
                    'file_ext' => $ext,
                    'file_name' => $name,
                    'is_lock' => $is_lock,
                ];
                // 保存图片数据
                $savepath = $mediaController->createMedia($createData);
                //约定处理接口
                if ($savepath->getstatusCode() !== $this->getStatusCode()) {
                    throw new SelfException($savepath->getstatusText());
                }
                $data = $savepath->getData()->data->id;
                $src = Storage::url($savepath->getData()->data->link);


                return $this->success([
                    'url' => $data,
                    "fileName" => $name,
                    'src' => $src,
                ], '上传成功');
            }
            if ($result === false) {
                throw new SelfException('网络波动，请刷新重试');
            }

        } catch (SelfException $selfException) {
            return $this->failed($selfException->getMessage());
        } catch (\Exception $exception) {
            return $this->failed($exception->getMessage());
        }


    }

}

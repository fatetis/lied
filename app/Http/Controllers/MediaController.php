<?php

namespace App\Http\Controllers;

use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected $pictureService;

    public function __construct(MediaService $pictureService)
    {
        $this->pictureService = $pictureService;
    }

    /**
     * 以媒体id获取媒体链接地址
     * @param Request $request
     * @return string
     * Author: fatetis
     * Date:2019/10/11 001114:35
     */
    public function getMediaLinkById(Request $request)
    {
        $id = $request->route('id');
        try {
            header('Content-type:image/png');
            $pictureInfo = $this->pictureService->getMediaLinkById($id);
            if(!empty($pictureInfo->link) && Storage::exists($pictureInfo->link)){
                echo file_get_contents(Storage::url($pictureInfo->link));
                die;
            }
            throw new \Exception('图片链接为空');
        }catch (\Exception $exception){
            elog('媒体id获取媒体链接地址抛出异常', $exception, [
                $id
            ]);
            return '';
        }
    }

    /**
     * 创建媒体路径
     * @param array $data 创建数据
     * @return mixed
     * Author: fatetis
     * Date:2019/10/11 001114:36
     */
    public function createMedia($data)
    {
        if(array_filter($data) < count($data)) return $this->failed('数据不能为空');
        $result = $this->pictureService->createMedia($data);
        if($result){
            $data = [
                'id' => $result['id'],
                'file_name' => $result['file_name'],
                'link' => $result['link']
            ];
            //约定返回数据
            return $this->success($data);
        }else{
            return $this->failed('创建失败');
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Services\PictureService;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    protected $pictureService;

    public function __construct(PictureService $pictureService)
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
        return $this->pictureService->getMediaLinkById($id);
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
                'link' => $result['link']
            ];
            //约定返回数据
            return $this->success($data);
        }else{
            elog('创建媒体数据失败，数据：'.je($result));
            return $this->failed('创建失败');
        }
    }

}

<?php

namespace App\Admin\Controllers\Api;

use App\Admin\Controllers\UploadController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;

class UeditorController extends Controller
{
    /**
     * 上传控制器
     * @var UploadController
     */
    protected $uploadController;

    /**
     * 媒体库控制器
     * @var MediaController
     */
    protected $mediaController;

    /**
     * SUCCESS
     */
    const SUCCESS = 'SUCCESS';

    public function __construct(UploadController $uploadController, MediaController $mediaController)
    {
        $this->uploadController = $uploadController;
        $this->mediaController = $mediaController;
    }

    public function index(Request $request)
    {
        $action = $request->input('action', '');
        switch ($action)
        {
            case 'upload-image':
                $request->offsetSet('upload_url', urlStandard('ueditor'));
                $result = $this->uploadImage($request);
                return je($result);
                break;
            case 'config':
                return je(config('ueditor')['upload'], '');
                break;
        }
        return $this->failed('配置失败');
    }

    public function uploadImage($request)
    {
        $savepath = $this->uploadController->uploadImageRequest($request, $this->mediaController);
        $data = $savepath->getData()->data->id;
        $src = $savepath->getData()->data->link;
        $filename = $savepath->getData()->data->file_name;
        return [
            'state' => self::SUCCESS,
            'url' => $src,
            'title' => $filename,
            'original' => $src,
        ];
    }


}
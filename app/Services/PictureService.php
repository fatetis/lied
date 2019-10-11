<?php

namespace App\Services;

use App\Models\Picture;

class PictureService extends BaseService
{

    protected $table = Picture::class;

    /**
     * 获取一条picture表数据
     * @param int $picId 主键id
     * @return string 媒体地址
     * Author: fatetis
     * Date:2019/10/11 001114:37
     */
    public function getMediaLinkById($picId)
    {
        try {
            return parent::findOrFail($picId)['link'];
        }catch (\Exception $exception){
            elog('找不到图片链接,媒体id为'.$picId);
            return '';
        }
    }

    /**
     * 创建一条picture数据
     * @param array $data 创建数据
     * @return mixed
     * Author: fatetis
     * Date:2019/10/11 001114:36
     */
    public function createMedia($data)
    {
        return parent::create($data);
    }

}

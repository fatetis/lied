<?php

namespace App\Services;

use App\Models\Media;

class MediaService extends BaseService
{

    protected $table = Media::class;

    /**
     * 获取一条或者多条picture表数据
     * @param int $picId 主键id
     * @return string 媒体地址
     * Author: fatetis
     * Date:2019/10/11 001114:37
     */
    public function getMediaLinkById($picId)
    {
        if(is_array($picId)) {
            return $this->table::whereIn('id', $picId)->pluck('link', 'id')->toArray();
        }
        return $this->table::find($picId);
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
        return $this->table::create($data);
    }

}

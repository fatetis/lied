<?php

namespace App\Services;

use App\Models\Picture;

class PictureService extends BaseService
{

    protected $table = Picture::class;

    public function getMediaLinkById($picId)
    {
        return parent::findOrFail($picId)['link'];
    }

}

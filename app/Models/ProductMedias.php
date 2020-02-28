<?php

namespace App\Models;

class ProductMedias extends BaseModel
{
    protected $table = 'product_medias';
    protected $primaryKey = 'media_id';
    protected $fillable = ['product_id', 'media_id', 'sort'];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}

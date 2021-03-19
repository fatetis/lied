<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/24
 * Time: 15:23
 */

namespace App\Admin\Extensions\Form;

use App\Services\MediaService;
use Encore\Admin\Form\Field;
use Illuminate\Support\Facades\Storage;

/**
 * 使用示例：
 * $form->skimage('survey_comment', '头像')->attribute('file')->attribute('upload_url', UploadFile::POST_PATH_LOG_IMAGE);
 * $form->skimage('photo_pics', '照片')->attribute('images')->attribute('upload_url', UploadFile::POST_PATH_LOG_IMAGE)->attribute('is_lock', 1);
 * Class SkImage
 * @package App\Admin\Extensions\Form
 * 注意：开启系统debug后，因为系统接口返回了额外数据，导致上传后返回失误，无法显示
 */
class SkImage extends Field
{

    protected $view = 'admin.form.skimage';

    protected static $css = [
        'vendor/laravel-admin-ext/sk-image/skimage_style.css',
        'vendor/laravel-admin-ext/lightbox/lightbox/lightbox.min.css'
    ];

    protected static $js = [
        'vendor/laravel-admin-ext/sk-image/Sortable.min.js',
        'vendor/laravel-admin-ext/sk-image/plupload/plupload.full.min.js',
        'vendor/laravel-admin-ext/sk-image/alioss.js',
        'vendor/laravel-admin-ext/lightbox/lightbox/lightbox.min.js'
    ];

    public function render()
    {
        $name = $this->formatName($this->column);
        $token = csrf_token();
        $videoType = array_key_exists('video', $this->attributes);
        if ($videoType) {
            $this->script = <<<EOT
init_video_upload('{$name}','$token');
EOT;
        } else {
            $this->script = <<<EOT
alioss_upload('{$name}','$token');

EOT;
        }
        if (array_key_exists('value', $this->attributes) && !empty($this->attributes['value'])) {
            $this->value = jd($this->attributes['value']) ?: [];
        }else{
            $this->value = $this->value ? explode(' ', $this->value) : [];
        }

        if(!empty($this->value)) {
            $this->variables['media_link'] = (new MediaService())->getMediaLinkById($this->value);

//            if (!$pictureInfo->isEmpty()) {
//                $this->variables['media_link'] = collect($pictureInfo)->map(function($value){
//                    return Storage::url($value);
//                })->toArray();
//            }
        }
        return parent::render();
    }

}

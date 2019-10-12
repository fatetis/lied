<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/24
 * Time: 15:23
 */

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

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
    ];

    protected static $js = [
        'vendor/laravel-admin-ext/sk-image/Sortable.min.js',
        'vendor/laravel-admin-ext/sk-image/plupload/plupload.full.min.js',
//        'vendor/laravel-admin-ext/sk-image/plupload/i18n/zh_CN.js',
        'vendor/laravel-admin-ext/sk-image/alioss.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);
        $token = csrf_token();
        $this->script = <<<EOT
alioss_upload('{$name}','$token');

EOT;
        return parent::render();
    }

}
<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/vendor/wangEditor-3.1.1/release/wangEditor.min.css',
    ];

    protected static $js = [
        '/vendor/wangEditor-3.1.1/release/wangEditor.min.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);
        $token = csrf_token();
//        editor.customConfig.uploadImgShowBase64 = true
        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.zIndex = 0
editor.customConfig.debug = true;
editor.customConfig.pasteFilterStyle = true
editor.customConfig.uploadImgServer = '/admin/up_image';   
editor.customConfig.uploadFileName = "upload_file";
editor.customConfig.uploadImgParams = {
    _token: '{$token}'  
}
editor.create()

EOT;
        return parent::render();
    }
}

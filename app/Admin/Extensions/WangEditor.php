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
        $image_server = route('apiUploadImage', ['_token' => csrf_token()]);
        $image_path = urlStandard('wang_editor');

        $this->script = <<<EOT
var E = window.wangEditor;
var editor = new E('#{$this->id}');
editor.customConfig.zIndex = 0;
editor.customConfig.debug = true;
editor.customConfig.pasteFilterStyle = true;
editor.customConfig.uploadImgServer = '{$image_server}';   
editor.customConfig.uploadFileName = "upload_file[]";
editor.customConfig.uploadImgMaxSize = 2 * 1024 * 1024;
editor.customConfig.uploadImgShowBase64 = false;
editor.customConfig.showLinkImg = false;
editor.customConfig.uploadImgParams = {
    'upload_url': '{$image_path}'
}
editor.create();
EOT;
        return parent::render();
    }
}

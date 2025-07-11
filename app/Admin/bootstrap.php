<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Admin\Extensions\Form\Editor;
use App\Admin\Extensions\Form\ProductSku;
use App\Admin\Extensions\Form\SkImage;
use App\Admin\Extensions\WangEditor;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;

Encore\Admin\Form::forget(['map','editor']);
//Form::extend('wangeditor', WangEditor::class);
Form::extend('prosku', ProductSku::class);
Form::extend('skmedia', SkImage::class);
Form::extend('UEditor', Editor::class);

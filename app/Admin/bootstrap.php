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

use App\Admin\Extensions\Form\ProductSku;
use App\Admin\Extensions\Form\SkImage;
use App\Admin\Extensions\WangEditor;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;

Encore\Admin\Form::forget(['map','editor']);
Form::extend('wangeditor', WangEditor::class);
Form::extend('prosku', ProductSku::class);
Admin::css('admin/lightbox/lightbox.min.css');//lightbox2 灯箱
Admin::js('admin/lightbox/lightbox.min.js');//lightbox2 灯箱
Form::extend('skimage', SkImage::class);//图片上锁插件

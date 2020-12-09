<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->group(['prefix' => 'api'], function ($router) {
        $router->get('brand', 'ApiController@brand')->name('selectBrand');
        $router->get('product', 'ApiController@product')->name('selectProduct');
        $router->get('coupon', 'ApiController@coupon')->name('selectCoupon');
        $router->get('loadcoupon/limit', 'ApiController@loadCouponLimit')->name('loadCouponLimit');
        $router->get('loadpro', 'ApiController@loadpro')->name('loadPro');
        $router->get('product/category', 'ApiController@productCategory');
//      单选城市三级联动
        $router->get('city', 'ApiController@city');
        $router->get('area', 'ApiController@area');

        $router->get('adv/position', 'ApiController@advPosition');
        $router->get('region/city', 'ApiController@regionsCity');

        $router->get('region/open/city', 'ApiController@getRegionsOpenCity');

        $router->group(['namespace' => 'Api'], function ($router) {
            $router->post('attr/get', 'ProductController@getAttrData')->name('proAttrGetApi');//获取规格名称
            $router->post('attr/create', 'ProductController@createAttrData')->name('proAttrCreateApi');//创建规格名称
            $router->post('attr/value/get', 'ProductController@getAttrValueData')->name('proAttrValueGetApi');//获取规格名称
            $router->post('attr/value/create', 'ProductController@createAttrValueData')->name('proAttrValueCreateApi');//创建规格名称
        });
    });

    $router->get('download/excel', 'DownLoadExcelController@outside')->name('downLoadExcel');

//    产品路由

    $router->group(['prefix' => 'product', 'namespace' => 'Product'], function ($router) {
        $router->resource('category', 'ProductCategoryController');//产品分类
        $router->resource('attr', 'ProductAttrController');//产品属性分类
        $router->resource('seckill', 'ProductSeckillController');//产品秒杀
        $router->resource('/', 'Product\ProductController');//产品

    });
    $router->group(['prefix' => 'order', 'namespace' => 'Order'], function ($router) {
        $router->resource('/base', 'OrderBaseController');//订单
    });

//    品牌路由
    $router->resource('brand/category', 'Brand\BrandCategoryController');
    $router->resource('brand', 'Brand\BrandController');

//    用户路由
    $router->resource('user', 'User\UserController');

//    地域路由
    $router->resource('region/open', 'Regions\RegionsOpenController');
    $router->resource('region', 'Regions\RegionsController');

//    广告路由
    $router->resource('adv/position', 'Adv\AdvPositionController');
    $router->resource('adv', 'Adv\AdvController');

//    文章路由
    $router->resource('article/category', 'Article\ArticleCategoryController');
    $router->resource('article', 'Article\ArticleController');

//    优惠券路由
    $router->resource('coupon/offline', 'Coupon\CouponOfflineController');
    $router->resource('coupon/batch', 'Coupon\CouponBatchController');
    $router->resource('coupon', 'Coupon\CouponController');

//    上传路由
    $router->post('upload/image', 'UploadController@index')->name('uploadImage');
    $router->post('upload/video', 'UploadController@video')->name('uploadVideo');

});

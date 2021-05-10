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
        /**
         * 单选城市三级联动
         */
        $router->get('city', 'ApiController@city')->name('api.city');
        $router->get('area', 'ApiController@area')->name('api.area');
        $router->get('adv/position', 'ApiController@advPosition');
        $router->get('region/city', 'ApiController@regionsCity');
        $router->get('region/open/city', 'ApiController@getRegionsOpenCity');
        $router->group(['namespace' => 'Api'], function ($router) {
            $router->post('attr/get', 'ProductController@getAttrData')->name('proAttrGetApi');
            $router->post('attr/create', 'ProductController@createAttrData')->name('proAttrCreateApi');
            $router->post('attr/value/get', 'ProductController@getAttrValueData')->name('proAttrValueGetApi');
            $router->post('attr/value/create', 'ProductController@createAttrValueData')->name('proAttrValueCreateApi');
            $router->get('order/base', 'OrderController@firstOrderBaseById')->name('admin.api.order.base');
            $router->post('order/delivery', 'OrderController@orderDelivery')->name('admin.api.order.delivery');
            $router->post('order/address/update', 'OrderController@updateOrderAddress')->name('admin.api.order.address.update');
            $router->post('order/price/update', 'OrderController@updateOrderPrice')->name('admin.api.order.price.update');
            $router->any('ueditor', 'UeditorController@index')->name('api.ueditor');

        });
        $router->post('upload/image', 'UploadController@editUploadImg')->name('apiUploadImage');
    });
    $router->get('download/excel', 'DownLoadExcelController@outside')->name('downLoadExcel');
    $router->group(['prefix' => 'product', 'namespace' => 'Product'], function ($router) {
        $router->resource('category', 'ProductCategoryController');
        $router->resource('attr', 'ProductAttrController');
        $router->resource('seckill', 'ProductSeckillController');
    });
    $router->resource('product', 'Product\ProductController');
    $router->group(['prefix' => 'order', 'namespace' => 'Order'], function ($router) {
        $router->resource('/base', 'OrderBaseController');
    });
    $router->resource('brand/category', 'Brand\BrandCategoryController');
    $router->resource('brand', 'Brand\BrandController');
    $router->resource('user', 'User\UserController');
    $router->resource('region/open', 'Regions\RegionsOpenController');
    $router->resource('region', 'Regions\RegionsController');
    $router->resource('adv/position', 'Adv\AdvPositionController');
    $router->resource('adv', 'Adv\AdvController');
    $router->resource('article/category', 'Article\ArticleCategoryController');
    $router->resource('article', 'Article\ArticleController');
    $router->resource('coupon/offline', 'Coupon\CouponOfflineController');
    $router->resource('coupon/batch', 'Coupon\CouponBatchController');
    $router->resource('coupon', 'Coupon\CouponController');
    $router->post('upload/image', 'UploadController@index')->name('uploadImage');
    $router->post('upload/video', 'UploadController@video')->name('uploadVideo');
});

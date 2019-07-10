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

    });

    $router->get('download/excel', 'DownLoadExcelController@outside')->name('downLoadExcel');

//    产品路由
    $router->resource('product/category', 'Product\ProductCategoryController');//产品分类
    $router->resource('product/sku/category', 'Product\ProductSkuCategoryController');//产品属性分类
    $router->resource('product/seckill', 'Product\ProductSeckillController');//产品秒杀
    $router->resource('product/order', 'Order\OrderController');//订单
    $router->resource('product', 'Product\ProductController');//产品

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
    $router->resource('artical/category', 'Artical\ArticalCategoryController');
    $router->resource('artical', 'Artical\ArticalController');

//    优惠券路由
    $router->resource('coupon/offline', 'Coupon\CouponOfflineController');
    $router->resource('coupon/batch', 'Coupon\CouponBatchController');
    $router->resource('coupon', 'Coupon\CouponController');

});

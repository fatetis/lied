<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;

/**
 * 登录验证路由
 */
Route::group(['middleware' => 'auth'], function (Router $router) {
//    订单
    $router->group(['namespace' => 'Order','prefix'=>'order'], function (Router $router) {
        $router->get('/','IndexController@index');
        $router->post('deal','IndexController@createOrder')->name('orderDeal');
        $router->post('deal/high','IndexController@createOrderByRedis')->name('orderDealHigh');
    });

});

/**
 *公开页面
 */
Route::group([], function (Router $router) {

//    首页
    $router->group(['namespace' => 'Index'], function (Router $router) {
        $router->get('/','IndexController@index')->name('index');
    });

//    产品
    $router->group(['namespace' => 'Product','prefix'=>'product'], function (Router $router) {
        $router->get('/','IndexController@index')->name('productIndex');
        $router->get('detail/{id}','IndexController@detail')->where('id', '[0-9]+')->name('productDetail');
    });

//    测试
    $router->get('auth/weixin', 'Socialite\WechatController@redirectToProvider');
    $router->get('auth/weixin/callback','WechatController@handleProviderCallback')->name('aa');
//    获取图片路径
    $router->get('media/get/{id}', 'MediaController@getMediaLinkById')->where('id', '[1-9]+')->name('getMedia');
});

/**
 * 不需要登录验证,登录了访问不到以下路由
 */
Route::group(['middleware' => 'notAuth'], function (Router $router) {
    //    用户
    $router->group(['namespace' => 'Users','prefix'=>'user'], function (Router $router) {
        $router->get('login','LoginController@getLogin')->name('getLogin');
        $router->post('login','LoginController@postLogin')->name('postLogin');
        $router->get('register','LoginController@getRegister')->name('getRegister');
        $router->post('register','LoginController@postRegister')->name('postRegister');
    });
});

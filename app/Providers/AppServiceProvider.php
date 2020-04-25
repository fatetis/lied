<?php

namespace App\Providers;


use App\Rules\Mobile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //自定义Validator手机号码验证
        Validator::extend('mobile', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^1[3|4|5|7|8]\d{9}$/", $value);
        });
        //自定义Validator密码验证
        Validator::extend('password', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$/", $value);
        });
        //自定义Validator验证码验证
        Validator::extend('code', function($attribute, $value, $parameters, $validator) {
            return preg_match("/[0-9]{6}/", $value);
        });
        // 前端请求链接协议 默认使用http
        if(env('REDIRECT_HTTPS')){
            $this->app['request']->server->set('HTTPS',true);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

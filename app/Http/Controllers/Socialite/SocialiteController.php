<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/04/16
 * Time: 11:56
 */

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use App\Services\SocialiteService;

class SocialiteController extends Controller
{
    protected $socialiteService;

    public function __construct(SocialiteService $socialiteService)
    {
        $this->socialiteService = $socialiteService;
    }

    public function saveUserInfo($userInfo,$type)
    {
        try{
            if(!$userInfo['openid']) throw new \Exception('openid获取异常');
            if(!$type) throw new \Exception('类型不能为空');
            $result = $this->socialiteService->saveUserInfo($userInfo,$type);
            return $result ? $result : '数据保存失败';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getSession($sessionKey)
    {
        if(!is_string($sessionKey)) return $this->errorJson('The sessionKey must be string');
        return session($sessionKey);
    }

    public function setSessionValue($parameter)
    {
        if(!is_array($parameter)) return $this->errorJson('The parameter must be array');
        return session($parameter);
    }

    public function setLoginReturnUrl()
    {
        if(!$this->getSession('login_return_url')) $this->setSessionValue(['login_return_url' => url()->previous()]);
    }



}

<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/04/03
 * Time: 15:02
 */

namespace App\Http\Controllers\Socialite;

use App\Http\Contracts\Socialite\SocialiteInterface;
use App\Services\WechatService;
use Laravel\Socialite\Facades\Socialite;

class WechatController extends SocialiteController implements SocialiteInterface
{
    protected $userAgent;

    protected $wechatService;

    public function __construct(WechatService $wechatService)
    {
        $this->userAgent = isMobile() ? 'weixin' : 'weixinweb';
        $this->wechatService = $wechatService;
    }

    public function redirectToProvider()
    {
        $this->setLoginReturnUrl();
        return Socialite::with($this->userAgent)->redirect();
    }

    public function handleProviderCallback()
    {
        $userInfo = Socialite::with($this->userAgent)->stateless()->user();
        $result = $this->saveUserInfo($userInfo->user,1);
        return $result ? redirect($this->getSession('login_return_url')) : $this->errorJson($result);
    }

}

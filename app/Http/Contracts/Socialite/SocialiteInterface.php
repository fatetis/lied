<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/4/16
 * Time: 9:30
 */

namespace App\Http\Contracts\Socialite;

interface SocialiteInterface
{
    public function redirectToProvider();

    public function handleProviderCallback();
}

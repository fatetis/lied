<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/04/16
 * Time: 12:01
 */
namespace App\Services;


use App\Models\UsersOauth;
use Illuminate\Support\Facades\Storage;

class SocialiteService extends BaseService {

    protected $table = UsersOauth::class;

    public function saveUserInfo($userInfo,$type)
    {
        $loginUserInfo = UsersService::user();
        $thumb = $this->saveImgToImgStorage($userInfo['headimgurl']);
        $result = $this->checkUserBindSocialite($userInfo,$type);
        if($result) return $result;
        $data = [
            'user_id'       => $loginUserInfo['user_id'] ?? 0,
            'unionid'       => $userInfo['unionid'] ?? 0,
            'openid'        => $userInfo['openid'],
            'sex'           => $userInfo['sex'],
            'name'          => $userInfo['nickname'],
            'thumb'         => $thumb,
        ];
        return $this->create($data);
    }

    /**
     * 保存微信头像到Storage存储器中
     * @param $imgLink
     * @return int|string
     */
    public function saveImgToImgStorage($imgLink)
    {
        $imgContent = curlLink($imgLink);
        $picturePath = urlStandard('socialiteheadimg').randStr().'png';
        $result = Storage::put($picturePath,file_get_contents($imgContent));
        return $result ? $picturePath : 0;
    }

    protected function checkUserBindSocialite($userInfo,$type){
        switch ($type){
            case 1 :
                $whereField = $userInfo['unionid'] ? ['unionid' => $userInfo['unionid']] : ['openid' => $userInfo['openid']];
                $userOauth = $this->first($whereField);
                if($userOauth) return $userOauth;
                break;
        }
        return false;
    }
}



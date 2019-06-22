<?php

namespace App\Services;


use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class UsersService extends BaseService {

    protected $table = Users::class;

    public function register($parameter){
        $name = $parameter['name'];
        $mobile = $parameter['mobile'];
        $password = $parameter['password'];
        $register_ip = $parameter['register_ip'];
        return $this->firstOrCreate(['name' => $name],['name' => $name, 'mobile' => $mobile, 'password' => $this->bcryptStr($password),'register_ip' => $register_ip]);
    }

    public static function user()
    {
        return Auth::guard('web')->user();
    }

    public function bcryptStr($pwd)
    {
        return bcrypt($pwd);
    }

}



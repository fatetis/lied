<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    protected $usersService;

    public function __construct(UsersService $usersService){
        $this -> usersService = $usersService;
        //已登录则跳过此页面
//        $this->middleware(function ($request, $next) {
//            if ($this->guard()->check()) {
//                return redirect($this->redirectPath());
//            }
//            return $next($request);
//        });

    }

    public function getLogin(){

        return view('m.users.login');
    }

    public function getRegister(Request $request){
        return view('m.users.register');
    }

    public function postLogin(Request $request){
        try{
            $parameter = $this -> checkLoginType($request);

            if (is_array($parameter) && $this->guard()->attempt($parameter)) {
                $request->session()->regenerate();
                return $this->successJson('登录成功','',$this->redirectPath());
            }

            return $this->errorJson($parameter);
        }catch (\Exception $exception){
            return $this->errorJson($exception->getMessage());
        }

    }

    public function checkLoginType($request){
        try{
            if(!empty($request->input('name'))){
                $parameter = $request->only(['name', 'password']);

                $validator = Validator::make($parameter, [
                    'name' => 'required|max:8|string',
                    'password' => 'required|password',
                ]);
            } else {
                #todo 手机验证码生成
                $parameter = $request->only(['mobile', 'password']);

                $validator = Validator::make($parameter, [
                    'mobile' => 'required|mobile',
                    'code' => 'required|code',
                ]);
            }

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }
            return $parameter;
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function postRegister(Request $request){
        try{
            $parameter = $request->only('name','password','mobile');
            $parameter['register_ip'] = $request -> getClientIp();
            $validator = Validator::make($parameter, [
                'name' => 'required|max:8|string|unique:users',
                'mobile' => 'required|mobile|unique:users',
                'password' => 'required|password',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }
            $user = $this -> usersService -> register($parameter);
            $this->guard()->loginUsingId($user->id, false);
            return $this->successJson('注册成功');
        }catch (\Exception $exception){
            return $this->errorJson($exception->getMessage());
        }
    }

//    public function getLogout(Request $request)
//    {
//        $this->guard()->logout();
//
//        $request->session()->invalidate();
//
//        return redirect()->route('home');
//    }

    protected function guard(){
        return Auth::guard('web');
    }

    protected function redirectPath(){
        return route('index');
    }

}

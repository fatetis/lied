<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if($request->ajax()){
                return response()->json([
                    'status'=>400,
                    'msg'=>'请先登录',
                    'data'=>[],
                    'url'=>route('getLogin')
                ]);
            }

            return route('getLogin');
        }
    }
}

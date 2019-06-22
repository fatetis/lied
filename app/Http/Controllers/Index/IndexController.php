<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Services\UsersService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $userService;

    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
    }

    public function Index(Request $request)
    {
        return view('m.index');
    }

}

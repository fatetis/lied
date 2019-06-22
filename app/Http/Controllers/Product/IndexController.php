<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/1/16 0016
 * Time: 17:53
 */
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        echo 12;die;
    }

    public function detail(Request $request){
        $id = $request->route('id');
        echo $id;die;
    }
}

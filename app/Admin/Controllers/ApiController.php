<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdvPosition;
use App\Models\Brand;
use App\Models\Coupons;
use App\Models\CouponsLimit;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * select选择框--品牌数据
     * @param Request $request
     * @return mixed
     */
    public static function brand(Request $request)
    {
        $q = $request->get('q');
        return Brand::where('name', 'like', "%$q%")->where('is_show',1)->where('is_audit',1)->orderBy('sort_order','desc')->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--产品分类数据
     * @param Request $request
     * @return mixed
     */
    public static function productCategory(Request $request)
    {
        $q = $request->get('q');
        return ProductCategory::where('name', 'like', "%$q%")->where('is_show',1)->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--产品数据
     * @param Request $request
     * @return mixed
     */
    public static function product(Request $request)
    {
        $q = $request->get('q');
        return Product::where('name', 'like', "%$q%")->where('is_show',1)->where('is_audit',1)->orderBy('sort_order','desc')->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--广告位置
     * @param Request $request
     * @return mixed
     */
    public static function advPosition(Request $request)
    {
        $q = $request->get('q');
        return AdvPosition::where('name', 'like', "%$q%")->where('is_show',1)->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--城市
     * @param Request $request
     * @return mixed
     */
    public function regionsCity(Request $request)
    {
        $q = $request->get('q');
        return Regions::where('region_name', 'like', "%$q%")->where('region_grade' ,'=', 2)->orderBY('region_id','asc')->paginate(null, ['region_id', 'region_name as text']);
    }

    /**
     * 省市区三级联动数据-城市
     * @param Request $request
     * @return mixed
     */
    public static function city(Request $request)
    {
        $q = $request->get('q');
        return Regions::where(['region_grade' => 2,'parent_id'=>$q])->select('region_name as text', 'region_id as id')->get();
    }

    /**
     * 省市区三级联动数据-区
     * @param Request $request
     * @return mixed
     */
    public static function area(Request $request)
    {
        $q = $request->get('q');
        return Regions::where(['region_grade' => 3,'parent_id'=>$q])->select('region_name as text', 'region_id as id')->get();
    }

    /**
     * load选择框--产品数据where(['brand'=>?])
     * @param Request $request
     * @return mixed
     */
    public static function loadpro(Request $request)
    {
        $q = $request->get('q');
        return Product::where('brand_id', $q)->where('is_show',1)->where('is_audit',1)->orderBy('sort_order','desc')->get(['id', DB::raw('name as text')]);
    }

    public function coupon(Request $request)
    {
        $q = $request->get('q');
        return Coupons::where('name','like',"%$q%")->where('is_show',1)->where('is_online',0)->orderBy('sort_order','desc')->paginate(null, ['id', 'name as text']);
    }

    public function loadCouponLimit(Request $request)
    {
        $q = $request->get('q');
        $prefix = Config::get('database.connections.mysql.prefix');
        return CouponsLimit::leftJoin('product','product.id','coupons_limit.product_id')
            ->leftJoin('brand','brand.id','coupons_limit.brand_id')
            ->where([
                'coupons_limit.coupon_id'   => $q,
                'brand.is_audit'            => 1,
                'brand.is_show'             => 1,
                'product.is_audit'          => 1,
                'product.is_show'           => 1,
            ])
            ->orderBy('coupons_limit.updated_at','desc')
            ->get(['coupons_limit.id',DB::raw("concat(".$prefix."brand.`name`,'-',".$prefix."product.`name`) as text")]);

    }





}

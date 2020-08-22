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
use App\Models\RegionsOpen;
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
        return Brand::query()
            ->where('name', 'like', "%$q%")
            ->where('is_show', GlobalStatusCodeController::YES)
            ->where('is_audit', GlobalStatusCodeController::YES)
            ->orderBy('sort','desc')
            ->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--产品分类数据
     * @param Request $request
     * @return mixed
     */
    public static function productCategory(Request $request)
    {
        $q = $request->get('q');
        return ProductCategory::query()
            ->where('name', 'like', "%$q%")
            ->where('is_show', GlobalStatusCodeController::YES)
            ->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--产品数据
     * @param Request $request
     * @return mixed
     */
    public static function product(Request $request)
    {
        $q = $request->get('q');
        return Product::query()
            ->where('name', 'like', "%$q%")
            ->where('is_show', GlobalStatusCodeController::YES)
            ->where('is_audit', GlobalStatusCodeController::YES)
            ->orderBy('sort_order','desc')
            ->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--广告位置
     * @param Request $request
     * @return mixed
     */
    public static function advPosition(Request $request)
    {
        $q = $request->get('q');
        return AdvPosition::query()
            ->where('name', 'like', "%$q%")
            ->where('is_show',1)
            ->paginate(null, ['id', 'name as text']);
    }

    /**
     * select选择框--城市
     * @param Request $request
     * @return mixed
     */
    public function regionsCity(Request $request)
    {
        $q = $request->get('q');
        return Regions::query()
            ->where('region_name', 'like', "%$q%")
            ->where('region_grade' ,'=', Regions::GRADE_CITY)
            ->orderBY('region_id','asc')
            ->paginate(null, ['region_id', 'region_name as text']);
    }

    /**
     * 省市区三级联动数据-城市
     * @param Request $request
     * @return mixed
     */
    public static function city(Request $request)
    {
        $q = $request->get('q');
        return Regions::query()
            ->where(['region_grade' => Regions::GRADE_CITY, 'parent_id'=>$q])
            ->select('region_name as text', 'region_id as id')
            ->get();
    }

    /**
     * 省市区三级联动数据-区
     * @param Request $request
     * @return mixed
     */
    public static function area(Request $request)
    {
        $q = $request->get('q');
        return Regions::query()
            ->where(['region_grade' => Regions::GRADE_AREA, 'parent_id'=>$q])
            ->select('region_name as text', 'region_id as id')
            ->get();
    }

    /**
     * load选择框--产品数据where(['brand'=>?])
     * @param Request $request
     * @return mixed
     */
    public static function loadpro(Request $request)
    {
        $q = $request->get('q');
        return Product::query()
            ->where('brand_id', $q)
            ->where('is_show', GlobalStatusCodeController::YES)
            ->where('is_audit', GlobalStatusCodeController::YES)
            ->orderBy('sort_order','desc')
            ->get(['id', DB::raw('name as text')]);
    }

    /**
     * 优惠券选择框-优惠券数据
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * Author: fatetis
     * Date:2020/7/31 00319:54
     */
    public function coupon(Request $request)
    {
        $q = $request->get('q');
        return Coupons::query()
            ->where('name','like',"%$q%")
            ->where('is_show', GlobalStatusCodeController::YES)
            ->where('is_online', GlobalStatusCodeController::NO)
            ->orderBy('sort_order','desc')
            ->paginate(null, ['id', 'name as text']);
    }

    /**
     * 优惠券限制选择框-优惠券限制数据
     * @param Request $request
     * @return mixed
     * Author: fatetis
     * Date:2020/7/31 00319:55
     */
    public function loadCouponLimit(Request $request)
    {
        $q = $request->get('q');
        $prefix = Config::get('database.connections.mysql.prefix');
        return CouponsLimit::query()
            ->leftJoin('product','product.id','coupons_limit.product_id')
            ->leftJoin('brand','brand.id','coupons_limit.brand_id')
            ->where([
                'coupons_limit.coupon_id'   => $q,
                'brand.is_audit'            => GlobalStatusCodeController::YES,
                'brand.is_show'             => GlobalStatusCodeController::YES,
                'product.is_audit'          => GlobalStatusCodeController::YES,
                'product.is_show'           => GlobalStatusCodeController::YES,
            ])
            ->orderBy('coupons_limit.updated_at','desc')
            ->get(['coupons_limit.id',DB::raw("concat(".$prefix."brand.`name`,'-',".$prefix."product.`name`) as text")]);

    }

    public function getRegionsOpenCity(Request $request)
    {
        $q = $request->get('q');
        return RegionsOpen::query()
            ->leftJoin('regions','regions.region_id', 'regions_open.region_id')
            ->where(function ($query) use ($q){
                return $query->where('regions.region_name','like',"%$q%")
                    ->orwhere('regions.e_name','like',"%$q%");
            })
            ->where('regions_open.is_show', GlobalStatusCodeController::YES)
            ->orderBy('regions_open.sort_order','desc')
            ->paginate(null, ['regions_open.id', 'regions.region_name as text']);
    }





}

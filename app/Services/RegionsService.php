<?php

namespace App\Services;

use App\Admin\Controllers\GlobalStatusCodeController;
use App\Models\Regions;
use App\Models\RegionsOpen;

class RegionsService extends BaseService {

    protected $table = Regions::class;

    public function getCityByProvinceId($id)
    {
        return Regions::query()->where([
            'region_grade'=> Regions::GRADE_CITY,
            'parent_id' => $id
        ])->pluck('region_name', 'region_id');
    }

    public function getAreaByProvinceId($id)
    {
        return Regions::query()->where([
            'region_grade'=> Regions::GRADE_AREA,
            'parent_id' => $id
        ])->pluck('region_name', 'region_id');
    }

    /**
     * 获取所有省份
     * @return \Illuminate\Support\Collection
     * Author: fatetis
     * Date:2020/7/30 003017:00
     */
    public static function getAllProvince()
    {
        return Regions::query()->where(['region_grade'=> Regions::GRADE_PROVINCE])->pluck('region_name', 'region_id');
    }


    /**
     * 获取所有城市
     * @return \Illuminate\Support\Collection
     * Author: fatetis
     * Date:2020/7/30 003016:57
     */
    public static function getAllCity()
    {
        return Regions::query()->where(['region_grade'=> Regions::GRADE_CITY])->pluck('region_name', 'region_id');
    }

    /**
     * 获取城市的上下级
     * @param string $regionId
     * @return array
     */
    public static function getRegionsCategoryByRegionId($regionId = '')
    {
        $regionSql = Regions::query();

        if(empty($regionId)){
            $regionId = RegionsOpen::query()->where('is_show',1)->pluck('region_id')->toArray();
        }

        if(is_array($regionId)){
            foreach ($regionId as $key => $value){
                $regionSql->orWhere("region_path","like","%,{$value},%");
            }
        }elseif(!empty($regionId)){
            $regionSql->where("region_path","like","%,{$regionId},%");
        }
        $regionSql->groupBy('region_id');
        $result = $regionSql->get()->toArray();
        return self::recursiveToRegions($result);
    }

    /**
     * 处理城市的上下级关系
     * @param $regionList
     * @return array
     */
    protected static function recursiveToRegions($regionList)
    {
        $arr = [];
        foreach ($regionList as $key => $value){
            $pathArr = array_filter(explode(',',$value['region_path']));
            if(empty($value['parent_id'])){
                $arr[$pathArr[1]] = $value;
            }else if($value['region_grade'] == 2){
                if(!isset($arr[$pathArr[1]])){
                    $result = Regions::find($pathArr[1])->toArray();
                    $arr[$pathArr[1]] = $result;
                }
                $arr[$pathArr[1]]['children'][$value['region_id']] = $value;
            }else{
                if(!isset($arr[$pathArr[1]])){
                    $result = Regions::find($pathArr[1])->toArray();
                    $arr[$pathArr[1]] = $result;
                }
                if(!isset($arr[$pathArr[1]]['children'][$value['parent_id']])){
                    $result = Regions::find($value['parent_id'])->toArray();
                    $arr[$pathArr[1]]['children'][$value['parent_id']] = $result;
                }
                $arr[$pathArr[1]]['children'][$value['parent_id']]['children'][$value['region_id']] = $value;
            }
        }
        return $arr;
    }

    public static function getRegionsOpenCity()
    {
        return RegionsOpen::query()
            ->leftJoin('regions','regions.region_id', 'regions_open.region_id')
            ->where('regions_open.is_show', GlobalStatusCodeController::YES)
            ->orderBy('regions_open.sort_order','desc')
            ->pluck('regions.region_name', 'regions_open.id');

    }

}

<?php


namespace App\Admin\Controllers\Api;

use App\Models\ProductAttr;
use App\Services\ProductAttrService;
use Illuminate\Http\Request;

class ProductController extends BaseController {

    protected $productAttrService;

    public function __construct(ProductAttrService $productAttrService)
    {
        $this->productAttrService = $productAttrService;
    }

    /**
     * 获取产品属性的数据
     * @param Request $request
     * @return mixed
     * Author: fatetis
     * Date:2019/8/6 000614:16
     */
    public function getAttrData(Request $request)
    {
        $key = $request->input('key','');
        return $this->success($this->productAttrService->get([['name','like',"%{$key}%"]])->toJson());
    }

    /**
     * 创建产品属性的数据
     * @param Request $request
     * @return mixed
     * Author: fatetis
     * Date:2019/8/6 000614:17
     */
    public function createAttrData(Request $request)
    {
        $key = $request->input('key','');
        $data = $this->productAttrService->create(['name' => $key]);
        return $this->success($data->toJson());
    }


}

<?php


namespace App\Admin\Controllers\Api;

use App\Models\ProductAttr;
use App\Services\ProductAttrService;
use App\Services\ProductAttrValuesService;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ProductController extends BaseController {

    protected $productAttrService;
    protected $productAttrValuesService;

    public function __construct(ProductAttrService $productAttrService, ProductAttrValuesService $productAttrValuesService)
    {
        $this->productAttrService = $productAttrService;
        $this->productAttrValuesService = $productAttrValuesService;
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
        return $this->success($this->productAttrService->getProductAttrByLikeName($key)->toJson());
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
        if(empty($key)){
            $this->failed('缺少必要参数');
        }
        $data = $this->productAttrService->createProductAttr(['name' => $key]);
        return $this->success($data->toJson());
    }

    /**
     * 获取产品属性值的数据
     * @param Request $request
     * @return mixed
     * Author: fatetis
     * Date:2019/8/7 000711:58
     */
    public function getAttrValueData(Request $request)
    {
        $key = $request->input('key', '');
        $pid = $request->input('pid', '');
        $data = $this->productAttrValuesService->getProductAttrValueByLikeNameAndAttrId($pid, $key)->toJson();
        return $this->success($data);
    }

    /**
     * 创建产品属性值的数据
     * @param Request $request
     * @return mixed
     * Author: fatetis
     * Date:2019/8/7 000711:58
     */
    public function createAttrValueData(Request $request)
    {
        $key = $request->input('key','');
        $pid = $request->input('pid','');
        if(empty($key) || empty($pid)){
            $this->failed('缺少必要参数');
        }

        $data = $this->productAttrValuesService->createProductAttrValue(['name' => $key, 'product_attr_id' => $pid])->toJson();
        return $this->success($data);
    }


}

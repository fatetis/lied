<?php

namespace App\Admin\Controllers\Product;

use App\Models\Brand;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductSku;
use App\Services\ProductService;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;

class ProductController extends Controller
{
    use HasResourceActions;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('产品管理')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('产品管理')
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
//        $product_id = request()->route()->product;
//        $aa = $this->productService->getProductById($product_id, ['attrs', 'skus']);
//        dd($aa);
        return $content
            ->header('产品管理')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('产品管理')
            ->description('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);
        $grid->model()->orderBy('updated_at', 'desc');
        $grid->model()->orderBy('id', 'desc');
        $grid->id('产品id');
        $grid->name('产品名称');
//            ->modal('产品属性', function ($model) {
//            $comments = $model->sku()
//                ->leftJoin('product_sku_category','product_sku_category.id','product_sku.sku_category_id')
//                ->select(['product_sku.id', 'product_sku_category.name','product_sku.attr_price', 'product_sku.stock_number'])
//                ->orderBy('product_sku.updated_at','desc')
//                ->get()
//                ->toArray();
//            return new Table(['ID','属性分类', '价格', '库存数量'], $comments);
//        });
        $grid->brand()->name('品牌分类');
        $grid->category()->name('产品分类');
        $grid->line_price('市场价格（元）');
        $grid->is_on_sale('显示')->switch();
        $grid->is_audit('审核')->switch();
        $grid->sort('排序')->editable();
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
//    protected function detail($id)
//    {
//        $show = new Show(Product::findOrFail($id));
//        $show->id();
//        $show->name('产品名称');
//        $show->thumb('产品缩略图')->image();
//        $show->picture('产品图')->image();
//        $show->description('产品简介');
//        $show->market_price('市场价格（元）');
//        $show->price('销售价格（元）');
//        $show->warn_number('库存报警数量');
////        $show->stock_number('库存数量');
//        $show->give_intergral('赠送积分');
//        $show->is_real('实物')->using(['0'=>'否','1'=>'是']);
//        $show->is_new('新品')->using(['0'=>'否','1'=>'是']);
//        $show->is_hot('热卖')->using(['0'=>'否','1'=>'是']);
//        $show->is_audit('审核')->using(['0'=>'否','1'=>'是']);
//        $show->is_show('显示')->using(['0'=>'否','1'=>'是']);
//        $show->sort_order('排序');
//        $show->created_at('创建时间');
//        $show->updated_at('编辑时间');
//        $show->sku('产品属性', function ($sku) {
//            $sku->setResource('/admin/product/sku/category');
////            $sku->sku_category_id('属性分类名称')->as(function ($skuCategoryId) {
////                $result = ProductSkuCategory::find($skuCategoryId);
////                return $result['name'];
////            });
//            $sku->attr_price('产品价格');
//            $sku->stock_number('库存数量');
//            $sku->thumb('属性缩略图')->image();
//
//        });
//        $show->brand('品牌分类', function ($brand) {
//            $brand->setResource('/admin/brand');
//            $brand->name('品牌名称');
//            $brand->thumb('品牌logo')->image();
//            $brand->description('品牌描述');
//            $brand->site_url('品牌网址')->link();
//        });
//        $show->category('产品分类', function ($productCategory) {
//            $productCategory->setResource('/admin/product/category');
//            $productCategory->pid('父级分类')->using(ProductCategory::selectOptions());
//            $productCategory->name('产品分类名称');
//        });
//        return $show;
//    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        $form = new Form(new Product);
        $form->tab('基础信息', function ($form) {

            $states = [
                'on' => ['value' => 1, 'text' => '✔', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '✖', 'color' => 'danger'],
            ];

            $product_data = ProductCategory::selectOptions();
            array_shift($product_data);

            $form->text('name', '产品名称')->required();
            $form->select('category_id', '产品分类')->options($product_data);

            $form->select('brand_id', '品牌')->options(function ($id) {
                $brand = Brand::query()->find($id);
                if ($brand) {
                    return [$brand->id => $brand->name];
                }
            })->ajax(route('selectBrand'))->required();
            $form->currency('line_price', '市场价格')->symbol('￥');
            $form->skmedia('picture', '产品banner图')->attribute('images')->attribute([
                'upload_url' => urlStandard('product_picture'),
                'data-multi' => true,
                'value' => je($this->productService->getProductMedia(request()->route()->product)),
            ])->help('上传图片宽*高为750*750')->required();

            $form->text('description', '简要描述');
            $form->wangeditor('content', '描述');
            $form->number('sort', '产品排序')->value(99)->max(99);
            $form->switch('is_real', '实物')->value(0);
            $form->switch('is_on_sale', '显示')->value(1);
            $form->switch('is_audit', '审核状态')->states($states);
            $form->hidden('created_id')->value(Admin::user()->id);

        })->tab('属性信息', function ($form) {

            $form->prosku('prosku', '商品规格');

        })->tab('扩展信息', function ($form) {

            $form->number('virtual_quantity', '虚拟购买量');
//            $form->number('is_limit', '限购')->value(0)->min(0);


        });

        $form->ignore('prosku');
        $form->ignore('picture');


        $form->saving(function (Form $form){
            /**
             * 商品规格属性判断
             */
            $prosku = request('prosku');

            if (!empty($prosku) && count($prosku) != count(array_filter(array_column($prosku, 'media_id')))) {
                $error = new MessageBag([
                    'title' => '错误信息',
                    'message' => '商品规格缩略图不能为空',
                ]);
                return back()->with(compact('error'));
            }
        });

        $form->saved(function (Form $form){
            $prosku = request('prosku');
            $picture = request('picture');

            $prosku_result = $this->productService->saveProduct($form->model()->id, $prosku, $picture);
            if ($prosku_result !== true) {
                if ($form->isCreating()) $form->model()->delete();
                $error = new MessageBag([
                    'title' => '错误信息',
                    'message' => $prosku_result
                ]);
                return back()->with(compact('error'));
            }
        });
        return $form;
    }


}

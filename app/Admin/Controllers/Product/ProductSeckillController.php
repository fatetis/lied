<?php

namespace App\Admin\Controllers\Product;

use App\Models\Product;
use App\Models\ProductSeckill;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductSeckillController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
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
            ->header('Detail')
            ->description('description')
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
        return $content
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductSeckill);

        $grid->id('Id');
        $grid->product_id('Product id');
        $grid->number('Number');
        $grid->limit_user('Limit user');
        $grid->start_time('Start time');
        $grid->end_time('End time');
        $grid->is_show('Is show');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->deleted_at('Deleted at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ProductSeckill::findOrFail($id));

        $show->id('Id');
        $show->product_id('Product id');
        $show->number('Number');
        $show->limit_user('Limit user');
        $show->start_time('Start time');
        $show->end_time('End time');
        $show->is_show('Is show');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->deleted_at('Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ProductSeckill);

        $form->select('product_id','参与产品')->options(function ($id) {
            $products = Product::find($id);
            if ($products) {
                return [$products->id => $products->name];
            }
        })->ajax('/admin/api/product');
        $form->text('limit_user', '用户分类');
        $form->number('number', '秒杀库存');
        $form->number('limit_shop', '限定用户购买次数');
        $form->datetimeRange('start_time', 'end_time', '活动时间');
        $form->switch('is_show', '是否显示');

        return $form;
    }
}

<?php

namespace App\Admin\Controllers\Brand;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BrandController extends Controller
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
            ->header('品牌管理')
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
            ->header('品牌管理')
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
        return $content
            ->header('品牌管理')
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
            ->header('品牌管理')
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
        $grid = new Grid(new Brand);
        $grid->id('Id');
        $grid->name('名称');
        $grid->site_url('网址');
        $grid->is_show('显示')->switch();
        $grid->sort_order('排序')->editable()->sortable();
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
    protected function detail($id)
    {
        $show = new Show(Brand::findOrFail($id));

        $show->id('Id');
        $show->name('品牌名称');
        $show->thumb('缩略图')->image();
        $show->description('品牌描述');
        $show->site_url('品牌网址')->link();
        $show->is_show('显示')->using(['1' => '是', '0' => '否']);
        $show->sort_order('排序序号');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Brand);

        $form->text('name', '品牌名称');
        $form->select('category_id', '品牌分类')->options(BrandCategory::selectOptions());
        $form->image('thumb', '品牌logo')->move(urlStandard('brand_thumb'))->uniqueName()->removable();
        $form->text('site_url', '品牌网址');
        $form->textarea('description', '品牌描述');
        $form->number('sort_order', '排序')->value(99);
        $form->switch('is_show', '显示');

        return $form;
    }
}

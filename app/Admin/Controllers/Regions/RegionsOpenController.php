<?php

namespace App\Admin\Controllers\Regions;

use App\Models\Regions;
use App\Models\RegionsOpen;
use App\Http\Controllers\Controller;
use App\Services\RegionsService;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RegionsOpenController extends Controller
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
            ->header('城市开通')
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
            ->header('城市开通')
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
            ->header('城市开通')
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
            ->header('城市开通')
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
//        $aa = RegionsService::getRegionsCategoryByRegionId();
        $grid = new Grid(new RegionsOpen);
        $grid->disableExport();//禁用导出
        $grid->id('ID');
        $grid->regions()->region_name('城市名称');
        $grid->is_show('显示')->switch();
        $grid->sort_order('排序')->editable();
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
        $show = new Show(RegionsOpen::findOrFail($id));

        $show->id('Id');
        $show->region_id('城市ID');
        $show->is_show('显示')->using(['0'=>'否','1'=>'是']);
        $show->sort_order('排序');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        $show->deleted_at('删除时间');
        $show->regions('城市名称', function ($productCategory) {
            $productCategory->setResource('/admin/region');
            $productCategory->region_name('城市名称');
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RegionsOpen);

        $form->select('region_id', '开通城市')->options(RegionsService::getAllCity());
        $form->switch('is_show', '显示');
        $form->number('sort_order', '排序');

        return $form;
    }
}

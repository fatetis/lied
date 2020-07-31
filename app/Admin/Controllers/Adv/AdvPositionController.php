<?php

namespace App\Admin\Controllers\Adv;

use App\Models\AdvPosition;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class AdvPositionController extends Controller
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
            ->header('广告位置管理')
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
            ->header('广告位置管理')
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
            ->header('广告位置管理')
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
            ->header('广告位置管理')
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
        $grid = new Grid(new AdvPosition);
        $grid->disableExport();
        $grid->id('Id');
        $grid->name('名称');
        $grid->ename('英文代号');
        $grid->width('宽度');
        $grid->height('高度');
        $grid->is_show('显示')->switch();
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
        $show = new Show(AdvPosition::findOrFail($id));

        $show->id('Id');
        $show->name('名称');
        $show->ename('英文代号');
        $show->width('宽度');
        $show->height('高度');
        $show->is_show('显示')->using(['0'=>'否','1'=>'是']);
        $show->created_at('创建时间');
        $show->updated_at('编辑时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdvPosition);

        $form->text('name', '广告名称')->required();
        $form->text('ename', '英文代号')->required();
        $form->number('width', '宽度')->required();
        $form->number('height', '高度')->required();
        $form->switch('is_show', '是否显示');

        return $form;
    }
}

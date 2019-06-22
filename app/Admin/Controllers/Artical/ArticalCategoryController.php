<?php

namespace App\Admin\Controllers\Artical;

use App\Models\ArticalCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;

class ArticalCategoryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header('文章分类');
            $content->body(ArticalCategory::tree(function($tree){
                $tree->query(function ($model) {
                    return $model->where('is_show', 1);
                });
            }));
        });
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
        $grid = new Grid(new ArticalCategory);

        $grid->id('Id');
        $grid->name('Name');
        $grid->desc('Desc');
        $grid->pid('Pid');
        $grid->sort_order('Sort order');
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
        $show = new Show(ArticalCategory::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->desc('Desc');
        $show->pid('Pid');
        $show->sort_order('Sort order');
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
        $form = new Form(new ArticalCategory);

        $form->select('pid', trans('admin.parent_id'))->options(ArticalCategory::selectOptions());
        $form->text('name', '分类名称')->rules('required')->rules('max:5',[
            'max' => '最多只能输入5个字'
        ]);
        $form->text('description', '分类简述');
        $form->switch('is_show', '是否显示');


        return $form;
    }
}

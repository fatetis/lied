<?php

namespace App\Admin\Controllers\Product;

use App\Admin\Controllers\GlobalStatusCodeController;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;
use Illuminate\Support\MessageBag;

class ProductCategoryController extends Controller
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
            $content->header('产品分类');
            $content->body(ProductCategory::tree(function (Tree $tree) {
                $tree->branch(function ($branch) {
                    return "{$branch['id']} - {$branch['name']}". ($branch['is_rec'] == 1 ? ' - <strong style="color: #c9302c">推荐</strong>': '');
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
        $grid = new Grid(new ProductCategory);

        $grid->id('Id');
        $grid->pid('Pid');
        $grid->name('Name');
        $grid->sort_order('Sort order');
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
        $show = new Show(ProductCategory::findOrFail($id));

        $show->id('Id');
        $show->pid('Pid');
        $show->name('Name');
        $show->sort_order('Sort order');
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
        $form = new Form(new ProductCategory);

        $form->select('pid', trans('admin.parent_id'))->options(ProductCategory::selectOptions());
        $form->text('name', '分类名称')->rules('required')->rules('max:8', [
            'max' => '最多只能输入8个字'
        ]);
        $form->skmedia('media_id', '分类icon')->attribute('images')->attribute([
            'upload_url' => urlStandard('product_category')
        ])->help('上传图片宽*高为140*140')->required();
        $form->number('sort', '排序')->value(99)->max(99);
        $form->switch('is_rec', '推荐')->value(0);

        $form->saving(function (Form $form){
            $pid = $form->pid;
            $is_rec = $form->is_rec;
            if (empty($pid) && $is_rec === GlobalStatusCodeController::ON) {
                $error = new MessageBag([
                    'title' => '错误信息',
                    'message' => '顶级分类不可以做推荐',
                ]);
                return back()->with(compact('error'));
            }
        });
        return $form;
    }
}

<?php

namespace App\Admin\Controllers\Article;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ArticleController extends Controller
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
            ->header('文章管理')
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
            ->header('文章管理')
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
            ->header('文章管理')
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
            ->header('文章管理')
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
        $grid = new Grid(new Article);

        $grid->id('Id');
        $grid->category()->name('分类名称');
        $grid->user_id('User id');
        $grid->title('标题');
        $grid->thumb('缩略图')->image('','35','35');
        $grid->desc('简介');
        $grid->is_hot('热门')->switch();
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
        $show = new Show(Article::findOrFail($id));

        $show->id('Id');
        $show->category_id('文章分类ID');
        $show->user_id('创建者ID');
        $show->title('标题');
        $show->thumb('缩略图')->image();
        $show->desc('简介');
        $show->content('内容');
        $show->is_hot('热门')->using(['0'=>'否','1'=>'是']);
        $show->is_show('显示')->using(['0'=>'否','1'=>'是']);
        $show->sort_order('排序');
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
        $form = new Form(new Article);
        $form->text('title', '文章标题')->rules('required');
        $form->select('category_id', '文章分类')->options(ArticleCategory::selectOptions());

        $form->image('thumb', '文章缩略图')->move(urlStandard('article_thumb'))->uniqueName()->removable();

        $form->wangeditor('description', '文章简介');
        $form->wangeditor('content', '文章内容');

        $form->number('sort_order', '排序')->value(99);
        $form->switch('is_show', '显示')->value(1);
        $form->switch('is_hot', '热门')->value(1);
//        $form->hidden('user_id')->value(getAdminUserId());
        return $form;
    }
}

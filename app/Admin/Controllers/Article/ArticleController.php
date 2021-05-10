<?php

namespace App\Admin\Controllers\Article;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
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
        $grid->adminUser()->username('创建者');
        $grid->title('标题');
        $grid->description('简介');
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
        $show->description('简介');
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
        $form->text('title', '文章标题')->required();
        $form->select('category_id', '文章分类')->options(ArticleCategory::selectOptions());
        $form->skmedia('thumb', '分类icon')->attribute('images')->attribute([
            'upload_url' => urlStandard('article_thumb')
        ])->help('上传图片宽*高为140*140')->required();

        $form->UEditor('description', '文章简介');
        $form->UEditor('content', '文章内容');

        $form->number('sort_order', '排序')->value(99);
        $form->switch('is_show', '显示')->value(1);
        $form->switch('is_hot', '热门')->value(1);
        $form->hidden('user_id')->value(Admin::user()->id);
        return $form;
    }
}

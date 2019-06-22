<?php

namespace App\Admin\Controllers\User;

use App\Models\Users;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
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
            ->header('用户管理')
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
            ->header('用户管理')
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
            ->header('用户管理')
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
            ->header('用户管理')
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
        $grid = new Grid(new Users);
        // 去掉`创建`按钮
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });
        $grid->id('用户Id');
        $grid->name('名称');
        $grid->nick_name('真实名称');
        $grid->mobile('手机号码');
        $grid->email('邮件地址');
        $grid->created_at('创建时间');

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
        $show = new Show(Users::findOrFail($id));

        $show->id('用户Id');
        $show->name('用户名');
        $show->nick_name('真实名称');
        $show->mobile('手机号码');
        $show->email('email');
        $show->register_ip('注册ip');
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
        $form = new Form(new Users);
        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
        });
        $form->footer(function ($footer) {
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });
        $form->display('name', '名称');
        $form->text('nick_name', '真实名称');
        $form->mobile('mobile', '手机号码');
        $form->email('email', '邮件地址');
        $form->display('created_at', '创建时间');
        $form->display('updated_at', '更新时间');
        return $form;
    }
}

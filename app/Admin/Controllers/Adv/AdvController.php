<?php

namespace App\Admin\Controllers\Adv;

use App\Models\Adv;
use App\Http\Controllers\Controller;
use App\Models\AdvPosition;
use App\Services\RegionsService;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class AdvController extends Controller
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
            ->header('广告管理')
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
            ->header('广告管理')
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
            ->header('广告管理')
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
            ->header('广告管理')
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
        $grid = new Grid(new Adv);
        $grid->id('ID');
        $grid->name('名称')->modal('投放城市', function ($model) {
            $comments = $model->advopen()->get()->map(function ($comment) {
                return [
                    $comment['regionopen']['regions']['region_name'],
                    $comment['start_time'],
                    $comment['end_time'],
                    round((strtotime($comment['end_time']) - strtotime($comment['start_time']))/(3600*24), 1).'天后'
                ];
            });
            return new Table(['城市', '开始时间', '结束时间', '剩余投放时间'], $comments->toArray());
        });
        $grid->url('链接')->link();
        $grid->advposition()->name('位置名称');
        $grid->is_show('显示')->switch();
        $grid->sort_order('排序')->editable();
        $grid->created_at('创建时间');
        $grid->updated_at('编辑时间');



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
        $show = new Show(Adv::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->url('Url');
        $show->thumb('Thumb');
        $show->position_id('Position id');
        $show->is_show('Is show');
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
        $form = new Form(new Adv);
        $form->text('name', '名称');
        $form->url('url', '链接');
        $form->skmedia('media_id', '产品banner图')->attribute('images')->attribute([
            'upload_url' => urlStandard('adv_thumb')
        ])->help('上传图片宽*高为750*750')->required();
        $form->select('position_id', '广告位置')
            ->options(function ($id) {
                $advPosition = AdvPosition::query()->find($id);
                if ($advPosition) {
                    return [$advPosition->id => $advPosition->name];
                }
                return [];
            })
            ->ajax('/admin/api/adv/position')
            ->required()
            ->when('1', function (Form $form) {
                $form->text('desc', '描述');
            });
        $form->switch('is_show', '是否显示');
        $form->number('sort', '排序')->default('99');
        $form->hasMany('advopen', '城市展示', function (Form\NestedForm  $form) {
            $form->select('region_open_id', '城市')
                ->options(RegionsService::getRegionsOpenCity())
                ->required();
            $form->datetimeRange('start_time', 'end_time', '投放时间');
        });

        return $form;
    }
}

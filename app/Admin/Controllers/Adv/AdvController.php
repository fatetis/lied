<?php

namespace App\Admin\Controllers\Adv;

use App\Models\Adv;
use App\Http\Controllers\Controller;
use App\Models\AdvPosition;
use App\Models\Regions;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->name('名称');
        $grid->url('链接')->link();
        $grid->advPosition()->name('位置名称');
        $grid->region_city_id('所属城市')->display(function($regionCityId){
            $result = Regions::whereIn('region_id',$regionCityId)->pluck('region_name','region_id')->toArray();
            return implode(',',$result);
        });
        $grid->start_time('开始时间');
        $grid->end_time('结束时间');
        $grid->click_num('点击数量');
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
        $show->city_id('City id');
        $show->start_time('Start time');
        $show->end_time('End time');
        $show->click_num('Click num');
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
        $form->image('thumb', '缩略图')->move(urlStandard('adv_thumb'))->uniqueName()->removable();
        $form->select('position_id', '广告位置')->options(function ($id) {
            $advPosition = AdvPosition::find($id);
            if ($advPosition) {
                return [$advPosition->id => $advPosition->name];
            }
        })->ajax('/admin/api/adv/position')->rules('required');
        $form->multipleSelect('region_city_id','市')->options(Regions::getAllCity());

        $form->datetimeRange('start_time', 'end_time', '活动时间');
        $form->switch('is_show', '是否显示');
        $form->number('sort_order', '排序')->default('99');

        return $form;
    }
}

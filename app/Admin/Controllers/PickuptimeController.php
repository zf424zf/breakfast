<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\PickupTime as PickTimeModel;

class PickuptimeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('取货时间段');
            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑取货时间段');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新增取货时间段');
            $content->body($this->form());
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(PickTimeModel::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->start('开始时间');
            $grid->end('结束时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(PickTimeModel::class, function (Form $form) {
            $form->timeRange('start','end', '选择取货时间')->rules('required')->help('格式  时:分')->options(['format'=>'HH:mm']);
            $form->number('purchase_stop', '下单截止小时')->rules('required')->help('在取货开始时间点之前的小时数,例如:取货开始时间段是7:30 下单截止是12小时,则享下单截止时间点是前一天19:30');
        });
    }
}

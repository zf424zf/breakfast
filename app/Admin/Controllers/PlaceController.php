<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Metro\Place as PlaceModel;
use App\Models\Metro\Station as StationModel;
use App\Models\Metro\PlaceRelation as PlaceRelationModel;

class PlaceController extends Controller
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
            $content->header('取餐地点');
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
            $content->header('编辑取餐地点');
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
            $content->header('新增取餐地点');
            $content->body($this->form());
        });
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            PlaceRelationModel::where('place_id', $id)->delete();
            return response()->json([
                'status'  => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(PlaceModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('取餐地点')->editable();;
            $grid->stations('地铁站')->display(function ($stations) {
                return implode(',', array_column($stations, 'name'));
            });
            $grid->column('location','地图位置')->openMap(function () {
                list($lat, $lng) = explode(',', $this->location);
                return [$lat, $lng];
            }, '地图位置');
            $grid->address('地址');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $arrays = StationModel::get()->toArray();
        $stations = [];
        foreach ($arrays as $array) {
            $stations[$array['id']] = $array['name'];
        }
        return Admin::form(PlaceModel::class, function (Form $form) use ($stations) {
            $form->display('id', 'ID');
            $form->text('name', '取餐地点')->rules('required');
            $form->text('location', '地图坐标')->rules('required')->help('坐标拾取地址: <a href="http://lbs.qq.com/tool/getpoint/index.html" target="_blank">http://lbs.qq.com/tool/getpoint/index.html</a>');
            $form->text('address', '详细地址')->rules('required');
            $form->checkbox('stations', '地铁站')->options($stations);
        });
    }
}

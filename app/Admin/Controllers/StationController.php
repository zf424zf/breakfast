<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Metro\Station;
use App\Models\Metro\Metro as MetroModel;
use App\Models\Metro\StationRelation as StationRelationModel;
use App\Models\Metro\PlaceRelation as PlaceRelationModel;

class StationController extends Controller
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

            $content->header('地铁站点');

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

            $content->header('编辑地铁站点');

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

            $content->header('新增地铁站点');

            $content->body($this->form());
        });
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            StationRelationModel::where('station_id', $id)->delete();
            PlaceRelationModel::where('station_id', $id)->delete();
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
        return Admin::grid(Station::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->name('站点名称')->editable();;
            $grid->metros('地铁线路')->display(function ($metros) {
                return implode(',', array_column($metros, 'name'));
            });
            $grid->places('取餐点')->display(function ($places) {
                return implode(',', array_column($places, 'name'));
            });
            $grid->created_at('创建时间');
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                // 设置created_at字段的范围查询
                $filter->where(function ($query) {
                    $input = $this->input;
                    $query->whereHas('metros', function ($query) use ($input) {
                        $query->where('metro_id', $input);
                    });
                }, '地铁线路')->select(MetroModel::all()->pluck('name', 'id'));
            });
            $grid->actions(function ($actions) {
                $actions->append('<a href="' . admin_url('place_sort?station_id=' . $actions->getKey()) . '"><i class="fa fa-eye"></i></a>');
            });
            //$grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Station::class, function (Form $form) {
            $form->display('id', 'ID');
            if (request()->route('station')) {
                $form->text('name', '站点名称')->rules('required|unique:metro_station,name,' . request()->route('station') . ',id');//|
            } else {
                $form->text('name', '站点名称')->rules('required|unique:metro_station');//|
            }
            $form->checkbox('metros', '地铁线路')->options(MetroModel::all()->pluck('name', 'id'))->rules('required');
        });
    }
}

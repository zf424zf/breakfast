<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Metro\Station as StationModel;
use App\Models\Metro\PlaceRelation as PlaceRelationModel;

class PlaceSortController extends Controller
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
            $metro = StationModel::find(request('station_id'));
            $content->header($metro->name);
            $content->description($metro->name . '取餐点排序');
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

    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {

    }

    public function destroy($id)
    {

    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(PlaceRelationModel::class, function (Grid $grid) {
            $grid->paginate(100);
            $grid->model()->where('station_id', request('station_id'))->orderBy('sort', 'DESC');
            $grid->sort('排序')->editable();
            $grid->place('取餐点')->display(function ($place) {
                return $place['name'];
            });
            $grid->disableCreation();
            $grid->disablePagination();
            $grid->disableExport();
            $grid->disableRowSelector();
            $grid->disableActions();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
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
        return Admin::form(PlaceRelationModel::class, function (Form $form) {
            $form->number('sort', '排序');
        });
    }
}

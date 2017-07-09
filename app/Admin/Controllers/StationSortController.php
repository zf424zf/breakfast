<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Metro\Metro as MetroModel;
use App\Models\Metro\StationRelation as StationRelationModel;

class StationSortController extends Controller
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
            $metro = MetroModel::find(request('metro_id'));
            $content->header($metro->name);
            $content->description($metro->name . '地铁站排序');
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
        return Admin::grid(StationRelationModel::class, function (Grid $grid) {
            $grid->paginate(100);
            $grid->model()->where('metro_id', request('metro_id'))->orderBy('sort', 'DESC');
            $grid->sort('排序')->editable();
            $grid->station('地铁站')->display(function ($station) {
                return $station['name'];
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
        return Admin::form(StationRelationModel::class, function (Form $form) {
            $form->number('sort', '排序')->help('前台展示按照倒叙排列');
        });
    }
}

<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Stock;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use App\Models\Product\Products;

class StockController extends Controller
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
            $content->header('库存');
            $content->description('库存管理');
            $content->body($this->grid());
        });
    }

    public function show($id)
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

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Stock::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            $grid->date('日期');
            $grid->product('商品')->display(function ($product) {
                return $product['name'];
            });
            $grid->stock('库存')->editable();
            $grid->filter(function ($filter) {
                //$filter->useModal();
                $filter->disableIdFilter();
                $filter->is('date', '日期')->setPlaceholder('格式:20170809');
                $filter->is('product_id', '商品')->select(Products::all()->pluck('name', 'id'));;
            });
            $grid->disableCreation();
            $grid->disableActions();
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
        return Admin::form(Stock::class, function (Form $form) {
            $form->number('stock', '库存');
        });
    }
}

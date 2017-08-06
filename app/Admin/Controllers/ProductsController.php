<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Product\Products as ProductsModel;
use App\Models\Saleday as Saledays;
use App\Models\Product\Saleday;
use App\Models\Metro\Place as PlaceModel;
use App\Models\PickupTime as Pickuptimes;
use App\Models\Stock;

class ProductsController extends Controller
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
            $content->header('商品管理');
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
            $content->header('编辑商品');
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
            $content->header('新增商品');
            $content->body($this->form());
        });
    }


    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            Saleday::where('product_id', $id)->delete();
            Stock::where('product_id', $id)->delete();
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
        return Admin::grid(ProductsModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('商品名称')->editable();;
            //$grid->img('封面')->image();
            //$grid->stock('库存')->editable();
            $states = [
                'on'  => ['value' => 1, 'text' => '上架', 'color' => 'success'],
                'off' => ['value' => 2, 'text' => '下架', 'color' => 'danger'],
            ];
            $grid->status('上下架')->switch($states);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ProductsModel::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '商品名称')->rules('required');
            $form->image('img', '封面图')->rules('required');
            $form->checkbox('saledays', '销售日期')->options(Saledays::all()->pluck('name', 'weekday'))->default([1, 2, 3, 4, 5, 6, 7]);
            $picks = Pickuptimes::all()->toArray();
            $picktimes = [];
            foreach ($picks as $key => $pick) {
                $picktimes[$pick['id']] = $pick['start'] . '-' . $pick['end'];
            }
            $form->checkbox('pickuptimes', '销售时段')->options($picktimes)->rules('required');
            $form->multipleSelect('places', '销售地点')->options(PlaceModel::all()->pluck('name', 'id'));
            $form->currency('origin_price', '原价')->rules('required')->symbol('￥');
            $form->currency('coupon_price', '优惠价')->rules('required')->symbol('￥');
            $form->currency('early_price', '早鸟价')->rules('required')->symbol('￥');
            $form->number('early_time', '早鸟时间')->rules('required')->help('在取货开始时间点之前的小时数,例如:取货开始时间段是7:30 早鸟时间是12小时,则享受早鸟价格的最后时间点是前一天19:30');
            //$form->number('stock', '库存')->rules('required')->default(0);
            $form->number('recommend', '推荐指数')->rules('required')->default(5);
            $form->text('calori', '卡路里');
            $form->text('material', '食材');
            $states = [
                'on'  => ['value' => 1, 'text' => '上架', 'color' => 'success'],
                'off' => ['value' => 2, 'text' => '下架', 'color' => 'danger'],
            ];
            $form->switch('status', '状态')->states($states)->default(1);
            //$form->checkbox('stations', '地铁站')->options($stations);
            $form->saved(function (Form $form) {
                \Artisan::call('stock:create');
            });

        });
    }
}

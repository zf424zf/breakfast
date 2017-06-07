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
            Saleday::where('product_id',$id)->delete();
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
            $grid->stock('库存')->editable();
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
            $form->checkbox('saledays','销售日期')->options(Saledays::all()->pluck('name','weekday'));
            $form->number('stock', '库存')->rules('required')->default(0);
            $form->number('recommend', '推荐指数')->rules('required')->default(5);
            $form->text('calori', '卡路里');
            $form->text('material', '食材');
            $states = [
                'on'  => ['value' => 1, 'text' => '上架', 'color' => 'success'],
                'off' => ['value' => 2, 'text' => '下架', 'color' => 'danger'],
            ];
            $form->switch('status','状态')->states($states)->default(1);
            //$form->checkbox('stations', '地铁站')->options($stations);

        });
    }
}

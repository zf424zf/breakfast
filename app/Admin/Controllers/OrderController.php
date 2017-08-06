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
use App\Models\Order\Order as OrderModel;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;

class OrderController extends Controller
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
            $content->header('订单');
            $content->description('订单列表');
            $content->body($this->grid());
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('订单详情');
            $headers = ['Keys', 'Values'];
            $order = OrderModel::find($id);
            $goods = '';
            foreach ($order->goods as $good) {
                $goods .= $good->product->name . 'X' . $good->count . ';&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            $rows = [
                'ID'     => $order->id,
                '订单号'    => $order->order_id,
                '用户'     => $order->user->nickname,
                '取货日期'   => $order->date,
                '取货时间段'  => $order->pickuptime['start'] . '-' . $order->pickuptime['end'],
                '取货地点'   => $order->place->name,
                '订单金额'   => $order->amount,
                '支付时间'   => $order->pay_time ? date('Y-m-d H:i:s', $order->pay_time) : '未支付',
                '支付流水'   => $order->pay_time ? $order->pay_flow : '未支付',
                '联系人'    => $order->name,
                '联系电话'   => $order->phone,
                '公司'     => $order->company,
                '状态'     => order_status($order->status),
                '下单时间'   => $order->created_at,
                '上次变更时间' => $order->updated_at,
                '订单商品'   => $goods,
            ];
            $table = new Table($headers, $rows);
            $content->row((new Box('订单详情', $table))->style('info')->solid());
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

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(OrderModel::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            $grid->id('ID');
            $grid->order_id('订单号');
            $grid->user('用户')->display(function ($user) {
                return $user['nickname'];
            });
            $grid->date('取餐日期');
            $grid->pickuptime('取餐时间')->display(function ($pickuptime) {
                return $pickuptime['start'] . '-' . $pickuptime['end'];
            });
            $grid->place('取餐地点')->display(function ($place) {
                return $place['name'];
            });
            $grid->amount('订单金额');
            $grid->created_at('下单时间');
            $grid->status('订单状态')->display(function ($status) {
                return order_status($status);
            });
            $grid->filter(function ($filter) {
                //$filter->useModal();
                // 设置created_at字段的范围查询
                $filter->is('uid', 'UID');
                $filter->is('date', '取货日期')->setPlaceholder('格式:20170809');
                $filter->like('phone', '电话');
                $filter->between('created_at', '下单时间')->datetime();
            });
            $grid->disableCreation();
            //$grid->disableActions();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->append('<a href="' . admin_url('order/' . $actions->getKey()) . '">详情</a>');
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

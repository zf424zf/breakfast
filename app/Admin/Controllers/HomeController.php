<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;
use App\Models\PickupTime as PickupTimeModel;
use App\Models\Order\Products as Goods;
use App\Http\Services\Order as OrderService;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('一起吃早餐');
            $content->description('一起吃早餐管理平台');

            $content->row(function (Row $row) {

                $row->column(12, function (Column $column) {

                    $form = new Form();

                    $form->action(admin_url('/'));
                    $form->method('GET');
                    $dates = [];
                    $timestamp = time() - 86400 * 15;
                    for ($i = 1; $i <= 30; $i++) {
                        $time = $timestamp + 86400 * $i;
                        $dates [date('Ymd', $time)] = date('Y-m-d', $time);
                    }
                    $picktimes = [];
                    $picktimes[0] = '请选择取货时间段';
                    foreach (PickupTimeModel::all()->toArray() as $key => $pick) {
                        $picktimes[$pick['id']] = $pick['start'] . '-' . $pick['end'];
                    }
                    $form->select('date', '取货日期')->options($dates)->default(request('date', date('Ymd')));
                    $form->select('pickuptime_id', '取货时间段')->options($picktimes)->default(request('pickuptime_id', 0));

                    $column->append((new Box('销售统计筛选', $form))->removable()->collapsable()->style('info'));
                });


            });
            $date = request('date', date('Ymd'));
            $pickuptimeId = request('pickuptime_id', 0);
            $select = Goods::where('date', $date)->select(app('db')
                ->raw('SUM(count) as num,product_id,`date`'))
                ->whereIn('status', [OrderService::PAYED])
            ;
            if ($pickuptimeId) {
                $select->where('pickuptime_id', $pickuptimeId);
            }
            $select = $select->groupBy('product_id')->with('product')->get()->pluck(null, 'product_id')->toArray();
            $headers = ['商品名称', '销售日期', '售出数量'];
            $rows = [];
            foreach ($select as $item) {
                $rows[] = [$item['product']['name'], $item['date'], $item['num']];
            }
            $content->row((new Box('统计详情', new Table($headers, $rows)))->style('info')->solid());
        });
    }
}

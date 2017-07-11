<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Metro\Place;
use App\Models\PickupTime;
use App\Models\Order\Order as OrderModel;
use App\Http\Services\Order as OrderService;

class PickuplistController extends Controller
{

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        $places = Place::all()->keyBy('id');
        $pickuptimes = PickupTime::all()->keyBy('id');
        $orders = collect([]);
        if (request('place_id') || request('pickuptime_id')) {
            $orders = OrderModel::with('goods', 'goods.product')->where('date', date('Ymd'))->whereIn('status', [OrderService::PAYED, OrderService::PICKED, OrderService::FINISHED]);
            if (request('place_id')) {
                $orders->where('place_id', request('place_id'));
            }
            if (request('pickuptime_id')) {
                $orders->where('pickuptime_id', request('pickuptime_id'));
            }
            $orders = $orders->get();
            if ($orders->count()) {
                foreach ($orders as $key => $order) {
                    $orders[$key]['tail'] = (int)substr($order['phone'], 7, 4);
                }
                $orders = $orders->sortBy('tail');
            }
        }
        return view('pickuplist', ['places' => $places, 'pickuptimes' => $pickuptimes, 'orders' => $orders->toArray()]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Metro\Place as PlaceModel;
use App\Models\PickupTime as PickupTimeModel;
use App\Models\Product\Products as ProductModel;

class CartController extends Controller
{

    const SESSION_KEY = 'cart';

    public function __construct()
    {
        //$this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index($placeId = null)
    {
        $todayIndex = date('w');
        $start = strtotime("-{$todayIndex} day");
        $dates = [];
        $carts = session(self::SESSION_KEY);
        for ($i = 0; $i < 21; $i++) {
            $timestamp = $start + ($i * 86400);
            $dates[] = [
                'show'     => date('d', $timestamp),
                'date'     => date('Ymd', $timestamp),
                'selected' => array_get($carts, date('Ymd', $timestamp), []),
            ];
        }
        $place = $placeId ? PlaceModel::find($placeId) : null;
        //获取周
        $date = date('Ymd', strtotime(request('date', date('Ymd'))));
        if (!$date) {
            abort(404);
        }
        $pickuptimes = PickupTimeModel::all()->toArray();
        $products = ProductModel::available()->get()->toArray();
        $cart = isset($carts[$date]) ? $carts[$date] : [];
        return view('cart', [
            'dates'       => $dates,
            'place'       => $place,
            'date'        => $date,
            'pickuptimes' => $pickuptimes,
            'products'    => $products,
            'cart'        => $cart,
        ]);
    }

    public function add()
    {
        if (!request('date') || request('count') === null || !request('product_id')) {
            return [
                'error'   => 1,
                'message' => '参数错误',
            ];
        }
        $data = session(self::SESSION_KEY, []);
        if (request('count')) {
            $data[request('date')][request('product_id')] = request('count');
        } else {
            unset($data[request('date')][request('product_id')]);
        }

        session([self::SESSION_KEY => $data]);
        return [
            'error'   => 0,
            'message' => 'ok',
        ];
    }
}
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
    public function __construct()
    {
        //$this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index($placeId = null)
    {
        $todayIndex = date('w');
        $start = strtotime("-{$todayIndex} day");
        $dates = [];
        for ($i = 0; $i < 21; $i++) {
            $timestamp = $start + ($i * 86400);
            $dates[] = [
                'show' => date('d', $timestamp),
                'date' => date('Ymd', $timestamp),
            ];
        }
        $place = $placeId ? PlaceModel::find($placeId) : null;
        //获取周
        $date = strtotime(request('date', date('Ymd')));
        $pickuptimes = PickupTimeModel::all()->toArray();
        $products = ProductModel::available()->get()->toArray();
        return view('cart', ['dates' => $dates, 'place' => $place, 'date' => $date, 'pickuptimes' => $pickuptimes, 'products' => $products]);
    }
}
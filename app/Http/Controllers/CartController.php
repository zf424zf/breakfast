<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;


class CartController extends Controller
{
    public function __construct()
    {
        //$this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        $todayIndex = date('w');
        $start = strtotime("-{$todayIndex} day");
        $dates = [];
        for ($i = 0; $i < 21; $i++) {
            $timestamp = $start + ($i * 86400);
            $dates[] = [
                'show'     => date('d', $timestamp),
                'date'     => date('Y-m-d', $timestamp),
                'is_today' => date('Y-m-d', $timestamp) == date('Y-m-d') ? true : false,
            ];
        }
        return view('cart', ['dates' => $dates]);
    }
}
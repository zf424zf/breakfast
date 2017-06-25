<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Posts as PostsModel;

class TestController extends Controller
{
    const NEWS_CATID = 2;

    public function __construct()
    {
        //$this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        echo strlen('0626594fe7b0003999302');
        $orderIds = [];
        for($i = 0 ;$i < 1000;$i++){
            $orderIds[] = \App\Http\Services\Order::buildOrderId();
        }
        var_dump(array_count_values($orderIds));
    }
}
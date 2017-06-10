<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;


class LocationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        return view('location');
    }
}
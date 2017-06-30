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
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        var_dump(app('cache')->remember('test',\Carbon\Carbon::now()->addSeconds(10),function (){
            return 123;
        }));
    }
}
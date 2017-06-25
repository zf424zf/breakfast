<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Posts as PostsModel;

class IndexController extends Controller
{
    const NEWS_CATID = 2;

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        $posts = PostsModel::select(['id', 'subject', 'cover', 'summary'])->where('category_id', self::NEWS_CATID)->orderBy('id', 'DESC')->take(10)->get()->toArray();
        app('user')->info();
        return view('index', ['posts' => $posts]);
    }
}
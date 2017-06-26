<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Posts as PostsModel;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function show($id)
    {
        $post = PostsModel::find($id)->toArray();
        return view('post', ['post' => $post]);
    }
}
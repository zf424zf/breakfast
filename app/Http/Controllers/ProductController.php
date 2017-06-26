<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Product\Products as ProductModel;

class ProductController extends Controller
{
    const NEWS_CATID = 2;

    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function show($id)
    {
        $product = ProductModel::findOrFail($id);
        return view('product.show', ['product' => $product]);
    }
}
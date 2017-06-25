@extends('layout')
@section('title','首页')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-gray">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back_btn" onclick="history.back(-1)"></a>
                <h1 class="title">一起吃早餐</h1>
            </header>
            <!--头部结束-->
            <!--我的订单开始-->
            <div class="content order-cont">
                <h4>确认订单</h4>
                <div class="list-block order-contact">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">联系人</div>
                                    <div class="item-input"><input type="text" placeholder="您的称呼"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">联系电话</div>
                                    <div class="item-input"><input type="text" placeholder="您的联系电话"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">所在公司</div>
                                    <div class="item-input"><input type="text" placeholder="选填"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--<div class="space"></div>
                <div class="list-block order-contact">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">取货地点</div>
                                    <div class="item-input"><input type="text" placeholder="上海徐汇"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">取货时间</div>
                                    <div class="item-input">
                                        <select>
                                            <option>7:30-9:30</option>
                                            <option>7:30-9:30</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>-->
                <div class="space"></div>
                <div class="card">
                    <div class="card-header"><p>共4个订单</p></div>
                    <div class="card-content">
                        <div class="card-content-top">
                            <p class="pull-left"><span>7:30-9:30 5-23 周一 (中央商场) </span></p>
                        </div>
                        <div class="list-block media-list">
                            <ul>
                                <li class="item-content">
                                    <div class="item-media">
                                        <img src="../static/images/food.jpg" width="44" />
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            培根三明治
                                        </div>
                                        <div class="item-subtitle">
                                            <p class="pull-left">x1</p>
                                            <p class="pull-right">￥10.50</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content">
                                    <div class="item-media">
                                        <img src="../static/images/food.jpg" width="44" />
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            培根三明治
                                        </div>
                                        <div class="item-subtitle">
                                            <p class="pull-left">x1</p>
                                            <p class="pull-right">￥10.50</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-content-top">
                            <p class="pull-left"><span>7:30-9:30 5-23 周一 (中央商场) </span></p>
                        </div>
                        <div class="list-block media-list">
                            <ul>
                                <li class="item-content">
                                    <div class="item-media">
                                        <img src="../static/images/food.jpg" width="44" />
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            培根三明治
                                        </div>
                                        <div class="item-subtitle">
                                            <p class="pull-left">x1</p>
                                            <p class="pull-right">￥10.50</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content last">
                                    <div class="item-media">
                                        <img src="../static/images/food.jpg" width="44" />
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            培根三明治
                                        </div>
                                        <div class="item-subtitle">
                                            <p class="pull-left">x1</p>
                                            <p class="pull-right">￥10.50</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="list-block order-contact">
                        <ul>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">早餐金额</div>
                                    <div class="item-after">￥6.00</div>
                                </div>
                            </li>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">促销价</div>
                                    <div class="item-after f-gray">￥0.00</div>
                                </div>
                            </li>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">优惠券抵扣</div>
                                    <div class="item-after">
                                        <select>
                                            <option>无</option>
                                            <option>优惠券1</option>
                                        </select>
                                        <span class="icon icon-right"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="item-content item-price">
                                <div class="item-inner">
                                    <div class="item-title">总计<em>￥</em>20<span>优惠<em>￥</em>0</span></div>
                                    <div class="item-after">待支付￥27.6</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--我的订单结束-->

            <!--底部悬浮开始-->
            <nav class="bar bar-tab bar-pay">
                <p class="pull-left">总计<em>￥27.5</em><span>已优惠0元</span></p>
                <a class="pull-right external" href="#">去支付</a>
            </nav>
            <!--底部悬浮结束-->
        </div>
    </div>
@endsection
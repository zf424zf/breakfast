@extends('layout')
@section('title','首页')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-address">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back_btn" onclick="history.back(-1)"></a>
                <h1 class="title">我要下单</h1>
            </header>
            <!--头部结束-->
            <!--订餐地址选择开始-->
            <div class="content">
                <div class="location-box">
                    <div class="location"><img src="{{cdn('images/location.png')}}" alt=""/><span>请选择取货地点</span></div>
                </div>
                <div class="calendar">
                    <div class="calendar-month">{{chinese_month()}}</div>
                    <div class="calendar-date">
                        <ul class="week">
                            <li>周日</li>
                            <li>周一</li>
                            <li>周二</li>
                            <li>周三</li>
                            <li>周四</li>
                            <li>周五</li>
                            <li>周六</li>
                        </ul>
                        <ul>
                            @foreach($dates as $date)
                            <li @if($date['is_today']) class="cur" @endif>{{$date['show']}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="pick-up-cont">
                    <div class="top">
                        <ul class="list-block">
                            <li class="cur">本周</li>
                            <li>周一05-19</li>
                            <li>
                                <label>取餐时间：</label>
                                <select>
                                    <option>7:30-9:30</option>
                                    <option>7:30-9:30</option>
                                    <option>7:30-9:30</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div class="bottom">
                        <div class="list-block media-list cart-list">
                            <ul>
                                <li class="item-content">
                                    <div class="item-media">
                                        <a href="#" class="food-alert">
                                            <img src="../static/images/food.jpg" width="80"/>
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title">培根三明治</div>
                                        </div>
                                        <div class="item-subtitle">食材：培根、鸡蛋、面包</div>
                                        <div class="item-text">
                                            <div class="pull-left">
                                                ￥10.50 <span>15.00</span>
                                            </div>
                                            <div class="pull-right food-cart"><a href="javascript:;" class="food-add"></a> </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content">
                                    <div class="item-media">
                                        <a href="#">
                                            <img src="../static/images/food.jpg" width="80"/>
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title">培根三明治</div>
                                        </div>
                                        <div class="item-subtitle">食材：培根、鸡蛋、面包</div>
                                        <div class="item-text">
                                            <div class="pull-left">
                                                ￥10.50 <span>15.00</span>
                                            </div>
                                            <div class="pull-right food-cart">
                                                <a href="javascript:;" class="food-minus"></a>
                                                <span>1</span>
                                                <a href="javascript:;" class="food-add"></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content">
                                    <div class="item-media">
                                        <a href="#">
                                            <img src="../static/images/food.jpg" width="80"/>
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title">培根三明治</div>
                                        </div>
                                        <div class="item-subtitle">食材：培根、鸡蛋、面包</div>
                                        <div class="item-text">
                                            <div class="pull-left">
                                                ￥10.50 <span>15.00</span>
                                            </div>
                                            <div class="pull-right food-cart">
                                                <a href="javascript:;" class="food-minus"></a>
                                                <span>1</span>
                                                <a href="javascript:;" class="food-add"></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--订餐地址结束-->
            <!--底部悬浮开始-->
            <nav class="bar bar-tab bar-pay cart-pay">
                <div class="pull-left">
                    <div class="cart-box"><i>3</i> <img src="{{cdn('images/cart.png')}}" alt=""/></div>
                    <div class="cart-price">
                        ￥27.5<span>已优惠0元</span>
                    </div>
                </div>
                <a class="pull-right external" href="#">去支付</a>
            </nav>
            <!--底部悬浮结束-->
        </div>
        <div class="cover"></div>
        <!--早餐详情-->
        <div class="food-detail">
            <div class="close-btn"><img src="{{cdn('images/close.png')}}" alt=""/></div>
            <img src="../static/images/pic.jpg" alt=""/>
            <div class="txt">
                <h4>培根西红柿三明治</h4>
                <p>食材：培根、鸡蛋、西红柿、面包</p>
                <p>卡路里：30</p>
                <div><span>推荐：</span>
                    <ul>
                        <li class="solid"></li>
                        <li class="solid"></li>
                        <li class="solid"></li>
                        <li class="solid"></li>
                        <li class="hollow"></li>
                    </ul>
                </div>
            </div>
            <div class="food-detail-footer">
                <div class="pull-left">￥10.50</div>
                <a href="javascript:;">加入购物车</a>
            </div>
        </div>
        <!--购物车-->
        <div class="food-list">
            <h4><span>购物车</span></h4>
            <h6>星期一 5-22</h6>
            <div class="list-block">
                <ul>
                    <li class="item-content">
                        <div class="item-inner">
                            <div class="item-title">培根三明治</div>
                            <div class="item-after">
                                <div class="pull-left">
                                    ￥10.50
                                </div>
                                <div class="pull-right food-cart">
                                    <a href="javascript:;" class="food-minus"></a>
                                    <span>2</span>
                                    <a href="javascript:;" class="food-add"></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-inner">
                            <div class="item-title">培根三明治</div>
                            <div class="item-after">
                                <div class="pull-left">
                                    ￥10.50
                                </div>
                                <div class="pull-right food-cart">
                                    <a href="javascript:;" class="food-minus"></a>
                                    <span>1</span>
                                    <a href="javascript:;" class="food-add"></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <h6>星期二 5-23</h6>
            <div class="list-block">
                <ul>
                    <li class="item-content">
                        <div class="item-inner">
                            <div class="item-title">培根三明治</div>
                            <div class="item-after">
                                <div class="pull-left">
                                    ￥10.50
                                </div>
                                <div class="pull-right food-cart">
                                    <a href="javascript:;" class="food-minus"></a>
                                    <span>2</span>
                                    <a href="javascript:;" class="food-add"></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-inner">
                            <div class="item-title">培根三明治</div>
                            <div class="item-after">
                                <div class="pull-left">
                                    ￥10.50
                                </div>
                                <div class="pull-right food-cart">
                                    <a href="javascript:;" class="food-minus"></a>
                                    <span>1</span>
                                    <a href="javascript:;" class="food-add"></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
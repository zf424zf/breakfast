@extends('layout')
@section('title','我要下单')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-address" id="cart">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back"></a>
                <h1 class="title">我要下单</h1>
            </header>
            <!--头部结束-->
            <!--订餐地址选择开始-->
            <div class="content">
                <div class="location-box">
                    <div class="location">
                        <img src="{{cdn('images/location.png')}}" alt=""/>
                        <a href="{{url('/metro')}}">{{$place->name or '请选择取货地点'}}</a>
                    </div>
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
                            @foreach($dates as $d)
                                <?php
                                    $class = '';
                                    if($d['date'] == $date){
                                        $class = 'cur';
                                    }elseif($d['date'] < date('Ymd')){
                                        $class = 'f-gray';
                                    }elseif(array_sum($d['selected'])){
                                        $class = 'dot';
                                    }
                                ?>
                                <li class="{{$class}}">
                                    @if($d['date'] < date('Ymd'))
                                        {{$d['show']}}
                                    @else
                                        <a href="{{url()->current()}}?date={{$d['date']}}" data-no-cache="true">{{$d['show']}}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="pick-up-cont">
                    <div class="top">
                        <ul class="list-block">
                            <li class="cur">{{chinese_human_week($date)}}</li>
                            <li>{{chinese_week(strtotime($date))}} {{date('m-d',strtotime($date))}}</li>
                            <li>
                                <label>取餐时间：</label>
                                <select name="pickuptime" id="pickuptime">
                                    @foreach($pickuptimes as $pickuptime)
                                    <option value="{{$pickuptime['id']}}">{{$pickuptime['start']}}-{{$pickuptime['end']}}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div class="bottom">
                        <div class="list-block media-list cart-list">
                            <ul id="cart-list">
                                @foreach($products as $product)
                                <li class="item-content" data-date="{{$date}}" data-count="{{$cart[$product['id']] or 0}}" data-id="{{$product['id']}}">
                                    <div class="item-media">
                                        <a href="#" class="food-alert">
                                            <img src="{{img_url($product['img'],80,80)}}" width="80"/>
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title">{{$product['name']}}</div>
                                        </div>
                                        <div class="item-subtitle">食材：{{$product['material']}}</div>
                                        <div class="item-text">
                                            <div class="pull-left">
                                                ￥{{$product['coupon_price']}} <span>{{$product['origin_price']}}</span>
                                            </div>
                                            <div class="pull-right food-cart">
                                                <a href="javascript:;" class="food-reduce"></a>
                                                <span class="food-count">1</span>
                                                <a href="javascript:;" class="food-add"></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--订餐地址结束-->
            <!--底部悬浮开始-->
            <nav class="bar bar-tab bar-pay cart-pay">
                <div class="pull-left">
                    <div class="cart-box"><i id="cart-count">0</i> <img src="{{cdn('images/cart.png')}}" alt=""/></div>
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
        <div class="food-list" id="food-list">
        </div>
    </div>
@endsection
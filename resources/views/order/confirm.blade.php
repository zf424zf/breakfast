@extends('layout')
@section('title','确认订单')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-gray">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back"></a>
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
                                    <div class="item-input">
                                        <input type="text" name="name" placeholder="您的称呼" value="{{$lastOrder['name'] or ''}}">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">联系电话</div>
                                    <div class="item-input">
                                        <input type="text" name="phone" placeholder="您的联系电话" value="{{$lastOrder['phone'] or ''}}">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">所在公司</div>
                                    <div class="item-input">
                                        <input type="text" name="company" placeholder="选填" value="{{$lastOrder['company'] or ''}}">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="space"></div>
                <div class="card">
                    <div class="card-header"><p>共{{$orderCount}}个订单</p></div>
                    @if($count)
                        @foreach($datas as $date => $dateData)
                            @if(array_sum(array_dot($dateData)) > 0)
                                @foreach($dateData as $placeId => $placeData)
                                    @foreach($placeData as $pickuptimeId => $pickuptimeData)
                                        @if(array_sum($pickuptimeData) > 0)
                                            <div class="card-content">
                                                <div class="card-content-top">
                                                    <p class="pull-left">
                                                        <span>
                                                            {{$pickuptimes[$pickuptimeId]['start']}}-{{$pickuptimes[$pickuptimeId]['end']}}
                                                            {{date('m-d',strtotime($date))}} {{chinese_week(strtotime($date))}}
                                                            ({{$places[$placeId]['name']}})
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="list-block media-list">
                                                    <ul>
                                                        @foreach($pickuptimeData as $productId => $count)
                                                        <li class="item-content">
                                                            <div class="item-media">
                                                                <img src="{{img_url($products[$productId]['img'],80,80)}}" width="44"/>
                                                            </div>
                                                            <div class="item-inner">
                                                                <div class="item-title-row">
                                                                    {{$products[$productId]['name']}}
                                                                </div>
                                                                <div class="item-subtitle">
                                                                    <p class="pull-left">x{{$count}}</p>
                                                                    <p class="pull-right">￥{{$products[$productId]['origin_price']}}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <div class="cart-empty">
                            购物车空空如也,快去挑选您的商品吧 <a href="#" class="back">去挑选</a>
                        </div>
                    @endif
                    <div class="space"></div>
                    <div class="list-block order-contact" style="margin-bottom: 3rem;">
                        <ul>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">总价</div>
                                    <div class="item-after">￥{{$amount + $couponAmount}}</div>
                                </div>
                            </li>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">促销价</div>
                                    <div class="item-after f-gray">￥{{$amount}}</div>
                                </div>
                            </li>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">优惠券抵扣</div>
                                    <div class="item-after">
                                        @if($coupon)
                                            {{$coupon['name']. '  ￥-'.$coupon['amount']}}
                                        @else
                                            无
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="item-content item-price">
                                <div class="item-inner">
                                    <div class="item-title">总计<em>￥</em>{{$amount + $couponAmount}}<span>优惠<em>￥</em>{{$couponAmount}}</span></div>
                                    <div class="item-after">待支付￥{{$amount}}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--我的订单结束-->

            <!--底部悬浮开始-->
            <nav class="bar bar-tab bar-pay">
                <p class="pull-left">总计<em>￥{{$amount}}</em><span>已优惠{{$couponAmount}}元</span></p>
                <a class="pull-right" href="javascript:;" id="create-order">去支付</a>
            </nav>
            <!--底部悬浮结束-->
        </div>
    </div>
@endsection
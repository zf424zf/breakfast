@extends('layout')
@section('title','我的订单')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="{{url('/')}}" class="icon icon-left pull-left"></a>
                <h1 class="title">{{setting('title')}}</h1>
            </header>
            <!--头部结束-->
            <!--我的订单开始-->
            <div class="content order-cont">
                <h4>我的早餐</h4>
                <div class="calendar" id="order-list-calendar">
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
                                if($d['date'] < date('Ymd')){
                                    $class = 'f-gray';
                                }elseif(isset($orderKeybyDates[$d['date']])){
                                    $class = '';
                                    foreach ($orderKeybyDates[$d['date']] as $order){
                                        if($order['status'] == 0){
                                            $class = 'blue';
                                        }
                                    }
                                    foreach ($orderKeybyDates[$d['date']] as $order){
                                        if($order['status'] == 1){
                                            $class = 'orange';
                                        }
                                    }
                                }
                                ?>
                                <li class="{{$class}}">
                                    @if($d['date'] < date('Ymd'))
                                        {{$d['show']}}
                                    @else
                                        <a href="javascript:;" data-date="{{$d['date']}}" data-no-cache="true">{{$d['show']}}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if(!isset($orderKeybyDates[date('Ymd',time() + 86400)]))
                <div class="calendar-info">
                    <span>明天</span> (未预定)
                </div>
                @endif
                <h4>我的订单</h4>
                @foreach($batchs as $key => $orders)
                <div class="card">
                    <div class="card-header">
                        <p>下单时间 {{date('Y-m-d H:i',$key)}}</p>
                    </div>
                    @foreach($orders as $order)
                    <div class="card-content">
                        <div class="card-content-top">
                            <p class="pull-left">
                                <span>
                                    请在
                                    {{date('m-d',strtotime($order['date']))}}当天
                                    {{chinese_week(strtotime($order['date']))}}
                                    {{$order['pickuptime']['start']}} - {{$order['pickuptime']['end']}}取餐

                                </span>
                            </p>
                            <p class="pull-right f-blue border-blue" >
                                {{order_status($order['status'])}}
                            </p>
                        </div>
                        <div class="list-block media-list">
                            <ul>
                                @foreach($order['goods'] as $good)
                                <li class="item-content">
                                    <div class="item-media">
                                        <img src="{{img_url($good['product']['img'],80,80)}}" width="44" />
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            {{$good['product']['name']}}
                                        </div>
                                        <div class="item-subtitle">
                                            <p class="pull-left">x{{$good['count']}}</p>
                                            <p class="pull-right">￥{{$good['price']}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if($order['status'] == 1)
                    <div class="card-footer">
                        <p class="pull-left"></p>
                        <div class="pull-right">
                            @if(strtotime($order['date'] . ' ' . $order['pickuptime']['start']) - setting('stop_refund_hour', 8) * 3600 > time())
                            <a href="javascript:;" data-id="{{$order['order_id']}}" class="button button-fill border-orange order-refund">申请退款</a>
                            @endif
                            @if(strtotime($order['date'] . ' ' . $order['pickuptime']['end']) < time())
                            <a href="javascript:;" class="button button-fill button-gray">取货码</a>
                            @else
                            <a href="{{url('order/pickup?order_id='.$order['order_id'])}}" class="button button-fill button-orange">取货码</a>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @if(array_first($orders)['status'] == 0)
                    <div class="card-footer">
                        <p class="pull-left"></p>
                        <div class="pull-right">
                            <span>¥{{array_sum(array_column($orders,'amount'))}}</span>
                            <a href="javascript:;"data-ids="{{implode(',',array_column($orders,'order_id'))}}" class="pull-right button cancel-order">取消订单</a>
                            <a href="{{url('order/pay?order_ids='.implode(',',array_column($orders,'order_id')))}}" class="button button-fill">去支付</a>
                        </div>
                    </div>
                    @endif
                </div>
                    @if(!$loop->last)
                        <div class="space"></div>
                    @endif
                @endforeach
            </div>
            <!--我的订单结束-->
        </div>
    </div>
@endsection
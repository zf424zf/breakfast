@extends('layout')
@section('title','首页')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back"></a>
                <h1 class="title">一起吃早餐</h1>
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
                                }elseif(array_sum(array_dot($d['selected']))){
                                    $class = 'dot';
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
                <div class="calendar-info">
                    <span>明天</span> (未预定)
                </div>
                <h4>我的订单</h4>
                <div class="card">
                    <div class="card-header"><p>下单时间 2017-05-19 18:30</p><span class="f-orange">待支付</span></div>
                    <div class="card-content">
                        <div class="card-content-top">
                            <p class="pull-left">周一5-23 <span>请在当天7:30-9:30取餐</span></p>
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
                            <p class="pull-left">周二5-24<span>请在当天7:30-9:30取餐</span></p>
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
                    <div class="card-footer">
                        <p class="pull-left"></p>
                        <div class="pull-right">
                            <span>¥800</span>
                            <a href="#" class="pull-right button">取消订单</a>
                            <a href="#" class="button button-fill">去支付</a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="card">
                    <div class="card-header"><p>下单时间 2017-05-19 18:30</p><span class="f-orange">已支付</span></div>
                    <div class="card-content">
                        <div class="card-content-top">
                            <p class="pull-left">周一5-23 <span>请在当天7:30-9:30取餐</span></p>
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
                    <div class="card-footer">
                        <p class="pull-left"></p>
                        <div class="pull-right">
                            <a href="#" class="button button-fill button-gray">已取货</a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-content-top">
                            <p class="pull-left">周一5-23 <span>请在当天7:30-9:30取餐</span></p>
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
                    <div class="card-footer">
                        <p class="pull-left"></p>
                        <div class="pull-right">
                            <a href="#" class="button button-fill border-orange">申请退款</a>
                            <a href="#" class="button button-fill button-orange">取货码</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--我的订单结束-->
        </div>
    </div>
@endsection
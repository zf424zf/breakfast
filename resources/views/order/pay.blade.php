@extends('layout')
@section('title','支付')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-gray" data-config='<?php echo app('wechat')->js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage','chooseImage','chooseWXPay')) ?>'>
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="{{url('order/confirm')}}" data-no-cache="true" class="icon icon-left pull-left"></a>
                <h1 class="title">一起吃早餐</h1>
            </header>
            <!--头部结束-->
            <!--确认支付开始-->
            <div class="content">
                <div class="pay-cont">
                    <div class="pay-detail">
                        <div class="top">
                            <h4>谢谢订购</h4>
                            <p>本单30分钟内有效，请尽快支付，以免订完</p>
                        </div>
                        @foreach($orders as $order)
                        <div class="bottom">
                            <p class="fl">订单 #{{$order['order_id']}}# </p>
                            <p class="fr">￥{{$order['amount']}}</p>
                        </div>
                        @endforeach
                        @if($coupon)
                        <div class="space"></div>
                        <div class="bottom">
                            <p class="fl">优惠券: {{$coupon['name']}} </p>
                            <p class="fr">-￥{{$coupon['amount']}}</p>
                        </div>
                        @endif
                        <div class="space"></div>
                        <div class="bottom">
                            <p class="fl">支付金额:  </p>
                            <?php
                                $amount = array_sum(array_column($orders,'amount'));
                                if($coupon){
                                    $amount = $amount - $coupon['amount'] > 0 ? $amount - $coupon['amount'] : 0;
                                }
                            ?>
                            <p class="fr">￥{{$amount}}</p>
                        </div>
                    </div>
                    <div class="list-block media-list">
                        <h4>请选择支付方式</h4>
                        <ul>
                            <!--<li>
                                <label class="label-checkbox item-content">
                                    <div class="item-inner">
                                        <div class="item-pic"><img src="../static/images/zhifubao.png"></div>
                                        <div class="item-title-row">
                                            <div class="item-title">支付宝</div>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="my-checkbox" checked="checked">
                                    <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
                                </label>
                            </li>-->
                            <li>
                                <label class="label-checkbox item-content">
                                    <div class="item-inner">
                                        <div class="item-pic"><img src="{{cdn('images/weixin.png')}}"></div>
                                        <div class="item-title-row">
                                            <div class="item-title">微信支付</div>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="my-checkbox" checked>
                                    <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="content-block">
                        <a href="javascript:;" data-orders="{{implode(',',array_column($orders,'order_id'))}}" id="confirm-pay" class="button button-big button-fill">确认支付</a>
                    </div>
                    <div class="pay-tips">
                        <div class="fl">注：</div>
                        <div class="fl">
                            <p>成功支付后，凭订单的取餐码到取货点领取。</p>
                            <p>本订单遵从<a href="#" target="_blank">《交易约定》</a> </p>
                        </div>
                    </div>
                </div>
            </div>
            <!--确认支付结束-->
        </div>

    </div>
@endsection
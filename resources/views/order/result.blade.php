@extends('layout')
@section('title','支付结果')
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
                <a href="{{url('/order')}}" data-no-cache="true" class="pull-right">完成</a>
            </header>
            <!--头部结束-->
            <!--已收货开始-->
            <div class="content">
                <div class="page-skip">
                    <h4>您的订单已生成</h4>
                    <div class="img"><img src="{{cdn('images/skip.png')}}" alt="" /></div>
                    <p>请您在约定的时间内取餐</p>
                    <div class="content-block">
                        <a href="{{url('/order')}}" data-no-cache="true" class="button button-big">查看详情</a>
                    </div>
                </div>
            </div>
            <!--已收货结束-->
        </div>

    </div>
@endsection
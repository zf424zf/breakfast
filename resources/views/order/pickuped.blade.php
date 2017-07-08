@extends('layout')
@section('title','早餐')
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
            <!--完成取货开始-->
            <div class="content">
                <div class="page-skip pick-up">
                    {{date('m月d日',strtotime($order['date']))}}
                    {{$order['pickuptime']['start']}} - {{$order['pickuptime']['end']}}
                    <br>
                    {{$order['place']['name']}}
                    @foreach($order['goods'] as $good)
                        <p>{{$good['product']['name']}}x{{$good['count']}}</p>
                    @endforeach
                    <div class="img"><img src="{{cdn('images/code.png')}}" alt=""/></div>
                    <div class="content-block">
                        <a href="{{url('order')}}" data-no-cache="true">完成取货</a>
                    </div>
                </div>
            </div>
            <!--完成取货结束-->
        </div>
@endsection
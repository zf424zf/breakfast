@extends('layout')
@section('title','早餐')
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
            <!--早餐色块开始-->
            <div class="content">
                <div class="color-lump">
                    <h4>
                        {{date('m月d日',strtotime($order['date']))}}
                        {{$order['pickuptime']['start']}} - {{$order['pickuptime']['end']}}
                        <br>
                        {{$order['place']['name']}}
                    </h4>
                    <?php
                    $colors = ["#0093db", "#fb914a", "#5eaf6d", "#f361a0", "#987dfc", "#fbcdd6", "#a0da55"];
                    ?>
                    <div class="row no-gutter">
                        @foreach($order['goods'] as $good)
                        <div class="col-50" style="background: {{$colors[array_rand($colors,1)]}}">{{$good['product']['name']}}x{{$good['count']}}</div>
                        @endforeach
                    </div>
                    <div class="bar-footer">
                        <a href="javascript:;" id="confirm-pickup" data-id="{{$order['order_id']}}" class="button button-fill button-big">确认取货</a>
                    </div>
                </div>

            </div>
            <!--早餐色块结束-->

        </div>
@endsection
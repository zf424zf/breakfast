@extends('layout')
@section('title','首页')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-index" id="index">
            <!--头部开始-->
            <header class="bar bar-nav">
                <h1 class="title">{{setting('title')}}</h1>
            </header>
            <!--头部结束-->
            <!--首页开始-->
            <div class="content">
                <!--幻灯片开始-->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="../static/images/banner1.jpg" alt="" style='width: 100%'>
                        </div>
                        <div class="swiper-slide"><img src="../static/images/banner2.jpg" alt="" style='width: 100%'>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <!--幻灯片结束-->
                <!--入口工具栏开始-->
                <div class="row no-gutter">
                    <div class="col-50">
                        <a class="tab-item active" href="{{url('metro')}}">
                            <img src="../static/images/book.png" alt=""/>我要订餐
                        </a>
                    </div>
                    <div class="col-50">
                        <a class="tab-item" href="#">
                            <img src="../static/images/order.png" alt=""/>我的订单
                        </a>
                    </div>
                </div>
                <!--入口工具栏结束-->
                <!--健康饮食开始-->
                <div class="list-block media-list">
                    <h4>健康饮食</h4>
                    <ul>
                        <li>
                            <a href="#" class="item-content">
                                <div class="item-media"><img src="../static/images/pic.jpg" width="80"/></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">一日之季在于晨</div>
                                    </div>
                                    <div class="item-text">早餐是一天之中最重要的,早餐是一天之中最重要的，早餐是一天之中最重要的</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item-content">
                                <div class="item-media"><img src="../static/images/pic.jpg" width="80"/></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">一日之季在于晨</div>
                                    </div>
                                    <div class="item-text">早餐是一天之中最重要的,早餐是一天之中最重要的，早餐是一天之中最重要的</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item-content">
                                <div class="item-media"><img src="../static/images/pic.jpg" width="80"/></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">一日之季在于晨</div>
                                    </div>
                                    <div class="item-text">早餐是一天之中最重要的,早餐是一天之中最重要的，早餐是一天之中最重要的</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--健康饮食结束-->
            </div>

            <!--底部悬浮开始-->
        @include('nav')
        <!--底部悬浮结束-->
            <!--首页结束-->
        </div>

    </div>
@endsection
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
                <div class="calendar">
                    <div class="calendar-month f-small">5月</div>
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
                            <li>21</li>
                            <li class="orange">22</li>
                            <li>23</li>
                            <li class="cur">24</li>
                            <li class="blue">25</li>
                            <li>26</li>
                            <li class="dot">27</li>
                            <li>28</li>
                            <li>29</li>
                            <li>30</li>
                            <li>31</li>
                            <li>28</li>
                            <li>29</li>
                            <li>30</li>
                            <li>31</li>
                            <li>28</li>
                            <li>29</li>
                            <li>30</li>
                            <li class="f-gray">1</li>
                            <li class="f-gray">2</li>
                            <li class="f-gray">3</li>
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
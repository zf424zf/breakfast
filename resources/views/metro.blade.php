@extends('layout')
@section('title','首页')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page" id="choose-station">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back_btn back"></a>
                <h1 class="title">{{setting('title')}}</h1>
            </header>
            <!--头部结束-->
            <!--地址定位开始-->
            <div class="content">
                <div class="search-box">
                    <div class="address">上海 <span class="icon icon-down"></span></div>
                    <div class="searchbar">
                        <a class="searchbar-cancel">取消</a>
                        <div class="search-input">
                            <label class="icon icon-search" for="search"></label>
                            <input type="search" id='search' placeholder='请输入地址'/>
                        </div>
                    </div>
                </div>
                <div class="location-list">
                    <div class="top row no-gutter">
                        <div class="col-50">地铁</div>
                        <div class="col-50">地铁站</div>
                    </div>
                    <div class="cont">
                        <ul>
                            @foreach($metros as $metro)
                            <li>
                                <p @if($loop->first) class="active" @endif>{{$metro['name']}} <span class="icon icon-right"></span></p>
                                <dl @if($loop->first) style="display: block" @endif>
                                    @foreach($metro['stations'] as $station)
                                    <dd>{{$station['name']}}</dd>
                                    @endforeach
                                </dl>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--地址定位结束-->
        </div>
    </div>
@endsection
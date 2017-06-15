@extends('layout')
@section('title','首页')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-gray" id="choose-place">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back"></a>
                <h1 class="title">一起吃早餐</h1>
            </header>
            <!--头部结束-->
            <!--地图定位开始-->
            <div class="content">
                <div class="search-box">
                    <div class="address">上海</div>
                    <div class="searchbar">
                        <a class="searchbar-cancel">取消</a>
                        <div class="search-input">
                            <label class="icon icon-search" for="search"></label>
                            <input type="search" id='search' placeholder='请输入地址'/>
                        </div>
                    </div>
                </div>
                <div class="map-box">
                    <div class="top">
                        <select id="station-select" name="station-select">
                            <option value="">人民广场站</option>
                            <option value="">人民广场站2</option>
                            <option value="">人民广场站22</option>
                            <option value="">人民广场站233</option>
                            <option value="">人民广场站2444</option>
                        </select>
                    </div>
                    <ul>
                        @foreach($station->places as $place)
                        <li data-id="{{$place['id']}}">
                            <h4><span>{{$loop->index + 1}}</span>{{$place['name']}}</h4>
                            <p>{{$place['address']}}</p>
                        </li>
                        <li class="map" id="map-{{$place['id']}}" data-lat="{{$place['lat']}}" data-lng="{{$place['lng']}}"></li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <!--地图定位结束-->
        </div>
    </div>
@endsection
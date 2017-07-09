@extends('layout')
@section('title',$post['subject'])
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page page-gray">
            <!--头部开始-->
            <header class="bar bar-nav">
                <a href="#" class="icon icon-left pull-left back"></a>
                <h1 class="title">{{setting('title')}}</h1>
            </header>
            <!--头部结束-->
            <!--资讯详情开始-->
            <div class="content news-cont">
                <h4>{{$post['subject']}}</h4>
                <div class="news-content"></div>
                {!! $post['content'] !!}
            </div>
            <!--资讯详情结束-->
        </div>
    </div>
@endsection
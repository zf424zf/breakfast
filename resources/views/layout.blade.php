<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{setting('title')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- basic css&js -->
    <link rel="stylesheet" href="{{cdn('dist/css/sm.min.css')}}">
    <link rel="stylesheet" href="{{cdn('dist/css/sm-extend.min.css')}}">
    <link rel="stylesheet" href="{{cdn('assets/css/style.css')}}">
    <script src="{{cdn('assets/js/zepto.min.js')}}"></script>
    <script src="{{cdn('dist/js/sm.min.js')}}"></script>
    <script src="{{cdn('dist/js/sm-extend.min.js')}}"></script>
    <script src="{{cdn('assets/js/common.js')}}"></script>
    <script src="http://map.qq.com/api/js?v=2.exp"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    @yield('resource')
</head>
<body>
@yield('content')
</body>

</html>
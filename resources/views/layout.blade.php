<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{setting('title')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <!-- basic css&js -->
    <link rel="stylesheet" href="{{cdn('dist/css/sm.min.css')}}">
    <link rel="stylesheet" href="{{cdn('dist/css/sm-extend.min.css')}}">
    <link rel="stylesheet" href="{{cdn('assets/css/style.css')}}">
    <script src="{{cdn('assets/js/zepto.min.js')}}"></script>
    <script src="{{cdn('dist/js/sm.min.js')}}"></script>
    <script src="{{cdn('dist/js/sm-extend.min.js')}}"></script>
    <script src="{{cdn('assets/js/common.js')}}"></script>
    @yield('resource')
</head>
<body>
@yield('content')
</body>

</html>
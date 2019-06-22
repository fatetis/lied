<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    {{--手机--}}
    <meta name="format-detection" content="telephone=no">
    <meta name="applicable-device" content="mobile">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    {{--防止csrf攻击--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>八块钱网商城</title>
    @yield('css')
</head>
<body>
<div id="app">
@section('header')
    <!--顶部搜索-->
@show

@yield('content')

@section('footer')
    <!--底部导航-->
@show
</div>

{{--<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>--}}
@yield('js')
</body>
</html>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        @section('title')
            知美商城
        @endsection
    </title>

    <!-- Bootstrap -->
    <script src="/web/frame/jquery/jquery.min.js"></script>
    <link href="/web/frame/bootstrap-3.3.0-dist/dist/css/bootstrap.css" rel="stylesheet">
    <link href="/web/css/base/style.css?v=3" rel="stylesheet">
    <link href="/web/css/base/style_plus.css" rel="stylesheet">

    @stack('bootstrap_select_css')
    @stack('index_css')
    @stack('search_no_results_css')
    @stack('lucky_area_css')
    @stack('member_area_css')
    @stack('product_detail_css')
    @stack('merchant_detail_css')
    @stack('personal_css')
    @stack('register_plus_css')
    @stack('lottery_css')
    @stack('personal_data_css')
    @stack('notice_css')
    @stack('address_css')
    @stack('order_detail_css')
    @stack('cash_css')
    @stack('cart_css')
    @stack('settlement_css')
    @stack('order_list_css')
    @stack('comment_css')
    @stack('sale_service_css')
    @stack('lucky_index_css')
    @stack('pay_succ_css')

    @stack('citys_js')

    @stack('dotdotdot_js')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header>
    @include('web.layout.shared.top')
    @section('header')
        @include('web.layout.shared.header')
    @show
    @yield('nav')
</header>

<div id="content" class="min-con">
    @yield('content')
</div>

@include('web.layout.shared.footer')

<script src="/web/frame/bootstrap-3.3.0-dist/dist/js/bootstrap.min.js"></script>
@stack('home_index_js')
@stack('goods_detail_js')
@stack('personal_js')
@stack('bootstrap_select_js')
@stack('auth_register_js')
@stack('account_js')
@stack('cart_js')
@stack('settlement_js')
@stack('comment_js')
@stack('sale_service_js')
</body>
</html>
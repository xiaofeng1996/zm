@extends('web.layout.main')

@section('nav_home_selected')
    selected
@endsection

@section('nav')
    @include('web.layout.shared.nav')
@endsection

@push('index_css')
    <link href="/web/css/index.css?v=2" rel="stylesheet">
@endpush

@push('home_index_js')
    <script src="/web/js/index.js"></script>
@endpush

@push('dotdotdot_js')
    <script src="/web/js/jquery.dotdotdot.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <!--<div class="catagory-con">-->
        <!--<div class="c-wrap">-->

        <!--</div>-->
        <!--</div>-->
        <div class="row">
            <div class="col-xs-9">
                <div class="row">
                    <div id="catagory-list" class="catagory-con col-xs-3 text-center">
                        <div class="c-wrap">
                            <ul>
                                @foreach($categorys as $key => $category)
                                    <li data-target="#c{{ $key }}">
                                        <a >{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-9 padding-right0 position-relative">
                        <div id="banner" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @foreach($banners as $key=>$banner) 
                                    @if ($key == 0)
                                        <li data-target="#banner" data-slide-to="{{ $key }}" class="active"></li>
                                    @else
                                        <li data-target="#banner" data-slide-to="{{ $key }}" ></li>
                                    @endif
                                @endforeach
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                @foreach($banners as $key=>$banner) 
                                    @if ($key == 0)
                                        @if ($banner->keytype == 1)
                                            <a href="/goods/{{ $banner->keyid }}">
                                                <img src="{{ $banner->image_web }}">
                                            </a>
                                        @else
                                            <a href="{{ $banner->link }}">
                                                <img src="{{ $banner->image_web }}">
                                            </a>
                                        @endif
                                    @else
                                        <div class="item">
                                            @if ($banner->keytype == 1)
                                                <a href="/goods/{{ $banner->keyid }}">
                                                    <img src="{{ $banner->image_web }}">
                                                </a>
                                            @else
                                                <a href="{{ $banner->link }}">
                                                    <img src="{{ $banner->image_web }}">
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="banner-info">
                                时时彩即开奖时数据-- {{ $last_lottery->opentime }} 今日 {{ substr($last_lottery->expect, -3) }} 期
                            </div>
                        </div>
                        <div id="G-catagory" style="display: none;">
                            <div class="c-wrap">
                                @foreach($categorys as $key => $category)
                                    <div id="c{{ $key }}" style="display: none" >
                                        @foreach($category->children as $child)
                                            <ul class="clearfix">
                                                <li style="width: 80px;"><a href="/goods/member?cate_id={{ $child->id }}">{{ $child->name }}&nbsp;></a></li>
                                                @foreach($child->children as $c)
                                                    <li><a href="/goods/member?cate_id={{ $c->id }}">{{ $c->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row famous-brand">
                    <ul class="clearfix padding10">
                        <li class="col-xs-2">
                            <a>
                                <img src="/web/images/brand1.png">
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a>
                                <img src="/web/images/brand2.png">
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a>
                                <img src="/web/images/brand1.png">
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a>
                                <img src="/web/images/brand2.png">
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a>
                                <img src="/web/images/brand1.png">
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a>
                                <img src="/web/images/brand2.png">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-3 text-center">
                <div class="login-board">
                    @if(!$user)
                    <div class="u-wrap">
                        <div class="ub-con">
                            <div class="ub-con1">
                                <div class="lb-title clearfix">
                                    <div class="pull-left">手机登录</div>
                                    <a class="pull-right" href="/register">免费注册 ></a>
                                </div>
                                <form action="/login" method="POST">
                                    <div class="form-item">
                                        {{ csrf_field() }}
                                    </div>
                                    <div class="form-item">
                                        <input id="login-mobile" type="text" name="mobile" placeholder="请输入手机号" value="{{ old('mobile') }}">
                                    </div>
                                    <div class="form-item">
                                        <input type="password" name="password" placeholder="请输入密码" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-item">
                                        <p class="err-msg"> {{ $errors->first() }} </p>
                                        @if(session('login_err'))
                                            <p class="err-msg">{{ session('login_err') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-item">
                                        <button type="submit">登陆</button>
                                    </div>
                                </form>
                                    <a href="/forgot/password" class="pull-right text-underline margin-top5">忘记密码</a>
                                <div class="clear-both">
                                    <p class="text-left color-brown margin0 fontsize-small">使用以下方式登陆</p>
                                    <ul class="login-type clearfix">
                                        <li class="sina_btn">
                                            <a href="<?=$code_url?>">
                                                <img src="/web/images/sina_btn.png">
                                            </a>
                                        </li>
                                        <li class="qq_btn">
                                            <a>
                                                <img src="/web/images/qq_btn.png">
                                            </a>
                                        </li>
                                        <li class="wx_btn">
                                            <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wx5a0feb9538019d3f&redirect_uri=http://www.zhimei.com/wx&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect">
                                                <img src="/web/images/wx_btn.png">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="u-wrap">
                        <div class="hl-con">
                            <div class="hl-con1">
                                <a href="/user">
                                    <img src="{{ $user->avatar }}" style="width: 80px; height: 80px;">
                                </a>
                                <p><a href="/user" style="color: #1F2D3D;">{{ $user->name }}</a></p>
                            </div>
                            <div class="hl-con2 clearfix">
                                <div class="hc2-item">
                                    <a href="/orders">
                                        <img src="web/images/order_goods.png">
                                        <p>商城订单</p>
                                    </a>
                                </div>
                                <div class="hc2-item">
                                    <a href="/orders?is_lucky=1">
                                        <img src="web/images/winning_record.png">
                                        <p>中奖纪录</p>
                                    </a>
                                    <!--<div class="hc2-tip">
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="activity_board padding10">
                    <div class="a-wrap clearfix">
                        <div class="a-head clearfix">
                            <div class="pull-left margin-left10 margin-top10 color-white">活动公告NEWS</div>
                            <a class="pull-right margin-top10 margin-right10 color-white">更多</a>
                        </div>
                        <div class="a-con padding10">
                            @if($last_activity_notice)
                                {{ $last_activity_notice->content }}
                            @else
                                还没有活动通知
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--幸运区-->
        <div class="row">
            <div id="product-featured"  class="col-xs-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row pf-title">
                        </div>
                        <!--商品内容-->
                        <div class="row pf-con">
                            <div class="col-xs-12">
                                <div class="row pf-row">
                                    @foreach($lucky_goods as $g)
                                        <div class="col-xs-3 pf-col">
                                            <div class="pc-wrap goods" data-id="{{ $g->id }}">
                                                <div style="width: 200px; height: 200px; overflow: hidden;" class="pc-img">
                                                    <img style="height: 200px;" src="{{ $g->image }}"/>
                                                    @if ($g->collects_count)
                                                        <div class="heart-solid collect" data-id="{{ $g->id }}"></div>
                                                    @else
                                                        <div class="heart-selected collect" data-id="{{ $g->id }}"></div>
                                                    @endif
                                                    <div class="pc-info clearfix">
                                                        <div class="pull-left fontsize-small padding-top5 padding-bottom5">
                                                            赠送抽奖次数<span class="color-red">{{ $g->lucky_num }}</span>
                                                        </div>
                                                        <div class="pull-right fontsize-small padding-top5 padding-bottom5">
                                                            抽奖概率<span class="color-red">{{ $g->lucky_rate }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="goods-name" style="height: 40px;">
                                                    <p class="pc-title">{{ $g->name }}</p>
                                                </div>
                                                <p class="pc-price">￥{{ $g->price }} <small class="color-s"><s>{{ $g->old_price }}</s></small></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row margin-bottom100">
                    <div class="col-xs-12">
                        <div class="row pf-viptitle">
                        </div>
                        <!--商品内容-->
                        <div class="row pf-con">
                            <div class="col-xs-12">
                                <div class="row pf-row">
                                    @foreach($member_goods as $g)
                                        <div class="col-xs-3 pf-col">
                                            <div class="pc-wrap goods" data-id="{{ $g->id }}">
                                                <div style="width: 200px; height: 200px; overflow: hidden;" class="pc-img">
                                                    <img style="height: 200px;" src="{{ $g->image }}">
                                                    @if ($g->collects_count)
                                                        <div class="heart-solid collect" data-id="{{ $g->id }}"></div>
                                                    @else
                                                        <div class="heart-selected collect" data-id="{{ $g->id }}"></div>
                                                    @endif
                                                </div>
                                                <div class="goods-name" style="height: 40px;">
                                                    <p class="pc-title">{{ $g->name }}</p>
                                                </div>
                                                <p class="pc-price">￥{{$g->price}} <span class="icon icon-scart pull-right margin-right15"></span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="win-list" class="col-xs-3">
                <div class="win-wrap">
                    <div class="win-c1">
                        <div class="win-c2">
                            <div class="win-head clearfix">
                                <div class="pull-left">
                                    中奖名单
                                </div>
                                <a href="/lottery/{{ $last_lottery->expect }}" class="pull-right color-white">
                                    更多
                                </a>
                            </div>
                            <div class="win-con">
                                <div id="lottery-results">
                                    <p>{{ $last_lottery->expect }}期开奖结果</p>
                                    <ul class="clearfix">
                                        @php
                                            $opencode = $last_lottery->opencode;
                                            $opencodes = explode(',', $opencode);
                                            foreach ($opencodes as $code) {
                                                echo '<li>' . $code . '</li>';
                                            } 
                                        @endphp
                                    </ul>
                                </div>
                                <ul class="list-con">
                                    @foreach ($order_lotteries as $order_lottery)
                                        <li>
                                            <div class="pull-left">{{ $order_lottery->mobile }}</div>
                                            <div class="pull-right color-purple">{{ $order_lottery->award_desc }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        if(window.location.href.indexOf('login=1')) {
            $("#login-mobile").focus();
        }

        $(function () {
            // 收藏
            $(".collect").click(function (event) {
                event.stopPropagation();
                var _this = $(this);
                var id = _this.attr("data-id");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/collect',
                    method: 'post',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            if (data.infor.is_collect == 1) {
                                _this.removeClass("heart-selected").addClass("heart-solid");
                            } else {
                                _this.removeClass("heart-solid").addClass("heart-selected");
                            }
                        } else {
                            alert(data.infor);
                        }
                    }
                })
            });

            // 跳转详情
            $(".goods").click(function () {
                var id = $(this).attr("data-id");
                window.location.href = "/goods/" + id;
            })

            // 自适应 banner/类别选择区域 高度
            var cate_height = $("#catagory-list").height();
            if (cate_height > 400) {
                $("#banner").height(cate_height);
                $("#banner img").height(cate_height);
                $("#G-catagory").height(cate_height - 20);
            }

            $(".goods-name").dotdotdot({

            })

            //跳转至qq登录页面
            $('.qq_btn').click(function(){
                childWindow = window.open("/qqLogin","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            })

        });
    </script>
@endsection
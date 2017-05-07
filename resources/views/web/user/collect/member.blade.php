@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a>商品收藏</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content product-list-content">
                <div class="personal-wrap">
                    <div class="person-content">
                        <div class="person-header">
                            <span class="header-title">我的收藏</span>
                        </div>
                        <div class="person-body">
                            <div class="person-nav witless">
                                <ul class="clearfix">
                                    <li class="selected">
                                        <a href="/collects/member">会员商品</a>
                                    </li>
                                    <li>
                                        <a href="/collects/lucky">购物中大奖</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-list">
                                <div class="row">
                                    @foreach ($collects as $collect)
                                        <div class="col-xs-3 product-item">
                                            <div class="pc-wrap">
                                                <div class="pc-img">
                                                    <img src="{{ $collect->goods->image }}"/>
                                                    <div class="heart-solid collect-btn" style="cursor: pointer;" data-id="{{ $collect->goods->id }}"></div>
                                                    <div class="pc-info clearfix">
                                                        <div class="pull-left fontsize-small padding-top5 padding-bottom5 color-golden">
                                                            赠送抽奖次数<span class="color-red">{{ $collect->goods->lucky_num }}</span>
                                                        </div>
                                                        <div class="pull-right fontsize-small padding-top5 padding-bottom5 color-golden">
                                                            抽奖概率<span class="color-red">{{ $collect->goods->lucky_rate }}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="/goods/{{ $collect->goods->id }}">
                                                    <p class="pc-title">{{ $collect->goods->name }}</p>
                                                    <p class="pc-price">￥{{ $collect->goods->price }}
                                                        <small class="color-s"><s>{{ $collect->goods->old_price }}</s></small>
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--分页-->
                <div class="row">
                    <div id="pf-footer">
                        <nav>
                            <ul class="pf-page clearfix">
                                <li class="prev"><a href="{{ $collects->previousPageUrl() }}"><span class="glyphicon glyphicon-chevron-left"></span> 上一页</a></li>
                                @php
                                    $total = $collects->total();
                                    $per_page = $collects->perPage();
                                    $pages = ceil( $total / $per_page );

                                    $current_page = $collects->currentPage();

                                    $page_start = ceil($current_page / 5);
                                    $page_end = ($page_start + 5 <= $pages) ? $page_start + 5 : $pages;

                                    for ($page = $page_start; $page <= $page_end; $page++) {
                                        $url = $collects->url($page);
                                        if ($page == $current_page) {
                                            echo "<li class='selected'><a href='$url'> $page </a></li>";
                                        } else {
                                            echo "<li><a href='$url'> $page </a></li>";
                                        }
                                    }
                                @endphp
                                <li class="next"><a href="{{$collects->nextPageUrl()}}">下一页<span class="glyphicon glyphicon-chevron-right"></span></a></li>
                                <li>
                                    <a>共{{ ceil($collects->total() / 5) }}页 到第</a>
                                </li>
                                <li>
                                    <input id="page" type="text" value="{{ $collects->currentPage() }}"> 页
                                </li>
                                <li>
                                    <button id="chose-page">确定</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#chose-page").click(function () {
            var page = $("#page").val();
            var url = '{{ $collects->url(1) }}';
            window.location.href = url;
        });

        // 取消收藏
        $(".collect-btn").click(function (event) {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/collect',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function () {
                    window.location.reload();
                }
            })
        });
    </script>
@endsection

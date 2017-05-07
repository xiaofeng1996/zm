@extends('web.layout.main')

@push('merchant_detail_css')
    <link rel="stylesheet" href="/web/css/businessDetails.css">
@endpush

@push('dotdotdot_js')
    <script src="/web/js/jquery.dotdotdot.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <ol class="col-xs-4 pathNavigation clearfix">
                <li>当前位置:</li>
                <li><a href="/">首页</a></li>
                <li><a>商家主页</a></li>
            </ol>
        </div>
        <!--幸运区-->
        <div class="row">
            <div id="product-featured"  class="col-xs-12">
                <div class="row margin-bottom100">
                    <div class="col-xs-12">
                        <!--商品内容-->
                        <div class="row pf-con">
                            <div class="business-box">
                                <div class="merchant-image">
                                    <img style="" src="{{ $merchant->image }}"/>
                                </div>
                                <p>{{ $merchant->name }}</p>
                                <p><span class="icon icon-tel"></span>{{ $merchant->mobile }}</p>
                            </div>
                            <div class="col-xs-12">
                                @if (count($goods))
                                    <div class="row pf-row">
                                        @foreach ($goods as $g)
                                            <div class="col-xs-3 pf-col goods" data-id="{{ $g->id }}">
                                                <div class="pc-wrap">
                                                    <div class="pc-img">
                                                        <img src="{{ $g->image }}"/>
                                                        @if($g->collects_count > 0)
                                                            <div class="heart-solid collect" data-id="{{ $g->id }}"></div>
                                                        @else
                                                            <div class="heart-selected collect" data-id="{{ $g->id }}"></div>
                                                        @endif
                                                    </div>
                                                    <div class="goods-name" style="height: 40px;">
                                                        <p class="pc-title">{{ $g->name }}</p>
                                                    </div>
                                                    <p class="pc-price">￥{{ $g->price }} <span class="icon icon-scart pull-right margin-right15"></span></p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="goods-list-empty">
                                        <p>没有商品 : (</p>                                    
                                    </div>
                                @endif
                            </div>
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
                        <li class="prev"><a href="{{ $goods->previousPageUrl() }}"><span class="glyphicon glyphicon-chevron-left"></span> 上一页</a></li>
                        @php
                            $total = $goods->total();
                            $per_page = $goods->perPage();
                            $pages = ceil( $total / $per_page );

                            $current_page = $goods->currentPage();

                            $page_start = ceil($current_page / 5);
                            $page_end = ($page_start + 5 <= $pages) ? $page_start + 5 : $pages; 

                            for ($page = $page_start; $page <= $page_end; $page++) {
                                $url = $goods->url($page);
                                if ($page == $current_page) {
                                    echo "<li class='selected'><a href='$url'> $page </a></li>";
                                } else {
                                    echo "<li><a href='$url'> $page </a></li>";
                                }
                            }
                        @endphp
                        <li class="next"><a href="{{$goods->nextPageUrl()}}">下一页<span class="glyphicon glyphicon-chevron-right"></span></a></li>
                        <li>
                            <a>共{{ ceil($goods->total() / 5) }}页 到第</a>
                        </li>
                        <li>
                            <input id="page" type="text" value="{{ $goods->currentPage() }}"> 页
                        </li>
                        <li>
                            <button id="chose-page">确定</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        $(function () {
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

            $(".goods-name").dotdotdot({

            })

        })
    </script>
@endsection
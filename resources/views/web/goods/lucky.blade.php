@extends('web.layout.main')

@section('nav_lucky_selected')
    selected
@endsection

@section('nav')
    @include('web.layout.shared.nav')
@endsection

@push('search_no_results_css')
    <link rel="stylesheet" href="/web/css/searchNoResults.css">
@endpush

@push('search_no_results_css')
    <link rel="stylesheet" href="/web/css/luckAreaSearchResults.css">
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
                <li><a href="/goods/lucky">幸运区</a></li>
                @if($keyword)
                    <li><a href="/goods/lucky?page={{ $goods->currentPage() }}&keyword={{ $keyword }}">{{ $keyword }}</a></li>
                @endif
            </ol>
        </div>
        <!--幸运区-->
        @if(count($goods))
            <div class="row">
                <div id="product-featured"  class="col-xs-12">
                    <div class="row margin-bottom100">
                        <div class="col-xs-12">
                            <!--商品内容-->
                            <div class="row pf-con">
                                <div class="col-xs-12">
                                    <div class="row pf-row">
                                        @foreach($goods as $g)
                                            <div class="col-xs-3 pf-col">
                                                <div class="pc-wrap goods" data-id="{{ $g->id }}">
                                                    <div style="width: 215px; height: 215px; overflow: hidden;" class="pc-img">
                                                        <img style="height: 215px;" src="{{ $g->image }}"/>
                                                        @if($g->collects_count)
                                                            <div class="heart-solid collect" style="cursor: pointer;" data-id="{{ $g->id }}"></div>
                                                        @else
                                                            <div class="heart-selected collect" style="cursor: pointer;" data-id="{{ $g->id }}"></div>
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
                                                    <p class="pc-price">￥{{ $g->price }}
                                                        <small class="color-s"><s>{{ $g->old_price }}</s></small>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="no-search">
                <img src="/web/images/no_search.png">
                <p>抱歉，暂无您想要的搜索结果哦!</p>
            </div>
        @endif
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
                                $url .= $keyword ? '&keyword='. $keyword : '';
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
                            <input type="text" id="page" value="{{ $goods->currentPage() }}"> 页
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
        $("#chose-page").click(function () {
            var page = $("#page").val();
            var url = "{{ $goods->url(" + page + ") }}";
            url += "{{ $keyword }}" ? "&keyword={{ $keyword }}" : "";
            window.location.href = url;
        });
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

            $(".goods-name").dotdotdot({

            })

        });
    </script>
@endsection
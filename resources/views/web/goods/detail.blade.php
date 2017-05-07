@extends('web.layout.main')

@push('product_detail_css')
    <link rel="stylesheet" href="/web/css/productDetails.css?v=5">
@endpush

@push('goods_detail_js')
    <script src="/web/js/productDetail.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <ol class="col-xs-4 pathNavigation clearfix">
                <li>当前位置:</li>
                <li><a href="/">首页</a></li>
                <li><a href="/goods/member">会员商品</a></li>
                <li><a>详情</a></li>
            </ol>
        </div>
        <div id="product-info" class="row">
            <div class="pi-wrap">
                <div class="pi-con clearfix col-xs-12">
                    <div class="pc-img col-xs-4">
                        <div class="pci-b-img">
                            <img id="goods-img-show" src="{{ $goods->image }}"/>
                        </div>
                        <div class="pci-sm-img">
                            <div class="psi-con">
                                <ul class="clearfix">
                                    @foreach($goods->images as $key => $image)
                                        <li class="selected"><a><img class="goods-img" src="{{ $image->image }}"/></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div>
                            @if($goods->collects_count > 0)
                                <div class="heart-solid collect" data-id="{{ $goods->id }}"></div>
                            @else
                                <div class="heart-selected collect" data-id="{{ $goods->id }}"></div>
                            @endif
                            <span style="margin-left: 30px;">收藏商品</span>
                        </div>
                    </div>
                    <div class="pc-info col-xs-5">
                        <div class="row margin0">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="pi-title">{{ $goods->name }}</div>
                                    <div class="pi-cost">
                                        <div class="p-panel">
                                            <div><span class="color-purple">价格：</span><span
                                                    class="color-purple">￥</span><span
                                                    class="fontsize-5xlarge color-purple"><strong>{{ $goods->price }}</strong></span>
                                                <span class="fontsize-xlarge"><s>￥{{ $goods->old_price }}</s></span></div>
                                            <div><span class="color-purple">运费：</span><span
                                                    class="color-purple">￥</span><span
                                                    class="color-purple fontsize-xxlarge">{{ $goods->merchant->fare }}</span></div>
                                        </div>
                                        <div id="goods-attr">
                                            <!-- 商品属性 --> 
                                        </div>
                                        <dl>
                                            <dt>数量：</dt>
                                            <dd>
                                                <div class="td-inner">
                                                    <div class="amount-wrapper ">
                                                        <div class="item-amount ">
                                                            <a class="amount-sub" id="goods-num-reduce">-</a>
                                                            <input id="goods-num" class="text-amount" type="text" value="1">
                                                            <a class="amount-add" id="goods-num-plus">+</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </dd>
                                        </dl>
                                        <div class="clearfix">
                                            <div id="add-cart-btn" class="purple-btn pull-left">
                                                加入购物车
                                            </div>
                                            <div id="buy" class="brown-btn pull-left" style="cursor: pointer;">
                                                立即购买
                                            </div>
                                        </div>
                                        <div class="margin-top15">
                                            <span class="icon icon-replacement"></span>
                                            @if($goods->support_return)
                                                <span class="icon icon-returns"></span>
                                                <span>支持退换货</span>
                                            @else
                                                <span>支持换货</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="pc-entrance col-xs-3">
                        <div class="pce-box">
                            <div class="merchant-image">
                                <img style="" src="{{ $goods->merchant->image }}"/>
                            </div>
                            <p>{{ $goods->merchant->name }}</p>
                            <p><span class="icon icon-tel"></span>{{ $goods->merchant->mobile }}</p>
                            <a class="pce-btn" href="/merchant/{{ $goods->merchant->id }}">进入商家主页</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="product-detail" class="row">
            <div class="col-xs-12 margin0 padding0">
                <nav class="d-nav">
                    <ul class="clearfix">
                        <li class="selected" data-target="#product-description"><a>商品详情</a></li>
                        <li data-target="#product-review"><a>商品评价</a></li>
                    </ul>
                </nav>
                <div id="product-description">
                    @if (isset($goods->richText) && count($goods->richText) > 0)
                        {!! $goods->richText->content !!}
                    @else
                        <span>暂未添加详情介绍</span>
                    @endif
                </div>

                <div id="product-review">
                    <div class="review-head">
                        @php
                            $star_count = ceil(($goods->good_comments_count / ($goods->comments_count + 1)) * 100 / 20);
                            for ($i = 0; $i < $star_count; $i++) {
                                echo '<span class="icon icon-flower praise"></span>';
                            }
                        @endphp
                        <span class="color-golden vam margin-left15">好评率</span>
                        <span class="color-purple vam">{{ round(($goods->good_comments_count / ($goods->comments_count + 1)) * 100) }}%</span>
                    </div>
                    <div class="review-body">
                        @foreach ($goods->comments as $comment)
                            <div class="rb-item">
                                <div class="row">
                                    <div class="user-portrait">
                                        <img src="{{ $comment->user->avatar }}"/>
                                        <div>{{ $comment->user->name }}</div>
                                    </div>
                                    <div class="col-xs-11 col-xs-offset-1">
                                        <div class="row margin-bottom25">
                                            <div class="col-xs-3">
                                                @for($i = 0; $i < $comment->star; $i++)
                                                    <span class="icon icon-sm-flower praise"></span>
                                                @endfor
                                                <span class="color-golden pull-right">{{ $comment->created_at }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 margin-bottom10">
                                                <p>
                                                    {{ $comment->content }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row img-view">
                                    <div class="col-xs-11 col-xs-offset-1">
                                        @foreach ($comment->images as $image)
                                            <img src="{{ $image->image }}"/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var goods_obj = {
            'attr_id': 0,
            'goods_num': 1
        }

        var attr_names = new Array();
        var attr_values = new Array();
        function getAttrs(goods_id, attr_names, attr_values) {
            attr_names = attr_names || '';
            attr_values = attr_values || '';
            $.ajax({
                url: "/goods/attrs",
                method: 'get',
                data: {
                    goods_id: goods_id,
                    attr_names: attr_names,
                    attr_values: attr_values
                },
                success: function (data) {
                    if (data.success == 1) {
                        goods_obj.attr_id = data.infor.attr_id;
                        var attrs = data.infor.attrs;
                        var template = '';
                        for (var i = 0; i< attrs.length; i++) {
                            template += '<dl>';
                            template +=     '<dt>' + attrs[i].name + ': </dt>';
                            template +=     '<dd>';
                            template +=         '<ul class="option clearfix">';
                            for (var j = 0; j < attrs[i].values.length; j++) {
                                if (attrs[i].values[j].allow_select == 1 && attrs[i].values[j].selected == 1) {
                                    template +=          '<li class="selected"';
                                    template +=               ' data-attr-name="' + attrs[i].attr_name + '"';
                                    template +=               ' data-attr-value="' + attrs[i].values[j].value + '"';
                                    template +=           '>'
                                    template +=               '<a>' + attrs[i].values[j].value + '</a>';
                                    template +=          '</li>';
                                } else if (attrs[i].values[j].allow_select == 1 && attrs[i].values[j].selected == 0) {
                                    template +=          '<li';
                                    template +=               ' data-attr-name="' + attrs[i].attr_name + '"';
                                    template +=               ' data-attr-value="' + attrs[i].values[j].value + '"';
                                    template +=           '>'
                                    template +=               '<a>' + attrs[i].values[j].value + '</a>';
                                    template +=          '</li>';
                                }
                            }
                            template +=         '</ul>';
                            template +=     '</dd>';
                            template += '</dl>';
                        }

                    }
                    $("#goods-attr").html(template);
                }
            })
        }
        getAttrs("{{ $goods->id }}");

        // 监听属性点击
        $("#goods-attr").on("click", "li", function () {
            var attr_name = $(this).attr('data-attr-name');
            var attr_value = $(this).attr('data-attr-value');
            var key = getKey(attr_names, attr_name);
            if (key != -1) {
                if ($(this).hasClass('selected')) {
                    attr_names.splice(key, 1);
                    attr_values.splice(key, 1);
                } else {
                    attr_values[key] = attr_value;
                }
            } else {
                attr_names.push(attr_name);
                attr_values.push(attr_value);
            }
            var goods_id = "{{ $goods->id }}";
            var attr_names_str = attr_names.join('@@');
            var attr_values_str = attr_values.join('@@');
            getAttrs(goods_id, attr_names_str, attr_values_str);
        });

        function getKey(arr, val) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == val) {
                    return i;
                }
            }
            return -1;
        }

        // 修改购物车数量
        $("#goods-num-reduce").click(function () {
            var goods_num = $("#goods-num").val();
            goods_num = goods_num > 1 ? goods_num - 1 : 1;
            $("#goods-num").val(goods_num);
            goods_obj.goods_num = goods_num;
        });

        $("#goods-num-plus").click(function () {
            var goods_num = $("#goods-num").val();
            goods_num++;
            $("#goods-num").val(goods_num);
            goods_obj.goods_num = goods_num;
        });

        $("#goods-num").change(function () {
            goods_obj.goods_num = $("#goods-num").val();
        })

        $("#buy").click(function () {
            if (!goods_obj.attr_id) {
                alert('请先选择商品规格');
            } else if (goods_obj.goods_num < 1) {
                alert('请选择商品数量');
            } else {
                window.location.href = "/order/create?attr_id=" + goods_obj.attr_id + "&goods_num=" + goods_obj.goods_num;
            }
        });

        //  购物车相关
        var cartObj = {
            init: function () {
                cartObj.methods.listenAddCart();
            },
            methods: {
                listenAddCart: function () {
                    $("#add-cart-btn").click(function () {
                        if (goods_obj.attr_id == 0) {
                            alert('请先选择商品规格');
                        } else if (goods_obj.goods_num <=0 ) {
                            alert('请先选择商品数量');
                        } else {
                            var data = goods_obj;
                            data._token = "{{ csrf_token() }}";
                            $.ajax({
                                url: '/cart/add',
                                method: 'post',
                                data: data,
                                success: function (data) {
                                    if (data.success == 1) {
                                        alert('加入成功');
                                    } else {
                                        alert(data.infor);
                                    }
                                },
                                error: function () {
                                    alert('操作失败');
                                }
                            })
                        }
                    });
                },
            }
        }
        cartObj.init();

        $(".goods-img").click(function () {
            var src = $(this).attr("src");
            $("#goods-img-show").attr("src", src);
        })

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

    </script>
@endsection
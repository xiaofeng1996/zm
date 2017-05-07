@extends('web.layout.main')

@push('cart_css')
    <link rel="stylesheet" href="/web/css/shoppingCart.css">
@endpush

@push('cart_js')
    <script src="/web/js/shoppingCart.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a>购物车</a></li>
                </ol>
            </div>
        </div>
        <div id="shopping-cart" class="row">
            <div class="col-xs-12">
                <div class="row sc-head">
                    <div class="col-xs-2 text-left">
                        <div data-role="checkbox">
                            <a>
                                <span id="all-sel" class="icon icon-tb-unchecked vab margin-right5"></span>
                                全选
                            </a>

                        </div>
                    </div>
                    <div class="col-xs-3">
                        商品信息
                    </div>
                    <div class="col-xs-2">
                        单价（￥）
                    </div>
                    <div class="col-xs-2">
                        数量
                    </div>
                    <div class="col-xs-2">
                        小计（￥）
                    </div>
                    <div class="col-xs-1">
                        操作
                    </div>
                </div>
                <div class="row sc-con">
                    @foreach ($carts as $cart)
                        <div class="col-xs-12">
                            <div class="con-f row">
                                <div class="col-xs-12">
                                    <a>
                                        <span class="icon icon-tb-unchecked vab margin-right5 merchant-all-sel" data-merchant-id="{{ $cart->merchant->id }}"></span>
                                        商家: {{ $cart->merchant->name }}
                                    </a>
                                </div>
                            </div>
                            @foreach($cart->carts as $c)
                                <div class="con-c row" style="margin-top: 20px;">
                                    <div class="col-xs-2 text-left">
                                        <a data-role="checkbox">
                                            <span
                                                class="icon icon-tb-unchecked margin-right5 merchant-single-sel"
                                                data-cart-id="{{ $c->id }}"
                                                data-attr-id="{{ $c->attr_id }}"
                                                data-merchant-id="{{ $cart->merchant->id }}"
                                                data-price="{{ $c->goods->price }}"
                                            ></span>
                                            <img src="{{ $c->goods->image }}"/>
                                        </a>
                                    </div>
                                    <div class="col-xs-3 text-left margin-top20">
                                        {{ $c->goods->title }}
                                    </div>
                                    <div class="col-xs-2 margin-top30">
                                        {{ $c->goods->price }}
                                    </div>
                                    <div class="col-xs-2 margin-top30 td-amount">
                                        <div class="td-inner">
                                            <div class="amount-wrapper ">
                                                <div class="item-amount ">
                                                    <a class="amount-sub" data-id="{{ $c->id }}" style="cursor: pointer;">-</a>
                                                        <input class="text-amount" data-id="{{ $c->id }}" data-merchant-id="{{ $cart->merchant->id }}" data-price="{{ $c->goods->price }}" type="text" value="{{ $c->goods_num }}">
                                                    <a class="amount-add" data-id="{{ $c->id }}" style="cursor: pointer;">+</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 margin-top30">
                                        520px
                                    </div>
                                    <div class="col-xs-1 margin-top30">
                                        <a class="del" data-id="{{ $c->id }}" style="cursor: pointer;">删除</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="row sc-footer">
                    <div class="col-xs-6">

                    </div>
                    <div class="col-xs-6 text-right">
                        <div>
                            已选商品 <span id="goods-num">0</span>，合计（不含运费：
                            <small>￥</small>
                            <span class="fontsize-xlarge color-purple"><strong id="total-price">0.00</strong></span>）
                            <button id="settle" class="button">结算</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="payDialog" class="modal fade">
        <div class="modal-dialog margin-top125">
            <div class="modal-content">
                <div class="modal-header text-center bg-purple color-white">
                    <span class="icon icon-left-cloud"></span>
                    <span>选择支付方式</span>
                    <span class="icon icon-right-cloud"></span>

                    <button type="button" class="close color-white" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <div class="pay-item">
                        <label for="pay-yezf" class="pay-radio">
                            <span class="pip"></span>
                        </label>
                        <input id="pay-yezf" type="radio" name="pay-type" value="4">
                        <span class="icon icon-pay-yezf margin-left20 vabaseline"></span>
                        <div class="inline-block margin-left5">
                            <div class="fontsize-large">余额支付</div>
                            <div class="fontsize-normal">(可用余额￥{{ $user->shop_balance }})</div>
                        </div>
                    </div>
                    <a id="pay" class="button-purple margin-left35 margin-right35 margin-top55">去支付</a>
                    <form id="pay-form" action="/cart/create_order" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="text" id="data" name="data">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @php
        $total_count = 0;
        $merchant_count = [];
        foreach($carts as $key => $cart) {
            $merchant = $cart->merchant;
            $m_carts = $cart->carts;
            $merchant_carts_count = count($m_carts);

            $merchant_count[$key]['merchant_id'] = $merchant->id;
            $merchant_count[$key]['total_count'] = $merchant_carts_count;
            $merchant_count[$key]['current_count'] = 0;

            $total_count += $merchant_carts_count;
        }
    @endphp
    <script>
        var cartObj = {
            data: {
                total_count: "{{ $total_count }}",
                current_count: 0,
                total_price: 0,
                goods_num: 0,
//                merchant: [
//                    {
//                        merchant_id: 0,
//                        total_count: 0,
//                        current_count: 0
//                    }
//                ],
                merchant: JSON.parse('{!! json_encode($merchant_count) !!}'),
                datas: []
            },
            init: function () {
                console.log(cartObj.data);
                cartObj.methods.listenAdd();
                cartObj.methods.listenSub();
                cartObj.methods.listenDel();
                cartObj.methods.listenAllSel();
                cartObj.methods.listenMerchantAllSel();
                cartObj.methods.listenMerchantSingleSel();
                cartObj.methods.listenPay();
                cartObj.methods.listenToPay();
            },
            methods: {
                initData: function () {

                },
                listenAdd: function () {
                    $(".amount-add").click(function () {
                        var id = $(this).attr("data-id");
                        var countObj = $(".text-amount[data-id="+id+"]");
                        var merchant_id = countObj.attr("data-merchant-id");
                        var count = countObj.val();
                        count++;
                        countObj.val(count);
                        cartObj.methods.updateGoodsCount(id, count, merchant_id);
                    });
                },
                listenSub: function () {
                    $(".amount-sub").click(function () {
                        var id = $(this).attr("data-id");
                        var countObj = $(".text-amount[data-id="+id+"]");
                        var merchant_id = countObj.attr("data-merchant-id");
                        var count = countObj.val();
                        if (count <= 1) {
                            alert('数量不能小于1');
                        } else {
                            count--;
                            countObj.val(count);
                            cartObj.methods.updateGoodsCount(id, count, merchant_id);
                        }
                    });
                },
                listenDel: function () {
                    $(".del").click(function () {
                        var cart_id = $(this).attr('data-id');
                        $.ajax({
                            url: '/cart/delete',
                            method: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                cart_id: cart_id
                            },
                            success: function (data) {
                                if (data.success == 0) {
                                    alert(data.infor);
                                } else {
                                    window.location.reload();
                                }
                            },
                            error: function () {

                            }
                        })
                    });
                },
                updateGoodsCount: function (cart_id, goods_num, merchant_id) {
                    $.ajax({
                        url: '/cart/update',
                        method: 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            cart_id: cart_id,
                            goods_num: goods_num
                        },
                        success: function (data) {
                            if (data.success == 0) {
                                alert(data.infor);
                            } else {
                                cartObj.methods.chDatasGoodsNum(merchant_id, cart_id, goods_num);
                            }
                        },
                        error: function () {
                            alert('修改失败');
                        }
                    })
                },
                listenAllSel: function () {
                    $("#all-sel").click(function () {
                        cartObj.methods.selAll($(this));
                    });
                },
                listenMerchantAllSel: function () { // 选择商家所有购物车
                    $(".merchant-all-sel").click(function () {
                            if ($(this).hasClass("icon-tb-unchecked")) {
                                cartObj.methods.selMerchant($(this));
                            } else {
                                cartObj.methods.rmMerchant($(this));
                            }
                    });
                },
                listenMerchantSingleSel: function () { // 选择商家单个购物车
                    $(".merchant-single-sel").click(function () {
                        var cart = $(this);
                        if (cart.hasClass("icon-tb-unchecked")) {
                            cartObj.methods.selMerchantCart(cart);
                        } else {
                            cartObj.methods.rmMerchantCart(cart);
                        }
                    });
                },
                selAll: function (allObj) {
                    if (allObj.hasClass("icon-tb-unchecked")) {
                        allObj.removeClass("icon-tb-unchecked").addClass("icon-tb-checked");
                        cartObj.methods.selAllMerchant();
                    } else {
                        allObj.removeClass("icon-tb-checked").addClass("icon-tb-unchecked");
                        cartObj.methods.rmAllMerchant();
                    }
                },
                selAllMerchant: function () {
                    var merchants = $(".merchant-all-sel");
                    merchants.map(function () {
                        cartObj.methods.selMerchant($(this));
                    });
                },
                rmAllMerchant: function () {
                    var merchants = $(".merchant-all-sel");
                    merchants.map(function () {
                        cartObj.methods.rmMerchant($(this));
                    });

                },
                selMerchant: function (merchant) {
                    merchant.removeClass("icon-tb-unchecked").addClass("icon-tb-checked");
                    var merchant_id = merchant.attr("data-merchant-id");
                    var merchant_carts = $(".merchant-single-sel[data-merchant-id=" + merchant_id + "]");
                    cartObj.methods.selAllMerchantCart(merchant_carts);
                },
                rmMerchant: function (merchant) {
                    merchant.removeClass("icon-tb-checked").addClass("icon-tb-unchecked");
                    var merchant_id = merchant.attr("data-merchant-id");
                    var merchant_carts = $(".merchant-single-sel[data-merchant-id=" + merchant_id + "]");
                    cartObj.methods.rmAllMerchantCart(merchant_carts);
                },
                selAllMerchantCart: function (carts) {
                    carts.map(function () {
                        cartObj.methods.selMerchantCart($(this));
                    });
                },
                rmAllMerchantCart: function (carts) {
                    carts.map(function () {
                        cartObj.methods.rmMerchantCart($(this));
                    });
                },
                selMerchantCart: function (cart) {
                    cart.removeClass("icon-tb-unchecked").addClass("icon-tb-checked");
                    cartObj.data.current_count++;
                    if (cartObj.data.total_count == cartObj.data.current_count) {
                        $("#all-sel").removeClass("icon-tb-unchecked").addClass("icon-tb-checked");
                    }

                    var merchant_id = cart.attr("data-merchant-id");
                    var merchant = $(".merchant-all-sel[data-merchant-id="+merchant_id+"]");
                    for (var i = 0; i < cartObj.data.merchant.length; i++) {
                        if (cartObj.data.merchant[i].merchant_id == merchant_id) {
                            cartObj.data.merchant[i].current_count++;
                            if (cartObj.data.merchant[i].total_count <= cartObj.data.merchant[i].current_count) {
                                merchant.removeClass("icon-tb-unchecked").addClass("icon-tb-checked");
                            } else {
                                merchant.removeClass("icon-tb-checked").addClass("icon-tb-unchecked");
                            }
                        }
                    }

                    cartObj.methods.addData(cart);
                    cartObj.methods.setGoodsNumAndTotalPrice();

                },
                rmMerchantCart: function (cart) {
                    cart.removeClass("icon-tb-checked").addClass("icon-tb-unchecked");
                    cartObj.data.current_count--;
                    if (cartObj.data.total_count > cartObj.data.current_count) {
                        $("#all-sel").removeClass("icon-tb-checked").addClass("icon-tb-unchecked");
                    }

                    var merchant_id = cart.attr("data-merchant-id");
                    var merchant = $(".merchant-all-sel[data-merchant-id="+merchant_id+"]");
                    for (var i = 0; i < cartObj.data.merchant.length; i++) {
                        if (cartObj.data.merchant[i].merchant_id == merchant_id) {
                            cartObj.data.merchant[i].current_count--;
                            merchant.removeClass("icon-tb-checked").addClass("icon-tb-unchecked");
                        }
                    }

                    cartObj.methods.rmData(cart);
                    cartObj.methods.setGoodsNumAndTotalPrice();

                },
                // 添加选中数据
                addData: function (cart) {
                    var merchant_id = cart.attr("data-merchant-id");
                    var attr_id = cart.attr("data-attr-id");
                    var cart_id = cart.attr("data-cart-id");
                    var price = cart.attr("data-price");
                    var goods_num = $(".text-amount[data-id="+cart_id+"]").val();
                    var is_exist = 0;
                    var datas_len = cartObj.data.datas.length;
                    for (var i = 0; i < datas_len; i++) {
                        if (cartObj.data.datas[i].merchant_id == merchant_id) {
                            is_exist = 1;
                            var attr = {
                                attr_id: attr_id,
                                cart_id: cart_id,
                                goods_num: goods_num,
                                price: price
                            };
                            cartObj.data.datas[i].attrs.push(attr);
                        }
                    }
                    if (!is_exist) {
                        var data = {
                            merchant_id: merchant_id,
                            attrs: [
                                {
                                    attr_id: attr_id,
                                    cart_id: cart_id,
                                    goods_num: goods_num,
                                    price: price
                                }
                            ]
                        };
                        cartObj.data.datas.push(data);
                    }
                },
                // 删除选中数据
                rmData: function (cart) {
                    var merchant_id = cart.attr("data-merchant-id");
                    var attr_id = cart.attr("data-attr-id");
                    var cart_id = cart.attr("data-cart-id");
                    var datas_len = cartObj.data.datas.length;

                    wrap_loop:
                    for(var i = 0; i< datas_len; i++) {
                        if (cartObj.data.datas[i].merchant_id == merchant_id) {
                            if (cartObj.data.datas[i].attrs.length <= 1) {
                                cartObj.data.datas.splice(i, 1);
                                break wrap_loop;
                            } else {
                                var attrs = cartObj.data.datas[i].attrs;
                                var attrs_len = attrs.length;
                                for(var j = 0; j < attrs_len; j++) {
                                    if (attrs[j].cart_id == cart_id && attrs[j].attr_id == attr_id) {
                                        cartObj.data.datas[i].attrs.splice(j, 1);
                                        break wrap_loop;
                                    }
                                }
                            }
                        }
                    }
                },
                // 修改购物车中商品数量
                chDatasGoodsNum: function (merchant_id, cart_id, goods_num) {
                    var datas_len = cartObj.data.datas.length;
                    for(var i = 0; i < datas_len; i++) {
                        if (cartObj.data.datas[i].merchant_id == merchant_id) {
                            var attrs_len = cartObj.data.datas[i].attrs.length;
                            for (var j = 0; j < attrs_len; j++) {
                                if (cartObj.data.datas[i].attrs[j].cart_id == cart_id) {
                                    cartObj.data.datas[i].attrs[j].goods_num = goods_num;
                                }
                            }
                        }
                    }
                    cartObj.methods.setGoodsNumAndTotalPrice();
                },
                setGoodsNumAndTotalPrice: function () {
                    var goods_num = 0;
                    var total_price = 0;
                    var datas_len = cartObj.data.datas.length;
                    for (var i = 0; i < datas_len; i++) {
                        var attrs_len = cartObj.data.datas[i].attrs.length;
                        for (var j = 0; j < attrs_len; j++) {
                            var _goods_num = cartObj.data.datas[i].attrs[j].goods_num;
                            var _price = cartObj.data.datas[i].attrs[j].price;
                            goods_num += _goods_num * 1;
                            total_price += _goods_num * _price;
                        }
                    }
                    $("#goods-num").html(goods_num);
                    $("#total-price").html(total_price);

                    cartObj.data.total_price = total_price;
                    cartObj.data.goods_num = goods_num;

                },
                listenPay: function () {
                    $("#settle").click(function () {
                        if (cartObj.data.datas.length <= 0) {
                            alert('请先选择商品');
                        } else {
                            var shop_balance = "{{ $user->shop_balance }}";
                            if (shop_balance < cartObj.data.total_price) {
                                alert('购物金不足， 请充值');
                            } else {
                                $("#payDialog").modal();
                            }
                        }
                    });
                },
                listenToPay: function () {
                    $("#pay").click(function () {
                        $("#data").val(JSON.stringify(cartObj.data.datas));
                        $("form#pay-form").submit();
                    });
                }
            }
        }
        cartObj.init();
    </script>
@endsection

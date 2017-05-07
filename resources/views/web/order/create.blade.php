@extends('web.layout.main')

@push('settlement_css')
    <link rel="stylesheet" href="/web/css/settlement.css">
@endpush

@push('settlement_js')
    <script src="/web/js/settlement.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a>创建订单</a></li>
                </ol>
            </div>
        </div>
        <div id="shipping-address">
            <div>
                <div class="sa-head" >
                    选择收货地址
                </div>
                <div class="sa-con clearfix">
                    @foreach($addrs as $addr)
                        <div class="sac-addr-box pull-left addr" style="margin-left: 20px;"
                            data-id = "{{ $addr->id }}"
                            data-name = "{{ $addr->name }}"
                            data-mobile = "{{ $addr->mobile }}"
                            data-province = "{{ $addr->province }}"
                            data-city = "{{ $addr->city }}"
                            data-district = "{{ $addr->district }}"
                            data-address = "{{ $addr->address }}"
                        >
                            <!---->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div>
                                        <span class="icon icon-house"></span>
                                        <span class="color-brown vam addr-default-container" id = "addr-default-container-{{ $addr->id }}">
                                            @if ($addr->is_default)
                                                默认地址
                                            @endif
                                        </span>
                                    </div>

                                </div>
                                <div class="pull-right">
                                    <div>
                                        <a href="/addr/create?id={{ $addr->id }}&from=order" class="icon icon-update" title="修改"></a>
                                        <a class="icon icon-rubbish addr-del" data-id = {{ $addr->id }} title="删除">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="margin-top20 color-brown">
                                <span class="margin-left20">{{ $addr->name }}</span>
                                <span class="margin-left20">{{ $addr->mobile }}</span>
                            </div>
                            <div class="margin-top20 color-brown">
                                <span class="margin-left20">{{ $addr->province }}</span>
                                <span class="margin-left5">{{ $addr->city }}</span>
                                <span class="margin-left5">{{ $addr->district }}</span>
                            </div>
                            <div class="margin-top5 color-brown">
                                <span class="margin-left20">{{ $addr->address }}</span>
                            </div>
                        </div>
                    @endforeach

                    @if(count($addrs) < 3)
                        <a href="/addr/create" class="sac-addr-add-box pull-left margin-left25">
                            <div class="text-center margin-top55">
                                <span class="icon icon-add"></span>
                                <p class="color-purple margin-top5">增加新地址</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div id="order-message">
            <div>
                <div class="om-head">
                    确定订单消息
                </div>
                <div class="om-con">
                    <div class="row">
                        <div class="col-xs-12 border-golden">
                            <div class="row sc-head">
                                <div class="col-xs-5 text-left">
                                    商品信息
                                </div>
                                <div class="col-xs-3">
                                    单价（￥）
                                </div>
                                <div class="col-xs-2">
                                    数量
                                </div>
                                <div class="col-xs-2">
                                    小计（￥）
                                </div>
                            </div>
                            <div class="row sc-con">
                                <div class="col-xs-12">
                                    <div class="con-f row">
                                        <div class="col-xs-12">
                                            <a>
                                                商家：{{ $attr->goods->merchant->name }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="con-c row">
                                        <div class="col-xs-5 clearfix">
                                            <div class="pull-left">
                                                <img src="{{ $attr->image }}"/>
                                            </div>
                                            <div class="pull-left margin-left15">
                                                <div class="margin-top10 font-border">{{ $attr->title }}</div>
                                                <div class="margin-top10">
                                                    @php
                                                        foreach ($attr_cates as $key => $cate) {
                                                            $attr_name = $cate->attr_name;
                                                            $name = $cate->name;
                                                            if ($attr->$attr_name) {
                                                                echo '<span>' . $name . '：' . $attr->$attr_name . '&nbsp;&nbsp;</span>';
                                                            }
                                                        }
                                                    @endphp
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xs-3 margin-top30">
                                           {{ $attr->price }}
                                        </div>
                                        <div class="col-xs-2 margin-top30 td-amount">
                                            <div class="td-inner">
                                                <div class="amount-wrapper ">
                                                    <div class="item-amount ">
                                                        <a class="amount-sub goods-num-sub"
                                                           data-attr-id="{{ $attr->id }}"
                                                           data-merchant-id="{{ $attr->goods->merchant_id }}"
                                                        >-</a>
                                                        <input
                                                               class="text-amount"
                                                               type="text"
                                                               data-attr-id="{{ $attr->id }}"
                                                               data-merchant-id="{{ $attr->goods->merchant_id }}"
                                                               value="{{ $goods_num }}"
                                                        >
                                                        <a class="amount-add goods-num-add"
                                                           data-attr-id="{{ $attr->id }}"
                                                           data-merchant-id="{{ $attr->goods->merchant_id }}"
                                                        >+</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 margin-top30">
                                            {{ $attr->price * $goods_num }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="row text-right color-golden margin-top20">
                        <div>
                            合计：￥<span id="price">{{ $attr->price * $goods_num }}</span>
                        </div>
                        <div>
                            运费：￥<span>{{ $attr->goods->merchant->fare }}</span>
                        </div>
                        <div class="margin-top20">
                            总计支付：<span class="fontsize-xlarge color-purple">￥<span id="total-price">{{ $attr->price * $goods_num + $attr->goods->merchant->fare }}</span></span>
                        </div>
                        <div class="pull-right">
                            <a id="pay" class="purple-btn margin-top5">去付款</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--支付说明-->
    <div id="payInstruction" class="modal fade">
        <div class="modal-dialog" style="width:450px;">
            <div class="modal-content">
                <div class="modal-header text-center bg-purple color-white">
                    <span class="icon icon-left-cloud"></span>
                    <span>选择支付方式</span>
                    <span class="icon icon-right-cloud"></span>

                    <button type="button" class="close color-white" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body text-center">
                    <p class="margin-top55 margin-bottom100 fontsize-large">本商品因参加购物抽奖仅支持换货不支持退货</p>
                    <a id="goPay" class="button-purple margin-left35 margin-right35">去支付</a>
                </div>
            </div>
        </div>
    </div>
    <!--支付对话框-->
    <div id="payDialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center bg-purple color-white">
                    <span class="icon icon-left-cloud"></span>
                    <span>选择支付方式</span>
                    <span class="icon icon-right-cloud"></span>
                    <button type="button" class="close color-white" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pay-item" data-payType="支付宝">
                        <label for="pay-zfb" class="pay-radio on">
                            <span class="pip"></span>
                        </label>
                        <input id="pay-zfb" type="radio" name="pay-type" value="1">
                        <span class="icon icon-pay-zfb vab margin-left20"></span>
                    </div>
                    <div class="pay-item" data-payType="微信支付">
                        <label for="pay-wx" class="pay-radio">
                            <span class="pip"></span>
                        </label>
                        <input id="pay-wx" type="radio" name="pay-type" value="2">
                        <span class="icon icon-pay-wx vab margin-left20"></span>
                    </div>
                    <a id="payNow" class="button-purple margin-left35 margin-right35">立即支付</a>
                </div>
            </div>
        </div>
    <script>
        var orderObj = {
            data: {
                name: '',
                mobile: '',
                address: '',
                goods: [

                ]
            },
            init: function () {
                orderObj.methods.initLoaded();
                orderObj.methods.listenAddrDel();
                orderObj.methods.listenAddrSel();
                orderObj.methods.listenGoodsNumAdd();
                orderObj.methods.listenGoodsNumSub();
                orderObj.methods.listenGoodsNumCh();
                orderObj.methods.listenPay();
            },
            methods: {
                // ------------------------- 初始化数据相关 ------------------------ start
                initLoaded: function () {
                    orderObj.methods.initAddrs();
                    orderObj.methods.initGoods();
                },
                initAddrs: function () {
                    var is_default = "{{ count($addrs) > 0 ? $addrs[0]->is_default : 0 }}";
                    if (is_default == 1) {
                        var name = "{{ isset($addrs[0]) ? $addrs[0]->name : "" }}";
                        var mobile = "{{ isset($addrs[0]) ? $addrs[0]->mobile : "" }}";
                        var province = "{{ isset($addrs[0]) ? $addrs[0]->province : "" }}";
                        var city = "{{ isset($addrs[0]) ? $addrs[0]->city : "" }}";
                        var district = "{{ isset($addrs[0]) ? $addrs[0]->district : "" }}";
                        var address = "{{ isset($addrs[0]) ? $addrs[0]->address : "" }}";
                        orderObj.methods.setAddrs(name, mobile, province, city, district, address);
                    }
                },
                initGoods: function () {
                    var order = {
                        merchant_id: "{{ $attr->goods->merchant_id }}",
                        attrs: [
                            {
                                attr_id: "{{ $attr->id }}",
                                cart_id: 0,
                                goods_num: "{{ $goods_num }}"
                            }
                        ]
                    }
                    orderObj.data.goods.push(order);
                },
                // ------------------------- 初始化数据相关 ------------------------ end

                // ------------------------- 事件监听相关 ------------------------ start
                listenAddrDel: function () {
                    $(".addr-del").click(function () {
                        var addr_id = $(this).attr('data-id');
                        if (confirm("确认删除")) {
                            $.ajax({
                                url: '/addr/delete',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: addr_id
                                },
                                method: 'post',
                                success: function (data) {
                                    if (data.success) {
                                        window.location.reload();
                                    } else {
                                        alert(data.infor);
                                    }
                                }
                            })
                        }
                    });
                },
                listenAddrSel: function () {
                    $(".addr").click(function () {
                        var id = $(this).attr("data-id");
                        var name = $(this).attr("data-name");
                        var mobile = $(this).attr("data-mobile");
                        var province = $(this).attr("data-province");
                        var city = $(this).attr("data-city");
                        var district = $(this).attr("data-district");
                        var address = $(this).attr("data-address");
                        orderObj.methods.setAddrs(name, mobile, province, city, district, address);
                        orderObj.methods.setAddrDefault(id);
                    });
                },
                listenGoodsNumSub: function () {
                    $(".goods-num-sub").click(function () {
                        var attr_id = $(this).attr("data-attr-id");
                        var merchant_id = $(this).attr("data-merchant-id");

                        var goods_num_container = $(".text-amount[data-attr-id=" + attr_id + "]");
                        var goods_num = goods_num_container.val();

                        if (goods_num >= 2 ) {
                            goods_num--;
                            goods_num_container.val(goods_num);
                            orderObj.methods.chGoodsNum(merchant_id, attr_id, goods_num);
                        }
                    });
                },
                listenGoodsNumAdd: function () {
                    $(".goods-num-add").click(function () {
                        var attr_id = $(this).attr("data-attr-id");
                        var merchant_id = $(this).attr("data-merchant-id");

                        var goods_num_container = $(".text-amount[data-attr-id=" + attr_id + "]");
                        var goods_num = goods_num_container.val();
                        goods_num++;
                        goods_num_container.val(goods_num);

                        orderObj.methods.chGoodsNum(merchant_id, attr_id, goods_num);
                    });
                },
                listenGoodsNumCh: function () {
                    $(".text-amount").change(function () {
                        var goods_num = $(this).val();
                        if (goods_num > 0 && typeof(goods_num) == 'integer') {
                            var merchant_id = $(this).attr("data-merchant-id");
                            var attr_id = $(this).attr("data-attr-id");
                            orderObj.methods.chGoodsNum(merchant_id, attr_id, goods_num);
                        } else {
                            $(this).val(1);
                        }
                    });
                },
//                listenPay: function () {
//                    $("#pay").click(function () {
//                        $("#payDialog").modal("show");
//                    })
//                },
                listenPay: function () {
                    $("#pay").click(function () {

                        var data = orderObj.data;
                        data._token = "{{ csrf_token() }}";
                        data.goods = JSON.stringify(orderObj.data.goods);

                        $.ajax({
                            url: '/order',
                            method: 'post',
                            data: data,
                            success: function (data) {
                                console.log(data);
                                if (data.success == 1) {
                                    form = $("<form></form>");
                                    form.attr('action', '/alipay/sign');
                                    form.attr('method', 'post');

                                    var token_input = $("<input type='hidden' name='_token' />");
                                    token_input.attr('value', "{{ csrf_token() }}");

                                    var keytype_input = $("<input type='hidden' name='keytype' />");
                                    keytype_input.attr('value', 1);

                                    var keyid_input = $("<input type='hidden' name='keyid' />");
                                    keyid_input.attr('value', data.infor.order_id);

                                    form.append(token_input);
                                    form.append(keytype_input);
                                    form.append(keyid_input);

                                    document.body.appendChild(form[0]);

                                    form.submit();

                                } else {
                                    alert(data.infor);
                                }
                            }
                        })
                    });
                },
                // ------------------------- 事件监听相关 ------------------------ end

                setAddrs: function (name, mobile, province, city, district, address) {
                    orderObj.data.name = name;
                    orderObj.data.mobile = mobile;
                    orderObj.data.address = province + city + district + address;
                },
                setAddrDefault: function (id) {
                    $.ajax({
                        url: '/addr/set_default',
                        method: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function () {
                            $(".addr-default-container").html("hah");
                            $("#addr-default-container-" + id).html("默认地址");
                        }
                    })
                },
                chGoodsNum: function (merchant_id, attr_id, goods_num) {
                    var goods = orderObj.data.goods;
                    var len = goods.length;
                    for (var i = 0; i < len; i++) {
                        if (goods[i].merchant_id == merchant_id) {
                            var attrs = goods[i].attrs;
                            var attrs_len = attrs.length;
                            for (var j = 0; j < attrs_len; j++) {
                                if (attrs[j].attr_id = attr_id) {
                                    orderObj.data.goods[i].attrs[j].goods_num = goods_num;
                                }
                            }
                        }
                    }
                }
            }
        }
        orderObj.init();
    </script>
@endsection
@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('lucky_index_css')
    <link rel="stylesheet" href="/web/css/lucky_index.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@push('pay_succ_css')
    <link rel="stylesheet" href="/web/css/paySuccess.css">
@endpush

@section('content')
    <div class="container margin-bottom30">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a>商品购买</a></li>
                    <li><a>订单信息</a></li>
                </ol>
            </div>
        </div>
        <!--<div class="order-content">-->
        <!--<div class="order-title">-->
        <!--<span>订单信息</span>-->
        <!--</div>-->
        <!--<div class="order-con">-->

        <!--</div>-->
        <!--</div>-->
        <!--基本信息-->
        <div class="personal-content pc-pull">
            <div class="person-content">
                <div class="person-header">
                    <span class="header-title">待发货订单</span>
                </div>
                <div class="person-body bg-white">
                    <table class="order-info">
                        <tbody>
                        <tr>
                            <td class="t1">
                                <div class="con">
                                    <h5 class="font-border">收货人信息</h5>
                                    <div>收货人：{{ $order->name }}</div>
                                    <div>联系方式：{{ $order->mobile }}</div>
                                    <div>收货地址：{{ $order->address }}</div>
                                    <div class="margin-top20">
                                        <span class="margin-right20">订单号码：{{ $order->out_trade_no }}</span>
                                        <span>下单时间：{{ date('Y-m-d H:i', strtotime($order->created_at)) }}</span>
                                    </div>
                                    <div>商家信息：{{ $order->merchant->name }}</div>
                                </div>

                            </td>
                            <td class="t2">
                                <div class="con">
                                    <div class="font-border">订单状态：等待发货</div>
                                    <br/>
                                    <div>或到<a href="/orders" class="link">我的订单</a>取消订单</div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="order-list white-style">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <span class="color-golden">
                                        下单时间: {{ date('Y-m-d H:i', strtotime($order->created_at)) }}
                                        &nbsp;&nbsp;
                                        订单号：{{ $order->out_trade_no }}
                                    </span>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->goods as $g)
                                <tr>
                                    <td colspan="2" class="con1">
                                        <img src="{{ $g->image }}"/>
                                        <div class="inline-block vam order-title">
                                            <div>
                                                {{ $g->title }}
                                            </div>
                                            <div>
                                                规格：{{ $g->attr }}
                                            </div>
                                        </div>
                                        <div class="inline-block">
                                            <span class="vam margin-right45">X{{ $g->goods_num }}</span>
                                            <span class="vam">￥{{ $g->price }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                @if ($lottery)
                                    <td class="remark-con">
                                        <span>注<sup>*</sup>:赠送抽奖次数1中奖概率10%,对应时时彩末位数字<br/>本商品只负责换货,不允许退货,请谨慎购买</span>
                                    </td>
                                @endif
                                <td class="total-con">
                                    <div class="text-right color-golden">
                                        <div>
                                            <div>
                                                总价：￥{{ $order->total_money - $order->fare }}
                                            </div>
                                            <div class="margin-bottom15">
                                                运费：￥{{ $order->fare }}
                                            </div>
                                            <span>总计支付：</span>
                                            <span class="fontsize-normal">￥</span>
                                            <span class="fontsize-xxlarge color-purple">{{ $order->total_money }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!--选择幸运数字-->
                    @if ($lottery)
                        <div class="text-center color-golden margin-top30 margin-bottom10">支付成功，去选择你的幸运数字!</div>
                        <table class="lucky-list white-style">
                            <thead>
                                <tr>
                                    <td colspan="2" class="clearfix">
                                        <div class="pull-left title-with-btn">
                                            你的幸运数字
                                        </div>
                                        <div class="pull-right">
                                            <a class="purple-btn2" id="submit">提交</a>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="lottery-container">
                                {{-- 显示选中的号码 --}}
                            </tbody>
                            <tfoot id="add-luck-num">
                                <tr>
                                    <td colspan="2" class="add-lucky">
                                        <a id="addLuckyNum" class="color-golden"><span class="icon icon-circle-add margin-right15"></span><span class="vam">选择幸运数字</span></a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="luckyDialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center bg-purple color-white">
                    <span class="icon icon-left-cloud"></span>
                    <span>选择幸运数字</span>
                    <span class="icon icon-right-cloud"></span>
                    <button type="button" class="close color-white" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="lkDialog-title">
                        @php
                            if ($lottery) {
                                echo '<span class="t1">距 ' . $lottery['last']->expect . ' 期截止</span>';
                            }
                        @endphp
                        <br/>
                        <span>(开奖前2min自动算到下期)</span>
                    </div>
                    <div class="band-aid margin-top25">
                        <div class="band-aid-wrap">
                            <span class="icon-square-number">0</span>
                            <span class="icon-square-number">5</span>
                            :
                            <span class="icon-square-number">0</span>
                            <span class="icon-square-number">5</span>
                            :
                            <span class="icon-square-number">0</span>
                            <span class="icon-square-number">5</span>
                        </div>
                    </div>
                    <div id="allow-sel-container">
                    
                    </div>
                    <a id="pickOk" class="button-purple margin-left35 margin-right35 margin-top55">确定</a>
                </div>
            </div>
        </div>
    </div>
    <script>

        var lotteryObj = {
            data: {
                lottery: JSON.parse('{!! json_encode($lottery) !!}'),
                current_luck_num: 0,
                sels: [],
                temp_sel: [null, null, null, null, null]
            },
            init: function () {
                lotteryObj.methods.listenAddLuckyBtn();
                lotteryObj.methods.appendLotterySel();
                lotteryObj.methods.listenSelNum();
                lotteryObj.methods.listenSubmitSel();
                lotteryObj.methods.listenDialogClosed();
                lotteryObj.methods.listenRmLottery();
                lotteryObj.methods.listenSubmit();
            },
            methods: {
                listenAddLuckyBtn: function () {
                    $('#addLuckyNum').click(function () {
                        if (lotteryObj.data.current_luck_num >= lotteryObj.data.lottery.luck_num) {
                            alert('最多可选' + lotteryObj.data.lottery.luck_num + '组号码');
                        } else {
                            $('#luckyDialog').modal();
                        }
                    });
                },
                isShowAddLuckBtn: function () {
                    if (lotteryObj.data.current_luck_num >= lotteryObj.data.lottery.luck_num) {
                        $("#add-luck-num").css("display", "none");                       
                    } else {
                        $("#add-luck-num").css("display", "block");                       
                    }
                },
                appendLotterySel: function () {
                    var lotteryPoint = ['个位', '十位', '百位', '千位', '万位'];
                    var allowNum = lotteryObj.data.lottery.options[0].num;
                    var template = '';
                    for(var i = 0; i < allowNum; i++) {
                        template    +=  '<div class="lucky-pick clearfix">';
                        template    +=      '<div class="pick-title">';
                        template    +=          lotteryPoint[i];
                        template    +=      '</div>';
                        template    +=      '<div class="pick-content" data-point="' + i + '">';
                        template    +=          '<div>';
                        template    +=              '<a class="icon icon-win-number">0</a>';
                        template    +=              '<a class="icon icon-win-number">1</a>';
                        template    +=              '<a class="icon icon-win-number">2</a>';
                        template    +=              '<a class="icon icon-win-number">3</a>';
                        template    +=              '<a class="icon icon-win-number">4</a>';
                        template    +=          '</div>';
                        template    +=          '<div>';
                        template    +=              '<a class="icon icon-win-number">5</a>';
                        template    +=              '<a class="icon icon-win-number">6</a>';
                        template    +=              '<a class="icon icon-win-number">7</a>';
                        template    +=              '<a class="icon icon-win-number">8</a>';
                        template    +=              '<a class="icon icon-win-number">9</a>';
                        template    +=          '</div>';
                        template    +=      '</div>';
                        template    +=  '</div>';
                    }
                    $("#allow-sel-container").html(template);
                },
                appendLottery: function () {
                    var template = '';
                    var sels = lotteryObj.data.sels;
                    for (var sel_key in sels) {
                        var sel = sels[sel_key];
                        template    += '<tr>';
                        template    +=      '<td class="con1">';
                        for (var s_key in sel) {
                            if (sel[s_key] !== null) {
                                template    +=          '<span class="icon icon-win-number selected margin-right15">' + sel[s_key] + '</span>';
                            }
                        }
                        template    +=      '</td>';
                        template    +=      '<td class="con2">';
                        template    +=          '<a class="rm-btn"><span class="icon icon-remove margin-right5"></span><span class="vam" data-key="' + sel_key + '">删除</span></a>';
                        template    +=      '</td>';
                        template    += '</tr>';
                    }
                    $("#lottery-container").html(template);
                    lotteryObj.data.current_luck_num = sels.length;
                    lotteryObj.methods.isShowAddLuckBtn();
                },
                listenRmLottery: function () {
                    $("#lottery-container").on('click', '.rm-btn', function () {
                        var sel_key = $(this).attr("data-key");
                        lotteryObj.methods.rmLottery(sel_key);
                    });
                },
                rmLottery: function (sel_key) {
                    lotteryObj.data.sels.splice(sel_key, 1);
                    lotteryObj.methods.appendLottery();
                },
                listenSelNum: function () {
                    $(".pick-content a").click(function () {
                        var num = $(this).html();
                        var point = $(this).parent().parent().attr("data-point");
                        $(".pick-content[data-point='" + point + "'] a").removeClass("selected");
                        $(this).addClass("selected");
                        lotteryObj.data.temp_sel[point] = num;
                    });
                },
                // 提交选中的号码
                listenSubmitSel: function () {
                    $("#pickOk").click(function () {
                        var temp_sel = lotteryObj.data.temp_sel;
                        // 中间不能有空位
                        var sel_num1 = 0;
                        var sel_num2 = 0;
                        for (var i = 4; i >= 0; i--) {
                            if (temp_sel[i] !== null) {
                                sel_num1++;
                                sel_num2++;
                            } else {
                                (sel_num2 > 0) ? sel_num2-- : 0;
                            }
                        }
                        
                        if (sel_num1 != sel_num2) {
                            alert('之前不能有空位');
                        } else if (sel_num1 == 0) {
                            alert('请选择号码');
                        } else {
                            $("#luckyDialog").modal('hide');
                            lotteryObj.methods.pushSels(temp_sel); 
                        }
                    });
                },
                listenDialogClosed: function () {
                    $("#luckyDialog").on("hidden.bs.modal", function () {
                        lotteryObj.methods.clearTempSel();
                    })
                },
                pushSels: function (sel) {
                    lotteryObj.data.sels.push(sel);
                    lotteryObj.methods.appendLottery();
                },
                clearTempSel: function () {
                    $(".pick-content a").removeClass("selected");
                    lotteryObj.data.temp_sel = [null, null, null, null, null];
                },
                listenSubmit: function () {
                    $("#submit").click(function () {
                        var codes = '';
                        var sels = lotteryObj.data.sels;
                        console.log(sels);
                        if (sels.length <= 0) {
                            alert('请先选择号码');
                        } else {
                            for (var i in sels) {
                                var sel = sels[i];
                                for (var j in sel) {
                                    if (sel[j] !== null) {
                                        codes += sel[j] + ',';
                                    }
                                }
                                codes = codes.substr(0, codes.length - 1);
                                codes += '@';
                            }
                            codes = codes.substr(0, codes.length - 1);

                            var data = {};
                            data.order_id = "{{ $order->id }}";
                            data.selected_code = codes;
                            data._token = "{{ csrf_token() }}";
                            console.log(data);
                            $.ajax({
                                url: '/lottery',
                                method: 'post',
                                data: data,
                                success: function (data) {
                                    if (data.success == 1) {
                                        window.location.href = '/user';
                                    } else {
                                        alert(data.infor);
                                    }
                                }
                            });
                        }
                    });
                }
            }
        }
        lotteryObj.init();
    </script>
@endsection
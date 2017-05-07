@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@push('personal_js')
    <script src="/web/js/personStyle.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/orders">订单</a></li>
                    <li><a >订单详情</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">
                            @php
                                $status = ['待支付', '待发货', '待收货', '待评价', '已评价', '已关闭'];
                                echo $status[$order->status - 1];
                            @endphp
                            &nbsp;订单详情
                        </span>
                    </div>
                    <div class="person-body">
                        @if($order->is_lucky && $order->lottery_expect)
                            <table class="win-info">
                                <thead>
                                    <tr>
                                        <td>
                                            <span>{{ $order->lottery_expect }}期中奖号码</span>
                                            @php
                                                $opencodes = explode(',', $order->opencode);
                                                foreach($opencodes as $code) {
                                                    if ($code) {
                                                        echo '<span class="icon icon-win-number selected">' . $code . '</span>'; 
                                                    } else {
                                                        echo '<span style="margin-left: 10px; color: #13CE66;">等待开奖...</span>';
                                                    }
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @foreach($order->lotteries as $lottery)
                                                @if($lottery->status == 1)
                                                    <span class="icon icon-win"></span>
                                                @endif
                                                @if ($lottery->status == 0)
                                                    <span style="color: #13CE66;">等待开奖...</span>
                                                @endif
                                                @if ($lottery->status == 2)
                                                    <span style="color: #FF4949;">未中奖</span>
                                                @endif
                                                已选号码: 
                                                @php
                                                    $codes = explode(',', $lottery->code);
                                                    foreach($codes as $code) {
                                                        echo '<span class="icon icon-win-number selected">' . $code . '</span>';
                                                    }
                                                @endphp
                                                <br/><br/>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        <table class="order-info">
                            <tbody>
                            <tr>
                                <td class="t1">
                                    <div class="con">
                                        <h5 class="font-border">收货人信息</h5>
                                        <div>收货人：{{ $order->name }}</div>
                                        <div>联系方式：{{ $order->mobile }}</div>
                                        <div>收货地址：{{ $order->address }}</div>
                                        <div>订单信息：{{ $order->merchant->name }}</div>
                                    </div>
                                </td>
                                <td class="t2">
                                    <div class="con">
                                        @if ($order->status == 1)
                                            <div class="font-border">订单状态：{{ $status[$order->status - 1] }}</div><br/>
                                            <div>您可以<a class="purple-btn">去支付</a></div><br />
                                            <div>或到<a class="link" href="/orders">我的订单</a>取消订单</div>
                                        @elseif($order->status == 2)
                                            <div class="font-border">订单状态：</div>
                                            <br />
                                            <div class="font-border">买家已付款，等待卖家发货</div>
                                        @elseif($order->status == 3)
                                            <div class="font-border">订单状态：等待收货!</div><br />
                                            <div>您可以<a class="purple-btn">确认收货</a></div><br />
                                            <span>物流信息：{{ $order->express_name }}</span><br/>
                                            <span>运单号码：{{ $order->express_no }}</span>
                                        @elseif($order->status == 4)
                                            <div class="font-border">订单状态：交易完成</div><br />
                                            <br/>
                                            <span>物流信息：{{ $order->express_name }}</span><br/>
                                            <span>运单号码：{{ $order->express_no }}</span>
                                        @elseif($order->status == 5)

                                        @elseif($order->status == 6)
                                            <div class="font-border">订单状态：交易关闭</div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="order-list">
                            <thead>
                            <tr>
                                <td colspan="2">
                                     <span class="color-golden">
                                            下单时间: {{ date('Y-m-d H:i', strtotime($order->created_at)) }}
                                            订单号：{{ $order->out_trade_no }}
                                     </span>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->goods as $g)
                                <tr>
                                    <td class="con1">
                                        <img src="{{ $g->image }}" />
                                        <div class="inline-block vam order-title">
                                            <div>
                                                {{ $g->name }}
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
                                    <td class="con2">
                                        @if(($order->status == 4 || $order->status == 5) && $g->service_status == 0)
                                            <a href="/services/create/{{ $g->id }}">申请售后</a>
                                        @endif
                                        @if($g->is_comment == 0)
                                            <a href="/comments/create/{{ $g->id }}">去评价</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-right margin-top30 color-golden">
                            <div>
                                <div>
                                    总价：￥{{ $order->total_money - $order->merchant->fare }}
                                </div>
                                <div class="margin-bottom15">
                                    运费：￥{{ $order->merchant->fare }}
                                </div>
                                <span>总计支付：</span>
                                <span class="fontsize-normal">￥</span>
                                <span class="fontsize-xxlarge color-purple">{{ $order->total_money }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

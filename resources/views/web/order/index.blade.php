@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_list_css')
    <link rel="stylesheet" href="/web/css/personCenter/mallOrders.css">
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
                    <li><a href="/user">个人中心</a></li>
                    <li><a>订单列表</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">商城订单</span>
                    </div>
                    <div class="person-body">
                        <div class="row order-filter">
                            <div class="col-xs-12 ">
                                <ul id="orders-nav" class="clearfix">
                                    <li class="selected">
                                        <a href="/orders?is_lucky={{ $is_lucky }}">全部订单</a>
                                    </li>
                                    <li class="">
                                        <a href="/orders?keytype=1&is_lucky={{ $is_lucky }}">待支付</a>
                                    </li>
                                    <li>
                                        <a href="/orders?keytype=2&is_lucky={{ $is_lucky }}">待发货</a>
                                    </li>
                                    <li>
                                        <a href="/orders?keytype=3&is_lucky={{ $is_lucky }}">待收货</a>
                                    </li>
                                    <li>
                                        <a href="/orders?keytype=4&is_lucky={{ $is_lucky }}">已完成</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row order-list">
                            <div class="col-xs-12">
                                @if (count($orders) > 0)
                                    @foreach ($orders as $order)
                                        <table class="order-detail">
                                            <thead>
                                                <tr>
                                                    <td colspan="2">
                                                <span  class="color-golden">
                                                下单时间: {{ $order->created_at }}
                                                    &nbsp;&nbsp;
                                                订单号：{{ $order->out_trade_no }}
                                                </span>

                                                    </td>
                                                    <td class="text-center">
                                                <span class="color-purple ">
                                                    @php
                                                        $status = ['待支付', '待发货', '待收货', '待评价', '已评价', '已关闭'];
                                                        echo $status[$order->status - 1];
                                                    @endphp
                                                </span>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="item-con1">
                                                        @foreach($order->goods as $g)
                                                            <div style="margin-bottom: 20px; margin-top: 20px;">
                                                                <img src="{{ $g->image }}" />
                                                                <div class="inline-block vam order-title">
                                                                    <div>
                                                                        {{ $g->name }}
                                                                    </div>
                                                                    <div>
                                                                        规格: {{ $g->attr }}
                                                                    </div>
                                                                </div>
                                                                <div class="inline-block">
                                                                    <span class="vam margin-right45">X{{ $g->goods_num }}</span>
                                                                    <span class="vam">￥{{ $g->price }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td class="item-con2" rowspan="2" >
                                                        <div>￥{{ $order->total_money }}</div>
                                                        <div>(含运费：￥{{ $order->fare }})</div>
                                                    </td>
                                                    <td class="item-con3" rowspan="2" >
                                                        @if ($order->status == 1)
                                                            <a class="btn-purple">去支付</a>
                                                        @endif
                                                        @if ($order->status == 1)
                                                            <a class="btn-white">取消订单</a>
                                                        @endif
                                                        <a href="/order/{{ $order->id }}">订单详情</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            @if ($is_lucky == 1)
                                                @if ($order->is_bet)
                                                    <tfoot class="winning-footer">
                                                        <tr>
                                                            <td colspan="1">
                                                                @if ($order->lotteries)
                                                                    @foreach($order->lotteries as $lottery)
                                                                        @if ($lottery->code)
                                                                            <span class="icon icon-wait"></span>
                                                                            已选号码: 
                                                                            @php
                                                                                $codes = explode(',', $lottery->code);
                                                                                foreach ($codes as $code) {
                                                                                    echo '<span class="icon icon-win-number">' . $code . '</span>';
                                                                                }
                                                                            @endphp
                                                                            <br/><br/>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td colspan="2" class="text-right">
                                                                <span>{{ $order->lottery_expect }} 期 待开奖</span>
                                                                @if ($order->opencode)
                                                                    <div class="text-center margin-left15">
                                                                        @php
                                                                            $opencodes = explode(',', $order->opencode);
                                                                            foreach($opencodes as $code) {
                                                                                echo '<span class="icon icon-win-number selected">1</span>';
                                                                            }
                                                                        @endphp
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                @else
                                                    <tfoot class="winning-footer">
                                                        <tr>
                                                            <td colspan="3" style="color: red;">没有选择投注</td> 
                                                        </tr>
                                                    </tfoot>
                                                @endif
                                            @endif
                                        </table>
                                    @endforeach
                                @else
                                    <p style="height: 80px; line-height: 80px; text-align: center;">还没有对应订单</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var params = window.location.search;
        if (params) {
            params = params.sbustring(1);
            var param_arr = params;
        }
    </script>
@endsection

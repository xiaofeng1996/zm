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
                    <li><a href="/user">个人中心</a></li>
                    <li><a >售后列表</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">待发货&nbsp;订单详情</span>
                    </div>
                    <div class="person-body">
                        <table class="order-header">
                            <tbody>
                            <tr>
                                <td class="con1">商品信息</td>
                                <td class="con2">退款金额</td>
                                <td class="con3">售后种类</td>
                                <td class="con4">退款状态</td>
                            </tr>
                            </tbody>
                        </table>
                        @foreach($services as $service)
                            <table class="order-status">
                                <thead>
                                <tr>
                                    <td colspan="3">
                                        <span class="color-golden">
                                                申请时间: {{ $service->applied_service_at }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="/services/{{ $service->id }}" class="text-underline">详情</a>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="con1">
                                        <img style="width: 80px; height: 80px;" src="{{ $service->goods->image }}"/>
                                        <div class="inline-block vam order-title">
                                            <div>
                                                {{ $service->goods->name }} 
                                            </div>
                                            <div>
                                                规格: {{ $service->goods->attr }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="con2">
                                        <span>￥{{ $service->applied_fee }}</span>
                                    </td>
                                    <td class="con3">
                                        @php
                                            $type = ['退货', '换货'];
                                            echo '<span>' . $type[$service->service_type - 1] . '</span>';
                                        @endphp
                                    </td>
                                    @php
                                        $status = ['申请中', '申请成功', '申请拒绝'];
                                        echo '<td class="con4">状态: ' . $status[$service->service_status - 1] . '</td>';
                                    @endphp
                                </tr>
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
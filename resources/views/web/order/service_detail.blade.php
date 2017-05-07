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
                    <li><a href="/services">售后服务</a></li>
                    <li><a>售后详情</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content status-area padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">售后详情</span>
                    </div>
                    <div class="person-body">
                        <div class="status-title">
                            @php
                                $status = ['申请中', '申请通过', '拒绝售后'];
                                echo '状态： ' . $status[$service->service_status - 1];
                            @endphp
                        </div>
                        <div class="status-info">
                            <span>申请时间: {{ date('Y-m-d H:i', strtotime($service->applied_service_at)) }}<span>
                            <br /><br />
                            <span class="font-border">
                                @php
                                    $type = ['退货', '换货'];
                                    echo '售后类型：&nbsp;&nbsp;' . $type[$service->service_type - 1];
                                @endphp
                            </span><br />
                            <span class="font-border">申请原因:&nbsp;&nbsp;{{ $service->applied_reason }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
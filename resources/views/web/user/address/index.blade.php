@extends('web.layout.main')

@push('address_css')
    <link rel="stylesheet" href="/web/css/personCenter/shippingAddressManager.css">
@endpush

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a>地址管理</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">收货地址管理</span>
                    </div>
                    <div class="person-body">
                        @if (count($addrs))
                            <!--后货地址-->
                                <div class="row">
                                    <div class="col-xs-3">
                                        <span class="fontsize-large color-golden font-border">您有{{ count($addrs) }}个收货地址</span>
                                    </div>
                                </div>
                                <hr class="hr-khaki"/>
                                <div id="shippingAddress" class="row">
                                    <div class="col-xs-4">
                                        <span class="color-golden line-height48">已保存有效地址（最多设置5个）</span>
                                    </div>
                                    <div class="col-xs-4 col-xs-offset-4">
                                        <a class="add-address">
                                            <apan>
                                                <span class="icon icon-add"></span>
                                                <span id="new-addr" class="fontsize-large relative-top-2" style="cursor: pointer;">新增收货地址</span>
                                            </apan>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="person-table">
                                            <thead>
                                            <tr>
                                                <td>收件人</td>
                                                <td>所在地</td>
                                                <td>详细地址</td>
                                                <td>邮政编码</td>
                                                <td>收货人地址</td>
                                                <td>操作</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($addrs as $addr)
                                                <tr>
                                                    <td>{{ $addr->name }}</td>
                                                    <td>{{ $addr->province }} {{ $addr->city }} {{ $addr->district }}</td>
                                                    <td>{{ $addr->address }}</td>
                                                    <td>{{ $addr->zipcode }}</td>
                                                    <td>{{ $addr->mobile }}</td>
                                                    <td>
                                                        <div>
                                                            <a href="/addr/create?id={{ $addr->id }}" class="inline-block margin-right5">修改</a>
                                                            |
                                                            <a class="inline-block margin-left5 del" style="cursor: pointer;" data-id="{{ $addr->id }}">删除</a>
                                                        </div>
                                                        <div>
                                                            @if($addr->is_default)
                                                                <a class="set-def-btn purple-btn">
                                                                    默认地址
                                                                </a>
                                                            @else
                                                                <a class="set-def-btn purple-btn def" style="cursor: pointer;" data-id="{{ $addr->id }}">
                                                                    设为默认
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function () {
            $(".del").click(function() {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: '/addr/delete',
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function () {
                        window.location.reload();
                    }
                })
            });
        })();

        (function () {
            $(".set-def-btn").click(function() {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: '/addr/set_default',
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function () {
                        window.location.reload();
                    }
                })
            });
        })();

        $("#new-addr").click(function () {
            window.location.href = '/addr/create';
        });
    </script>
@endsection

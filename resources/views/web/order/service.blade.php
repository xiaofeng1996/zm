@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('sale_service_css')
    <link rel="stylesheet" href="/web/css/personCenter/applyForAftermarket.css">
@endpush

@push('personal_js')
    <script src="/web/js/personStyle.js"></script>
@endpush

@push('sale_service_js')
    <script src="/web/js/applyForAftermarket.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a href="/orders">订单</a></li>
                    <li><a href="/order/"></a></li>
                    <li><a>申请售后</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">申请售后</span>
                    </div>
                    <div class="person-body">
                        <!--订单信息-->
                        <div class="order-info">
                            <div>
                                订单编号：{{ $order_goods->order->out_trade_no }} <br/>
                                下单时间：{{ date('Y-m-d H:i', strtotime($order_goods->order->created_at)) }}<br/>
                                @php
                                    $status = ['待支付', '待发货', '待收货', '待评价', '已评价'];
                                    echo '订单状态：' . $status[$order_goods->order->status - 1];
                                @endphp
                            </div>
                        </div>
                        <!--订单列表-->
                        <table class="order-item">
                            <tbody>
                            <tr>
                                <td class="t1">
                                    <img src="{{ $order_goods->image }}"/>
                                    <div class="inline-block order-title">
                                        {{ $order_goods->name }}<br/>
                                        规格：{{ $order_goods->attr }}
                                    </div>
                                    <div class="inline-block">
                                        X{{ $order_goods->goods_num }}
                                    </div>
                                </td>
                                <td class="t2">
                                    ￥{{ $order_goods->price }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--操作区-->
                        <form action="/services" method="POST" class="order-form" role="form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="text" name="order_id" value="{{ $order_goods->order_id }}" style="display: none;">
                            <input type="text" name="order_goods_id" value="{{ $order_goods->id }}" style="display: none;">
                            @if ($errors->first())
                                <p class="err-msg">{{ $errors->first() }}</p>
                            @endif
                            <div class="form-group clearfix">
                                <div class="form-radio">
                                    <div class="person-radio sales-type on">
                                        <span class="pip"></span>
                                        <input type="radio" id="returns" name="service_type" checked="checked" value="1" />
                                    </div>
                                    <label for="returns">换货</label>
                                </div>
                                <div class="form-radio">
                                    <div class="person-radio sales-type">
                                        <span class="pip"></span>
                                        <input type="radio" id="replacement" name="service_type" value="2" />
                                    </div>
                                    <label for="replacement">退货</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="apply-area" name="applied_reason" placeholder="输入申请原因"></textarea>
                            </div>
                            <div class="form-group ">
                                <div class="clearfix">
                                    <div class="btn-upload-img">
                                        <label for="img1">上传图片</label>
                                        <img id="image1" src="/web/images/upload_img.jpg" style="width:82px;height:82px;" data-target="#img1"/>
                                        <input id="img1" type="file" name="file0" onchange="previewImage(this,'image1')">
                                    </div>
                                    <div class="btn-upload-img">
                                        <label for="img2">上传图片</label>
                                        <img id="image2" src="/web/images/upload_img.jpg" style="width:82px;height:82px;" data-target="#img2"/>
                                        <input id="img2" type="file" name="file1" onchange="previewImage(this,'image2')">
                                    </div>
                                    <div class="btn-upload-img">
                                        <label for="img3">上传图片</label>
                                        <img id="image3" src="/web/images/upload_img.jpg" style="width:82px;height:82px;" data-target="#img3"/>
                                        <input id="img3" type="file" name="file2" onchange="previewImage(this,'image3')">
                                    </div>
                                    <div class="btn-upload-img">
                                        <label for="img4">上传图片</label>
                                        <img id="image4" src="/web/images/upload_img.jpg" style="width:82px;height:82px;" data-target="#img4"/>
                                        <input id="img4" type="file" name="file3" onchange="previewImage(this,'image4')">
                                    </div>
                                </div>
                                <span class="color-brown">(仅支持JPG，JPGE，GIF格式的图片最大2M)</span>


                            </div>
                            <div class="form-group">
                                <a id="submit" class="purple-btn">提交</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#submit").click(function () {
            $("form").submit();
        });
    </script>
@endsection
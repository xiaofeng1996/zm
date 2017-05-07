@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('comment_css')
    <link rel="stylesheet" href="/web/css/personCenter/estimate.css">
@endpush

@push('personal_js')
    <script src="/web/js/personStyle.js"></script>
@endpush

@push('comment_js')
    <script src="/web/js/estimate.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a href="/orders">会员订单</a></li>
                    <li><a href="/orders/">订单详情</a></li>
                    <li><a>评论</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">商品评价</span>
                    </div>
                    <div class="person-body">
                        <!--操作区-->
                        <form action="/comments" method="POST" class="order-form" role="form" enctype="multipart/form-data">
                            @if ($errors->first())
                                <p class="err-msg">{{$errors->first()}}</p>
                            @endif
                            {{ csrf_field() }}
                            <input type="text" name="order_id" value="{{ $order_goods->order_id }}" style="display: none;">
                            <input type="text" name="order_goods_id" value="{{ $order_goods->id }}" style="display: none;">
                            <input id="star" type="text" name="star" value="5" style="display: none;">
                            <div class="form-group">
                                <ul class="flower-list clearfix">
                                    <li class="checked">
                                        <a></a>
                                    </li>
                                    <li class="checked">
                                        <a></a>
                                    </li>
                                    <li class="checked">
                                        <a></a>
                                    </li>
                                    <li class="checked">
                                        <a></a>
                                    </li>
                                    <li class="checked">
                                        <a></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <textarea class="apply-area" name="content" placeholder="评价内容"></textarea>
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
        })
    </script>
@endsection

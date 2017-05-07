@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('personal_data_css')
    <link rel="stylesheet" href="/web/css/personCenter/personalData.css">
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
                    <li><a>个人中心</a></li>
                    <li><a>个人资料</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">个人资料</span>
                    </div>
                    <div class="person-body">
                        <div class="person-nav">
                            <ul class="clearfix">
                                <li id="base-info-nav" class="selected">
                                    <a data-target="#personInfo">基本信息</a>
                                </li>
                                <li id="safe-info-nav">
                                    <a data-target="#accountSafe">账户安全</a>
                                </li>
                            </ul>
                        </div>
                        <div class="row" >
                            <form id="personInfo" class="nav-content" action="/user/save" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="portrait-item row">
                                    <div class="col-xs-1 col-xs-offset-2 item-label">
                                        <span>头像：</span>
                                    </div>
                                    <div class="col-xs-2 person-portrait text-left">
                                        <img id="portraitImg" src="{{ $user->avatar }}" style="width:107px;height:107px;margin:0"/>
                                    </div>
                                    <div class="col-xs-5 padding-left0 btn-upload-img">
                                        <label for="uploadPortrait">上传头像</label>
                                        <input id="uploadPortrait" class="text-left" type="file" name="avatar" onchange="previewImage(this,'portraitImg')"/>
                                        <div class="fontsize-small color-golden">支持JPG，JPEG，GIF格式的图片最大2M</div>
                                    </div>

                                </div>
                                <div class="nickname-item row">
                                    <div class="col-xs-1 col-xs-offset-2 item-label">
                                        <span>昵称：</span>
                                    </div>
                                    <div class="col-xs-7 text-left">
                                        <input type="text"  placeholder="请输入昵称" name="name" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-xs-offset-3">
                                        <button id="personInfoSubmit" class="purple-btn">保存</button>
                                    </div>
                                </div>
                            </form>
                            <form id="accountSafe" class="nav-content clearfix" action="/password/reset" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <div class="form-item row">
                                    <div class="col-xs-1 col-xs-offset-2 item-label">
                                    </div>
                                    <div class="col-xs-7">
                                        @if($errors->first())
                                            <p class="err-msg"> {{ $errors->first() }} </p>
                                        @endif

                                        @if (session('reset_err'))
                                            <p class="err-msg"> {{ session('reset_err') }} </p>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-item row">
                                    <div class="col-xs-1 col-xs-offset-2 item-label">
                                        <span>密码：</span>
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="password" name="old_password" placeholder="请输入原密码">
                                    </div>
                                </div>
                                <div class="form-item row">
                                    <div class="col-xs-1 col-xs-offset-2 item-label">
                                        <span>新密码：</span>
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="password" name="new_password" placeholder="新密码，密码由6~20位字母，数字和符号组成">
                                    </div>
                                </div>
                                <div class="form-item row">
                                    <div class="col-xs-1 col-xs-offset-2 item-label">
                                        <span>确认密码：</span>
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="password" name="re_new_password" placeholder="请再次输入上面密码">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-xs-offset-3">
                                        <button id="accountSafeSubmit" class="purple-btn">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function (global) {
            $(".person-nav ul li").click(function () {
                var id = $(this).attr("id");
                var href = global.location.href;
                if (id == 'base-info-nav') {
                    global.location.href = global.location.href.split("#")[0] + '#base';
                    global.location.reload();
                } else {
                    global.location.href = global.location.href.split("#")[0] + '#safe';
                    global.location.reload();
                }
            });
        })(window);
        (function (global) {
            var href = global.location.href;
            var anchor = href.split('#')[1];
            if (anchor && anchor == 'safe') {
                showSafeInfo();
            } else {
                showBaseInfo();
            }
        })(window);
        function showBaseInfo() {
            $("#safe-info-nav").removeClass('selected');
            $("#accountSafe").css("display", "none")
            $("#base-info-nav").addClass('selected');
            $("#personInfo").css('display', 'block');
        }
        function showSafeInfo() {
            $("#base-info-nav").removeClass('selected');
            $("#personInfo").css('display', 'none');
            $("#safe-info-nav").addClass('selected');
            $("#accountSafe").css("display", "block")
        }
    </script>
@endsection

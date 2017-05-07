@extends('web.layout.main')

@push('personal_css')
    <link href="/web/css/base/personStyle.css" rel="stylesheet">
@endpush

@push('personal_js')
    <script src="/web/js/personStyle.js"></script>
@endpush

@section('header')
    <div id="header" class="min-con">
        <div class="container">
            <div class="header-con">
                <div class="logo">
                    <a href="/">
                        <img src="/web/images/zhimeishangcheng.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="reg-main clearfix">
            <div class="reg-other pull-left">
                <img class="startle" src="/web/images/buybuy.png" />
            </div>
            <div class="reg-form pull-right">
                <form action="/forgot/password" method="POST">
                    <div class="form-group clearfix">
                        <span class="pull-left fontsize-xlarge font-border">找回密码</span>
                        <a href="/?login=1" class="color-purple pull-right text-underline">直接登录</a>
                    </div>
                    {{ csrf_field() }}
                    <p style="color: #FF4949;">{{ $errors->first() }}</p>
                    @if (session('forgot_err'))
                        <p style="color: #FF4949;">{{ session('forgot_err') }}</p>
                    @endif
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">手机号</div>
                            <input class="form-control" type="text" name="mobile" placeholder="请输入手机号" value="{{ old('mobile') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">密码</div>
                            <input class="form-control" type="password" name="password" placeholder="密码由6~20位字母，数字和符号组成" value="{{ old('password') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">确认密码</div>
                            <input class="form-control" type="password" name="re_password" placeholder="请再次输入上面密码" value="{{ old('re_password') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group verification-group">
                            <div class="input-group-addon">验证码</div>
                            <input class="form-control" type="text" name="code" placeholder="请再次输入上面密码">
                            <span id="verify-code-container" class="verification-code color-purple">
                                <span id="get-verify-code" style="cursor: pointer;">点击获取验证码</span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <a id="form-submit" class="button-purple">找回密码</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var forgotObj = {
            data: {
                seconds: 60
            },
            methods: {
                listenCodeClick: function () {
                    $("#get-verify-code").click(function () {
                        forgotObj.data.seconds = 60;
                        forgotObj.methods.getVerifyCode();
                    });
                },
                getVerifyCode: function () {
                    var mobile = $("input[name='mobile']")[0].value;
                    if (!mobile) {
                        alert('请先填写手机号');
                    } else {
                        $.ajax({
                            url: '/code/send',
                            method: 'get',
                            data: {
                                mobile: mobile
                            },
                            success: function (data) {
                                forgotObj.methods.timeCountDown();
                            }
                        })
                    }
                },
                timeCountDown: function () {
                    if (forgotObj.data.seconds <= 0) {
                        $("#verify-code-container").html('<span id="get-verify-code">重新获取验证码</span>');
                    } else {
                        forgotObj.data.seconds--;
                        $("#verify-code-container").html(forgotObj.data.seconds + 's后重新获取');
                        setTimeout('forgotObj.methods.timeCountDown()', 1000);
                    }
                }
            }
        }
        forgotObj.methods.listenCodeClick();

        // 表单相关
        (function () {
            $("#form-submit").click(function () {
                $("form")[0].submit();
            });
        })();

    </script>
@endsection
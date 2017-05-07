@extends('web.layout.main')


@push('personal_css')
    <link href="/web/css/base/personStyle.css" rel="stylesheet">
@endpush

@push('bootstrap_select_css')
    <link href="/web/frame/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
@endpush

@push('auth_register_js')
    <script src="/web/js/auth/register.js"></script>
@endpush

@push('register_plus_css')
    <link rel="stylesheet" href="/web/css/register_plus.css">
@endpush

@push('citys_js')
    <script src="/js/city.min.js"></script>
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
                <img class="startle" src="/web/images/buybuy.png"/>
            </div>
            <div class="reg-form pull-right">
                <form action="/register" method="POST">
                    <div class="form-group clearfix">
                        <span href="/password/find" class="pull-left fontsize-xlarge font-border">注册</span>
                        <a href="/?login=1" class="color-purple pull-right text-underline">直接登录</a>
                    </div>
                    {{ csrf_field() }}
                    <p class="reg-err-msg">{{ $errors->first() }}</p>
                    @if (session('reg_err'))
                        <p class="reg-err-msg">{{ session('reg_err') }}</p>
                    @endif
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon" >手机号</div>
                            <input class="form-control" type="text" name="mobile" placeholder="请输入手机号" value="{{ old('mobile') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">密码</div>
                            <input class="form-control" type="password" name="password" placeholder="请输入密码" value="{{ old('password') }}">
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
                            <input class="form-control" type="text" name="code" placeholder="请输入验证码" >
                            <span id="verify-code-container" class="verification-code color-purple">
                                <span id="get-verify-code">点击获取验证码</span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group area-box clearfix">
                        <div class="reg-label pull-left" style="background-color: #FDF2DC;">
                            所在地区
                        </div>
                        <div>
                            <select id="selectProvince" name="province" class="address-select" title="请选择省">
                                
                            </select>
                            <select id="selectCity" name="city" class="address-select" title="请选择市">
                                <option>--请选择城市--</option>
                            </select>
                            <select id="selectDistrict" name="district" class="address-select"  title="请选择区">
                                <option>--请选择地区--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                            <a id="reg-agreement" style="display: inline; cursor: pointer;">注册协议</a> 
                            <input id="is-agreement" style="margin-left: 20px;" checked="checked" type="checkbox"> <label for="is-agreement">同意注册协议</label>
                    </div>
                    <div class="form-group">
                        <a id="form-submit" class="button-purple">提交</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 规则 -->
    <div class="modal ruleModal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title font-border" id="myModalLabel">注册协议</h4>
                </div>
                <div class="modal-body">
                    {!! $register_rule !!}
                </div>
                <div class="modal-footer">
                    <button id="register-agree" type="button" class="btn btn-primary">同意协议</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        var regObj = {
            data: {
                seconds: 60
            },
            methods: {
                listenCodeClick: function () {
                    $("#get-verify-code").click(function () {
                        regObj.data.seconds = 60;
                        regObj.methods.getVerifyCode();
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
                                regObj.methods.timeCountDown();
                            }
                        })
                    }
                },
                timeCountDown: function () {
                    if (regObj.data.seconds <= 0) {
                        $("#verify-code-container").html('<span id="get-verify-code">重新获取验证码</span>');
                    } else {
                        regObj.data.seconds--;
                        $("#verify-code-container").html(regObj.data.seconds + 's后重新获取');
                        setTimeout('regObj.methods.timeCountDown()', 1000);
                    }
                }
            }
        }

        regObj.methods.listenCodeClick();
        
        (function (global) {
            var cityObj = {
                data: {
                    provinces: global.city.citylist,
                    citys: [],
                    districts: []
                },
                methods: {
                    init: function () {
                        cityObj.methods.listenProvince();
                        cityObj.methods.listenCity();
                        cityObj.methods.setProvinces();
                    },
                    listenProvince: function () {
                        $("#selectProvince").change(function () {
                            var province = $(this).val();
                            cityObj.methods.setCitys(province);
                        })
                    },
                    listenCity: function () {
                        $("#selectCity").change(function () {
                            var city = $(this).val();
                            cityObj.methods.setDistricts(city);
                        })
                    },
                    setProvinces: function () {
                        var template = '<option>--请选择省--</option>';
                        var len = cityObj.data.provinces.length;
                        for (var i = 0; i < len; i++) {
                            template += '<option>' + cityObj.data.provinces[i].p + '</option>';
                        }
                        $("#selectProvince").html(template);
                    },
                    setCitys: function (province) {
                        var citys = cityObj.methods.getCitys(province);
                        var template = '<option>--请选择城市--</option>';
                        var len = citys.length;
                        for (var i = 0; i < len; i++) {
                            template += '<option>' + citys[i].n + '</option>';
                        }
                        $("#selectCity").html(template);
                    },
                    setDistricts: function (city) {
                        var districts = cityObj.methods.getDistricts(city);
                        if (districts && districts.length) {
                            $("#selectDistrict").show();
                            var template = '<option>--请选择地区--</option>';
                            var len = districts.length;
                            for (var i = 0; i < len; i++) {
                                template += '<option>' + districts[i].s + '</option>';
                            }
                            $("#selectDistrict").html(template);
                        } else {
                            $("#selectDistrict").hide();
                        }
                    },
                    getCitys: function (province) {
                        var provinces = cityObj.data.provinces;
                        var len = provinces.length;
                        for (var i = 0; i < len; i++) {
                            if (provinces[i].p == province) {
                                var citys = provinces[i].c;
                                cityObj.data.citys = citys;
                                return citys;
                            }
                        }
                    },
                    getDistricts: function (city) {
                        var citys = cityObj.data.citys;
                        var len = citys.length;
                        for (var i = 0; i < len; i++) {
                            if (citys[i].n == city) {
                                var districts = citys[i].a;
                                cityObj.data.districts = districts;
                                return districts;
                            }
                        }
                    }
                }
            }

            cityObj.methods.init();

        })(this); 
        
        // 登录相关
        (function (global) {
            $("#form-submit").click(function () {
                if ($("#form-submit").hasClass("button-purple")) {
                    $("form")[0].submit();
                } else {
                    alert('注册前需要同意注册协议');
                }
            });
        })(this);

        // 注册协议
        $(document).ready(function () {
            $("#reg-agreement").click(function () {
                $("#ruleModal").modal();
            });

            $('#register-agree').click(function () {
                $('#ruleModal').modal('hide');
                $("#is-agreement").attr("checked", true);
            });

            $("#is-agreement").change(function () {
                if ($("#is-agreement").prop("checked")) {
                    $("#form-submit").removeClass("button-gray");
                    $("#form-submit").addClass("button-purple");
                } else {
                    $("#form-submit").removeClass("button-purple");
                    $("#form-submit").addClass("button-gray");
                }
            })
        })
    </script>
@endsection
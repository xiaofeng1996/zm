@extends('web.layout.main')

@push('address_css')
    <link rel="stylesheet" href="/web/css/personCenter/shippingAddressManager.css">
@endpush

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('citys_js')
    <script src="/js/city.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
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
                        <div class="row">
                            <div class="col-xs-2">
                                <span class="fontsize-large color-golden font-border">编辑地址</span>
                            </div>
                        </div>
                        <hr class="hr-khaki"/>
                        <!--地址编辑-->
                        <form id="addressInfo" action="/addr/save" method="POST" class="no-border">
                            {{ csrf_field() }}
                            <input name="id" value="{{ isset($addr) ? $addr->id : 0 }}" style="display: none;">
                            <input type="text" name="redirect" value="{{ $redirect }}" style="display: none;">
                            <div class="info-item row">
                                <div class="col-xs-2 padding-right0 item-label">
                                </div>
                                <div class="col-xs-7 padding-left0">
                                    @if ($errors->first())
                                        <p class="err-msg"> {{ $errors->first() }} </p>
                                    @endif
                                    @if (session('save_err'))
                                        <p class="err-msg"> {{ session('save_err') }} </p>
                                    @endif
                                </div>
                            </div>
                            <div class="info-item row">
                                <div class="col-xs-2 padding-right0 item-label">
                                    <span class="color-golden">收货人姓名：<span class="color-red relative-top-5">*</span></span>
                                </div>
                                <div class="col-xs-7 padding-left0">
                                    <input type="text" name="name" value="{{ isset($addr) ? $addr->name : '' }}" placeholder="请输入姓名"/>
                                </div>
                            </div>
                            <div class="info-item row">
                                <div class="col-xs-2 padding-right0 item-label">
                                    <span class="color-golden">收货人手机：<span class="color-red relative-top-5">*</span></span>
                                </div>
                                <div class="col-xs-7 padding-left0">
                                    <input type="text" name="mobile" value="{{ isset($addr) ? $addr->mobile : '' }}" placeholder="请输入收货人手机号"/>
                                </div>
                            </div>
                            <div class="info-item row">
                                <div class="col-xs-2 padding-right0 item-label">
                                    <span class="color-golden">所在地区：<span class="color-red relative-top-5">*</span></span>
                                </div>
                                <div class="col-xs-7">
                                    <div class="row">
                                        <select id="selectProvince" name="province" class="selectpicker" title="请选择省">

                                        </select>
                                        <select id="selectCity" name="city" class="selectpicker" title="请选择市">
                                            <option>--请选择城市--</option>
                                        </select>
                                        <select id="selectDistrict" name="district" class="selectpicker" title="请选择区">
                                            <option>--请选择城市--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item row">
                                <div class="col-xs-2 padding-right0 item-label">
                                    <span class="color-golden">详细地址：<span class="color-red relative-top-5">*</span></span>
                                </div>
                                <div class="col-xs-7 padding-left0">
                                    <input type="text" name="address" value="{{ isset($addr) ? $addr->address : '' }}" placeholder="请输入详细收货地址"/>
                                </div>
                            </div>
                            <div class="info-item row">
                                <div class="col-xs-2 padding-right0 item-label">
                                    <span class="color-golden">邮政编码：<span class="color-red relative-top-5">*</span></span>
                                </div>
                                <div class="col-xs-7 padding-left0">
                                    <input type="text" name="zipcode" value="{{ isset($addr) ? $addr->zipcode : '' }}" placeholder="请输入邮政编码"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-2 col-xs-offset-2 padding-left0">
                                    <button id="addressSave" class="purple-btn">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
                        cityObj.methods.setDefault();
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
                        if (citys) {
                            var len = citys.length;
                            for (var i = 0; i < len; i++) {
                                template += '<option>' + citys[i].n + '</option>';
                            }
                        }
                        $("#selectCity").html(template);
                    },
                    setDistricts: function (city) {
                        var districts = cityObj.methods.getDistricts(city);
                        if (districts && districts.length) {
                            $("#selectDistrict").show();
                            var template = '<option>--请选择地区--</option>';
                            if (districts) {
                                var len = districts.length;
                                for (var i = 0; i < len; i++) {
                                    template += '<option>' + districts[i].s + '</option>';
                                }
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
                    },
                    setDefault: function () {
                        var province = "{{ isset($addr) ? $addr->province : '' }}";
                        var city = "{{ isset($addr) ? $addr->city : '' }}";
                        var district = "{{ isset($addr) ? $addr->district : '' }}";
                        console.log(province);
                        console.log(city);
                        console.log(district);
                        if (province) {
                            $("#selectProvince").val(province);
                            cityObj.methods.setCitys(province);
                        }
                        if (city) {
                            $("#selectCity").val(city);
                            cityObj.methods.setDistricts(city);
                        }
                        if (district) {
                            $("#selectDistrict").val(district);
                        }
                    }
                }
            }

            cityObj.methods.init();

        })(this);
    </script>
@endsection

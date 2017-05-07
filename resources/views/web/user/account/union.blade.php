@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a href="/account">账户中心</a></li>
                    <li><a>提现</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">

                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">编辑银行卡信息</span>
                    </div>
                    <div class="person-body">
                        <div class="cash-title">
                            <span class="color-red"><sup>*</sup></span>请填写以下信息,用于提现功能
                        </div>
                        <hr class="hr-khaki"/>
                        <div class="cash-form-box">
                            <form>
                                <div class="form-group">
                                    <label for="householdName">户主姓名</label>
                                    <input id="householdName" type="text" placeholder="请输入户主姓名" class="input-text-width-lg">
                                </div>
                                <div class="form-group">
                                    <label for="bankCardNum">银行卡号</label>
                                    <input id="bankCardNum" type="text" placeholder="请输入银行卡号" class="input-text-width">
                                </div>
                                <div class="form-group clearfix">
                                    <label for="ylAccount" class="pull-left">银行名称:</label>
                                    <div class="account-input input-group pull-left">
                                        <select id="bank-name" style="height: 33px; width: 325px;">
                                            <option value="">--请选择银行--</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="ylAccount" class="pull-left"></label>
                                    <div class="account-input input-group pull-left">
                                        <button id="submit" class="btn btn-primary" type="submit" >确认</button>
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
        $("#submit").click(function (e) {
            e.preventDefault();
            var bank_user_name = $("#householdName").val();
            var bank_card_no = $("#bankCardNum").val();
            var bank_name = $("#bank-name").val();
            if (!bank_user_name) {
                alert('请填写户主名称');
            } else if (!bank_card_no) {
                alert('请填写银行卡号');
            } else if (!bank_name) {
                alert('请选择银行名称');
            } else {
                var url = '/cash?bank_user_name=' + bank_user_name;
                url += '&bank_card_no=' + bank_card_no;
                url += '&bank_name=' + bank_name;
                url += '#union';
                window.location.href = url;
            }
        })
    </script>
@endsection

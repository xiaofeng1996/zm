@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('notice_css')
    <link rel="stylesheet" href="/web/css/personCenter/sysNotifacation.css">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a>通知消息</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">消息通知</span>
                    </div>
                    <div class="person-body">
                        <ul class="notify-list">
                            @if (count($notices))
                                @foreach($notices as $notice)
                                    <li class="clearfix">
                                        <div class="pull-left clearfix">
                                            <div class="icon icon-notify pull-left">

                                            </div>
                                            <div class="pull-right notify-title">
                                                <div>
                                                    系统通知
                                                </div>
                                                <div>
                                                    {{ $notice->content }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right notify-time">
                                            <div>
                                                <span>{{ date('Y-m-d H:i', strtotime($notice->created_at)) }}</span>
                                            </div>
                                            <div>
                                                <a href="/notice/delete/{{ $notice->id }}">删除</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <p style="text-align: center; color: #8492A6; margin: 20px;">还没有通知消息 : (</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

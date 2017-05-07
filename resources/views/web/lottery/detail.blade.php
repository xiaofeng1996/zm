@extends('web.layout.main')

@push('lottery_css')
    <link rel="stylesheet" href="/web/css/lottery.css">
@endpush

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
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
                    <li><a href="/lotteries">开奖列表</a></li>
                    <li><a>开奖详情</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            <!--基本信息-->
            <div class="personal-content pc-pull padding15">
                <div class="person-content">
                    <div class="person-body padding-top0 padding-left0 padding-right0">
                        <div class="lottery-header">
                            <div class="band-aid">
                                <div class="band-aid-wrap">
                                    <span class="font-border">期号：第{{ $lottery->expect }}期</span>
                                    <br/>
                                    <span>开奖时间：{{ $lottery->opentime }}</span>
                                </div>
                            </div>
                            <div class="lottery-panel">
                                <div class="lottery-panel-con">
                                    <div class="lottery-panel-title">
                                        开奖号码
                                    </div>
                                    <div>
                                        @if(!$lottery->opencode)
                                            <span class="font-border fontsize-xxxlarge color-purple">待开奖</span>
                                        @else
                                            @php
                                                $opencode = $lottery->opencode;
                                                $opencodes = explode(',', $opencode);
                                                foreach ($opencodes as $code) {
                                                    echo '<span class="icon icon-purple-circle">' . $code . '</span>';
                                                }
                                            @endphp
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="lottery-body text-center">
                            <span class="line"></span><span class="color-brown">中奖名单</span><span class="line"></span>
                            <br /><br/>
                            <span class="icon icon-book"></span>
                            <br />
                            @if(!$lottery->opencode)
                                <span class="fontsize-xxlarge font-border color-pink">待开奖</span>
                            @else
                                <div>
                                @if(!count($win_records))
                                    <span>没有人中奖 : (</span>
                                @else
                                    @foreach($win_records as $win_record)
                                        <div class="row">
                                            <div class="col-xs-2 col-xs-offset-4">
                                                 {{ $win_record->mobile }}
                                            </div>
                                            <div class="col-xs-2">
                                                <span class="color-purple">{{ $win_record->award_desc }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

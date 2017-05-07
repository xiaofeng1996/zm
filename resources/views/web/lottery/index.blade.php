@extends('web.layout.main')

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
                    <li><a>开奖列表</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content">
                    <div class="person-body">
                        <ul class="win-list">
                            @foreach($lotteries as $lottery)
                                <li>
                                    <a href="/lottery/{{ $lottery->expect  }}">
                                        <div class="clearfix">
                                            <div class="pull-left fontsize-xlarge">第{{ $lottery->expect }}期</div>
                                            <span class="pull-right fontsize-large">{{ date('Y-m-d H:i', $lottery->opentimestamp) }}</span>
                                        </div>
                                        <div class="margin-top5">
                                            @if ($lottery->opencode)
                                                @php
                                                    $opencode = $lottery->opencode;
                                                    $opencodes = explode(',', $opencode);
                                                    foreach ($opencodes as $code) {
                                                        echo '<span class="icon icon-purple-circle">' . $code . '</span>';
                                                    }
                                                @endphp
                                            @else
                                                <div class="margin-top5">
                                                    待开奖
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ssLottery">
        <div class="lottery-content">
            <div class="lottery-header">
                <button id="close-last-lottery" type="button" class="close" data-dismiss="modal"><span class="color-white" aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <span class="icon icon-left-cloud"></span>
                <span class="modal-title">重庆时时彩</span>
                <span class="icon icon-right-cloud"></span>
            </div>
            <div class="lottery-body color-golden">
                <div>20160919058期开彩结果</div>
                <div>12:15:32</div>
                <ul class="clearfix">
                    <li>
                        0
                    </li>
                    <li>
                        0
                    </li>
                    <li>
                        0
                    </li>
                    <li>
                        0
                    </li>
                    <li>
                        0
                    </li>
                </ul>
            </div>
        </div><!-- /.modal-content -->
    </div>
    <script>
        (function () {
            $("#close-last-lottery").click(function () {
                $("#ssLottery").css("display", "none");
            });
        })();
    </script>
@endsection

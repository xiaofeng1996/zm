<div id="header" class="min-con">
    <div class="container">
        <div class="header-con">
            <div class="logo">
                <a href="/">
                    <img src="/web/images/zhimeishangcheng.png">
                </a>
            </div>
            <div class="pull-right clearfix">
                <div id="mall-search">
                    <ul class="m-option clearfix">
                        <li class="selected pull-left" data-lucky="0"><a>会员专区</a></li>
                        <li class="pull-left" data-lucky="1"><a>幸运区</a></li>
                    </ul>
                    <form class="search-form clearfix">
                        <div class="mallSearch-input clearfix">
                            <div class="s-combobox">
                                <div class="s-combobox-wrap">
                                    <input id="st" type="text" title="请输入搜索文字" placeholder="请输入关键字进行搜索">
                                </div>
                            </div>
                        </div>
                        <button id="search-button">
                        </button>
                    </form>
                    <ul class="hot-query clearfix">
                        @foreach($keywords as $keyword)
                            <li class="hot-query-click" data-value="{{ $keyword->keyword }}"><a>{{ $keyword->keyword }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <button id="shop-cart">
                    <a href="/carts" style="color: #FFFFFF;">
                        <span class="icon icon-cart"></span>
                        购物车{{ $cart_count }}件
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var is_lucky = 0;
    var path = Array('member', 'lucky');
    $("#mall-search ul:first-child li").click(function () {
        is_lucky = $(this).attr("data-lucky");
        $(this).addClass('selected');
        $(this).siblings().removeClass('selected');
    });

    $(".hot-query-click").click(function () {
        var keyword = $(this).attr("data-value");
        var url = '/goods/' + path[is_lucky] + '?keyword=' + keyword;
        window.location.href = url;
    });

    $("#search-button").click(function (e) {
        e.preventDefault();
        var keyword = $("#st").val();
        var url = '/goods/' + path[is_lucky] + '?keyword=' + keyword;
        console.log(url);
        window.location.href = url;
    });

</script>
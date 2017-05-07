<div class="main-nav">
    <div class="inner-con0 min-con">
        <div class="inner-con1 container">
            <a class="nav-catagory"><span class="icon icon-classification"></span>全部分类</a>
            <a href="/" class="@yield('nav_home_selected')">首页</a>
            <a href="/goods/member" class="@yield('nav_member_selected')">会员区</a>
            <a href="/goods/lucky" class="@yield('nav_lucky_selected')">幸运区</a>
            <a ></a>
            <a id="download" style="position: relative; cursor: pointer;">
                下载 App <span class="icon icon-gold-bottom-arrow" ></span>
                <div id="download-qrcode" style="display: none; position: absolute; top: 100%; left: 0px; z-index: 9999;">
                    <img src="/images/zmsc-qrcode.png" style="width: 180px;" alt="">
                </div>
            </a>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#download").click(function () {
            if ($("#download-qrcode").css('display') == 'none') {
                $("#download-qrcode").css('display', 'inline-block');
            } else {
                $("#download-qrcode").css('display', 'none');
            }
        })
    })
</script>
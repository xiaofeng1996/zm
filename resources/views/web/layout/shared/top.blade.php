<div id="site-nav" class="min-con">
    <div class="container">
        <div class="sn-container">
            <div class="sn-left">
                <p>
                    @if($user)
                        <span>欢迎您，{{ $user->name }}</span>
                        <a href="/notices"><span class="icon icon-email inline-block"></span>消息</a>
                    @else
                        <span>欢迎访问</span>
                    @endif
                </p>
            </div>
            <ul class="sn-right">
                @if($user)
                    <li>
                        <a href="/logout">退出</a>
                    </li>
                    <li class="seg">
                    </li>
                    <li>
                        <a href="/user">个人中心</a>
                    </li>
                    <li class="seg">
                    </li>
                @endif
                <li>
                    <a>客服：400-123456</a>
                </li>
            </ul>
        </div>
    </div>
</div>
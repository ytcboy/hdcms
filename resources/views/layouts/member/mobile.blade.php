<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>会员中心</title>
    @include('layouts.hdjs')
    @stack('css')
</head>
<body class="member">
@include('layouts.message')
@if (!if_route('member'))
    <div class="bg-light shadow-sm mb-2 border-top border-info">
        <div class="container px-0 border-bottom">
            <nav class="navbar navbar-expand-lg navbar-light bg-se border-0">
                <a class="text-secondary" href="javascript:;" onclick="window.history.back()">
                    <i class="fa fa-backward"></i>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active"></li>
                    </ul>
                    <div class="my-2 my-lg-0">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown ">
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="{{route('member')}}">
                                    会员中心
                                </a>
                                <a class="nav-link" href="{{route('member.info.index')}}">修改资料</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="{{route('logout')}}">退出登录</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
@endif
<div class="col-sm-10 px-0 mx-0 mobile">
    @yield('content')
</div>
<script>
    require(['bootstrap'])
</script>
</body>
</html>
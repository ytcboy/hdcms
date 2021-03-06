<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会员登录</title>
    @include('layouts.hdjs')
</head>
<body class="">
@include('layouts.message')
<div class="container">
    <div class="d-flex align-items-center justify-content-center w-100  mx-0" style=" height: 70vh">
        <div class="col-md-6 col-12 px-0">
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="card shadow-lg mt-5">
                    <div class="card-header">
                        <h4 class="text-secondary "><i class="fa fa-user"></i> 温馨提示</h4>
                    </div>
                    <div class="card-body">
                       <h4 class="pt-5 pb-5 text-secondary">当前域名没有绑定到任何模块</h4>
                    </div>
                    <div class="card-footer text-muted">
                        <a href="{{route('admin')}}" class="mr-2"><i class="fa fa-home"></i> 访问后台 </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">

    @yield('info')

    <link rel="icon" href="{{asset('resources/views/home/images/blog_xiao.jpg')}}">
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="{{url('/')}}"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k=>$v)<a target="_blank" href="{{url($v->nav_url)}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>@endforeach
    </nav>
    </nav>
</header>
@yield('content')
<footer>
    <p>{!! Config::get('web.copyright') !!} {!! Config::get('web.web_count') !!}</a>
    </p>
</footer>
<script src="{{asset('resources/views/home/js/silder.js')}}"></script>
</body>
</html>

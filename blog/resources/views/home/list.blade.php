@extends('layouts.home')
@section('info')
    <title>{{$field->cate_name}} - {{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$field->cate_name}}"/>
    <meta name="description" content="{{$field->cate_description}}"/>
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>{{$field->cate_title}}</span><a href="{{url('/')}}" class="n1" >网站首页</a><a href="{{url('cate/'.$field->cate_id)}}" class="n2">{{$field->cate_name}}</a>
        </h1>
        <div class="newblog left">
            @foreach($data as $d)
            <h2>{{$d->art_title}}</h2>
            <p class="dateview"><span>发布时间：{{date('Y-m-d', $d->art_time)}}</span><span>作者：{{$d->art_editor}}</span><span>分类：[<a href="{{url('cate/.'.$field->cate_id)}}">{{$field->cate_name}}</a>]</span>
            </p>
            <figure><img src="{{url($d->art_thumb)}}"></figure>
            <ul class="nlist">
                <p>{{$d->art_description}}</p>
                <a title="{{$d->art_title}}" href="{{url('a/'.$d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
            @endforeach


            {{--分页--}}
            <div class="page">
                {{$data->links()}}
            </div>
        </div>
        <aside class="right">
            <div class="rnav">
                <ul>
                    <li class="rnav1"><a href="/download/" target="_blank">日记</a></li>
                    <li class="rnav2"><a href="/newsfree/" target="_blank">程序人生</a></li>
                    <li class="rnav3"><a href="/web/" target="_blank">欣赏</a></li>
                    <li class="rnav4"><a href="/newshtml5/" target="_blank">短信祝福</a></li>
                </ul>
            </div>
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a
                        class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span
                        class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585"></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="news" style="float: left;">
                <h3>
                    <p>最新<span>文章</span></p>
                </h3>
                <ul class="rank">
                    @foreach($new as $n)
                    <li><a href="{{'a/'.$n->art_id}}" title="{{$n->art_title}}" target="_blank">{{$n->art_title}}</a></li>
                   @endforeach
                </ul>
                <h3 class="ph">
                    <p>点击<span>排行</span></p>
                </h3>
                <ul class="paih">
                    @foreach($hot as $d)
                    <li><a href="{{url('a/'.$d->art_id)}}" title="{{$d->art_title}}" target="_blank">{{$d->art_title}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="visitors">
                <h3><p>最近访客</p></h3>
                <ul>

                </ul>
            </div>

        </aside>
    </article>
@endsection
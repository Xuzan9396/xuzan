@extends('layouts.home')
@section('info')
    <title>{{Config::get('web.web_title')}} - {{Config::get('web.seo_title')}}</title>
    <meta name="keywords" content="{{Config::get('web.keywords')}}"/>
    <meta name="description" content="{{Config::get('web.description')}}"/>
    <meta name="author" content="{{Config::get('web.author')}}"/>
@endsection

@section('content')
    <div class="banner">
        <section class="box">
            <ul class="texts">
                {{--@foreach($bg as $k=>$v)--}}
                {{--<p>{{$v->bg_str}}</p>--}}
                {{--@endforeach--}}
                <p>人生没有彩排，每天都是现场直播</p>
                <p>加了锁的青春，不会再因谁而推开心门。</p>
                <p>只有启程，才会到达理想和目的地。</p>
            </ul>
            <div class="avatar"><a href="#"><span>徐赞</span></a></div>
        </section>
    </div>
    <div class="template">
        <div class="box">
            <h3>
                <p><span>个人博客</span> 个人推荐文章</p>
            </h3>
            <ul>
                @foreach($pics as $h)
                    <li><a href="{{url('a/'.$h->art_id)}}" target="_blank"><img
                                    src="{{url($h->art_thumb)}}"></a><span>{{$h->art_title}}</span></li>
                @endforeach
            </ul>

        </div>
    </div>
    <article>
        <h2 class="title_tj">
            <p>文章<span>推荐</span></p>
        </h2>
        <div class="bloglist left">
            {{--文章--}}
            @foreach($data as $d)
                <h3>{{$d->art_title}}</h3>
                <figure><img src="{{url($d->art_thumb)}}"></figure>
                <ul>
                    <p>{{ $d->art_description }}</p>
                    <a title="{{$d->art_title}}" href="{{url('a/'.$h->art_id)}}" target="_blank"
                       class="readmore">阅读全文>></a>
                </ul>
                <p class="dateview"><span>{{date('Y-m-d',$d->art_time)}}</span><span>作者：{{$d->art_editor}}</span></p>
            @endforeach
            <div class="page">

                <ul class="pagination">
                    {{$data->links()}}
                </ul>

            </div>
        </div>

        <aside class="right">
            <div class="weather">
                <iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true"
                        src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe>
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
                        <li><a href="{{url('a/'.$n->art_id)}}" title="{{$n->art_title}}"
                               target="_blank">{{$n->art_title}}</a></li>
                    @endforeach
                </ul>
                <h3 class="ph">
                    <p>点击<span>排行</span></p>
                </h3>
                <ul class="paih">
                    @foreach($hot as $h)
                        <li><a href="{{url('a/'.$h->art_id)}}" title="{{$h->art_title}}"
                               target="_blank">{{$h->art_title}}</a></li>
                    @endforeach
                </ul>
                <h3 class="links">
                    <p>友情<span>链接</span></p>
                </h3>
                <ul class="website">
                    {{--友情链接--}}
                    @foreach($links as $l)
                    <li><a href="{{$l->link_url}}" target="_blank">{{$l->link_name}}</a></li>
                    @endforeach
                </ul>
            </div>
       
        </aside>

    </article>
@endsection
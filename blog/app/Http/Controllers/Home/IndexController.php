<?php

namespace App\Http\Controllers\Home;



use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends CommentController
{
    public function index()
    {
        // 点击量的最高的文章 6
        $hot = Article::orderby('art_view', 'desc')->take(5)->get();
        // 个人推荐
        $pics = Article::orderby('art_view', 'desc')->take(6)->get();

        // 图文列表带分页效果 5 时间排序
        $data = Article::orderBy('art_time', 'desc')->paginate(5);
        // 最新发布的文章
        $new = Article::orderby('art_time', 'desc')->take(7)->get();
        // 友情链接
        $links =  Links::orderby('link_order', 'asc')->get();

        // 网站的配置项
        return view('home.index', compact('hot', 'data', 'new', 'links','pics'));
    }

    public function cate($cate_id)
    {
        // 一位数组
        $field = Category::find($cate_id);

        // 最新发布的文章
        $new = Article::orderby('art_time', 'desc')->take(7)->get();

        $hot = Article::orderby('art_view', 'desc')->take(5)->get();

        // 图文列表带分页效果 5 时间排序
        $data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(4);

        // 查看次数
        Category::where('cate_id', $cate_id)->increment('cate_view');

        return view('home.list', compact('field', 'data', 'new', 'hot'));
    }

    /*文章*/
    public function article($art_id)
    {
//        $field = Category::find($art_id);
        // 链接表查询
        $field = Article::Join('category', 'article.cate_id', '=', 'category.cate_id')->where('art_id', $art_id)->first();

//        上一篇
        $field['pre'] = Article::where('art_id', '<', $art_id)->orderBy('art_id', 'desc')->first();
//        下一篇
        $field['next'] = Article::where('art_id', '>', $art_id)->orderBy('art_id', 'asc')->first();

        //相关的文章
        $data = Article::where('cate_id', $field->cate_id)->orderBy('art_id', 'desc')->take(6)->get();

        // 最新的文章
        $hot = Article::where('cate_id', $field->cate_id)->orderBy('art_time', 'desc')->take(8)->get();

        // 点击最高的文章
        $view = Article::where('cate_id', $field->cate_id)->orderBy('art_view', 'desc')->take(5)->get();

        // 查看次数
        Article::where('art_id', $art_id)->increment('art_view');
        return view('home.new', compact('field', 'data' , 'hot', 'view'));
    }
}

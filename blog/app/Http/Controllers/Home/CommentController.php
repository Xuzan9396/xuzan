<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class CommentController extends Controller
{
    public function __construct()
    {
        $navs  =  Navs::orderBy('nav_order')->get();
        // 共享分享 分享导航条
       View::share('navs', $navs);
    }
}

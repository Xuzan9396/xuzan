<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
// 前台 Index
Route::get('/', 'Home\IndexController@index');
// 前台列表页
Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
// 前台文章页面
Route::get('/art', 'Home\IndexController@article');

Route::get('/a/{art_id}', 'Home\IndexController@article');
// 登录
Route::any('admin/login', 'Admin\LoginController@login');
//Route::any('admin/', 'Admin\LoginController@login');
// 验证码
Route::get('admin/code', 'Admin\LoginController@code');
//Route::get('admin/getcode','Admin\LoginController@getcyypode');
Route::get('admin/crypt', 'Admin\LoginController@crypt');


Route::group(['middleware' => ['web', 'admin.login'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'IndexController@index');
    // 详细列表
    Route::get('info', 'IndexController@info');
    // 退出路由
    Route::get('quit', 'IndexController@quit');

    // 密码
    Route::any('pass', 'IndexController@pass');
    // 异步请求排序
    Route::post('cate/changeorder', 'CategoryController@changeOrder');
    // 资源路由分类
    Route::resource('category', 'CategoryController');
    Route::resource('article', 'ArticleController');
    // 图片上传
    Route::any('upload', 'CommentController@upload');

    // 友情链接
    Route::resource('links', 'LinksController');
    // 友情链接排序
    Route::post('links/changeorder', 'LinksController@changeOrder');
    // 导航
    Route::resource('navs', 'NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder');
    // 文件配置项
    Route::get('config/putfile', 'ConfigController@putFile');

    Route::resource('config', 'ConfigController');
    // ajax排序
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    // 文件的内容
    Route::post('config/changecontent', 'ConfigController@changeContent');


});










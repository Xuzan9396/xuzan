<?php

namespace App\Http\Controllers\Admin;

//use App\Http\Model\Article;
//use App\Http\Model\Category;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Validator;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommentController
{
    // admin/article  get  全部文章列表 分页
    public function index()
    {
        // 文章分页
        $data = Article::orderBy('art_id', 'desc')->paginate(4);
//        dd($data->links() );
        return view('admin.article.index', compact('data'));
        return view('admin.article.index');
    }

    // admin/article/create  get 添加文章
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.article.add', compact('data'));
    }

    // admin/article post 添加分类提交的方法
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();
        // 把提交过来的null值转换为''
        foreach ($input as $key => &$item) {
            if ($item == null) {
                $item = '';
            }
        }

        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
            'art_thumb' => 'required',
        ];

        $message = [
            'art_title.required' => '文章名称不能为空！',
            'art_content.required' => '文章内容不能为空！',
            'art_thumb.required' => '上传图片不能为空！',
        ];

        // 验证表单
//        Validator::
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $re = Article::create($input);
            if ($re !== false) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    // admin/article/{articleid}/edit | category.editadmin/category  get 编辑文章
    public function edit($art_id)
    {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit', compact('data', 'field'));
    }

    // admin/article/{articleid}   | PUT|PATCH 更新文章
    public function update($art_id)
    {
        $input = Input::except('_token', '_method');
//        $file = Article::find($art_id);
//       dd(url('/'.$file->art_thumb));
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
            'art_thumb' => 'required',
        ];

        $message = [
            'art_title.required' => '文章名称不能为空！',
            'art_content.required' => '文章内容不能为空！',
            'art_thumb.required' => '上传图片不能为空！',
        ];

        // 验证表单
//        Validator::
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $re = Article::where('art_id',$art_id)->update($input);
            if($re){
                return redirect('admin/article');
            } else {
                return back()->with('errors','文章更新失败，请稍后重试！');
            }
        } else {
            return back()->withErrors($validator);
        }

    }

    //admin/article/{articleid} delete 删除某个分类
    public function destroy($art_id)
    {
        // 删除某个分类
        $re = Article::where('art_id', $art_id)->delete();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '文章删除失败',
            ];
        }
        return $data;
    }
}

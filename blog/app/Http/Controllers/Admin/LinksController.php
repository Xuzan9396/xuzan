<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class LinksController extends Controller
{
    // admin/links 路由的links 全部友情链接列表
    public function index()
    {
        $data = links::orderBy('link_order', 'asc')->get();
        return view('admin.links.index', compact('data'));
    }

    // ajax链接排序
    public function changeOrder()
    {

        $input = Input::all();
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $re = $link->update();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败',
            ];
        }
        return $data;
//        echo $input['link_id'];
    }

    // admin/links/create  get 添加友情链接
    public function create()
    {
//        $data = Links::where('link_pid', 0)->get();
        $data = [];
        return view('admin.links.add', compact('data'));
    }

    // admin/links post 添加分类提交的方法
    public function store()
    {
        $input = Input::except('_token');
//        foreach ($input as $key => &$item) {
//            if ($item == null) {
//                $item = '';
//            }
//        }

        // 验证数据
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        // 定义错误
        $message = [
            'link_name.required' => '友情链接名称不能为空!',
            'link_url.required' => 'url不能为空！',
        ];
        // 验证表单
//        Validator::
        $validator = Validator::make($input, $rules, $message);
        // 判断新密码验证是否通过了
        if ($validator->passes()) {
            $re = Links::create($input);
            if ($re) {
                return redirect('admin/links');
            } else {
                return back()->with('errors', '友情链接添加失败，请重新填写！');
            }
        } else {
            return back()->withErrors($validator);
//                dd($validator->errors()->all());
        }
    }

    // admin/links/{link_id}/edit | links.editadmin/links  get 编辑分类
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit', compact('field'));
    }

    // admin/links/{links}   | PUT|PATCH 更新分类
    public function update($link_id)
    {
        $input = Input::except('_token', '_method');


        // 验证数据
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        // 定义错误
        $message = [
            'link_name.required' => '链接名称不能为空！',
            'link_url.required' => 'url不能为空！',
        ];
        // 验证表单
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $re = Links::where('link_id', $link_id)->update($input);
            if ($re !== false) {
                return redirect('admin/links');
            } else {
                return back()->with('errors', '链接信息更新失败，请重新更新！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //admin/links/{links} delete 删除某个分类
    public function destroy($link_id)
    {
        // 删除某个分类
        $re = Links::where('link_id', $link_id)->delete();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '链接删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '链接删除失败',
            ];
        }
        return $data;
    }
}

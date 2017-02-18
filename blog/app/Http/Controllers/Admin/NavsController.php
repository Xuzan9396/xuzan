<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    // admin/navs 路由的navs 全部自定义导航列表
    public function index()
    {
        $data = navs::orderBy('nav_order', 'asc')->get();
        return view('admin.navs.index', compact('data'));
    }

    // ajax链接排序
    public function changeOrder()
    {

        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $re = $nav->update();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '自定义导航排序更新失败',
            ];
        }
        return $data;
//        echo $input['nav_id'];
    }

    // admin/navs/create  get 添加自定义导航
    public function create()
    {
//        $data = Navs::where('nav_pid', 0)->get();
        $data = [];
        return view('admin.navs.add', compact('data'));
    }

    // admin/navs post 添加分类提交的方法
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
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        // 定义错误
        $message = [
            'nav_name.required' => '自定义导航名称不能为空!',
            'nav_url.required' => 'url不能为空！',
        ];
        // 验证表单
//        Validator::
        $validator = Validator::make($input, $rules, $message);
        // 判断新密码验证是否通过了
        if ($validator->passes()) {
            $re = Navs::create($input);
            if ($re) {
                return redirect('admin/navs');
            } else {
                return back()->with('errors', '自定义导航添加失败，请重新填写！');
            }
        } else {
            return back()->withErrors($validator);
//                dd($validator->errors()->all());
        }
    }

    // admin/navs/{nav_id}/edit | navs.editadmin/navs  get 编辑分类
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin.navs.edit', compact('field'));
    }

    // admin/navs/{navs}   | PUT|PATCH 更新分类
    public function update($nav_id)
    {
        $input = Input::except('_token', '_method');


        // 验证数据
        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        // 定义错误
        $message = [
            'nav_name.required' => '链接名称不能为空！',
            'nav_url.required' => 'url不能为空！',
        ];
        // 验证表单
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $re = Navs::where('nav_id', $nav_id)->update($input);
            if ($re !== false) {
                return redirect('admin/navs');
            } else {
                return back()->with('errors', '链接信息更新失败，请重新更新！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //admin/navs/{navs} delete 删除某个分类
    public function destroy($nav_id)
    {
        // 删除某个分类
        $re = Navs::where('nav_id', $nav_id)->delete();
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

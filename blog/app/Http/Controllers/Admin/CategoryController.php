<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommentController
{
    // admin/category  get  全部分类列表
    public function index()
    {
//        $categorys = Category::tree();
        $categorys = (new Category)->tree();
        // 返回一个二维数组
        return view('admin.category.index')->with('data', $categorys);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败',
            ];
        }
        return $data;
//        echo $input['cate_id'];
    }

    // admin/category/create  get 添加分类
    public function create()
    {
        $data = Category::where('cate_pid', 0)->get();

        return view('admin.category.add', compact('data'));
    }

    // admin/category post 添加分类提交的方法
    public function store()
    {
        $input = Input::except('_token');

        // 验证数据
        $rules = [
            'cate_name' => 'required',
//            'cate_order' => 'required',
        ];
        // 定义错误
        $message = [
            'cate_name.required' => '分类名称不能为空',
//            'cate_order.required' => '分类名称排序不能为空',
        ];
        // 验证表单
        $validator = Validator::make($input, $rules, $message);
        // 判断新密码验证是否通过了
        if ($validator->passes()) {
            $re = Category::create($input);
            if ($re) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '数据填充失败，请重新填写！');
            }
        } else {
            return back()->withErrors($validator);
//                dd($validator->errors()->all());
        }
    }

    // admin/category/{category}/edit | category.editadmin/category  get 编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.edit', compact('field', 'data'));
    }

    // admin/category/{category}   | PUT|PATCH 更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token', '_method');
        foreach ($input as $key=>&$item) {
            if ($item == null) {
               $input[$key] = '';
            }
        }

        // 验证数据
        $rules = [
            'cate_name' => 'required',
            'cate_order' => 'required',
        ];
        // 定义错误
        $message = [
            'cate_name.required' => '分类名称不能为空',
            'cate_order.required' => '分类名称排序不能为空',
        ];
        // 验证表单
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $re = Category::where('cate_id', $cate_id)->update($input);
            if ($re !== false) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '分类信息更新失败，请重新更新');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //admin/category/{category} delete 删除某个分类
    public function destroy($cate_id)
    {
        // 删除某个分类
        $re = Category::where('cate_id', $cate_id)->delete();
        Category::where('cate_pid', $cate_id)->update(['cate_pid'=>0]);
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '分类删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '分类删除失败',
            ];
        }
        return $data;
    }

    //admin/category/{category} get 显示单个分类信息
    public function show()
    {

    }

}

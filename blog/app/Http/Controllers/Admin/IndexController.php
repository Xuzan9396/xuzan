<?php

namespace App\Http\Controllers\Admin;

//use App\Http\Model\User;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Validator;


use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class IndexController extends CommentController
{
    public function index()
    {
//        $user = DB::connection()->getPdo();
//        dd($user);
//        echo 123456;
        return view('admin.index');
    }

    // 主页info页面
    public function info()
    {
        return view('admin.info');
    }

    // 退出登录
    public function quit()
    {
        session(['user' => null]);
        return redirect('admin/login');
    }

    // 更改超级管理员密码,修改密码
    public function pass()
    {
        // 是否是post提交
        if ($input = Input::all()) {
            // 验证数据
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            // 定义错误
            $message = [
                'password.required' => '新密码不能为空',
                'password.between' => '新密码必须6-20位之间',
                'password.confirmed' => '密码和新密码不一致',
            ];
            // 验证表单
            $validator = Validator::make($input, $rules, $message);

            // 判断新密码验证是否通过了
            if ($validator->passes()) {
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                // 判断原密码
                if ($input['password_o'] == $_password) {
                    // 更新密码
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back() -> with('errors', '密码修改成功');
                } else {
                    // 否则重新修改密码
                    return back()->with('errors','原密码错误！');
                }
            } else {
                return back()->withErrors($validator);
//                dd($validator->errors()->all());
            }

        } else {
            return view('admin.pass');
        }

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/code.class.php';

class LoginController extends CommentController
{
    public function login()
    {
        if($input = Input::all()){
            // 判断验证码
            $code = new \Code;
            // 获得验证码
            $_code = $code->get();
            if(strtoupper($input['code']) != $_code){
                return back()->with('msg', '验证码错误');
            }

            // 判断用户名或者密码
            $user = User::first();
            if($user -> user_name != $input['user_name'] || Crypt::decrypt($user -> user_pass) != $input['user_pass']){
                return back()->with('msg', '用户名不正确或者密码不正确');
            }
            // 登录成功存入session
            session(['user' => $user]);
//            dd(session('user'));
            return redirect('admin');
        }else{
//            $user = User::all();
//            dd($user);
//            session(['user' => null]);

            return view('admin.login');
        }
    }
    // 分配验证码图片
    public function code()
    {
        $code = new \Code;
        $code->make();

    }
    public function crypt()
    {
        $str = '123456';
        $str1 = 'eyJpdiI6IkpvQ1YwcHUzXC9PRHZuSXpWOWdsY3V3PT0iLCJ2YWx1ZSI6ImdoOUlJMXJIbGIxUnYzTGF1bUN1Nnc9PSIsIm1hYyI6IjA1OGM2ZmFkZTJmOWFiZmY0OTI1ZDIzOTNhOThjZjIyYWNhZDY4ZjVjZTQzMGVkMmQ5N2E4YWVhNWFiNTkyNjgifQ';
        echo Crypt::encrypt($str);
        echo '<hr>';
        echo  Crypt::decrypt($str1);
    }
}

















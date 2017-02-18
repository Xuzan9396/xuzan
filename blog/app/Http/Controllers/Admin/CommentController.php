<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{
    // 图片上传
    public function upload()
    {
//        拿到上传文件
        $file = Input::file('Filedata');
        if ($file->isValid()) {
            $realPath = $file -> getRealPath(); // 零时文件的绝对路径

            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,999). '.'.$entension;
            $path = $file -> move(base_path(). '/uploads', $newName);
            $filePath = 'uploads/' . $newName;
            return $filePath;
        }
    }
}

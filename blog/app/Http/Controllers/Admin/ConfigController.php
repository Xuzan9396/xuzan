<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    // admin/config 路由的config 全部配置项列表
    public function index()
    {
        $data = config::orderBy('conf_order', 'asc')->get();
        // content内容
        foreach ($data as $k => $v) {
            switch ($v->field_type) {
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="' . $v->conf_content . '">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]">' . $v->conf_content . '</textarea>';
                    break;
                case 'radio':
                    $arr = str_replace('，', ',', $v->field_value);
                    $arr = explode(',', $arr);
                    $str = '';
                    foreach ($arr as $m => $n) {
                        // 1|开启
                        $r = explode('|', $n);
                        // 选中单选
                        $c = $v->conf_content == $r[0] ? ' checked' : '';
                        $str .= '<input type="radio" name="conf_content[]" value="' . $r[0] . '"' . $c . '>' . $r[1] . '　';

                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index', compact('data'));
    }

    // ajax配置项排序
    public function changeOrder()
    {
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();
        if ($re) {
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败',
            ];
        }
        return $data;
//        echo $input['conf_id'];
    }

    // changContent 更新配置项
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k => $v) {
            Config::where('conf_id', $v)->update(['conf_content' => $input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors', '配置项更新成功！');
    }

    // 写入配置文件web.php
    public function putFile()
    {
        // 返回一个数组
        $config = Config::pluck('conf_content', 'conf_name')->all();
        $path = base_path().'\config\web.php';
        // true转换成字符串而不是数组
        $str = '<?php return ' .var_export($config, true). ';';
        file_put_contents($path, $str);
    }

    // admin/config/create  get 添加配置项
    public function create()
    {
//        $data = Config::where('conf_pid', 0)->get();
        $data = [];
        return view('admin.config.add', compact('data'));
    }

    // admin/config post 添加分类提交的方法
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
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];
        // 定义错误
        $message = [
            'conf_name.required' => '配置项名称不能为空!',
            'conf_title.required' => '配置项标题不能为空！',
        ];
        // 验证表单
//        Validator::
        $validator = Validator::make($input, $rules, $message);
        // 判断新密码验证是否通过了
        if ($validator->passes()) {
            $re = Config::create($input);
            if ($re) {
                return redirect('admin/config');
            } else {
                return back()->with('errors', '配置项添加失败，请重新填写！');
            }
        } else {
            return back()->withErrors($validator);
//                dd($validator->errors()->all());
        }
    }

    // admin/config/{conf_id}/edit | config.editadmin/config  get 编辑分类
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit', compact('field'));
    }

    // admin/config/{config}   | PUT|PATCH 更新分类
    public function update($conf_id)
    {
        $input = Input::except('_token', '_method');


        // 验证数据
        $rules = [
            'conf_name' => 'required',
            'conf_title' => 'required',
        ];
        // 定义错误
        $message = [
            'conf_name.required' => '配置项名称不能为空！',
            'conf_title.required' => '配置项标题不能为空！',
        ];
        // 验证表单
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $re = Config::where('conf_id', $conf_id)->update($input);
            if ($re !== false) {
                $this->putFile();
                return redirect('admin/config');
            } else {
                return back()->with('errors', '配置项信息更新失败，请重新更新！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //admin/config/{config} delete 删除某个分类
    public function destroy($conf_id)
    {
        // 删除某个分类
        $re = Config::where('conf_id', $conf_id)->delete();
        if ($re) {
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '配置项删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '配置项删除失败',
            ];
        }
        return $data;
    }


    //get.admin/category/{category}  显示单个分类信息
    public function show()
    {

    }
}

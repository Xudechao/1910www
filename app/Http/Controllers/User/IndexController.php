<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    //注册1
    public function reg()
    {
        return view('user.reg');
    }

    //注册2
    public function regDo(Request $request)
    {
        $pass1 = $request->input('password');
        $pass2 = $request->input('pass2');
        $name = $request->input('user_name');
        $email = $request->input('email');
        // echo $pass1;
        // echo $pass2;
        // echo $name;
        // echo $email;

        //密码长度必须大于6位
        $len = strlen($pass1);
        if($len<6){
            die("密码长度必须大于6位");
        }

        //两次密码是否一致
        if($pass1 != $pass2)
        {
            die('两次密码不一致');
        }

        //检测用户是否已经存在
        $user = UserModel::where(['user_name'=>$name])->first();
        if($user){
            die( $name . "用户名已存在");
        }

        //检测email是否已经存在
        $user = UserModel::where(['email'=>$email])->first();
        if($user){
            die("email已存在");
        }

        //生成密码
        $pass = password_hash($pass1,PASSWORD_BCRYPT);

        //验证通过 生成用户记录
        $data = [
            'user_name' => $name,
            'email' => $email,
            'password' => $pass,
            'reg_time' => time()
        ];
        $res = UserModel::insert($data);
        if($res)
        {
            echo "注册成功";
            header('Refresh:2;url=/user/login');
        }else{
            echo "注册失败";
            header('Refresh:2;url=/user/reg');
        }

    }

    //登录1
    public function login()
    {

        return view('user.login');
    }

    //登录2
     public function loginDo(Request $request)
    {
        $name = $request->input('name');
        $pass = $request->input('pass');

        //echo '用户输入的密码：'. $pass;echo '<br>';
        //验证登录信息
        $user = UserModel::where(['user_name'=>$name])->first();
        //echo '数据库的密码：'. $user->password;echo '</br>';

        //验证密码
        $res = password_verify($pass,$user->password);
        if($res)
        {
            //向客户端设置cookie
            //setcookie('uid',$user->user_id,time()+3600,'/');
            //setcookie('name',$user->user_name,time()+3600,'/');
            Cookie::queue('uid',$user->user_id,60);
            Cookie::queue('name',$user->user_name,60);
            echo "登录成功";
            header('Refresh:2;url=/user/center');
        }else{
            echo "用户与密码不一致，请重新登录";
            header('Refresh:2;url=/user/login');
        }

    }

    //用户中心
    public function center()
    {
        //判断用户是否登录
        //echo '<pre>';print_r($_COOKIE);echo'</pre>';
        if(Cookie::has('uid'))
        {
            //已登录
            return view('user.center');
        }else{
            //未登录
            return redirect('/user/login');
        }
    }
}

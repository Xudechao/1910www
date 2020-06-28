<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;


class UserController extends Controller
{


    /**
     * 用户注册
     * @param Request $request
     */
    public function reg(Request $request)
    {
        $pass1 = $request->input('password');
        $pass2 = $request->input('pass2');
        $name = $request->input('user_name');
        $email = $request->input('email');

        //密码长度必须大于6位
        $len = strlen($pass1);
        if ($len < 6) {
            $response = [
                'errno' => 50001,
                'msg' => '密码长度必须大于6'
            ];
            return $response;
        }

        //两次密码是否一致
        if ($pass1 != $pass2) {
            $response = [
                'errno' => 50002,
                'msg' => '两次输入的密码不一致'
            ];
            return $response;
        }

        //检测用户是否已经存在
        $user = UserModel::where(['user_name' => $name])->first();
        if ($user) {
            $response = [
                'errno' => 50003,
                'msg' => $name . "用户名已存在"
            ];
            return $response;
        }

        //检测email是否已经存在
        $user = UserModel::where(['email' => $email])->first();
        if ($user) {
            $response = [
                'errno' => 50004,
                'msg' => $email . 'email已存在'
            ];
            return $response;
        }

        //生成密码
        $pass = password_hash($pass1, PASSWORD_BCRYPT);

        //验证通过 生成用户记录
        $data = [
            'user_name' => $name,
            'email' => $email,
            'password' => $pass,
            'reg_time' => time()
        ];
        $res = UserModel::insert($data);
        if ($res) {
            $response = [
                'errno' => 0,
                'msg' => "注册成功"
            ];
            //header('Refresh:2;url=/user/login');
        } else {
            $response = [
                'errno' => 50005,
                'msg' => "注册失败"
            ];
            //header('Refresh:2;url=/user/reg');
        }
        return $response;
    }

    /**
     * 用户登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $name = $request->input('name');
        $pass = $request->input('pass');

        // var_dump($name);
        // var_dump($pass);die;
        //echo '用户输入的密码：'. $pass;echo '<br>';
        //验证登录信息
        $user = UserModel::where(['user_name' => $name])->first();
        //echo '数据库的密码：'. $user->password;echo '</br>';

        //验证密码
        $res = password_verify($pass, $user->password);
        if ($res) {
            //生成token
            $str = $user->user_id . $user->user_name . time();
            $token = substr(md5($str), 10, 16) . substr(md5($str), 0, 10);

            //保存token,后续验证使用

            //$data = [
            //    'uid' => $user->user_id,
            //    'token' => $token
            //    'expire' => time() + 7200
            //];
            //TokenModel::insert($data);

            Redis::set($token,$user->user_id);

            $response = [
                'errno' => 0,
                'msg' => 'ok',
                'token' => $token
            ];

        }else{
            $response = [
                'errno' => 50006,
                'msg' => '用户名与密码不一致,请重新登录',
            ];

        }
        return $response;
    }

    /**
     * 个人中心
     */
    public function center(Request $request)
    {
        //判断用户是否登录 ,判断是否有 uid 字段
        $token = $request->input('token');
//if(isset($_GET['token'])){
//  $token = $_GET['token'];
// }else{
//  $response = [
//     'errno' => 50007,
//      'msg' => '请先登录'
//  ];
//  return $response;
//}
//
// //检查token是否有效
// //$res = TokenModel::where(['token'=>$token])->first();
        $uid = Redis::get($token);

        if($uid)
        {
            //$uid = $res->uid;
            $user_info = UserModel::find($uid);
            //已登录
            echo $user_info->user_name . " 欢迎来到个人中心";
        }else{
            $response = [
                'errno' => 50008,
                'msg' => '请先登录'
            ];
            return $response;
        }

    }

    /**
     *我的订单
     */
    public function orders()
    {
        //订单信息
        $arr = [
            '3845842525454345354',
            '792586234e254556354',
            '1235877363323345354',
            '2312435353454345354',
            '7825830953454345354',
        ];


        $response = [
            'errno' => 0,
            'msg'   => 'OK',
            'data'  => [
                'orders'    => $arr
            ]
        ];

        return $response;
    }

    /**
     * 购物车接口
     */
    public function cart()
    {

        $goods = [
            987,
            654,
            321
        ];

        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => $goods
        ];

        return $response;

    }
}

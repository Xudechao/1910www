<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function hello()
    {
        echo __METHOD__;echo '<br>';
        echo date('Y-m-d H:i:s');
    }

    /**
     * redis测试
     */
    public function redis1()
    {
        $key = 'name1';
        $val1 = Redis::get($key);
        echo '$val1'. $val1;
    }

    /**
     * 测试1
     */
    public function test1(){
        $data = [
            'name' => 'xudechao',
            'email' => '3012922730@qq.com'
        ];
        return $data;
        echo json_encode($data);
    }

    /**
     * 发送数据
     */
    public function sign1(){
        $key = '1910';
        $data = 'hello word';
        $sign = md5($data.$key);
        echo "你要发送的数据:" .$data;echo '</br>';
        echo "你发送前生成的签名:" .$sign; echo '<hr>';

        $b_url = 'http://www.1910.com/secret?data='.$data.'&sign='.$sign;
        echo $b_url;
    }

    /**
     * 接收数据
     */
    public function secret(){
        $key = '1910';
        echo '<pre>';print_r($_GET);echo'</pre>';
        //收到数据 验证签名
        $data = $_GET['data'];
        $sign = $_GET['sign'];
        $local_sign = md5($data.$key);
        echo '本地计算机签名: '.$local_sign;echo '<br>';
        if($sign == $local_sign){
            echo "验签通过";
        }else{
            echo "验签失败";
        }
    }

    /**
     *
     */
    public function www()
    {

        $key = '1910';
        $url = 'http://api.1910.com/api/info';

        //向接口发送数据
        //get方式发送
        $data = 'hello';
        $sign = sha1($data.$key);

        $url = $url . '?data='.$data.'&sign='.$sign;

        //PHP 发起网路请求
        $response = file_get_contents($url);
        echo $response;

    }

    /**
     * 请求接口
     */
    public function sendData()
    {
        $url = 'http://api.1910.com/test/receive?name=xudechao&age=18';
        $response = file_get_contents($url);

        echo $response;
    }

    public function postData(){
        $key = '98K';
        $data = [
            'user_name' => 'xudechap',
            'user_age'  => 18
        ];

        $str = json_encode($data).$key;
        $sign = sha1($str);
        $send_data = [
            'data'  => json_encode($data),
            'sign'  => $sign
        ];
        $url = 'http://api.1910.com/test/receive-post';
        $ch = curl_init();
        $url = $url . '?send_data='.json_encode($send_data).'&sign='.$sign;
        //php 发起网络请求
        $response = file_get_contents($url);
//        echo $response;

        //  配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$send_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        $response = curl_exec($ch);

        // 检测错误
        $errno = curl_errno($ch);
        $errmsg = curl_error($ch);

        if($errno)
        {
            echo '错误码： '.$errno;echo '</br>';
            var_dump($errmsg);
            die;
        }
        curl_close($ch);

        echo $response;
    }

    /**
     * 对称加密
     */
    public function encrypt1()
    {
        $data = '土豆土豆，我是地瓜';
        $method = 'AES-256-CBC';        //加密算法
        $key = '1910api';               // 加密秘钥
        $iv = 'hellohelloABCDEF';       //初始向量

        //加密数据
        $enc_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);

        $sign = sha1($enc_data.$key);   //签名
        //echo "加密后的密文： ".$enc_data;

        //组合post数据
        $post_data = [
            'data'  => $enc_data,
            'sign'  => $sign
        ];

        //将密文发送至对端  post
        $url = 'http://api.1910.com/test/decrypt1';
        //curl初始化
        $ch = curl_init();
        // 设置参数
        curl_setopt($ch,CURLOPT_URL,$url);      // post 地址
        curl_setopt($ch,CURLOPT_POST,1);  // post方式发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);      // post的数据
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);      //通过变量接收响应

        //开启会话（发送请求）
        $response = curl_exec($ch);         //接收响应
        echo $response;

        //捕捉错误
        $errno = curl_errno($ch);
        if($errno)
        {
            $errmsg = curl_error($ch);
            var_dump($errmsg);
            die;
        }

        //关闭连接
        curl_close($ch);

    }
}

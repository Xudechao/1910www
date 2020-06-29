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
}

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


    //redis测试
    public function redis1()
    {
        $key = 'name1';
        $val1 = Redis::get($key);
        echo '$val1'. $val1;
    }

    public function test1(){
        $data = [
            'name' => 'xudechao',
            'email' => '3012922730@qq.com'
        ];
        return $data;
        echo json_encode($data);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{

    public function a()
    {
        $key = 'access_total';
        $total = Redis::incr($key);

        if ($total > 10){
            echo "请求过多了，大哥.请您稍后再整";
        }else{
            echo '当前次数为：'.$total;
        }
    }

    public function b()
    {
        echo __METHOD__;
    }

    public function c()
    {
        echo __METHOD__;
    }

    public function x()
    {
        echo __METHOD__;
    }

    public function y()
    {
        echo __METHOD__;
    }

    public function z()
    {
        echo __METHOD__;
    }

}

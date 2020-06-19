<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
<<<<<<< HEAD
=======

>>>>>>> 76817d498484cc128524ebe756a4791ab90756a5

class TestController extends Controller
{
    public function hello()
    {
        echo __METHOD__;echo '<br>';
        echo date('Y-m-d H:i:s');
    }

<<<<<<< HEAD
    //redis测试
    public function redis1()
    {
        $key = 'name1';
        $val1 = Redis::get($key);
        echo '$val1'. $val1;
    }
=======
     //redis测试
    public function redis1()
    {
         $key = 'name1';
         $val1 = Redis::get($key);
  	 echo '$val1'. $val1;
     }
>>>>>>> 76817d498484cc128524ebe756a4791ab90756a5
}

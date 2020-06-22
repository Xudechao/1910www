<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    /*
     * 商品详情页
     */
    public function detail()
    {
        $goods_id = $_GET['id'];
        echo 'goods_id: '. $goods_id;echo '<br>';

        //查询商品详情
        //$info = GoodsModel::where(['goods_id'=>$goods_id])->get()->toArray();
        $info = GoodsModel::find($goods_id)->toArray();
        echo '<pre>';print_r($info);echo '</pre>';
    }

//    public function goodsInfo()
//    {
//        $goods_id = $_GET['id'];
//        echo 'goods_id: '. $goods_id;echo '<br>';
//
//        //查询商品详情nl
//        $info = GoodsModel::where(['goods_id'=>$goods_id])->get()->toArray();
//        //$info = GoodsModel::find($goods_id)->toArray();
//        echo '<pre>';print_r($info);echo '</pre>';
//        return json_encode($info);
//    }
}

<?php
namespace app\home\controller;
use think\Controller;

class CartController extends Controller{
    public function addGoodsToCart()
    {
        $member_id = session('member_id');
        //1判断是否登录
        if(!$member_id){
            $response = ['code'=>-1,'message'=>'请先登录后操作'];
            echo json_encode($response);die;
        }
        //2接受参数
        $goods_id = input('goods_id');
        $goods_number = input('goods_number');
        $goods_attr_ids = input('goods_attr_ids');
        //3调用购物车方法进行商品的入库
        $cart = new \cart\Cart();
        $result = $cart->addCart($goods_id,$goods_attr_ids,$goods_number);
        if($result){
            $result = ['code'=>200,'message'=>'加入购物车成功'];
            echo json_encode($response);die;
        }else{
            $result = ['code'=>-2,'message'=>'加入购物车失败,稍后重试'];
            echo json_encode($response);die;
        }
    }
}
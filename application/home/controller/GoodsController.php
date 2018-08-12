<?php
/**
 * @Author: Marte
 * @Date:   2018-08-12 22:21:25
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-08-13 01:00:23
 */
namespace app\home\controller;
use app\home\model\Goods;
use think\Controller;
use app\home\model\Category;
class GoodsController extends Controller{

    public function detail()
    {
        $goods_id = input('goods_id');
        $goodsInfo = Goods::find($goods_id)->toArray();
        //面包屑导航
        $catModel = new Category;
        $cats = $catModel->select();

        $familyCats = $catModel->getFamilyCat($cats,$goodsInfo['cat_id']);
        // dump($cats);die;
        $goodsInfo['goods_img'] = json_decode($goodsInfo['goods_img']);
        $goodsInfo['goods_middle'] = json_decode($goodsInfo['goods_middle']);
        $goodsInfo['goods_thumb'] = json_decode($goodsInfo['goods_thumb']);
        return $this->fetch('',[
            'familyCats' => $familyCats,
            'goodsInfo' => $goodsInfo
            ]);
    }

}

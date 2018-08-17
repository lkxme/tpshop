<?php
/**
 * @Author: Marte
 * @Date:   2018-08-12 22:21:25
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-08-14 11:08:09
 */
namespace app\home\controller;
use app\home\model\Goods;
use think\Controller;
use app\home\model\Category;
use think\Db;
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

        //取出商品的单选属性数据
        $_singelAttrDatas= Db::name('goods_attr')
                        ->field('t1.*,t2.attr_name')
                        ->alias('t1')
                        ->join('sh_attribute t2','t1.attr_id = t2.attr_id','left')
                        ->where("t1.goods_id =".$goods_id." and t2.attr_type=1")
                        ->select();

        //通过attr_id把单选属性进行分组,为了后续再模板中遍历
        $singelAttrDatas=[];
        foreach ($_singelAttrDatas as $v) {
            $singelAttrDatas[ $v['attr_id']][] =$v;
        }
        //取出商品的唯一属性数据
        $onlyAttrDatas = Db::name('goods_attr')
                        ->field('t1.*,t2.attr_name')
                        ->alias('t1')
                        ->join('sh_attribute t2','t1.attr_id = t2.attr_id','left')
                        ->where("t1.goods_id =".$goods_id." and t2.attr_type=0")
                        ->select();

                        // halt($singelAttrDatas);
                        // halt($onlyAttrDatas);
        //把浏览访问过的商品goods_id 加入到浏览历史cookie中
        $goodsModel = new Goods();
        $history = $goodsModel->addGoodsTohistory($goods_id);//[1,5]
        //取出浏览器历史中商品的信息
        $where = [
            'is_delete' => 0,
            'is_sale' =>1,
            'goods_id' => ['in',$history]
        ];
        //数组变成字符串
        $goods_str_ids = implode(',',$history);
        // halt($history);
        $historyDatas = Goods::where($where)->order("field('goods_id',$goods_str_ids)")->select()->toArray();
// halt($historyDatas);
        return $this->fetch('',[
            'familyCats' => $familyCats,
            'goodsInfo' => $goodsInfo,
            'singelAttrDatas'=> $singelAttrDatas,
            'onlyAttrDatas' => $onlyAttrDatas,
            'historyDatas' => $historyDatas
            ]);
    }

}

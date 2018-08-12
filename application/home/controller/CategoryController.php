<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Category;
use app\home\model\Model;
use app\home\model\Goods;
class CategoryController extends Controller{
    public function index()
    {
        //获取当前分类id祖先分类(面包屑导航)
        $cat_id = input('cat_id');
        $catModel = new Category();
        //获取祖先分类
        $cats = $catModel->select()->toArray() ;
        $familyCat = $catModel->getFamilyCat($cats,$cat_id);
        // halt($familyCat);
        // 两个技巧

        // 1一每个cat_id 作为二维数组的小标
        $catsData = [];
        foreach ($cats as $v) {
            $catsData[$v['cat_id']] = $v;
        }
        // 2通过pid进行分组
        $children = [] ;
        foreach ($cats as $v) {
            $children[$v['pid']][] = $v['cat_id'];
        }
        //获取当前分类的子孙分类cat_id
        $sonsCatid = $catModel->getSonsCatId($cats,$cat_id);//[13,14]
        //把当前分类也要加上
        $sonsCatid[] = $cat_id;
        //查询在子孙分类下面的所有商品即可
        $where = [
            'is_sale' =>1,
            'is_delete' =>0,
            'cat_id' => ['in',$sonsCatid]
        ];
        $goodsData = Goods::where($where)->select()->toArray();
        return $this->fetch('',[
            'familyCat' => $familyCat,
            'catsData' => $catsData,
            'children' => $children,
            'goodsData' =>$goodsData
            ]);
    }

}
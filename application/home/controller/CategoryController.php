<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Category;
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
        return $this->fetch('',[
            'familyCat' => $familyCat
            ]);
    }
}
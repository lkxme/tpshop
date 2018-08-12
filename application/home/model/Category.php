<?php
namespace app\home\model;
use think\Model;

class Category extends Model{
	protected $pk = 'cat_id';



	//获取导航栏的分类的数据
	public function getNavData($limit){
		//is_show = 1
		return $this->where("is_show",'=','1')->limit($limit)->select();
	}
    //面包屑获取父分类
    //不管点击哪一个分类到此分类列表页，下图的蓝色区域都是当前分类的最顶级分类。
    // 蓝色顶级分类下面含有二级分类，二级分类下又包含三级分类

    public function getFamilyCat($data,$cat_id)
    {
       static $result = [];
       foreach($data as $k=>$v){
            //第一次循环,肯定先找到自己
            if($v['cat_id'] == $cat_id){
                $result[] = $v;
                //删除已经判断过的分类
                unset($data[$k]);
                //递归调用
                $this->getFamilyCat($data,$v['pid']);
            }
       }
       //返回结果(把数据翻转)
       return array_reverse($result);
    }
    //当点击某个分类的时候，应该把当前分类及其子孙分类下面的所有商品取出来。
    //如：当点击华为手机分类的时候，应该把华为分类下面的所有的商品取出来。
    //如：当点击国内手机分类时，应该把国内手机分类下面的所有的子孙分类的商品都取出来

  public function getSonsCatId($data,$cat_id){
    static $sonsId = [];
    foreach($data as $k=>$v){
      if($v['pid'] == $cat_id){
        $sonsId[] = $v['cat_id']; //只存储cat_id即可
        unset( $data[ $k] );
        //递归调用
        $this->getSonsCatId($data,$v['cat_id']);
      }
    }
    return $sonsId;
  }
}
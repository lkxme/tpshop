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
}
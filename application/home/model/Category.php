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
	
}
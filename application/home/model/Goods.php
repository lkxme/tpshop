<?php
namespace app\home\model;
use think\Model;

class Goods extends Model{
	protected $pk = 'goods_id';

	//商品加入浏览历史cookie中
	public function addGoodsTohistory($goods_id){
	//由于加入商品goods_id 之前,cookie可能已经有数据了,要先判断下取出来
		$history = cookie('history') ? cookie('history'):[$goods_id]; //[3,4]

		if($history){
			//说明浏览器历史已经有数据
			//1把商品id 加入$history头部
			array_unshift($history,$goods_id);
			//2.把$history重复的商品去除
			$history = array_unique($history);
			//3判断$history是否超过指定的长度
			if(count( $history)>5){
				//移除数组中$history最后一个元素
				array_pop($history) ;
			}
			//把浏览器历史重新写入cookie
			//tp5中cookid存到数组默认底层已经帮助我们序列化(serialize) 存储,取出来的时候,会自动帮助我们反序列化(unserialize)
			//储存一个星期 3600*24*7

		}/*else{
			//说明浏览器历史没有数据,直接把当前访问的商品goods_id 存进数组
			$history[] =$goods_id;
		}*/
		cookie('history',$history,3600*24*7);
		//返回给调用者
		return $history;
	}

	public function getGoods($type,$limit){
		//定义初始的查询条件
		$where = [
			'is_sale' => 1
		];
		switch($type){
			case 'is_crazy':
				//按照价格升序取出来
				$data = $this->where($where)->order('goods_price asc')->limit($limit)->select();
				break;
			default :
				$where[$type] = ['=',1];
				$data = $this->where($where)->limit($limit)->select();
				break;
		}
		//返回商品数据
		return $data;

	}



}
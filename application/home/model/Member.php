<?php
namespace app\home\model;
use think\Model;
class Member extends Model{
    protected $pk = 'member_id';
    //时间搓自动写入
    protected $autoWriteTimestamp = true;

    protected static function init(){
        //入库前事件
        Member::event('before_insert',function($member){
            $member['password'] =md5($member['password'].config('password_salt'));
        });
    }

    public function checkUser($username,$password)
    {
        $where = [
            'username' =>$username,
            'password' =>md5($password.config('password_salt'))
        ];
        $userInfo = $this->where($where)->find();
        if($userInfo){
            //设置用户的信息到session中
            session('member_username',$userInfo['username']);
            session('member_id',$userInfo['member_id']);
            return true;
        }else{
            return false;
        }
    }
}
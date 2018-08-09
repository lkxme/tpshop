<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Member;
// use think\Session;

class PublicController extends Controller{
    public function sendSms()
    {
        if(request()->isAjax()){
            //接收参数
            $phone = input('phone');
            //验证器验证
            $result = $this->validate(["phone"=>$phone],'Member.sendsms',[],true);
            if($result !== true){
                //说明手机号已经被注册过了
                $response = ['code'=>-1,'message'=>'手机号码占用,请更换一个'];
                echo json_encode($response);die;
            }
            //发送短信
            $rand = mt_rand(1000,9999);
            $result = sendSms($phone,array($rand,'5'),'1');
            //判断是否发送成功,返回json数据
            if( $result->statusCode == '000000'){
                //给手机验证加盐处理,设置有效期5分钟
                cookie('phone',md5($rand.config('sms_salt')),300);
                $response = ['code'=>200,'message'=>'发送成功,请查收'];
                echo json_encode($response);die;
            }else{
                $response = ['code'=>-2,'message'=>'网络异常请重试或'.$result->statusMsg];
                echo json_encode($response);die;
            }
        }
    }

    public function register()
    {
        if(request()->isPost()){
            //接收参数
            $postData = input('post.');
            //验证器验证
            $result = $this->validate($postData,'Member.register',[],true);
            if($result !== true){
                $this->error(implode(',',$result));
            }
            //入库
            $memberModel = new Member();
            if($memberModel->allowField(true)->save($postData)){
                //入库成功后消除cookie中的phone
                cookie('phone',null);
                $this->success("注册成功",url("/"));
            }else{
                $this->error("注册失败");
            }
        }
        return $this->fetch('');
    }

    public function login()
    {
        if(request()->isPost()){
            //接收参数
            $postData = input('post.');
            // halt($postData);
            //验证器验证
            $result = $this->validate($postData,'Member.login',[],true);
            if($result !== true){
                $this->error(implode(',',$result));
            }
            //入库
            $memberModel = new Member();
            $flag = $memberModel->checkUser($postData['username'],$postData['password']);
            if($flag){
                $this->redirect("/");
            }else{
                $this->error("用户名或密码错误");
            }
        }
        return $this->fetch('');
    }

    public function logout()
    {
        //清除session
        session('member_id',null);
        session('member_username',null);
        //重定向到登录页
        $this->redirect('home/public/login');
    }
}
<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Member;
// use think\Session;

class PublicController extends Controller{
    public function setNewPassword($member_id,$hash,$time)
    {
        //判断邮件地址是否被篡改
        if(md5($member_id.$time.config('email_salt')) != $hash ){
            exit('地址非法,被修改过');
        }
        //判断是否过了有效期30分钟
        if(time() >$time+1800){
            exit('时间超时,已过了有效期');
        }
        if(request()->isPost()){
           //接收参数
           $postData = input('post.');
           //验证器验证
           $result = $this->validate($postData,'Member.setNewPassword',[],true);
           if($result !== true){
               $this->error(implode(',',$result));
           }
           //入库
           //更新密码
           $data = [
                'member_id'=>$member_id,
                'password'=>md5($postData['password'].config('email_salt'))
           ];
           $memberModel = new Member();
           if($memberModel->update($data)){
               $this->success("密码设置成功",url("/home/public/login"));
           }else{
               $this->error("密码设置失败");
           }
       }
        return $this->fetch('');
    }

    public function sendEmail()
    {
        if(request()->isAjax()){
            //接受参数
            $email = input('email');
            // halt($email);
            //验证邮箱存在系统总,才发送邮件
            $result = Member::where('email','=',$email)->find();
            // halt($result);
            if(!$result){
                //说明没有这个邮箱
                $response = ['code'=>-1,'message'=>'邮箱不存在'];
                echo json_encode($response);die;
            }

            //构造找回密码的链接地址
            $member_id = $result['member_id'];
            $time = time();
            $hash =md5($result['member_id'].$time.config('email_salt'));
            //把用户的id和当前时间和邮箱的盐进行加密,防止用户篡改,后面验证邮箱地址的有效性
            $href = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']."/index.php/home/public/setNewPassword/".$member_id.'/'.$hash.'/'.$time;
            // halt($href);
            $content = "<a href='{$href}' target ='b_blank'>精细商城-找回密码</a>";
            //发送邮件
            if(sendEmail([$email],'找回密码',$content) ){
                $response = ['code'=>200,'message'=>'发送成功,请登录邮箱查看'];
                echo json_encode($response);die;
            }else{
                $response = ['code'=>-2,'message'=>'发送失败,请稍后再试'];
                echo json_encode($response);die;
            }
        }

    }

    public function forgetPassword()
    {
        return $this->fetch('');
    }

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
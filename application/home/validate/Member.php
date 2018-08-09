<?php
namespace app\home\validate;
use think\validate;
class Member extends Validate{
    //验证规则
    protected $rule = [
        //表单name名称 = 规则1|规则2'
        'username' =>'require|unique:member',
        'email' => 'require|email|unique:member',
        'password' => 'require',
        'repassword' =>'require|confirm:password',
        // captcha_src() captcha  | captcha_src('2') captcha:2
        'captcha' => 'require|captcha',
        //captcha_src('2') captcha:2 验证验证码标识为2的验证码
        'login_captcha' => 'require|captcha:2',
        'phone' => 'require|unique:member',
    ];

    //验证不通过的提示信息
    protected $message =[
        //表单name名称.规则名 => '规则信息'
        'username.require' => '用户名必填',
        'username.unique' => '用户名被占用',
        'email.require' => '邮箱必填',
        'email.unique' => '邮箱被占用',
        'email.email' => '邮箱非法格式',
        'password.require' =>'密码必填',
        'repassword.confirm' => '两次密码不一致',
        'captcha.require' => '验证码必填',
        'captcha.captcha' => '验证码有误',
    ];

    //验证场景
    protected $scene =[
        'register' =>['username','password','email','repassword'],
        'sendsms'  =>['phone'=>'require|unique:member'],
        'login' =>['username=>require','password','login_captcha'],
    ];
}

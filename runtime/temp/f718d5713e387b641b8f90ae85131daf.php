<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\phpStudy\WWW\tpshop\public/../application/admin\view\index\main.html";i:1533291537;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
        </ul>
    </div>
    <div class="mainindex">
        <div class="welinfo">
            <span><img src="<?php echo config('admin_static'); ?>/images/sun.png" alt="天气" /></span>
            <b>Admin早上好，欢迎使用商品管理系统</b>(admin@uimaker.com)
            <a href="#">帐号设置</a>
        </div>
        <div class="welinfo">
            <span><img src="<?php echo config('admin_static'); ?>/images/time.png" alt="时间" /></span>
            <i>您上次登录的时间：2013-10-09 15:22</i>
        </div>
        <div class="xline"></div>
        <div class="box"></div>
        <div class="welinfo">
            <span><img src="<?php echo config('admin_static'); ?>/images/dp.png" alt="提醒" /></span>
            <b>环境信息</b>
        </div>
        <ul class="infolist">
            <li><span>服务器类型：</span>Apache</li>
            <li><span>PHP软件版本：</span>5.3.29</li>
            <li><span>当前访问ip：</span>127.0.0.1</li>
        </ul>
        <div class="xline"></div>
        <div class="uimakerinfo"><b>最新订单信息</b></div>
        <ul class="infolist">
            <li><a href="#">如何发布文章</a></li>
            <li><a href="#">如何访问网站</a></li>
            <li><a href="#">如何管理广告</a></li>
        </ul>
    </div>
</body>

</html>

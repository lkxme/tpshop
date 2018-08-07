<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"G:\www.shop.com\public/../application/admin\view\auth\add.html";i:1532856267;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
    <style>
        .active{
            border-bottom: solid 3px #66c9f3;
        }
    </style>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle">
            <span class="active">基本信息</span>
        </div>
        <form action="" method="post">
            <ul class="forminfo">
                <li>
                    <label>权限名称</label>
                    <input name="auth_name" placeholder="请输入权限名称" type="text" class="dfinput" /><i></i>
                </li>
                <li>
                    <label>父级权限</label>
                    <select name='pid' class="dfinput">
                        <option value='0'>顶级权限</option>
                        <?php if(is_array($auths) || $auths instanceof \think\Collection || $auths instanceof \think\Paginator): if( count($auths)==0 ) : echo "" ;else: foreach($auths as $key=>$auth): ?>
                             <option value="<?php echo $auth['auth_id']; ?>"><?php echo str_repeat('&nbsp;',$auth['level']*3); ?><?php echo $auth['auth_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>控制器名</label>
                    <input name="auth_c" placeholder="顶级权限不填" type="text" class="dfinput" /><i></i>
                </li>
                <li>
                    <label>方法名</label>
                    <input name="auth_a" placeholder="顶级权限不填" type="text" class="dfinput" /><i></i>
                </li>
            </ul>
			<li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
             </li>
        </form>
    </div>
</body>
<script>
    //给name=pid的select元素绑定change事件
    $("select[name='pid']").on('change',function(){
        var auth_id = $(this).val();
        //如果是顶级权限（auth_id=0）
        if(auth_id == 0 ){
            //让两个input不可用
            $("input[name='auth_c'],input[name='auth_a']").prop('disabled',true).val(''); 
        }else{
            $("input[name='auth_c'],input[name='auth_a']").prop('disabled',false); 
        }
    });
    //自执行change事件
    $("select[name='pid']").change();
</script>

</html>

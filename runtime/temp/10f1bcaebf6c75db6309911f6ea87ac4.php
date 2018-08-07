<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\phpStudy\WWW\tpshop\public/../application/admin\view\goods\index.html";i:1533291537;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo config('admin_static'); ?>/css/page.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t01.png" /></span>添加</li>
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t02.png" /></span>修改</li>
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t03.png" /></span>删除</li>
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t04.png" /></span>统计</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>序号</th>
                    <th>商品名称</th>
                    <th>商品所属分类</th>
                    <th>商品价格</th>
                    <th>商品库存</th>
                    <th>商品图片</th>
                    <th>商品详情</th>
                    <th>回收站中</th>
                    <th>是否上架</th>
                    <th>是否精品</th>
                    <th>是否热卖</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): if( count($goods)==0 ) : echo "" ;else: foreach($goods as $key=>$good): ?>
                <tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $good['goods_name']; ?></td>
                    <td><?php echo $good['cat_name']; ?></td>
                    <td><?php echo $good['goods_price']; ?></td>
                    <td><?php echo $good['goods_number']; ?></td>
                    <td><img src="/static/upload/<?php echo json_decode($good['goods_thumb'])[0]; ?>"></td>
                    <td><a href="javascript:;">点击查看详情</a></td>
                    <td><?php echo !empty($good['is_delete'])?'是':"否"; ?></td>
                    <td><?php echo !empty($good['is_sale'])?'是':"否"; ?></td>
                    <td><?php echo !empty($good['is_new'])?'是':"否"; ?></td>
                    <td><?php echo !empty($good['is_best'])?'是':"否"; ?></td>
                    <td>
                        <a href="<?php echo url('/admin/goods/upd',['goods_id'=>$good['goods_id']]); ?>" class="tablelink">编辑</a> 
                        <a href="<?php echo url('/admin/goods/del',['goods_id'=>$good['goods_id']]); ?>" onclick="return confirm('确认删除？')" class="tablelink"> 删除</a>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination">
        </div>
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="<?php echo config('admin_static'); ?>/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>
</html>

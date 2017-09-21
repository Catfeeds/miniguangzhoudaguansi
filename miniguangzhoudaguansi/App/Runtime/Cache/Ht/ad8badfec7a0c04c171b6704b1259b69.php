<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<link href="/miniguangzhoudaguansi/Public/ht/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/jquery.js"></script>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/action.js"></script>
</head>
<body>
<div class="aaa_pts_show_1">【 咨询服务管理 】</div>
<div class="aaa_pts_show_2">
    <div>
       <div class="aaa_pts_4"><a href="<?php echo U('index');?>">全部咨询服务</a></div>
    </div>
    <div class="aaa_pts_3">
      <table class="pro_3">
         <tr class="tr_1">
           <td style="width:80px;">ID</td>
           <td>内容</td>
           <td style="width:100px;">所属类别</td>
           <td style="width:130px;">发布时间</td>
           <td style="width:100px;">状态</td>
           <td style="width:180px;">操作</td>
         </tr>
          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["content"]); ?></td>
            <td><?php if($vo["type"] == 1): ?>法律咨询<?php else: ?>法律服务<?php endif; ?></td>
            <td><?php echo ($vo["addtime"]); ?></td>
            <td><?php if($vo["state"] == 1): ?>未回复<?php elseif($vo["state"] == 2): ?>已回复<?php else: ?>服务中<?php endif; ?></td>
            <td>
              <!-- <a href="<?php echo U('review');?>?news_id=<?php echo ($vo["id"]); ?>">查看评论</a> |  -->
              <a onclick="del_id_url2(<?php echo ($vo["id"]); ?>)">删除</td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>  
         <tr>
            <td colspan="10" class="td_2">
                <?php echo ($page); ?>
             </td>
         </tr>
      </table>      
    </div>
    
</div>
<script>
function product_option(){
      $('form').submit();
}

function del_id_url2(id){
   if(confirm("确认删除吗？"))
   {
	  location='<?php echo U("del");?>?did='+id;
   }
}
</script>
</body>
</html>
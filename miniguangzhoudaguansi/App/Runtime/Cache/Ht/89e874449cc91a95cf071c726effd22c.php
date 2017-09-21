<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<link href="/miniguangzhoudaguansi/Public/ht/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/jquery.js"></script>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/action.js"></script>
</head>
<body>

<div class="aaa_pts_show_1">【 会员信息管理 】</div>

<div class="aaa_pts_show_2">
    
    <div>
       <div class="aaa_pts_4">会员审核</div>
    </div>
    <div class="aaa_pts_3">
      <form action="<?php echo U('shenhe');?>?id=<?php echo ($id); ?>" method="post" onsubmit="return ac_from();">
      <ul class="aaa_pts_5">
         <li>
            <div class="d1">姓  名:</div>
            <div>
              <input class="inp_1" name="truename" id="truename" readonly="readonly" value="<?php echo ($info["truename"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">头像:</div>
            <div>
              <img src="/miniguangzhoudaguansi/Data/<?php echo ($info["photo_ls"]); ?>" width="80px" height="80px"/>
           </div>
         </li>
         <li>
            <div class="d1">手机号码:</div>
            <div>
              <input class="inp_1" name="tel" id="tel" readonly="readonly" value="<?php echo ($info["tel"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">律师所:</div>
            <div>
              <input class="inp_1" name="shop_name" id="shop_name" readonly="readonly" value="<?php echo ($info["shop_name"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">地址:</div>
            <div>
              <input class="inp_1" name="dizhi" id="dizhi" readonly="readonly" value="<?php echo ($info["dizhi"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">项目服务:</div>
            <div>
              <input class="inp_1" name="service" id="service" readonly="readonly" value="<?php echo ($info["service"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">传真:</div>
            <div>
              <input class="inp_1" name="cz" id="cz" readonly="readonly" value="<?php echo ($info["cz"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">律师简介:</div>
            <div>
              <textarea class="inp_1 inp_2" style="width:400px;height:120px;" name="digest" id="digest" readonly="readonly" ><?php echo ($info["digest"]); ?></textarea>
            </div>
         </li>
         <li>
            <div class="d1">执业经验:</div>
            <div>
              <textarea class="inp_1 inp_2" style="width:400px;height:120px;" name="zyjy" id="zyjy" readonly="readonly" /><?php echo ($info["zyjy"]); ?></textarea>
            </div>
         </li>
         <li>
            <div class="d1">审核状态:</div>
            <div>
               <input type="radio" name="audit" value="2" checked="checked"/> 审核通过<br />
               <input type="radio" name="audit" value="3" /> 不通过
            </div>
         </li>
         <li>
            <div class="d1">理由/原因:</div>
            <div>
              <textarea class="inp_1 inp_2" style="width:250px;height:60px;" name="reason" id="reason"/></textarea>
            </div>
         </li>
         <li><input type="submit" name="submit" value="提交" class="aaa_pts_web_3" border="0">
             <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
         </li>
      </ul>
      </form> 
    </div>
</div>
<div class="aaa_pts_show_2">
        <div>
           <div class="aaa_pts_4">律师执业证:</div>
        </div>
        <div class="aaa_pts_3">
           <div style="line-height:80px; font-size:18px; text-align:center;">
              <img src="/miniguangzhoudaguansi/Data/<?php echo ($info["bl_photo"]); ?>" />
           </div>
        </div>
    </div>
<script>
function ac_from(){

   
}
</script>
</body>
</html>
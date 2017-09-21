<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<link href="/miniguangzhoudaguansi/Public/ht/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/jquery.js"></script>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/action.js"></script>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/plugins/xheditor/xheditor-1.2.1.min.js"></script>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/plugins/xheditor/xheditor_lang/zh-cn.js"></script>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/jCalendar.js"></script>
<style>
<?php  $width=round($img['width']*0.6+6); $height =round( $width*$img['height'] / $img['width']); ?>
.dx1{float:left; margin-left: 17px; margin-bottom:10px; }
.dx2{color:#090; font-size:16px;  border-bottom:1px solid #CCC; width:100% !important; padding-bottom:8px;}
.dx3{width:120px; margin:5px auto; border-radius: 2px; border: 1px solid #b9c9d6; display:block;}
.dx4{border-bottom:1px solid #eee; padding-top:5px; width:100%;}
.img-err {
    position: relative;
    top: 2px;
    left: 82%;
    color: white;
    font-size: 20px;
    border-radius: 16px;
    background: #c00;
    height: 21px;
    width: 21px;
    text-align: center;
    line-height: 20px;
    cursor:pointer;
}
.btn{
            height: 25px;
            width: 60px;
            line-height: 24px;
            padding: 0 8px;
            background: #24a49f;
            border: 1px #26bbdb solid;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            outline: none;
            -webkit-box-shadow: #666 0px 0px 6px;
            -moz-box-shadow: #666 0px 0px 6px;
        }
        .btn:hover{
          border: 1px #0080FF solid;
          background:#D2E9FF;
          color: red;
          -webkit-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px;
          -moz-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px;
        }
        .cls{
            background: #24a49f;
        }
</style>

</head>
<body>

<div class="aaa_pts_show_1">【 金牌律师管理 】</div>

<div class="aaa_pts_show_2">
    <div>
       <div class="aaa_pts_4"><a href="<?php echo U('Product/index');?>">全部律师</a></div>
       <!-- <div class="aaa_pts_4"><a href="<?php echo U('Product/add');?>">添加律师</a></div> -->
    </div>
    <div class="aaa_pts_3">
		<form action="?id=<?php echo ($id); ?>&page=<?php echo ($page); ?>&type=<?php echo ($type); ?>&name=<?php echo ($name); ?>&shop_id=<?php echo ($shop_id); ?>" method="post" onsubmit="return ac_from();" enctype="multipart/form-data">
		<ul class="aaa_pts_5">
			<li>
				<div class="d1">律师姓名:</div>
				<div>
					<input class="inp_1" name="name" id="name" style="width:150px;" value="<?php echo ($pro_allinfo["name"]); ?>"/>&nbsp;&nbsp;
				</div>
			</li>

     <!--  <li>
        <div class="d1">所属律师所:</div>
        <div>
          <input class="inp_1" id="partner" value="<?php echo ($shangchang["name"]); ?>" disabled="disabled"/>
          <input type="hidden" name="shop_id" id="shop_id" value="<?php echo ($pro_allinfo["shop_id"]); ?>"/>
          <input type="button" value="选择律师所" class="aaa_pts_web_3" style="margin-left:15px;" onclick="win_open('<?php echo U('Shangchang/index');?>?type=xz',1280,800)">
        </div>
       </li> -->

      <li>
        <div class="d1">事务所:</div>
        <div>
          <input class="inp_1" name="shop_name" id="shop_name" value="<?php echo ($pro_allinfo["shop_name"]); ?>"/>&nbsp;&nbsp;
        </div>
      </li>
       <li>
        <div class="d1">地址:</div>
        <div>
          <input class="inp_1" name="dizhi" id="dizhi" value="<?php echo ($pro_allinfo["dizhi"]); ?>"/>&nbsp;&nbsp;
        </div>
      </li>
      <li>
        <div class="d1">服务项目:</div>
        <div>
          <input class="inp_1" name="service" id="service" value="<?php echo ($pro_allinfo["service"]); ?>"/>&nbsp;&nbsp;
        </div>
        <div style="color:#c00; font-size:14px; padding-left:20px;">多个项目请用 / 分隔</div>
      </li>

         <!-- 产品分类 -->
     <!--  <li>
        <div class="d1">选择类别:</div>
        <div>
         <select class="inp_1" name="cid" id="cid" onchange="getcid();" style="width:150px;margin-right:5px;">
          <option value="">选择律师分类</option>
        
          <?php if(is_array($cate_list)): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php if($v["id"] == $pro_allinfo['cid']): ?>selected="selected"<?php endif; ?>>-- <?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
               
         </select>
        </div>
        <div style="color:#c00; font-size:14px; padding-left:20px;">默认：金牌律师</div>
      </li> -->
         <!-- 产品分类 -->

        <li class="product"><div class="d1 dx2">其他信息</div></li>
		    <li>
          <div style="color:#c00; font-size:14px; padding-left:20px;">上传律师头像大小: 120*120的图片 &nbsp;&nbsp;&nbsp;只能添加一张图片！！</div>
        </li>
        <li>
          <div class="d1">律师头像:</div>
           <div>
            <?php if ($pro_allinfo['photo_x']) { ?>
                  <img src="/miniguangzhoudaguansi/Data/<?php echo $pro_allinfo['photo_x']; ?>" width="80" height="80" style="margin-bottom: 3px;" />
                  <br />
              <?php } ?>
              <input type="file" name="photo_x" id="photo_x" />
            </div>
         </li>

        <li>
          <div style="color:#c00; font-size:14px; padding-left:20px;">上传律师执业证&nbsp;&nbsp;&nbsp;只能添加一张图片！！</div>
        </li>
        <li>
          <div class="d1">律师执业证:</div>
           <div>
            <?php if ($pro_allinfo['photo']) { ?>
              <img src="/miniguangzhoudaguansi/Data/<?php echo $pro_allinfo['photo']; ?>" style="margin-bottom: 3px;" width="80px" height="80px" /><br />
            <?php } ?>
            <input type="file" name="photo" id="photo" />
            </div>
         </li>

         <li>
            <div class="d1">律师简介:</div>
            <div>
              <textarea class="inp_1 inp_2" name="digest" id="digest" style="height:80px; width:400px;"/><?php echo $pro_allinfo['digest']; ?></textarea>
            </div>
         </li>
         <li>
            <div class="d1">执业经验:</div>
            <div>
              <textarea class="inp_1 inp_2" name="zyjy" id="zyjy" style="height:80px; width:400px;"/><?php echo $pro_allinfo['zyjy']; ?></textarea>
            </div>
         </li>
         <li>
            <div class="d1">联系方式:</div>
            <div>
              <input class="inp_1" style="width:150px;" name="tel" id="tel" value="<?php echo ($pro_allinfo["tel"]); ?>"/>
            </div>
         </li>
         <li>
            <div class="d1">传真:</div>
            <div>
              <input class="inp_1" style="width:150px;" name="cz" id="cz" value="<?php echo ($pro_allinfo["cz"]); ?>"/>
            </div>
         </li>
        <li>
            <div class="d1">排序:</div>
            <div>
              <input class="inp_1" style="width:150px;" name="sort" id="sort" value="<?php echo (int)$pro_allinfo['sort']; ?>"/> &nbsp;&nbsp;
            </div>
         </li>
         <!-- <li>
            <div class="d1">人气:</div>
            <div>
              <input class="inp_1" style="width:150px;" name="renqi" id="renqi" value="<?php echo (int)$pro_allinfo['renqi']; ?>"/>
            </div>
         </li> -->

      <li><input type="submit" name="submit" value="提交" class="aaa_pts_web_3" border="0" id="aaa_pts_web_s">
          <input type="hidden" name="pro_id" id='pro_id' value="<?php echo ($pro_allinfo["id"]); ?>">
      </li>
      </ul>
      </form>
         
    </div>
    
</div>
<script type="text/javascript" src="/miniguangzhoudaguansi/Public/ht/js/product.js"></script>
<script>
function upadd(obj){
  //alert('aaa');
  $('#imgs_add').append('<div>&nbsp;&nbsp;<input type="file" style="width:160px;" name="files[]" /><a onclick="$(this).parent().remove();" class="btn cls" style="background:#D0D0D0; width:40px; color:black;"">&nbsp;&nbsp;&nbsp;删除</a></div>');
  return false;
}

function ac_from(){

  var name=document.getElementById('name').value;
  if(name.length<1){
	  alert('律师姓名不能为空');
	  return false;
	} 

  
}

//图片删除
function del_img(img,obj){
  var pro_id = $('#pro_id').val();
  if (confirm('是否确认删除？')) {
    $.post('<?php echo U("img_del");?>',{img_url:img,pro_id:pro_id},function(data){
      if(data.status==1){
        $(obj).parent().remove();
        return false;
      }else{
        alert(data.err);
        return false;
      }
    },"json");
  };
}

//获取户型
function getcid(){
  var cateid = $('#cid').val();
  $.post('<?php echo U("getcid");?>',{cateid:cateid},function(data){
      if(data.catelist!=''){
        var htmls = '<option value="0">选择户型</option>';
        var cate = data.hlist;
        for (var i = 0; i<cate.length; i++) {
          htmls += '<option value="'+cate[i].id+'">-- '+cate[i].name+'</option>';
        }
        $('#htype').html(htmls);
      }else{
        $('#htype').html('<option value="0">选择户型</option>');
      }
    },"json");
}

//初始化编辑器
$('#content').xheditor({
  skin:'nostyle' ,
  upImgUrl:'<?php echo U("Upload/xheditor");?>'
});
</script>
</body>
</html>
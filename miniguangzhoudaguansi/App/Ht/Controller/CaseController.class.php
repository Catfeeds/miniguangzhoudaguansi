<?php
namespace Ht\Controller;
use Think\Controller;
class CaseController extends PublicController{
	/*
	*
	* 获取、查询新闻表数据
	*/
	public function index(){
		//构建搜索条件
		//分页
		$count   = M('case')->where('1=1')->count();// 查询满足要求的总记录数
		$Page    = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		//头部描述信息，默认值 “共 %TOTAL_ROW% 条记录”
		$Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		//上一页描述信息
	    $Page->setConfig('prev', '上一页');
	    //下一页描述信息
	    $Page->setConfig('next', '下一页');
	    //首页描述信息
	    $Page->setConfig('first', '首页');
	    //末页描述信息
	    $Page->setConfig('last', '末页');
	    /*
	    * 分页主题描述信息 
	    * %FIRST%  表示第一页的链接显示  
	    * %UP_PAGE%  表示上一页的链接显示   
	    * %LINK_PAGE%  表示分页的链接显示
	    * %DOWN_PAGE% 	表示下一页的链接显示
	    * %END%   表示最后一页的链接显示
	    */
	    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');

		$show = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = M('case')->where('1=1')->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as $k => $v) {
			$list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
		}

		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); // 输出模板

	}

	/*
	*
	* 添加修改案例
	*/
	public function add(){
		$id=(int)$_GET['id'];

		//==========================================
		// 组装post过来的数据进行处理添加
		//==========================================
		if($_POST['submit']==true){
		   $id = intval($_POST['id']);
		   $array=array(
				'title' => $_POST['title'] ,
				'source' => $_POST['source'] ,
				'author' => $_POST['author'] ,
				'content' => $_POST['content'] ,
		    );
		
		   
		  if($id>0){
			  //将空数据排除掉，防止将原有数据空置
			  foreach ($array as $k => $v) {
			  	 if(empty($v)){
			  	 	unset($v);
			  	 }
			  }
			  $partner =M('case')->where('id='.intval($id))->save($array);
		  }else{

			  $array['addtime']=time();
			  $partner =M('case')->add($array);
			  $id = $partner;
		  }
		  if($partner){			  
			   echo '
			   <script>
				  location= !confirm("操作成功！\n是否继续操作？") ? "?page='.$page.'name='.$name.'&sheng='.$sheng.'&city='.$city.'&quyu='.$quyu.'&tiaojian='.$tiaojian.'" : "?id='.$id.'&page='.$page.'&name='.$name.'&sheng='.$sheng.'&city='.$city.'&quyu='.$quyu.'&tiaojian='.$tiaojian.'";
			   </script>';
		   }else{
			   $this->error('保存失败！');
			   exit();
		  	}
		}

		//=============================
		// 查询店铺的所有信息出来
		//=============================
		$case= $id>0 ? M('case')->where('id='.$id)->find() : array();
	
		//==========================
		// 将GET到的数据再输出
		//==========================
		$this->assign('id',$id);
		$this->assign('page',$page);

		//=========================
		// 将变量输出
		//=========================	

		$this->assign('case',$case);
		$this->display();
	}

	/*
	*
	* 新闻删除、新闻评论删除
	*/
	public function del(){
		//以后删除还要加权限登录判断
		$id = intval($_GET['did']);
		$check_info = M('case')->where('id='.intval($id))->find();
		if (!$check_info) {
			$this->error('非法操作.');
			exit();
		}

		$res = M('case')->where('id='.intval($id))->delete();
		if ($res) {
			//把对应图片也一起删除
			$this->redirect('index');
		}else{
			$this->error('操作失败.');
		}
	}

	//***************************
	//说明： 设置推荐
	//***************************
	public function set_tj(){
		$id = intval($_REQUEST['id']);
		$tj_update=M('case')->field('type')->where('id='.intval($id))->find();
		if (!$tj_update) {
			$this->error('案例信息有误！');
			exit();
		}
		$data = array();
		$data['type'] = $tj_update['type']==1 ? 0 : 1;
		$up = M('case')->where('id='.intval($id))->save($data);
		if ($up) {
			$this->redirect('index');
			exit();
		}else{
		    $this->error('操作失败！');
			exit();
		}
	}

}
<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends PublicController {
	//***************************
	//  首页数据接口
	//***************************
    public function index(){
    	//如果缓存首页没有数据，那么就读取数据库
    	/***********获取首页顶部轮播图************/
  //   	$ggtop=M('guanggao')->order('sort desc,id asc')->field('id,name,photo')->limit(10)->select();
		// foreach ($ggtop as $k => $v) {
		// 	$ggtop[$k]['photo']=__DATAURL__.$v['photo'];
		// 	$ggtop[$k]['name']=urlencode($v['name']);
		// }
    	/***********获取首页顶部轮播图 end************/

        //============================
        //首页推荐律师事务所8个
        //============================
        $shop_list = M('shangchang')->where('status=1 AND type=1')->order('sort asc')->field('id,name,logo')->limit(8)->select();
        foreach ($shop_list as $k => $v) {
            $shop_list[$k]['logo'] = __DATAURL__.$v['logo'];
        }

    	//======================
    	//首页推荐律师
    	//======================
    	$pro_list = M('product')->where('del=0 AND type=1')->order('sort asc,id desc')->select();
    	foreach ($pro_list as $k => $v) {
    		$pro_list[$k]['photo_x'] = __DATAURL__.$v['photo_x'];
    	}

        //======================
        //首页 咨询内容
        //======================
        $consult = M('consult');
        $zixun = $consult->where('type=1')->order('addtime desc')->limit(3)->select();
        foreach ($zixun as $k => $v) {
            $zixun[$k]['addtime'] = date("Y-m-d",$v['addtime']);
            $zixun[$k]['photo'] = M('user')->where('id='.intval($v['uid']))->getField('photo');
            $zixun[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('truename');
            if($zixun[$k]['name']==''){
                $zixun[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('uname');
            }
        }

        //======================
        //首页 服务内容
        //======================
        $fuwu = $consult->where('type=2')->order('addtime desc')->limit(3)->select();
        foreach ($fuwu as $k => $v) {
            $fuwu[$k]['addtime'] = date("Y-m-d",$v['addtime']);
            $fuwu[$k]['photo'] = M('user')->where('id='.intval($v['uid']))->getField('photo');
            $fuwu[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('truename');
            if($fuwu[$k]['name']==''){
                $fuwu[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('uname');
            }
        }

        //案例
        $anli = M('case')->where('type=1')->select();
        if($anli){
            foreach($anli as $k => $v){
                $anli[$k]['addtime'] = date("Y-m-d",$v['addtime']);
            }
        }

        //客服电话
        $tel = M('program')->limit(1)->getField('tel');
    	echo json_encode(array('lslist'=>$pro_list,'shop'=>$shop_list,'zixun'=>$zixun,'fuwu'=>$fuwu,'tel'=>$tel,'anli'=>$anli));
    	exit();
    }

    //***************************
    //  首页产品 分页
    //***************************
    public function getlist(){
        $page = intval($_REQUEST['page']);
        if (!$page) {
           $page=2;
        }
        $limit = intval($page*6)-6;

        $news = M('news')->where('1=1')->order('sort desc,id desc')->field('id,name,addtime,photo,source')->limit($limit.',6')->select();
        foreach ($news as $k => $v) {
            $news[$k]['photo'] = __DATAURL__.$v['photo'];
            $news[$k]['addtime'] = date('Y-m-d',$v['addtime']);
        }

        echo json_encode(array('news'=>$news));
        exit();
    }

    //***************************
    //  首页供求 上一页
    //***************************
    public function getpage(){
        $page = intval($_REQUEST['page']);
        if (!$page) {
           $page=2;
        }
        $limit = intval($page*3)-3;

        $condition = array();
        $ptype = intval($_REQUEST['ptype']);
        if ($ptype==1) {
            $condition['type'] = 1;
        }else{
            $condition['type'] = 2;
        }

        //======================
        //首页 内容
        //======================
        $consult = M('consult');
        $list = $consult->where($condition)->order('addtime desc')->limit($limit.',3')->select();
        foreach ($list as $k => $v) {
            $list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
            $list[$k]['photo'] = M('user')->where('id='.intval($v['uid']))->getField('photo');
            $list[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('truename');
            if($list[$k]['name']==''){
                $list[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('uname');
            }
        }

        echo json_encode(array('list'=>$list));
        exit();
    }

    public function userinfo () {
        $uid = intval($_REQUEST['uid']);
        //客服电话
        $tel = M('program')->limit(1)->getField('tel');
        $userinfo = M('user')->where('id='.$uid)->find();
        echo json_encode(array('tel'=>$tel,'userinfo'=>$userinfo));
        exit();
    }


}
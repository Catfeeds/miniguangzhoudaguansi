<?php
namespace Api\Controller;
use Think\Controller;
class ConsultController extends PublicController {
	//***************************
	//  首页数据接口
	//***************************
    public function index(){

        
    }

    public function send_consult(){
        $uid = intval($_REQUEST['uid']);
        if(intval($_REQUEST['ls_id'])){
            $tmp_id = M('product')->where('id='.intval($_REQUEST['ls_id']))->getField('uid');
            if($uid==intval($tmp_id)){
                 echo json_encode(array('status'=>0,'err'=>'不能咨询自己!'));
                exit();
            }
           
        }
        $dtype = intval($_REQUEST['dtype']);
        if (!$uid || !$dtype) {
            echo json_encode(array('status'=>0,'err'=>'参数错误.'));
            exit();
        }

        $content = trim($_POST['content']);
        if (!$content) {
            echo json_encode(array('status'=>0,'err'=>'请输入内容.'));
            exit();
        }

        $userinfo = M('user')->where('del=0 AND id='.intval($uid))->find();
        if (!$userinfo) {
            echo json_encode(array('status'=>0,'err'=>'用户信息异常.'));
            exit();
        }

        // if (intval($userinfo['audit'])>0 || intval($userinfo['type'])==2) {
        //     echo json_encode(array('status'=>0,'err'=>'认证企业请从后台发布供求产品！'));
        //     exit();
        // }

        if (!$userinfo['tel']) {
            echo json_encode(array('status'=>0,'err'=>'请先去个人中心绑定您的手机号.'));
            exit();
        }

        $add = array();
        $add['uid'] = $uid;
        $add['content'] = $content;
        $add['phone'] = M('user')->where('id='.intval($uid))->getField('tel');
        $add['type'] = $dtype;
        $add['ls_id'] = intval($_REQUEST['ls_id']);
        $add['addtime'] = time();
        if($dtype==2){
            $audit = M('user')->where('id='.$uid)->getField('audit');
            if(intval($audit)!=2){
                echo json_encode(array('status'=>0,'err'=>'只有通过审核的律师才能发布服务！'));
                exit();
            }
            $add['status'] = 3;
            $add['ls_id'] = M('product')->where('uid='.$uid)->getField('id');
        }
       
        $res = M('consult')->add($add);
        if ($res) {
            echo json_encode(array('status'=>1,'err'=>'提交成功!'));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'提交失败！'));
            exit();
        }
    }

    //详情
    public function details(){
        $id = intval($_REQUEST['id']);
        $res = M('consult')->where('id='.$id)->find();
        if ($res) {
            $res['addtime'] = date("Y-m-d H:i:s",$res['addtime']);
            $res['type'] = M('user')->where('id='.intval($res['uid']))->getField('type');
            $res['name'] = M('user')->where('id='.intval($res['uid']))->getField('truename');
            if($res['name']==''){
                $res['name'] = M('user')->where('id='.intval($res['uid']))->getField('uname');
            }
            echo json_encode(array('status'=>1,'info'=>$res));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'信息错误！'));
            exit();
        }

    }

    //用户的咨询
    public function userConsult(){
        $uid = intval($_REQUEST['uid']);
        if (!$uid) {
            echo json_encode(array('status'=>0,'err'=>'网络错误！'));
            exit();
        }
        $list = array();
        $list = M('consult')->where('uid='.$uid.' AND type=1')->select();
        if($list){
            foreach ($list as $k => $v) {
                $list[$k]['addtime'] = date("Y-m-d H:i:s",$v['addtime']);
                $list[$k]['photo'] = M('user')->where('id='.intval($v['uid']))->getField('photo');
                $list[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('truename');
                if($list[$k]['name']==''){
                    $list[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('uname');
                }
            }
            echo json_encode(array('status'=>1,'list'=>$list));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络错误！'));
            exit();
        }
        
    }

     //已咨询我的
    public function meConsult(){
        $uid = intval($_REQUEST['uid']);
        if (!$uid) {
            echo json_encode(array('status'=>0,'err'=>'网络错误！'));
            exit();
        }
        $ls_id = M('product')->where('uid='.$uid)->getField('id');
        $list = array();
        $list = M('consult')->where('ls_id='.intval($ls_id).' AND type=1')->select();
        if($list){
            foreach ($list as $k => $v) {
                $list[$k]['addtime'] = date("Y-m-d H:i:s",$v['addtime']);
                $list[$k]['photo'] = M('user')->where('id='.intval($v['uid']))->getField('photo');
                $list[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('truename');
                if($list[$k]['name']==''){
                    $list[$k]['name'] = M('user')->where('id='.intval($v['uid']))->getField('uname');
                }
            }
            echo json_encode(array('status'=>1,'list'=>$list));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'没有数据！'));
            exit();
        }
        
    }

    //解答咨询
    public function jieda(){
        $uid = intval($_REQUEST['uid']);
        $zi_id = intval($_REQUEST['zi_id']);
        $ls_id = intval($_REQUEST['ls_id']);
        if (!$uid) {
            echo json_encode(array('status'=>0,'err'=>'网络错误！'));
            exit();
        }
        if($ls_id>0){
            $tmp_ls = M('product')->where('uid='.$uid)->getField('id');
            if(intval($tmp_ls)!=$ls_id){
                echo json_encode(array('status'=>0,'err'=>'该咨询已指定律师解答！'));
                exit();
            }
        }
        $reply_content = trim($_REQUEST['reply_content']);
        $data['reply_content'] = $reply_content;
        $data['state'] = 2;
        $res = M('consult')->where('id='.$zi_id)->save($data);
        if($res){
            echo json_encode(array('status'=>1,'err'=>'提交成功！'));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'提交失败！'));
            exit();
        }
        
    }

}
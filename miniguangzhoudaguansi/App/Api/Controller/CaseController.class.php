<?php
namespace Api\Controller;
use Think\Controller;
class CaseController extends PublicController {
	//***************************
	//  首页数据接口
	//***************************
    public function index(){
        $list = array();
        $list = M('case')->select();
        if ($list) {
            foreach($list as $k => $v){
                 $list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
            }

            echo json_encode(array('status'=>1,'list'=>$list,'content'=>$list['content']));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'暂无数据！'));
            exit();
        }
        
    }


    //详情
    public function details(){
        $id = intval($_REQUEST['id']);
        $res = M('case')->where('id='.$id)->find();
        if ($res) {
            $res['addtime'] = date("Y-m-d",$res['addtime']);
            $content = str_replace('/miniguangzhoudaguansi/Data/', __DATAURL__, $res['content']);
            $res['content']=html_entity_decode($content, ENT_QUOTES , 'utf-8');
            echo json_encode(array('status'=>1,'info'=>$res,'content'=>$res['content']));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'信息错误！'));
            exit();
        }

    }

     //法律常识详情
    public function legal_details(){
        $id = intval($_REQUEST['id']);
        $res = M('legal')->where('id='.$id)->find();
        if ($res) {
            $res['addtime'] = date("Y-m-d",$res['addtime']);
            $content = str_replace('/miniguangzhoudaguansi/Data/', __DATAURL__, $res['content']);
            $res['content']=html_entity_decode($content, ENT_QUOTES , 'utf-8');
            echo json_encode(array('status'=>1,'info'=>$res,'content'=>$res['content']));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'信息错误！'));
            exit();
        }

    }

}
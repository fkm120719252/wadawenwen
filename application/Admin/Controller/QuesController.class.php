<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class QuesController extends AdminbaseController{
	function _initialize() {
		parent::_initialize();
	}
	
	function index(){
		//实例化模型
		$ques = M('questions');
		$user = M('users');
		$terms = M('terms');
		
		//分页
		$count=$ques->count();
		$page = $this->page($count, 20);
		
		//查询数据库
		$quesInfo = $ques->limit($page->firstRow . ',' . $page->listRows)->select();

		//开始遍历
		foreach($quesInfo as $key => $item){
			$userInfo = $user->where(array("id"=>$item['uid']))->find();
			$quesInfo[$key]['name'] = $userInfo['user_login'];
			$termsInfo = $terms->where(array("term_id"=>$item['type']))->find();
			$quesInfo[$key]['type'] = $termsInfo['name'];		
			
			if($item['moneytype'] == 1){
				$quesInfo[$key]['moneytype'] = "金币";
			}elseif($item['moneytype'] == 2){
				$quesInfo[$key]['moneytype'] = "人民币";
			}
			
			if($item['status']==0){
				$quesInfo[$key]['status'] = "已关闭";
			}elseif($item['status']==1){
				$quesInfo[$key]['status'] = "正在进行";
			}elseif($item['status']==2){
				$quesInfo[$key]['status'] = "已确认";
			}
			
			$quesInfo[$key]['addtime'] = date('Y-m-d H:i:s',$item['addtime']);
		}
		$this->assign("Page", $page->show('Admin'));
		$this->assign("quesInfo",$quesInfo);
		$this->display();
	}
}
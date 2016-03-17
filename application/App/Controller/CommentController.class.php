<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class CommentController extends AppbaseController{

	function __controller(){
		parent::__controller();
	}
	
	//用户评论
	function reply(){
		//实例化模型
		$reply = M('reply');
		
		//获取数据
		$data['qid'] = I('post.qid');
		$data['uid'] = I('post.uid');
		$data['content'] = I('post.content');
		$data['addtime'] = time();
		
		//执行发表回复操作
		$replyInfo = $reply->data($data)->add();
		
		//判断是否成功
		if(!empty($replyInfo)){
			$return['status'] = "success";
			$return['explain'] = "回复成功";
			$return['value'] = $replyInfo;	
		}else{
			$return['status'] = "error";
			$return['explain'] = "回复失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
}
//疯狂动物城

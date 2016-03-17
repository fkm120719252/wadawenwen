<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class QuesController extends AppbaseController{

	function __controller(){
		parent::__controller();
	}
	
	function ques(){
		//实例化模型
		$ques = M('questions');
		$pageCount = 20;
		$page = "";
		if(I("post.page")){
			$page .= (I("post.page")-1)*$pageCount.",".$pageCount;
		}else{
			$page .="0,".$pageCount;
		}
		//获取post信息
		if(I("post.title")){
			$map['title'] = array("LIKE","%".I("post.title")."%");
		}
		if(I('post.type')){
			$map['type'] = I('post.type');
		}
		$quesInfo = $ques->where($map)->limit($page)->select();
		
		//执行判断操作
		if(!empty($quesInfo)){
			$return['status'] = "success";
			$return['explain'] = "查询问题成功";
			$return['value'] = $quesInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "查询问题失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	/**
	 * 添加问题
	 */
	function addQues(){
		//实例化模型
		$ques = M('questions');
		//获取数据
		$data['uid'] = I("post.uid");
		$data['title'] = I("post.title");
		$data['type'] = I("post.type");
		$data['content'] = I("post.content");
		
		$quesInfo = $ques->add($data);
		//执行判断操作
		if(!empty($quesInfo)){
			$return['status'] = "success";
			$return['explain'] = "添加问题成功";
			$return['value'] = $quesInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "添加问题失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
		
	}
	//图片上传测试
// 	function test(){
// 		$rootPath = SITE_PATH."data/upload/";
// 		$savePath = "avatar/";
// 		$url = $this->upload($rootPath, $savePath, $_FILES['file']);
// 		echo $rootPath.$url;
// 	}
}
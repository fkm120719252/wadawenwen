<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class TermsController extends AppbaseController{

	function __controller(){
		parent::__controller();
	}
	
	function getList(){
		//实例化模型
		$terms = M('terms');
		
		//查询语句
		$termsInfo = $terms->select();
		
		//执行判断操作
		if(!empty($termsInfo)){
			$return['status'] = "success";
			$return['explain'] = "获取列表成功";
			$return['value'] = $termsInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "查询列表失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
}
<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class SlideController extends AppbaseController{
	function __controller(){
		parent::__controller();
	}
	
	//查询操作
	function SlideList(){
		//实例化模型
		$slide = M('slide');
		
		//执行查询操作
		$slideInfo = $slide->select();
		
		//判断是否查询成功
		if(!empty($slideInfo)){
			$return['status'] = "success";
			$return['explain'] = "获取列表成功";
			$return['value'] = $slideInfo;			
		}else{
			$return['status'] = "error";
			$return['explain'] = "获取列表失败";
			$return['value'] = null;			
		}
		$this->ajaxReturn($return);
	}
}
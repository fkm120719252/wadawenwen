<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class ShopController extends AppbaseController{
	function __controller(){
		parent::__controller();
	}
	
	function shop(){
		//实例化
		$shop = M("shop");
		//分页
		$pageCount = 20;
		$page = "";
		if(I("post.page")){
			$page .= (I("post.page")-1)*$pageCount.",".$pageCount;
		}else{
			$page .="0,".$pageCount;
		}
		
		//查询语句
		$shopInfo = $shop->limit($page)->select();
		
		//执行判断操作
		if(!empty($shopInfo)){
			$return['status'] = "success";
			$return['explain'] = "获取店铺成功";
			$return['value'] = $shopInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "查询店铺失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	/**
	 * 开启店铺
	 */
	function openShop(){
		$flag = true;
		//实例化
		$shop = M("shop");
		//获取数据
		$data['title'] = I("post.title");
		$data['uid'] = I("post.uid");
		$data['time'] = time();
		while ($flag){
			$code = $this->randStr(6,"NUMBER");
			$r = $shop->where("code = ".$code)->find();
			if (empty($r)){
				$flag = false;
				$data['code'] = $code;
			}
		}
		$result = $shop->add($data);
		if($result){
			$return['status'] = "success";
			$return['explain'] = "获取店铺成功";
			$return['value'] = $result;
		}else{
			$return['status'] = "error";
			$return['explain'] = "查询店铺失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
}
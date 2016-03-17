<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ShopController extends AdminbaseController{
	private $model;
	function _initialize() {
		parent::_initialize();
		$this->model = M('shop');
	}
	
	function index(){
		//实例化
		$users = M('users');
		
		//分页
		$count=$this->model->count();
		$page = $this->page($count, 20);

		//查询
		$shopInfo = $this->model->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//遍历
		foreach($shopInfo as $key => $val){
			$userInfo = $users->where(array("id"=>$val['uid']))->find();
			$shopInfo[$key]['uid'] = $userInfo['user_login'];
			$shopInfo[$key]['time'] = date('Y-m-d H:i:s',$val['time']);
		}

		$this->assign("Page", $page->show('Admin'));
		$this->assign("shopInfo",$shopInfo);
		$this->display();
	}
}
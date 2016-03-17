<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class RedController extends AppbaseController{
	function __controller(){
		parent::__controller();
	}
	
	
	function red(){
		//实例化
		$red = M("red");
		
		//分页
		$pageCount = 20;
		$page = "";
		if(I("post.page")){
			$page .= (I("post.page")-1)*$pageCount.",".$pageCount;
		}else{
			$page .="0,".$pageCount;
		}
		
		//查询语句
		$redInfo = $red->limit($page)->select();
		
		//执行判断操作
		if(!empty($redInfo)){
			$return['status'] = "success";
			$return['explain'] = "获取红包成功";
			$return['value'] = $redInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "查询红包失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	/**
	 * 开启红包
	 */
	function openRed(){
		$flag = true;
		
		//实例化
		$red = M("red");
		$rod = M("rob");
		
		//获取数据
		$data['money'] = I("post.money");
		$data['sid'] = I("post.sid");
		$data['nums'] = I('post.nums');
		$data['addtime'] = time();
		
		while ($flag){
			$coding = $this->randStr(10,"NUMBER");
			$r = $red->where("coding = ".$coding)->find();
			if (empty($r)){
				$flag = false;
				$data['coding'] = $coding;
			}
		}
		$result = $red->add($data);
		if($result){
			$return['status'] = "success";
			$return['explain'] = "发布红包成功";
			$return['value'] = $result;
			//分配红包，并写入数据库
			$total = $data['money'];
			$min = 0.01;
			
			for ($i=1; $i <= $data['nums']; $i++) {
				if($i == $data['nums']){
					$money = number_format($total,2,'.', '');
				}else{
					$safe = ($total-$min*($data['nums']-$i))/($data['nums']-$i)*100;//随机安全上限
					$money = mt_rand(1,$safe)/100;
					$total = $total-$money;
				}
				//组合数据
				$temp['coding'] = $data['coding'];
				$temp['sid'] = $data['sid'];
				$temp['money'] = $money;
				$temp['addtime'] = time();
				$rod->add($temp);
			}
		}else{
			$return['status'] = "error";
			$return['explain'] = "发布红包失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	/*
	 * 抢红包
	 */
	function GrabRed(){
		//实例化模型
		$red = M("red");
		$rob = M("rob");
		
		//获取
		$coding = I('post.coding');
		$data['status'] = 0;
			
		//获取数据
		$robInfo = $rob->where("coding = ".$coding." and status=1")->find();
		$redInfo = $red->where("coding =".$coding)->find();
		$da['get_nums'] = $redInfo['get_nums'] + 1;
		
		if (!empty($robInfo)){
			//执行修改操作
			$robUpdata = $rob->where("id =".$robInfo['id'])->data($data)->save();
			$redUpdata = $red->where("id =".$redInfo['id'])->data($da)->save();
			//判断是否成功
			if(!empty($robUpdata)){
				$robInfo['status'] = 0;
				$return['status'] = "success";
				$return['explain'] = "抢包成功";
				$return['value'] = $robInfo;
			}
		}else{
			$return['status'] = "error";
			$return['explain'] = "抢包已领完";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
}
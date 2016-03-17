<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class CommonController extends AppbaseController{

	function __controller(){
		parent::__controller();
	}
	
	//登录
	function Login(){
		//实例化模型
		$user = M('users');
		
		//获取用户信息
		$username = I('post.user_login');
		$password = md5(I('post.user_pass'));
		
		//执行查询操作
		$userInfo = $user->where("user_login = '$username' and user_pass = '$password'")->find();
		
		//执行判断操作
		if(!empty($userInfo)){
			$return['status'] = "success";
			$return['explain'] = "登录成功";
			$return['value'] = $userInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "登录失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	//注册
	function Register(){
		if(I("post.user_login") && I("post.user_pass")){
			//实例化模型
			$user = M('users');
			
			$username = I('post.user_login');
			
			$userInfo = $user->where("user_login = '$username'")->find();
			
			if(empty($userInfo)){
				$flag = true;
				$data['user_login'] = $username;
				$data['user_pass'] = md5(I("post.user_pass"));
				$data['user_type'] = 2;
				//生成用户的唯一标识
				while ($flag){
					$code = $this->randStr(8,"NUMBER");
					$r = $user->where("user_code = ".$code)->find();
					if (empty($r)){
						$flag = false;
						$data['user_code'] = $code;
					}
				}
				//写入数据库
				if($user->add($data)){
					$userInfo = $user->where("user_login = '$username'")->find();
					$return['status'] = "success";
					$return['explain'] = "注册成功";
					$return['value'] = $userInfo;
				}else{
					$return['status'] = "error";
					$return['explain'] = "注册失败";
					$return['value'] = null;
				}
			}else{
				$return['status'] = "success";
				$return['explain'] = "登录成功";
				$return['value'] = $userInfo;
			}
			$this->ajaxReturn($return);
		}
	}
}
<?php
namespace App\Controller;
use Common\Controller\AppbaseController;
class UserController extends AppbaseController{
	function __controller(){
		parent::__controller();
	}
	/**
	 * 修改头像
	 */
	function editAvatar(){
		//实例化模型
		$user = M('users');
		
		//获取id
		$uid = I("post.id");
		
		//上传功能
		$rootPath = SITE_PATH."data/upload/";
		$savePath = "avatar/";
		$url = $this->upload($rootPath, $savePath, $_FILES['file']);
		$data['avatar'] = $url;
		
		//更新操作
		$userInfo = $user->where("id = ".$uid)->data($data)->save();
		
		//判断是否获取成功
		if(!empty($userInfo)){
			$return['status'] = "success";
			$return['explain'] = "修改成功";
			$return['value'] = $userInfo;			
		}else{
			$return['status'] = "error";
			$return['explain'] = "修改失败";
			$return['value'] = null;			
		}
		$this->ajaxReturn($return);
	}
	
	/**
	 * 修改昵称
	 */
	function editNicename(){
		//实例化模型
		$user = M('users');
		
		//获取id
		$id = I('post.id');
		
		//获取名称
		$data['user_nicename'] = I('post.user_nicename');
		
		//执行更新操作
		$userInfo = $user->where("id = ".$id)->data($data)->save();
		
		//判断是否获取成功
		if(!empty($userInfo)){
			$return['status'] = "success";
			$return['explain'] = "修改成功";
			$return['value'] = $userInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "修改失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	/**
	 * 修改性别
	 */
	function editSex(){
		//实例化模型
		$user = M('users');
		
		//获取id
		$id = I('post.id');
		
		//获取性别
		$data['sex'] = I('post.sex');
		
		//获取性别属性
		$result = $user->where("id = ".$id)->data($data)->save();
		
		//判断是否成功
		if(!empty($result)){
			$return['status'] = "success";
			$return['explain'] = "修改成功";
			$return['value'] = $result;			
		}else{
			$return['status'] = "success";
			$return['explain'] = "修改失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	/**
	 * 修改微信号
	 */
	function editWeixin(){
		//实例化模型
		$user_attach = M('user_attach');
		
		//获取id
		$data['uid'] = I('post.id');
		
		//获取微信号
		$data['weixin'] = I('post.weixin');
		$result = $user_attach->where("uid = ".$data['uid'])->find();
		
		if(empty($result) && $result['weixin'] == ""){
			//执行修改操作
			$userInfo = $user_attach->add($data);
		}else{
			//执行修改操作
			$userInfo = $user_attach->where("uid =".$data['uid'])->save(array('weixin'=>$data['weixin']));
		}
		
		//判断是否获取成功
		if(!empty($userInfo)){
			$return['status'] = "success";
			$return['explain'] = "修改微信号成功";
			$return['value'] = $userInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "修改微信号失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
	
	/**
	 * 修改QQ号码
	 */
	function editQQ(){
		//实例化模型
		$user_attach = M('user_attach');
		
		//获取id
		$data['uid'] = I('post.id');
		
		//获取qq号
		$data['qq'] = I('post.qq');
		$result = $user_attach->where("uid = ".$data['uid'])->find();
		if(empty($result) && $result['qq'] == ""){
			//执行修改操作
			$userInfo = $user_attach->add($data);
		}else{
			//执行修改操作
			$userInfo = $user_attach->where("uid =".$data['uid'])->save(array('qq'=>$data['qq']));
		}
		
		//判断是否获取成功
		if(!empty($userInfo)){
			$return['status'] = "success";
			$return['explain'] = "修改微信号成功";
			$return['value'] = $userInfo;
		}else{
			$return['status'] = "error";
			$return['explain'] = "修改微信号失败";
			$return['value'] = null;
		}
		$this->ajaxReturn($return);
	}
}
<?php
/**
 * App接口类
 */
namespace Common\Controller;
use Think\Controller;
class AppbaseController extends Controller{
	function __construct(){
		parent::__construct();
		$this->checkSafeCode();
	}
	/**
	 * 校验安全码
	 */
	public function checkSafeCode()
    {
        $this->safecode = I('post.appid', '');
        if($this->safecode == C('API_SAFE_CODE')){
            return;
        }else{
            $this->error(3002);
        }
    }
    /**
    * Ajax方式返回数据到客户端
    */
    protected function ajaxReturn($data){
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data,$json_option));
    }
    //空操作
    public function _empty() {
        $this->error('该页面不存在！');
    }
    /**
     * 文件上传
     * @param unknown $rootPath 文件存放跟路径
     * @param unknown $savePath 保存的文件夹名
     * @param unknown $file 文件
     * @return string
     */
    public function upload($rootPath,$savePath,$file){
    	$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	$upload->rootPath  =     $rootPath; // 设置附件上传根目录
    	$upload->savePath  =     $savePath; // 设置附件上传（子）目录
    	$upload->saveName = array('uniqid','');
    	$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
    	$upload->autoSub  = true;
    	$upload->subName  = array('date','Ymd');
    	// 上传文件
    	$info   =   $upload->uploadOne($file);
    	if(!$info) {// 上传错误提示错误信息
    		$this->error($upload->getError());
    	}else{// 上传成功
    		return $info['savepath'].$info['savename'];
    	}
    }
    
    //随机生成6位数字
    public function randStr($len=6,$format='ALL') {
    	switch($format) {
    		case 'ALL':
    			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; break;
    		case 'CHAR':
    			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~'; break;
    		case 'NUMBER':
    			$chars='0123456789'; break;
    		default :
    			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
    			break;
    	}
    	mt_srand((double)microtime()*1000000*getmypid());
    	$password="";
    	while(strlen($password)<$len)
    		$password.=substr($chars,(mt_rand()%strlen($chars)),1);
    	return $password;
    }
    //随机产生六位数密码End
}
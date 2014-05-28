<?php

/**
 * 访问权限验证
 * Class AuthControl
 */
class AuthControl extends CommonControl {
	public function __construct() {
		parent::__construct();
		header('Cache-control: private, must-revalidate');
		if(!$this -> checkAccess()) {
			$this -> error("没有操作权限");
		}
	}

	//后台权限验证
	protected function checkAccess() {
		//没登录或普通用户
		if(!IN_ADMIN){
			go("Login/login");
		}
		if (WEB_MASTER || $_SESSION['rid']==1) {
			return true;
		}
		$nodeModel = M("node");
		$nodeModel -> where = array("app" => APP, "control" => CONTROL, "method" => METHOD, 'type' => 1);
		$node = $nodeModel -> field("nid") -> find();
		//node不存在的节点自动通过验证
		if (is_null($node)) {
			return true;
		} else {
			$AccessModel =M('access'); 
			$AccessModel -> where = array("nid" => $node['nid'], "rid" => session("rid"));
			return $AccessModel -> find();
		}
	}

}

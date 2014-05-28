<?php

/**
 * 访问权限验证
 * Class AuthControl
 */
class AuthControl extends CommonControl {
	public function __construct() {
		parent::__construct();
		header("Cache-Control: no-cache, must-revalidate");
		header("Cache-control: private");
		if (!$this -> checkAdminAccess()) {
			$this -> error("没有操作权限");
		}
	}

	//后台权限验证
	protected function checkAdminAccess() {
		//站长与超级管理员放行
		if (session("WEB_MASTER") || session('rid') == 1) {
			return true;
		}
		//没有登录用户或非后台管理员跳转到登录入口
		if (!IN_ADMIN) {
			echo "<script>top.location.href='?a=Admin&c=Login&m=login'</script>";
			exit ;
		}
		//检测后台权限
		$db = M("node");
		$db -> where = array("app" => APP, "control" => CONTROL, "method" => METHOD, 'type' => 1);
		$node = $db -> field("nid") -> find();
		//node不存在的节点自动通过验证
		if (is_null($node)) {
			return true;
		} else {
			$db -> table("access");
			$db -> where = array("nid" => $node['nid'], "rid" => session("rid"));
			return $db -> find();
		}
	}

}

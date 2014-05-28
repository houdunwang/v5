<?php
class VersionControl extends Control {
	//JSONP 验证HDCMS版本状态
	public function checkVersion() {
		C(require 'hd/Common/Config/version.php');
		$ServerVersion = str_replace('.', '', C('HDCMS_VERSION'));
		$ClientVersion = str_replace('.', '', $_GET['version']);
		if ($ServerVersion > $ClientVersion) {
			$url = 'http://bbs.houdunwang.com/thread-68308-1-1.html';
			$message = "HDCMS有更新！最新版本" . C('HDCMS_VERSION') . "<br/>";
			$message .= "<a href='$url' target='_blank' style='color:red;font-size:14px;'>立即获取</a>";
			$data = array('state' => 1, 'message' => $message);
		} else {
			$data = array('state' => 0, 'message' => '您使用的是最新彼HDCMS');
		}
		$this -> ajax($data);
	}

}

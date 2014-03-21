<?php
class IndexControl extends Control{
	//构造函数
	public function __init(){
			define("__TEMPLATE__",__ROOT__.'/template/default');
	}
	//显示网站首页
	public function index(){
		$this->display('template/default/index.html');
	}
	//显示栏目列表
	public function channel(){
		$cid = Q("cid",null,'intval');
		if($cid){
			$db = M('category');
			$this->field= $db->find($cid);
			$this->display('template/default/list.html');
		}
	}
}
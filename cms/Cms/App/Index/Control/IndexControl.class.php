<?php
class IndexControl extends Control{
	//构造函数
	public function __init(){
			define("__TEMPLATE__",'template/default');
	}
	public function index(){
		$this->display('template/default/index.html');
	}
}
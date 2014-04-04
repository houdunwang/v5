<?php

class RecoveryControl extends AuthControl{
	//显示备份数据
	public function index(){
		$data= 	Dir::tree('backup');
		$this->data =$data;
		$this->display();
	}
}
<?php

class RecoveryControl extends AuthControl{
	//显示备份数据
	public function index(){
		$data= Dir::tree('backup');
		$this->data =$data;
		$this->display();
	}
	//还原数据
	public function  recovery(){
		$dir = Q('dir');
		Backup::recovery(array('dir'=>'backup/'.$dir,'url'=>__CONTROL__));
	}
	//删除备份目录
	public function del(){
		$dir = Q('dir');
		if(Dir::del('backup/'.$dir)){
			$this->success('删除成功！','index');
		}else{
			$this->error('删除失败，请检查目录权限！','index');
		}
	}
}
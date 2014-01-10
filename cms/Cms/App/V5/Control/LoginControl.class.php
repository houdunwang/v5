<?php
//后台管理员登录与退出模块
class LoginControl extends Control{
	//会员登录
	public function login(){
		$this->display();	
	}
	//登录时的验证码显示
	public function code(){
		$code = new Code();
		$code->show();
	}
	//验证用户输入的验证码正确性
	public function checkCode(){
		$stat = strtoupper($_POST['code'])==$_SESSION['code']?1:0;
		$this->ajax($stat);
	}
}
<?php
//后台登录权限验证
class AuthControl extends Control{
	//构造函数
	public  function __init(){
		if(!session("aid")){
			$this->error('你还没有登录，请登录后操作','Login/login');
		}
	}
}
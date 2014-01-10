<?php
//后台登录操作
class IndexControl extends AuthControl{
    function index(){
     	$this->display();
    }
    //欢迎界面
    public function welcome(){
    	echo "欢迎使用V5 CMS";
    }
}
?>
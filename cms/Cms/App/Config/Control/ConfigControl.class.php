<?php
class ConfigControl extends AuthControl{
	//模型对象
	private $_db;
	//构造函数
	public function __init(){
		$this->_db= K("Config");
	}
	//设置配置项
	public function set_config(){
		if(IS_POST){
			if($this->_db->update_config()){
				go("set_config");
			}
		}else{
			$this->config= $this->_db->get_config();
			$this->display();
		}
	}
}
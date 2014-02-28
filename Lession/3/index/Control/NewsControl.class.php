<?php
class NewsControl extends Control{
	//模型对象
	private $_db;
	public function __init(){
		$this->_db = K('news');
	}
	//http://localhost/v5/3/index.php?c=News&m=content&id=1
	//显示文章内容
	function content(){
		$id = Q("get.id",NULL,'intval');
		if($id){
			$field = $this->_db->find($id);
			// $this->assign("field",$field);
			//http://localhost/v5/3/index.php?c=News&m=content&id=2
			$this->field = $field;
			$this->display();
		}
	}
}
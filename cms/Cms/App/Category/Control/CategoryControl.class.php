<?php
//栏目管理模块
class CategoryControl extends AuthControl{
	//数据模型对象
	private $_db;
	//构造函数
	public function __init(){
		$this->_db= K('Category');
	}
    	function index(){
    		$this->category = $this->_db->all();
    		$this->display();
    	}
    	//添加栏目
    	function add(){
    		if(IS_POST){
    			if($this->_db->add_category()){
    				$this->ajax(array('state'=>1,'message'=>'栏目添加成功'));
    				// $this->success('栏目添加成功 ！');
    			}else{
    				$this->ajax(array('state'=>0,'message'=>'栏目添加失败'));
    				// $this->error($this->_db->error);
    			}
    		}else{
    			$this->display();
    		}
   	 }
}
?>
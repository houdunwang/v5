<?php
//栏目模型 
class CategoryModel extends Model{
	//设置模型主表
	public $validate=array(
		array('cname','nonull','栏目名不能为空',2,3)
	);
	public $table ='category';
	//添加栏目
	public function add_category(){
		//create就是对数据执行自动验证（当然还有更多功能，后面说...)
		if($this->create()){
			//向表中写入数据
			return $this->add();
		}
	}
}
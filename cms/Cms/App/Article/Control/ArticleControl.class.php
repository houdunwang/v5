<?php
/**
* 文章管理
* @author houdunwang.com
*/
class ArticleControl extends AuthControl{
	//模型
	private $_db;
	//栏目缓存
	private $_category;
	//构造函数
	public function __init(){
		$this->_db= K('Article');
		//栏目缓存
		$this->_category= F("category");
	}
	//显示文章列表
	public function index(){
		$page = new Page($this->_db->count(),10);
		$this->page= $page->show(2);
		$this->article= $this->_db->limit($page->limit())->all();
		$this->display();
	}
	//添加文章
	public function add(){
		if(IS_POST){
			//通过模板完成文章的添加
			if($this->_db->add_article()){
				$this->success('添加成功','index');
			}else{
				$this->error('文章添加失败',$this->_db->error);
			}
		}else{
			$this->category= $this->_category;
			$this->display();
		}
	}
	//修改文章
	public function edit(){
		$id = Q("id",NULL,'intval');
		//必须传递修改文章的id
		if(!$id)$this->error('参数传递错误!');

		if(IS_POST){
			//将修改数据写入表
			if($this->_db->edit_article()){
				$this->success('修改成功','index');
			}else{
				$this->error('文章修改失败',$this->_db->error);
			}
		}else{
			$field = $this->_db->find($id);
			$this->field= $field;
			$this->category = $this->_category;
			$this->display();
		}

	}
}

















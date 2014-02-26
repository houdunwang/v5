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
		$page = new Page($this->_db->count(),1,1);
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
}

















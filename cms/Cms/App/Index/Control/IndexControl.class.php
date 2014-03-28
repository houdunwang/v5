<?php
class IndexControl extends Control{

	//构造函数
	public function __init(){
			define("__TEMPLATE__",__ROOT__.'/template/default');
	}
	//显示网站首页
	public function index(){
		$this->display('template/default/index.html');
	}
	//显示栏目列表
	public function channel(){
		$cid = Q("cid",null,'intval');
		if($cid){
			$db = M('category');
			$this->field= $db->find($cid);
			$this->display('template/default/list.html');
		}
	}
	//访问内容页
	public function article(){
		//访问文章的id
		$id = Q('id',null,'intval');
		if($id){
			$db=  K("ArticleView");
			$this->hdcms = $db->find($id);
			$this->display('template/default/content.html');
		}
	}
	//修改点击次数
	public function update_click(){
		$id = Q('id',null,'intval');
		if($id){
			$db = M('article');
			$db->inc('click',"id=$id",1);
			$click = $db->where("id=$id")->getField('click');
			echo  "document.write($click)";
			exit;
		}
	}
}
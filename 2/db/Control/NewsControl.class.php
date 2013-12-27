<?php
class NewsControl extends Control{
	function show(){
		$db = M("news");
		//分页
		//查询总条数
		$count = $db->count();
		//分页对象
		$page = new Page($count,2);
		$this->assign("page",$page->show());
		$data = $db->where($page->limit())->all();
		$this->assign("news",$data);
		$this->display();
	}
	//向文章表new表添加数据
	function  add(){
		if(IS_POST){
			$db = M("news");
			if($db->add()){
				$this->success("发表成功",'show');
			}else{
				$this->error('发表失败','show');
			}
		}else{
			$this->display();
		}
	}
}
<?php
class ArticleModel extends Model{
	//文章操作表
	public $table ='article';
	//自动完成（给字段赋值）
	public $auto=array(
		//文章发表时间字段处理（只在添加文章时处理）
		array('addtime','time','function',2,1),
		//获得文章的发布者管理员ID
		array('admin_id','get_adminid','method',2,3),
		//获得文章的发布者名称
		array('author','get_author','method',2,3),
	);
	//获得文章的发布者管理员ID
	public function get_adminid(){
		return session('aid');
	}
	//获得文章的发布者名称
	public function get_author(){
		return empty($_POST['author'])?session('username'):$_POST['author'];
	}
	//添加文章
	public function add_article(){
		if($this->create()){
			//如果有上传的图片数据时才进行缩略图上传处理
			if(!empty($_FILES['thumb']['name'])){
				//文章缩略图上传处理
				$upload = new Upload('upload/article/'.date("Y/m/d"));
				$file = $upload->upload();
				$this->data['thumb']=$file[0]['path'];
			}
			return $this->add();
		}
	}
}
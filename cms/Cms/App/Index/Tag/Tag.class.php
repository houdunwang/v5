<?php
class Tag{
	public $tag =array(
		'arclist'=>array('block'=>1,'level'=>3)
	);
	/**
	 * 获得文章数据
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _arclist($attr,$content){
		//显示条数
		$row = isset($attr['row'])?$attr['row']:10;
		//显示类型   hot 热门文章   new  最新文章
		$type = isset($attr['type'])?$attr['type']:'new';
		//标题长度
		$titlelen = isset($attr['titlelen'])?$attr['titlelen']:'10';
		//是否只获取有缩略图的文章 1获得只有图片的  0 有没有都行
		$image = intval(isset($attr['image'])?$attr['image']:0);
		//获得指定文章
		$id =intval(isset($attr['id'])?$attr['id']:0); 
		$php=<<<str
	<?php 
		\$db= M("article");
		\$type='$type';
		if($id){
			 \$db->where("id=$id");
		}
		if($image){
			\$db->where("thumb<>''");
		}
		switch(\$type){
			case 'hot':
				\$db->order('click desc');
			break;
			default:
				\$db->order('id desc');
		}
		\$result= \$db->limit($row)->all();
		if(\$result):
		foreach(\$result as \$field):
			\$field['title'] = mb_substr(\$field['title'], 0,$titlelen,'utf8');
			\$field['thumb']="__ROOT__/".\$field['thumb'];
		;?>
str;
		$php.=$content;
		$php.="<?php endforeach;endif;?>";
		return $php;
	}
}
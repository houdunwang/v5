<?php
class Tag{
	public $tag =array(
		'arclist'=>array('block'=>1,'level'=>3),
		'channel'=>array('block'=>1,'level'=>3),
		'pagelist'=>array('block'=>1,'level'=>3),
		'pagenum'=>array('block'=>0)
	);

	/**
	 * 栏目页的分页数据
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _pagelist($attr,$content){
		$row = isset($attr['row'])?intval($attr['row']):10;
		$php=<<<str
		<?php
		\$cid =\$_GET['cid'];
		\$data = Data::channelList(F("category"),\$cid,'','cid');
		\$tmp=array(\$cid);
		foreach(\$data as \$d){
			\$tmp[]=\$d['cid'];
		}
		\$where ="cid in(". implode(',',\$tmp).')';
		\$db=K('ArticleView');
		\$row =$row;
		\$page =new Page(\$db->where(\$where)->count(),\$row);
		\$result = \$db->where(\$where)->limit(\$page->limit())->all();
		if(\$result):
			foreach(\$result as \$field):
				\$field['caturl']=U('channel',array('cid'=>\$field['cid']));
		;?>
str;
		$php.=$content;
		$php.="<?php endforeach;endif;?>";
		return $php;
	}
	/**
	 * 分页页码
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _pagenum($attr,$content){
		$style=isset($attr['style'])?$attr['style']:2;
		return '<?php echo  $page->show('.$style.');?>';
	}
	/**
	 * 栏目标签
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function _channel($attr,$content){
		$type=isset($attr['type'])?$attr['type']:'self';
		$cid=isset($attr['cid'])?intval($attr['cid']):0;
		$php=<<<str
		<?php
		\$type='$type';
		\$cid=$cid?$cid:Q('cid',null,'intval');
		\$db = M('category');
		\$result=array();
		switch(\$type){
			case 'self'://显示同级栏目，需要栏目cid
			if(\$cid){
				\$pid = \$db->where("cid=\$cid")->getField('pid');
				\$result =\$db->where('pid=\$pid')->all();
			}
			break;
			case 'son'://子栏目,需要栏目cid
			if(\$cid){
				\$result =\$db->where('pid=$cid')->all();
			}
			break;
			case 'top'://一级栏目
			\$result = \$db->where('pid=0')->all();
			break;
		}
		if(\$result):
			foreach(\$result as \$field):
				\$field['url']=U('channel',array('cid'=>\$field['cid']));
		;?>
str;
		$php.=$content;
		$php.="<?php endforeach;endif;?>";
		return $php;
	}
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
		\$cid=\$_GET['cid'];
		\$db= M("article");
		\$type='$type';
		if(\$cid){
			\$db->where("catid=\$cid");
		}
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
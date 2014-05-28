<?php

/**
 * 前台内容模型
 */
class ContentIndexModel extends ViewModel {
	//表
	public $table;
	//副表
	protected $_stable;
	//模型mid
	protected $_mid;
	//栏目id
	protected $_cid;
	//文章id
	protected $_aid;
	//模型缓存
	protected $_model;
	//栏目缓存
	protected $_category;

	/**
	 * 构造函数
	 * $options=array('mid'=>模型mid)
	 */
	public function __init() {
		//----------------缓存数据
		$this -> _category = cache("category");
		$this -> _model = cache("model");
		$this -> _mid = Q('mid', null, 'intval');
		$this -> _cid = Q('cid', null, 'intval');
		$this -> _aid = Q('aid', null, 'intval');
		//主表
		$this -> table = $this -> _model[$this -> _mid]['table_name'];
		//副表
		$this -> _stable = $this -> table . '_data';
		//表关联
		$this -> view = array(
		//栏目表
		'category' => array('type' => INNER_JOIN, 'on' => $this -> table . '.cid=category.cid'), "user" => array('type' => INNER_JOIN, 'on' => $this -> table . '.uid=user.uid'), "model" => array('type' => INNER_JOIN, 'on' => 'model.mid=category.mid'), "content_tag" => array('type' => LEFT_JOIN, 'on' => $this -> table . '.aid=content_tag.aid'), );
		//副表关联
		$this -> view[$this -> _stable] = array('type' => INNER_JOIN, 'on' => $this -> table . ".aid={$this->table}_data.aid");
	}

	/**
	 * 获得文章内容
	 */
	public function get_one() {
		$field = $this -> join('category,user,model,' . $this -> _stable) -> where($this -> tableFull . '.aid=' . $this -> _aid) -> find();
		if ($field) {
			//获得tag
			$field['tag'] = $this -> get_tag($this -> _aid);
		}
		return $field;
	}

	/**
	 * 获得文章tag
	 * @param $aid 文章aid
	 * @return string
	 */
	public function get_tag($aid) {
		$pre = C('DB_PREFIX');
		$sql = "SELECT tag FROM {$pre}tag AS t JOIN {$pre}content_tag AS ct ON
                t.tid=ct.tid WHERE mid={$this->_mid} AND aid={$aid}";
		$tag_result = M() -> query($sql);
		$tag = '';
		if (!empty($tag_result)) {
			foreach ($tag_result as $t) {
				$url = U('Search/Search/search', array('g' => 'Hdcms', 'word' => $t['tag'], 'type' => 'tag'));
				$tag .= " <a href=\"$url\">{$t['tag']}</a>";
			}
		}
		return $tag;
	}

}

<?php
/**
 *内容添加/删除/修改操作
 * @author hdxj <houdunwangxj@gmail.com>
 */
class Content {
	private $_mid;
	private $_mode;
	public $error;
	public function __construct($mid) {
		$this -> _model = cache('model');
		$this -> _mid = $mid;
	}

	//获取单篇文章
	public function find($aid) {
		$ContentModel = ContentViewModel::getInstance($this -> _mid);
		$data = $ContentModel -> where($ContentModel -> tableFull . '.aid=' . $aid) -> find();
		if (!$data) {
			$this -> error = '文章不存在';
			return false;
		}
		$ContentOutModel = new ContentOutModel($this -> _mid);
		$data = $ContentOutModel -> get($data);
		if ($data == false) {
			$this -> error = $ContentOutModel -> error;
		} else {
			return $data;
		}
	}

	//添加文章
	public function add($data) {
		$ContentModel = ContentModel::getInstance($this -> _mid);
		if (!isset($this -> _model[$this -> _mid])) {
			$this -> error='模型不存在';
		}
		$ContentInputModel = new ContentInputModel($this -> _mid);
		$insertData = $ContentInputModel -> get($data);
		if ($insertData == false) {
			$this -> error = $ContentInputModel -> error;
			return false;
		}
		if ($ContentModel -> create($insertData)) {
			$result = $ContentModel -> add($insertData);
			$aid = $result[$ContentModel -> table];
			$this -> editTagData($aid);
			M('upload') -> where(array('uid' => $_SESSION['uid'])) -> save(array('state' => 1));
			return $aid;
		} else {
			$this -> error = $ContentModel -> error;
			return false;
		}
	}

	//修改文章
	public function edit($data) {
		$ContentModel = ContentModel::getInstance($this -> _mid);
		if (!isset($this -> _model[$this -> _mid])) {
			$this -> error('模型不存在');
		}
		$ContentInputModel = new ContentInputModel($this -> _mid);
		$editData = $ContentInputModel -> get($data);
		if ($editData == false) {
			$this -> error = $ContentInputModel -> error;
			return false;
		}
		if ($ContentModel -> create($editData)) {
			$result = $ContentModel -> save($editData);
			$aid = $result[$ContentModel -> table];
			$this -> editTagData($data['aid']);
			M('upload') -> where(array('uid' => $_SESSION['uid'])) -> save(array('state' => 1));
			return $aid;
		} else {
			$this -> error = $ContentModel -> error;
			return false;
		}
	}

	//修改Tag
	public function editTagData($aid) {
		$tagModel = M('tag');
		$contentTagModel = M("content_tag");
		//删除文章旧的tag记录
		$cid = Q('cid', 0, 'intval');
		$mid = Q('mid', 0, 'intval');
		$contentTagModel -> where(array('aid' => $aid, 'mid' => $mid)) -> del();
		//修改tag
		$tag = Q('tag');
		if ($tag) {
			$tag = String::toSemiangle($tag);
			$tagData = explode(',', $tag);
			if (!empty($tagData)) {
				$tagData = array_unique($tagData);
				foreach ($tagData as $tag) {
					$tid = $tagModel -> where(array('tag' => $tag)) -> getField('tid');
					if ($tid) {
						//修改tag记数
						$tagModel -> exe("UPDATE " . C('DB_PREFIX') . "tag SET `total`=total+1");
					} else {
						$tid = $tagModel -> add(array('tag' => $tag, 'total' => 1));
					}
					$contentTagModel -> add(array('aid' => $aid, 'uid' => $_SESSION['uid'], 'mid' => $mid, 'cid' => $cid, 'tid' => $tid));
				}
			}
		}
	}

	//删除文章
	public function del($aid) {
		$ContentModel = ContentModel::getInstance($this -> _mid);
		$data = $ContentModel -> find($aid);
		if (!$data) {
			$this -> error = '文章不存在';
			return false;
		}
		if ($ContentModel -> del($aid)) {
			//删除文章tag属性
			M('content_tag') -> where(array('mid' => $this -> _mid, 'cid' => $data['cid'])) -> del();
			return true;
		} else {
			$this -> error = '删除文章失败';
		}
	}

}

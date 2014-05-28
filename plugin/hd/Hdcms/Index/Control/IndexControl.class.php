<?php

/**
 * 网站前台
 * Class IndexControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class IndexControl extends PublicControl {
	//网站首页
	public function index() {
		$this -> display('template/' . C('WEB_STYLE') . '/index.html');
	}

	//内容页
	public function content() {
		$mid = Q('mid', 0, 'intval');
		$cid = Q('cid', 0, 'intval');
		$aid = Q('aid', 0, 'intval');
		if (!$mid || !$cid || !$aid) {
			$this -> error('参数错误', __ROOT__);
		}
		$ContentModel = new Content($mid);
		$field = $ContentModel -> find($aid);
		if ($field) {
			$field['time'] = date("Y/m/d", $field['addtime']);
			$field['date_before'] = date_before($field['addtime']);
			$field['commentnum'] = M("comment") -> where("cid=" . $cid . " AND aid=" . $aid) -> count();
			$this -> assign('hdcms', $field);
			$this -> display($field['template']);
		}		
	}

	//栏目列表
	public function category() {
		$mid = Q('mid', 0, 'intval');
		$cid = Q('cid', 0, 'intval');
		if (!$mid || !$cid) {
			$this -> error('参数错误');
		}
		$categoryCache = cache('category');
		if (!isset($categoryCache[$cid])) {
			$this -> error('栏目不存在', __ROOT__);
		}
		if ($cid) {
			$category = $categoryCache[$cid];
			//外部链接，直接跳转
			if ($category['cattype'] == 3) {
				go($category['cat_redirecturl']);
			} else {
				$Model = ContentViewModel::getInstance($mid);
				$where = C('DB_PREFIX') . 'category.cid=' . $cid . " OR pid=" . $cid;
				$category['content_num'] = $Model -> join('category') -> where($where) -> count();
				$childCategory = Data::channelList($categoryCache, $cid);
				$catWhere = array('cid' => array());
				if (!empty($childCategory)) {
					foreach ($childCategory as $cat) {
						$catWhere['cid'][] = $cat['cid'];
					}
				}
				$catWhere['cid'][] = $cid;
				$category['comment_num'] = intval( M('comment') -> where($catWhere) -> sum());
				//栏目模板
				switch ($category['cattype']) {
					case 1 :
						//普通栏目
						$tpl = $category['list_tpl'];
						break;
					case 2 :
						//封面栏目
						$tpl = $category['index_tpl'];
						break;
				}
				$tpl = 'template/' . C("WEB_STYLE") . '/' . $tpl;
				$this -> assign("hdcms", $category);
				$this -> display($tpl);
			}
		}
	}

}

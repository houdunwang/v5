<?php

/**
 * 网站前台
 * Class IndexControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class IndexControl extends PublicControl {
	//网站首页
	public function index() {
		$CacheTime = C('CACHE_INDEX') >= 1 ? C('CACHE_INDEX') : null;
		$this -> display('template/' . C('WEB_STYLE') . '/index.html', $CacheTime);
	}
	//内容页
	public function content() {
		$mid = Q('mid', 0, 'intval');
		$cid = Q('cid', 0, 'intval');
		$aid = Q('aid', 0, 'intval');
		if (!$mid || !$cid || !$aid) {
			_404();
		}
		$ContentAccessModel = K('ContentAccess');
		if (!$ContentAccessModel -> isShow($cid)) {
			$this -> error('你没有阅读权限');
		}
		$CacheTime = C('CACHE_CONTENT') >= 1 ? C('CACHE_CONTENT') : null;
		if (!$this -> isCache()) {
			$ContentModel = new Content($mid);
			$field = $ContentModel -> find($aid);
			if ($field) {
				$this -> assign('hdcms', $field);
				$this -> display($field['template'], $CacheTime);
			}
		} else {
			$this -> display(null, $CacheTime);
		}
	}

	//栏目列表
	public function category() {
		$mid = Q('mid', 0, 'intval');
		$cid = Q('cid', 0, 'intval');
		$cache = cache('category');
		if (!$mid || !$cid || !isset($cache[$cid])) {
			_404();
		}
		$cachetime = C('CACHE_CATEGORY') >= 1 ? C('CACHE_CATEGORY') : null;
		if (!$this -> isCache()) {
			$category = $cache[$cid];
			//外部链接，直接跳转
			if ($category['cattype'] == 3) {
				go($category['cat_redirecturl']);
			} else {
				$Model = ContentViewModel::getInstance($category['mid']);
				$catid = getCategory($category['cid']);
				$category['content_num'] = $Model -> join() -> where("cid IN(" . implode(',', $catid) . ")") -> count();
				$category['comment_num'] = intval( M('comment') -> where("cid IN(" . implode(',', $catid) . ")") -> count());
				$this -> assign("hdcms", $category);
				$this -> display($category['template'], $cachetime);
			}
		} else {
			$this -> display(null, $cachetime);
		}
	}

	//404页面
	public function _404() {
		$this -> display('template/system/404.html');
	}

	//加入收藏
	public function addFavorite() {
		if (!session("uid")) {
			$this -> error('请登录后操作');
		} else {
			$db = M('favorite');
			$data = array();
			$data['uid'] = $_SESSION['uid'];
			$data['mid'] = intval($_POST['mid']);
			$data['cid'] = intval($_POST['cid']);
			$data['aid'] = intval($_POST['aid']);
			if ($db -> where($data) -> find()) {
				$this -> error('已经收藏过');
			} else {
				$db -> add($data);
				$this -> success('收藏成功!');
			}
		}
	}
	//获得点击数
	public function getClick() {
		$mid = Q('mid', 0, 'intval');
		$aid = Q('aid', 0, 'intval');
		$modelCache = cache('model');
		$Model = M($modelCache[$mid]['table_name']);
		$result = $Model -> find($aid);
		$Model -> save(array('aid' => $result['aid'], 'click' => $result['click'] + 1));
		echo "document.write({$result['click']});";
		exit ;
	}
}

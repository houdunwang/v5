<?php
/**
 * 静态生成
 * @author hdxj <houdunwangxj@gmail.com>
 */
class Html extends Control {
	//首页
	public function index() {
		if (C('CREATE_INDEX_HTML') == 1) {
			$template = 'template/' . C('WEB_STYLE') . '/index.html';
			return $this -> createHtml('index', './', $template);
		}
		return true;
	}
	//内容页
	public function content($data) {
		if (!$data['iscontenthtml']) {
			return true;
		}
		$_REQUEST['mid'] = $data['mid'];
		$_REQUEST['cid'] = $data['cid'];
		$_REQUEST['aid'] = $data['aid'];
		$this -> assign('hdcms', $data);
		$info = explode('.', $data['htmlfile']);
		return $this -> createHtml(basename($info[0]), dirname($data['htmlfile']) . '/', $data['template']);
	}
	//栏目页
	public function category($cid, $page = 1) {
		$categoryCache = cache('category');
		$cat = $categoryCache[$cid];
		$GLOBALS['totalPage'] = 0;
		if ($cat['cat_url_type'] == 2 || $cat['cattype'] == 3) {
			return true;
		}
		//单文章
		if ($cat['cattype'] == 4) {
			$Model = ContentViewModel::getInstance($cat['mid']);
			$result = $Model -> join() -> where("cid={$cat['cid']}") -> find();
			if ($result) {
				$Content = new Content($cat['mid']);
				$data = $Content -> find($result['aid']);
				return $this -> content($data);
			}
		} else {
			//普通栏目与封面栏目
			$htmlDir = C("HTML_PATH") ? C("HTML_PATH") . '/' : '';
			$_REQUEST['page'] = $_GET['page'] = $page;
			$_REQUEST['mid'] = $cat['mid'];
			$_REQUEST['cid'] = $cat['cid'];
			$Model = ContentViewModel::getInstance($cat['mid']);
			$catid = getCategory($cat['cid']);
			$cat['content_num'] = $Model -> join() -> where("cid IN(" . implode(',', $catid) . ")") -> count();
			$cat['comment_num'] = intval( M('comment') -> where("cid IN(" . implode(',', $catid) . ")") -> count());
			$htmlFile = $htmlDir . str_replace(array('{catdir}', '{cid}', '{page}'), array($cat['catdir'], $cat['cid'], $page), $cat['cat_html_url']);
			$info = explode('.', $htmlFile);
			$this -> assign("hdcms", $cat);
			$this -> createHtml(basename($info[0]), dirname($htmlFile) . '/', $cat['template']);
			//第1页时复制index.html
			if ($page == 1) {
				copy($htmlFile, dirname($htmlFile) . '/index.html');
			}
			return true;
		}
	}
	//生成栏目分页列表
	public function relation_category($cid) {
		$cache = cache('category');
		$cat = $cache[$cid];
		if ($cat['cat_url_type'] == 2 || $cat['cattype'] == 3) {
			return true;
		}
		unset($GLOBALS['totalPage']);
		$d = $page = 1;
		do {
			$this -> category($cid, $page);
			$d++;
			$page++;
			$totalPage = $GLOBALS['totalPage'];
		} while($d<=$totalPage && $d<10);
		return true;
	}
}

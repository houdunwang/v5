<?php
/**
 * 静态处理模块
 * Class HtmlControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class HtmlControl extends AuthControl {
	public function __init(){
		defined("__TEMPLATE__") or define("__TEMPLATE__", __ROOT__ . "/template/" . C("WEB_STYLE"));
	}
	//生成首页
	public function create_index() {
		if (IS_POST) {
			$tpl = 'template/' . C('WEB_STYLE') . '/index.html';
			if (is_file($tpl)) {
				$this -> error = '模板文件不存在';
			}
			$content = $this -> fetch($tpl);
			if (file_put_contents('index.html', $content)) {
				$this -> success('首页生成完毕',__METH__,0);
			} else {
				$this -> error('创建文件失败');
			}
		} else {
			$this -> display();
		}
	}

	//创建栏目
	public function create_category() {
		if (IS_POST) {
			$categoryCache = cache("category");
			$category = array();
			//没有选择栏目
			if (count($_POST['cid']) == 1 && $_POST['cid'][0] == 0) {
				//生成所有栏目
				if ($_POST['mid'] == 0) {
					$HtmlCategory = $categoryCache;
				} else {
					$HtmlCategory = M('category') -> where(array('mid' => $_POST['mid'])) -> all();
				}
			} else {
				$HtmlCategory = M('category') -> where(array('cid' => $_POST['cid'])) -> all();
			}
			//删除单文章栏目
			$oldCategory = $HtmlCategory;
			foreach ($oldCategory as $id => $category) {
				if (!in_array($category['cattype'], array(1, 2))) {
					unset($HtmlCategory[$id]);
				}
			}
			if (empty($HtmlCategory)) {
				$this -> success("栏目生成完毕", '', 0);
			} else {
				//最终生成的栏目
				$createCategory = array();
				require 'hd/Hdcms/Index/Control/IndexControl.class.php';
				$Control = new IndexControl;
				$htmlDir = C("HTML_PATH") ? C("HTML_PATH") . '/' : '';
				foreach ($HtmlCategory as $cat) {
					$_REQUEST['cid'] = $cat['cid'];
					$_REQUEST['mid'] = $cat['mid'];
					ob_start();
					$Control -> category();
					$content = ob_get_clean();
					$htmlFile = $htmlDir . $cat['catdir'] . '/index.html';
					if (!is_dir(dirname($htmlFile))) {
						if (!Dir::create(dirname($htmlFile))) {
							$this -> error('创建目录失败');
						}
					}
					if (file_put_contents($htmlFile, $content)===false) {
						$this -> error("{$htmlFile}创建失败");
					}
					$pageTotal = Page::$staticTotalPage;
					$step_row = Q('step_row', 10, 'intval');
					$cat['pageTotal'] = $pageTotal;
					$cat['currentPage'] = $pageTotal;
					$cat['step_row'] = $step_row;
					$createCategory[$cat['cid']] = $cat;
				}
				F('createCategoryFile', $createCategory);
				$this -> success('初始化完成...', U('BatchCategory'), 0);
			}
		} else {
			F('createCategoryFile', null);
			$this -> assign('category', json_encode(cache("category")));
			$this -> assign('model', cache("model"));
			$this -> display();
		}
	}

	//批量生成栏目
	public function BatchCategory() {
		$createCategory = F('createCategoryFile');
		if (empty($createCategory)) {
			 F('createCategoryFile',null);
			$this -> success('所有栏目生成完毕...', U('create_category'));
		} else {
			require 'hd/Hdcms/Index/Control/IndexControl.class.php';
			$Control = new IndexControl;
			$htmlDir = C("HTML_PATH") ? C("HTML_PATH") . '/' : '';
			$category = current($createCategory);
			for ($i = 0; $i <= $category['step_row']; $i++) {
				$_REQUEST['cid'] = $category['cid'];
				$_REQUEST['mid'] = $category['mid'];
				//从最后一页开始生成
				$page = $_REQUEST['page'] = $_GET['page'] = $category['currentPage'];
				$htmlFile = $htmlDir . str_replace(array('{catdir}', '{cid}', '{page}'), array($category['catdir'], $category['cid'], $page), $category['cat_html_url']);
				ob_start();
				$Control -> category();
				$content = ob_get_clean();
				if (!is_dir(dirname($htmlFile))) {
					if (!Dir::create(dirname($htmlFile))) {
						$this -> error('创建目录失败');
					}
				}
				if (file_put_contents($htmlFile, $content)===false) {
					$this -> error("{$htmlFile}创建失败");
				}
				$category['currentPage']--;
				if ($category['currentPage'] <= 0) {
					unset($createCategory[$category['cid']]);
					F('createCategoryFile', $createCategory);
					$this -> success("[{$category['catname']}]生成完毕...", __METH__, 0);
				}
			}
			$createCategory[$category['cid']]=$category;
			F('createCategoryFile', $createCategory);
			$message = "生成栏目{$category['catname']}的下" . $category['step_row'] . "页,
                            共有{$category['pageTotal']}页
                            (<font color='red'>" . floor($category['currentPage'] / $category['pageTotal'] * 100) . "%</font>)";
			$this -> success($message, __METH__);
		}
	}

	//生成内容页
	public function create_content() {
		if (IS_POST) {
			$categoryCache = cache('category');
			//没有选择栏目
			if (count($_POST['cid']) == 1 && $_POST['cid'][0] == 0) {
				//生成所有栏目
				if ($_POST['mid'] == 0) {
					$HtmlCategory = $categoryCache;
				} else {
					$HtmlCategory = M('category') -> where(array('mid' => $_POST['mid'])) -> all();
				}
			} else {
				$HtmlCategory = M('category') -> where(array('cid' => $_POST['cid'])) -> all();
			}
			if (empty($HtmlCategory)) {
				F('createContentFile', null);
				$this -> success("栏目生成完毕");
			} else {
				//指定条件更新
				$where = array();
				if ($_POST['type'] != 'all') {
					//更新最新发布N条
					if (!empty($_POST['total_row'])) {
						$total_row = $_POST['total_row'];
					}
					//发布时间
					if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
						$where[] = 'addtime>=' . strtotime($_POST['start_time']) . " AND addtime<=" . strtotime($_POST['end_time']);
					}
					//起始与结束aid
					if (!empty($_POST['start_id']) && !empty($_POST['end_id'])) {
						$where[] = 'aid>=' . $_POST['start_id'] . " AND aid<=" . $_POST['end_id'];
					}
				}
				$modelCache = cache('model');
				//最终生成的栏目
				$createCategory = array();
				foreach ($HtmlCategory as $cat) {
					$cat['options']['step_row'] = Q('step_row', 20, 'intval');
					$cat['options']['currentNum'] = 0;
					$cat['options']['where'] = $where;
					$cat['options']['where'][] =C('DB_PREFIX').'category.cid=' . $cat['cid'];
					//总条数
					if (isset($total_row)) {
						$cat['options']['total_row'] = $total_row;
					} else {
						$table = $modelCache[$cat['mid']]['table_name'];
						$cat['options']['total_row'] = M($table) -> count();
					}
					$createCategory[$cat['cid']] = $cat;
				}
				F('createContentFile', $createCategory);
				$this -> success('初始化完成...', U('BatchContent'), 0);
			}
		} else {
			F('createContentFile', null);
			$this -> assign('category', json_encode(cache('category')));
			$this -> assign('model', cache('model'));
			$this -> display();
		}
	}

	//指生成内容页
	public function BatchContent() {
		$createCategory = F('createContentFile');

		if (empty($createCategory)) {
			$this -> success('所有文章生成完毕...', U('create_content'), 0);
		}
		$modelCache = cache('model');
		$categorycache = cache('category');
		$oldCategory = $createCategory;
		$htmlDir = C("HTML_PATH") ? C("HTML_PATH") . '/' : '';
		require 'hd/Hdcms/Index/Control/IndexControl.class.php';
		$Control = new IndexControl;
		foreach ($oldCategory as $id => $category) {
			$options = $category['options'];
			$contentModel = ContentViewModel::getInstance($category['mid']);
			$limit = $options['currentNum'] . ',' . $options['step_row'];
			$contentData = $contentModel -> join('category') -> where($options['where']) -> limit($limit) -> all();
			if (empty($contentData)) {
				unset($createCategory[$id]);
				F('createContentFile', $createCategory);
				$this -> success("{$category['catname']}生成完毕...", __METH__, 0);
			}
			foreach ($contentData as $content) {
				$_REQUEST['cid'] = $category['cid'];
				$_REQUEST['mid'] = $category['mid'];
				$_REQUEST['aid'] = $content['aid'];
				$time = getdate($content['addtime']);
				$htmlFile = $htmlDir . str_replace(array('{catdir}', '{y}', '{m}', '{d}', '{aid}'), array($category['catdir'], $time['year'], $time['mon'], $time['mday'], $content['aid']), $category['arc_html_url']);
				ob_start();
				$Control -> content();
				$content = ob_get_clean();
				if (!is_dir(dirname($htmlFile))) {
					if (!Dir::create(dirname($htmlFile))) {
						$this -> error('创建目录失败');
					}
				}
				if(file_put_contents($htmlFile, $content)===false){
					$this -> error("{$htmlFile}创建失败");
				}
			}
			$options['currentNum'] = $options['currentNum'] + $options['step_row'] - 1;
			if ($options['currentNum'] >= $options['total_row']) {
				unset($createCategory[$id]);
				F('createContentFile', $createCategory);
				$this -> success("[{$category['catname']}] 生成完毕...", __METH__, 0);
			} else {
				$createCategory[$id]['options']=$options;
				F('createContentFile', $createCategory);
				$createCategory[$id]['options'] = $options;
				$message = "[{$category['catname']}]
                                已经更新{$options['currentNum']}条
                                (<font color='red'>" . floor($options['currentNum'] / $options['total_row'] * 100) . "%</font>)";
				$this -> success($message, __METH__, 0);
			}
		}

	}

}

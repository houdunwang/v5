<?php

/**
 * 内容关键字搜索
 * Class IndexControl
 * @author <houdunwangxj@gmail.com>
 */
class SearchControl extends Control {

	//高级搜索
	public function index() {
		$this -> category =cache("category");
		$this -> model =cache("model");
		$this -> display("./template/plug/search.html");
	}

	//搜索内容
	public function search() {
		$word = Q('word');
		$categoryCache = cache('category');
		if (!$word) {
			$this -> error("搜索内容不能为空");
		} else {
			$cid = empty($_REQUEST['cid'])?null:intval($_GET['cid']);
			$mid =empty($_REQUEST['mid'])?1:intval($_GET['mid']);
			$_REQUEST['mid']=$mid;
			//=====================记录搜索词
			$SearchTotal = M('search')->where(array('word'=>$word))->getField('total');
			if($SearchTotal){
				M('search')->where(array('word'=>$word))->save(array('total'=>$SearchTotal+1));
			}else{
				M('search')->add(array('total'=>1,'word'=>$word,'mid'=>$_REQUEST['mid']));
			}
			
			if($cid && isset($categoryCache[$cid])){
				$_REQUEST['mid']=$mid =$categoryCache[$cid]['mid'];
			}
			$pre = C('DB_PREFIX');
			$seachType = Q('type', 'title');
			$modelCache = cache('model');
			$categoryCache = cache('category');
			$contentModel = ContentViewModel::getInstance($mid);
			$table = $modelCache[$mid]['table_name'];
			if ($seachType == 'tag') {
				$db = M();
				$countSql = "SELECT count(*) AS c FROM 
						(SELECT distinct(aid) FROM {$pre}tag AS t INNER JOIN {$pre}content_tag AS ct ON t.tid=ct.tid WHERE tag='{$word}' AND mid=1 GROUP BY aid) AS c";
				$count = $db -> query($countSql);
				$page = new Page($count[0]['c'], 15);
				$DataSql = "SELECT * FROM {$pre}category as cat JOIN {$pre}{$table} AS c  ON cat.cid = c.cid JOIN {$pre}content_tag AS ct  ON c.aid=ct.aid INNER 
										JOIN {$pre}tag AS t ON t.tid=ct.tid WHERE t.tag='{$word}' LIMIT " . $page -> limit(true);
				$data = $db -> query($DataSql);
			} else {
				$where = array();
				if ($cid) {
					$cids = getCategory($cid);
					$where[] = $pre . "category.cid IN(" . implode(',',$cids).")";
				}
				if (!empty($_GET['search_begin_time']) && !empty($_GET['search_end_time'])) {
					$where[] = "addtime>=" . strtotime($_GET['search_begin_time']) . " AND addtime<=" . $_GET['search_end_time'];
				}
				switch($seachType) {
					case 'title' :
						$where[] = "title like '%{$word}%'";
						$count = $contentModel -> join('category') -> where($where) -> count();
						$page = new Page($count, 15);
						$data = $contentModel -> join('category') -> where($where) -> all();
						break;
					case 'description' :
						$where[] = "description like '%{$word}%'";
						$count = $contentModel -> join('category') -> where($where) -> count();
						$page = new Page($count, 15);
						$data = $contentModel -> join('category') -> where($where) -> all();
						break;
					case 'username' :
						$where[] = "username like '%{$word}%'";
						$count = $contentModel -> join('category,user') -> where($where) -> count();
						$page = new Page($count, 15);
						$data = $contentModel -> join('category,user') -> where($where) -> all();
						break;
				}
			}
			$this -> assign('searchModel', $modelCache);
			$this -> assign('searchCategory', $categoryCache);
			$this -> assign('page', $page);
			$this -> assign('data', $data);
			$this -> display();
		}
	}

	/**热门搜索词
	 * 前台通过js调用
	 * <script type="text/javascript" src="__ROOT__/index.php?a=Search&c=Search&m=search_word&row=10"></script>
	 */
	public function search_word() {
		$row = Q("get.row", 10, "intval");
		$db = M("search");
		$result = $db -> limit($row) -> all();
		$str = "";
		if (!empty($result)) {
			foreach ($result as $field) {
				$field['url'] = __ROOT__ . '/index.php?a=Search&c=Search&m=search&word=' . $field['word'];
				$str .= " <a href='{$field['url']}'>{$field['word']}</a>";
			}
		}
		echo "document.write('" . addslashes($str) . "')";
		exit ;
	}

}

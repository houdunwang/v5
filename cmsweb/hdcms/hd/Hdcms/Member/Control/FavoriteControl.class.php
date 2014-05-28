<?php
/**
 * 收藏夹管理
 * Class FavoriteControl
 */
class FavoriteControl extends MemberAuthControl {
	//列表
	public function index() {
		$Model = K('Favorite');
		$where = C('DB_PREFIX') . 'favorite.uid=' . $_SESSION['uid'];
		$count = $Model -> join() -> where($where) -> count();
		$page = new Page($count, 10);
		$this -> data = $Model -> where($where) -> limit($page -> limit()) -> all();
		$this -> page = $page -> show();
		$this -> count = $count;
		$this -> display();
	}

	//删除收藏
	public function del() {
		$Model = M('favorite');
		$fid = Q('fid', 0, 'intval');
		if ($Model -> del($fid)) {
			$this -> success('删除成功');
		}
	}

}

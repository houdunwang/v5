<?php

/**
 * 空间列表
 * Class IndexControl
 */
class SpaceControl extends CommonControl {
	//会员空间
	public function index() {
		$u = preg_replace('@[^\w]@', '', Q('u'));
		$pre = C('DB_PREFIX');
		$sql = "SELECT uid,nickname,rname,r.rid,spec_num,credits,regtime,logintime,domain,icon FROM {$pre}user AS u
                INNER JOIN {$pre}role AS r ON u.rid=r.rid
                WHERE u.uid='{$u}' OR domain='{$u}'";
		if (!$user = M() -> query($sql)) {
			_404('会员不存在');
		}
		$user = $user[0];
		//--------------------------增加空间访问次数
		if (!isset($_SESSION['uid']) or ($_SESSION['uid'] != $user['uid'])) {
			$sql = "UPDATE {$pre}user SET spec_num=spec_num+1";
			M() -> exe($sql);
		}
		//---------------------------获得文章列表
		$where = 'uid=' . $user['uid'] . ' AND content_state=1 ';
		$db = M('content');
		$count = $db -> where($where) -> count();
		$page = new Page($count, 10);
		$data = $db -> where($where) -> limit($page -> limit()) -> all();
		$this -> data = $data;
		$this -> page = $page -> show();
		$this -> user = $user;
		//------------------------------获得访问数据
		$guest = $this -> getGuest($user['uid']);
		$this -> assign('guest', $guest);
		$this -> display();
	}

	/**
	 * 获得访客数据
	 * @param $uid 空间用户uid
	 */
	private function getGuest($uid) {
		$db = M('user_guest');
		//记录访客数据
		if (isset($_SESSION['uid']) && $uid != $_SESSION['uid']) {
			//没有访问时添加数据
			if (!$db -> where("guest_uid={$_SESSION['uid']} AND uid={$uid}") -> find()) {
				$db -> add(array('guest_uid' => $_SESSION['uid'], 'uid' => $uid));
			}
		}
		//获得访客数据
		$pre = C('DB_PREFIX');
		$sql = "SELECT guest_uid,nickname,icon FROM {$pre}user AS u JOIN {$pre}user_guest AS ug ON u.uid=ug.guest_uid
               		WHERE ug.uid={$uid} LIMIT 20";
		$guestData = $db -> query($sql);
		if (!empty($guestData)) {
			foreach ($guestData as $n => $g) {
				$guestData[$n]['icon'] = empty($g['icon']) ? __ROOT__ . '/data/image/user/100.png' : __ROOT__ . '/' . $g['icon'];
			}
		}
		return $guestData;
	}
}

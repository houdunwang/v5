<?php
/**
 * 会员动态
 */
class UserDynamicModel extends Model {
	public $table = 'user_dynamic';
	//记录会员动态
	public function addDynamic($uid, $content) {
		$data = array('uid' => $uid, 'addtime' => time(), 'content' => $content);
		return $this -> add($data);
	}

}

<?php
/**
 * 系统消息
 * @author hdxj<houdunwangxj@gmail.com>
 */
class SystemMessageModel extends Model {
	public $table = 'system_message';
	//添加系统消息
	public function addSystemMessage($uid,$message) {
		$data = array('uid' => $uid, 'sendtime' => time(), 'message' => $message, 'state' => 0);
		return $this -> add($data);
	}

}

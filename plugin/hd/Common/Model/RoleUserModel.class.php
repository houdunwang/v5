<?php
//前台会员角色管理
class RoleUserModel extends Model {
	public $table = 'role';
	//更新缓存
	public function updateCache() {
		$roleData = $this -> where(array('admin' => 0)) -> all();
		if (!cache('user', $roleData,ROLE_CACHE_PATH)) {
			$this -> error = '缓存更新失败';
			return false;
		} else {
			return true;
		}
	}

}

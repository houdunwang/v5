<?php

/**
 * 角色
 * Class RoleModel
 * @author hdxj <houdunwangxj@gmail.com>
 */
class RoleModel extends Model {
	public $table = 'role';
	//添加角色
	public function addRole($data) {
		$rname = $data['rname'];
		if (empty($data['rname'])) {
			$this -> error = '角色名不能为空';
		}
		if ($this -> where(array('rname' => $rname)) -> find()) {
			$this -> error = '角色已经存在';
			return false;
		}
		if ($this -> add($data)) {
			$this -> updateCache();
			return true;
		} else {
			return false;
		}
	}

	//添加角色
	public function editRole($data) {
		$rname = $data['rname'];
		if (empty($data['rname'])) {
			$this -> error = '角色名不能为空';
		}
		if ($this -> where("rname='$rname' AND rid!={$data['rid']}") -> find()) {
			$this -> error = '角色已经存在';
			return false;
		}
		if ($this -> save($data)) {
			$this -> updateCache();
			return true;
		} else {
			return false;
		}
	}

	//删除用户
	public function delRole($rid) {
		$this -> del($rid);
		M("user") -> where(1) -> save(array('rid' => 4));
		return $this->updateCache();
	}

	//更新缓存
	public function updateCache() {
		$role = $this -> all();
		if (!cache('role', $role)) {
			$this -> error = '缓存更新失败';
			return false;
		} else {
			return true;
		}
	}

}

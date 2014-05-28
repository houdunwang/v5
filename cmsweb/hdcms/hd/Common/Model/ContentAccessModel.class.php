<?php
/**
 * 内容发表权限验证
 * @author hdxj <houdunwangxj@gmail.com>
 */
class ContentAccessModel extends  Model {
	public $table='category_access';
	private $CheckAction = array('');
	private function HasAccess($cid){
		if(WEB_MASTER || session('rid')==1)return true;
		$AccessData = $this -> where("cid=$cid") -> all();
		if (empty($AccessData))
			return true;
	}
	//查看权限
	public function isShow($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['show'] == 1;
	}
	//删除权限
	public function isAdd($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['add'] == 1;
	}
	//编辑权限
	public function isEdit($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['edit'] == 1;
	}
	//编辑权限
	public function isDel($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['del'] == 1;
	}
	//排序
	public function isOrder($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['order'] == 1;
	}
	//审核文章
	public function isAudit($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['audit'] == 1;
	}
	//移动
	public function isMove($cid) {
		if($this->HasAccess($cid))return true;
		$RoleAccess = $this -> where("cid=$cid AND rid={$_SESSION['rid']}") -> find();
		return $RoleAccess['move'] == 1;
	}
}

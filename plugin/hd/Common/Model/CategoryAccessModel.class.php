<?php
/**
 * 栏目权限
 */
class CategoryAccessModel extends Model {
	public $table = 'category_access';
	//获得栏目权限
//	public function getCategoryAccessList($cid) {
//		$categoryModel = M('category');
//		if (!$categoryModel -> find($cid)) {
//			$this -> error = '栏目不存在';
//			return false;
//		}
//		$categoryAccess = array('admin' => '', 'user' => '');
//		$accessData = $this -> where(array('cid' => $cid)) -> all();
//		if (empty($accessData)) {
//			return $categoryAccess;
//		} else {
//			foreach ($accessData as $access) {
//				$roleType = $access['admin'] ? 'admin' : 'user';
//				$categoryAccess[$roleType][] = $access;
//			}
//			return $categoryAccess;
//		}
//	}

}

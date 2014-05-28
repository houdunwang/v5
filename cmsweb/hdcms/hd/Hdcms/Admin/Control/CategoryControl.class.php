<?php

/**
 * 栏目管理模块
 * Class CategoryControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class CategoryControl extends AuthControl {
	private $_category, $_model;
	//构造函数
	public function __init() {
		$this -> _category = cache("category");
		$this -> _model = cache("model");
	}
	/**
	 * 显示栏目列表
	 */
	public function index() {
		$this -> category = $this -> _category;
		//添加模型名称
		$this -> display();
	}

	//将栏目名称转拼音做为静态目录
	public function dir_to_pinyin() {
		$dir = String::pinyin(Q("catname"));
		echo $dir ? $dir : Q('catname');
		exit ;
	}

	//验证静态目录
	public function check_category_dir() {
		//验证静态目录
		$cid=Q('cid',0,'intval');
		$db = M('category');
		if($cid){
			$db->where="cid<>$cid";
		}
		$state = $db-> find(array('catdir' => Q('catdir')));
		echo $state ? 0 : 1;
		exit ;
	}

	//添加栏目到表
	public function add() {
		//添加栏目
		if (IS_POST) {
			$post = $_POST;
			$CategoryModel = K("Category");
			if (empty($post)) {
				$this -> error( '参数不能为空');
			}
			if ($CategoryModel -> addCategory($post)) {
				$this -> success('添加栏目成功');
			} else {
				$this -> error($CategoryModel -> error);
			}
		} else {
			$roles = cache('role', false);
			$adminRole = $userRole = array();
			foreach ($roles as $role) {
				if ($role['admin'] == 1) {
					$adminRole[] = $role;
				} else {
					$userRole[] = $role;
				}
			}
			$this -> assign('category', $this -> _category);
			$this -> assign('model', $this -> _model);
			$this -> assign('category', $this -> _category);
			$this -> assign('role_admin', $adminRole);
			$this -> assign('role_user',$userRole);
			$this -> display();
		}
	}

	//修改栏目到表
	public function edit() {
		$CategoryModel = K("Category");
		$cid = Q('cid', 0, 'intval');
		if (IS_POST) {
			$post = $_POST;
			if (empty($post)) {
				$this -> error( '参数错误');
			}
			if ($CategoryModel -> editCategory($post)) {
				$this -> success( '修改栏目成功');
			} else {
				$this -> error($CategoryModel -> error);
			}
		} else {
			$categoryCache = cache('category');
			$categoryData = $categoryCache[$cid];
			foreach ($categoryCache as $n => $cat) {
				$selected = $disabled = "";
				//父栏目select状态
				$selected = $categoryData['pid'] == $cat['cid'] ? 'selected=""' : '';
				//子栏目disabled
				$disabled = Data::isChild($categoryCache, $cat['cid'], $cid) ? 'disabled=""' : '';
				//当前栏目不可选
				if ($cid == $cat['cid']) {
					$disabled = 'disabled="disabled"';
				}
				$categoryCache[$n]['selected'] = $selected;
				$categoryCache[$n]['disabled'] = $disabled;
			}
			$categoryAccess = $CategoryModel -> getCategoryAccess($cid);
			//分配角色权限
			$this -> assign('access', $categoryAccess);
			$this -> assign('field', $categoryData);
			$this -> assign('category', $categoryCache);
			$this -> display();
		}
	}

	//更新栏目排序
	public function updateOrder() {
		$CategoryModel = K("Category");
		if ($CategoryModel -> updateOrder())
			$this -> success( '更改排序成功');
	}

	//更新栏目缓存
	public function updateCache() {
		$categoryModel = K('Category');
		if ($categoryModel -> updateCache()) {
			$this -> success('更新缓存成功');
		} else {
			$this -> error( $categoryModel -> error);
		}
	}

	//删除栏目
	public function del() {
		$cid = Q('cid', 0, 'intval');
		if (!$cid) {
			$this -> error('参数错误');
		}
		$categoryModel = K('Category');
		if ($categoryModel -> delCategory($cid)) {
			$this -> success('删除栏目成功');
		} else {
			$this -> success($categoryModel -> error);
		}
	}

	//批量编辑栏目
	public function BulkEdit() {
		$CategoryModel = K('Category');
		if (Q('post.BulkEdit')) {
			foreach ($_POST['cat'] as $data) {
				$CategoryModel -> save($data);
			}
			//更新缓存
			$CategoryModel -> updateCache();
			$this -> success('修改成功');
		} else {
			$cid = $_POST['cid'];
			$data = $CategoryModel -> where($cid) -> all();
			if ($data) {
				$this -> data = $data;
				$this -> display();
			}
		}
	}

}

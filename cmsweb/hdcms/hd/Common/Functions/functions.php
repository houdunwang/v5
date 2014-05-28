<?php
if (!defined("HDPHP_PATH"))
	exit ;

/**
 * HDCMS缓存函数
 * @param String $name 缓存KEY
 * @param bool $value 删除缓存
 * @return bool
 */
function cache($name, $value = false, $CachePath = 'data/cache/Data') {
	if ($value === false) {
		return F($name, false, $CachePath);
	} else {
		return F($name, $value, $CachePath);
	}
}

/**
 * 获得栏目
 * @param int $cid 栏目cid
 * @param int $type 1 子栏目  2 父栏目
 * @param int $returnType 1 只有cid  2 内容
 */
function getCategory($cid, $type = 1, $return = 1) {
	$cache = cache('category');
	$cat = $catid = array();
	if ($type == 1) {//子栏目
		$cat = Data::channelList($cache, $cid);
	} else if ($type == 2) {//父栏目
		$cat = parentChannel($cache, $cid);
	}
	if ($return == 1) {//返回cid
		foreach($cat as $c){
			$catid[]=$c['cid'];
		}
		$catid[] = $cid;
		return $catid;
	} else if ($return == 2) {//返回所有栏目数据
		$cat[] = $cache[$cid];
	}
	return $cat;
}

//获得栏目url（主要用于模型标签使用）
function getCategoryUrl($field) {
	return Url::getCategoryUrl($field);
}

//添加会员动态
function addDynamic($uid, $conent) {
	K('UserDynamic') -> addDynamic($uid, $conent);
}

//发送系统信息
function addSystemMessage($uid, $message) {
	K('SystemMessage') -> addSystemMessage($uid, $message);
}

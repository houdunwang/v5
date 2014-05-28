<?php
/**
 * 更新缓存
 * @author hdxj <houdunwangxj@gmail.com>
 */
class CacheControl extends AuthControl {
	public function updateCache() {
		$ActionCache = F('updateCache');
		if ($ActionCache) {
			$action = array_shift($ActionCache);
			F('updateCache', $ActionCache);
			switch($action) {
				case "Config" :
					$Model = K("Config");
					$Model -> updateCache();
					$this -> success('网站配置更新完毕...', U("updateCache"), 0);
					break;
				case "Model" :
					$Model = K("Model");
					$Model -> updateCache();
					$this -> success('模型更新完毕...', U("updateCache"), 0);
					break;
				case "Field" :
					$Model = new ModelFieldModel(1);
					$ModelCache = cache("model");
					foreach ($ModelCache as $mid => $data) {
						$Model -> updateCache($mid);
					}
					$this -> success('字段更新完毕...', U("updateCache"), 0);
					break;
				case "Category" :
					$Model = K("Category");
					$Model -> updateCache();
					$this -> success('栏目更新完毕...', U("updateCache"), 0);
					break;
				case "Node" :
					$Model = K("Node");
					$Model -> updateCache();
					$this -> success('权限节点更新完毕...', U("updateCache"), 0);
					break;
				case "Table" :
					cache('table',null);
					$this -> success('数据表更新完毕...', U("updateCache"), 0);
					break;
				case "Role" :
					$Model = K("Role");
					$Model -> updateCache();
					$this -> success('角色更新完毕...', U("updateCache"), 0);
					break;
				case "Flag" :
					$Model = new FlagModel(1);
					$ModelCache = cache("model");
					foreach ($ModelCache as $mid => $data) {
						$Model -> updateCache($mid);
					}
					$this -> success('Flag更新完毕...', U("updateCache"), 0);
					break;
			}
		} else {
			Dir::del('temp');
			$this -> success('缓存更新成功...', U('index'), 0);
		}
	}

	//结束
	public function index() {
		if (IS_POST) {
			$Action = Q('Action');
			F("updateCache", $Action);
			$this -> success('准备更新...', U('updateCache'),1);
		} else {
			$this -> display();
		}
	}

}

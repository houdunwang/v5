<?php
/**
 * 权限模型
 * Class AccessModel
 * @author hdxj <houdunwangxj@gmail.com>
 */
class ConfigModel extends Model {
	public $table = "config";
	//修改配置文件
	public function saveConfig($configData) {
		if (!is_array($configData)) {
			$this -> error = '数据不能为空';
			return false;
		}
		//SESSION域名验证
		$sessionDomain = trim($configData['SESSION_DOMAIN'],'.');
		if(!empty($sessionDomain) && !strpos(__ROOT__, $sessionDomain)){
			$this->error='SESSION域名设置错误';
			return false;
		}
		//Cookie有效域名
		$cookieDomain = trim($configData['COOKIE_DOMAIN'],'.');
		if(!empty($cookieDomain) && !strpos(__ROOT__, $cookieDomain)){
			$this->error='COOKIE域名设置错误';
			return false;
		}
		//上传文件大小
		if(intval($configData['ALLOW_SIZE'])<100000){
			$this->error='上传文件大小不能小于100KB';
			return false;
		}
		//允许上传类型
		if(empty($configData['ALLOW_TYPE'])){
			$this->error='允许上传类型不能为空';
			return false;
		}
		//伪静态检测
		if($configData['OPEN_REWRITE']==1 && !is_file('.htaccess')){
			$this->error='.htaccess文件不存在，开启Rewrite失败';
			return false;
		}
		$configData = array_change_key_case_d($configData, 1);
		foreach ($configData AS $name => $value) {
			$this -> where(array('name' => $name)) -> save(array('name' => $name, 'value' => $value));
		}
		return $this -> updateCache();
	}

	//更新配置文件
	public function updateCache() {
		$configData = $this -> order('order_list ASC') -> all();
		$data = array();
		foreach ($configData as $c) {
			$name = strtoupper($c['name']);
			$data[$name] = $c['value'];
		}
		//写入配置文件
		$content = "<?php if (!defined('HDPHP_PATH')) exit; \nreturn " . var_export($data, true) . ";\n?>";
		return file_put_contents("data/config/config.inc.php", $content);
	}

}

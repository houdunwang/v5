<?php
/**
 * 前台使用的公共控制器
 * Class PublicControl
 */
class PublicControl extends CommonControl {
	//缓存目录
	public $cacheDir;
	// 构造函数
	public function __construct() {
		parent::__construct();
		//网站开启验证
		if (!$this -> verification()) {
			$this -> display("Template/system/site_close.html");
			exit ;
		}
		$this -> cacheDir = 'temp/Content/' . substr(md5(__URL__), 0, 3);
	}

	// 网站是否开启
	private function verification() {
		return session('admin') || C("web_open");
	}
	//视图缓存检测
	protected function isCache($cachePath = null){
		return parent::isCache($this -> cacheDir);
	}
	// 界面显示
	protected function display($tplFile = null, $cacheTime = null, $cachePath = null, $stat = false, $contentType = "text/html", $charset = "", $show = true) {
		//验证模板文件
//		if (is_file($tplFile) && is_readable($tplFile)) {
			$cacheDir = $this->cacheDir;
			parent::display($tplFile, $cacheTime, $cacheDir);
//		}
	}

}

<?php
/**
 * 文件存储
 * @author hdxj <houdunwangxj@gmail.com>
 */
class FileStorage {
	private $contents = array();
	/**
	 * 储存内容
	 * @param string $fileName 文件名
	 * @param string $content 数据
	 */
	public function save($fileName, $content) {
		$dir = dirname($fileName);
		Dir::create($dir);
		if (file_put_contents($fileName, $content) === false) {
			halt("创建文件{$fileName}失败");
		}
		$this -> contents[$fileName] = $content;
		return true;
	}

	/**
	 * 获得
	 * @param string $fileName 文件名
	 */
	public function get($fileName) {
		if (isset($this -> contents[$fileName])) {
			return $this -> contents[$fileName];
		}
		if (!is_file($fileName)) {
			return false;
		}
		$content = file_get_contents($fileName);
		$this -> contents[$fileName] = $content;
		return $content;
	}

}

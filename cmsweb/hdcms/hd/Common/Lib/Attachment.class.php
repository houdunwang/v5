<?php
/**
 * 附件处理类
 * @author hdxj <houdunwangxj@gmail.com>
 */
class Attachment {
	//下载附件
	public function download($value, $ext = array('jpg','gif','jpeg','png'), $mid = 0, $fileSavePath = null) {
		$fileSavePath = $this -> setSavePath($fileSavePath);
		$uploadModel = M('upload');
		if (!function_exists('curl_init')) {
			return $value;
		}
		$ext = implode('|', $ext);
		$curl = curl_init();
		if (!preg_match_all('/(href|src)=([\'"]?)([^\'">]+\.(' . $ext . '))\2/is', $value, $matchData, PREG_PATTERN_ORDER)) {
			return $value;
		}
		//远程文件
		$remoteData = array();
		$oldPath = $newPath = array();
		foreach ($matchData[3] as $match) {
			if (strpos($match, '://') == false) {
				continue;
			}
			//扩展名
			$fileInfo = pathinfo($match);
			$newFileName = mt_rand(1, 10000) . time();
			$newfile = $this -> getFileName(array('filename' => $newFileName, 'extension' => '.' . $fileInfo['extension'], 'dirname' => $fileSavePath));
			$oldPath[] = $match;
			$newPath[] = __ROOT__ . '/' . $newfile;
			curl_setopt($curl, CURLOPT_URL, $match);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			//超时时间
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			//结果保存在字符串中
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$fileData = curl_exec($curl);
			if ($fileData != false && curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
				$state = $this -> saveFile($newfile, $fileData);
				if ($state) {
					$isImage = preg_match('/jpeg|jpg|png|gif/i', $match);
					$TableData = array('name' => $fileInfo['filename'], 'filename' => $newFileName, 'basename' => $newFileName . $fileInfo['extension'], 'path' => $fileSavePath . '/' . $newFileName . '.' . $fileInfo['extension'], 'ext' => $fileInfo['extension'], 'image' => $isImage, 'size' => filesize($newfile), 'uptime' => time(), 'state' => 0, 'uid' => $_SESSION['uid'], 'mid' => $mid);
					$uploadModel -> add($TableData);
					$value = str_replace($oldPath, $newPath, $value);
				}
			}
		}
		return $value;
	}

	//文件储存目录
	private function setSavePath($path) {
		$path = $path ? $path : C('UPLOAD_PATH') . '/content/' . date('Y/m/d');
		if (!is_dir($path)) {
			Dir::create($path);
		}
		return trim($path, '/');
	}

	//储存文件
	public function saveFile($file, $data) {
		$res = @fopen($file, 'w');
		if ($res==false) {
			return false;
		}
		if (fwrite($res, $data)==false) {
			return false;
		}
		if (fclose($res) == false) {
			return false;
		}
		return true;
	}

	/**
	 * 储存的文件名
	 * $set=array('filename'=>'主文件名','extension'=>扩展名,'dirname'=>路径)
	 */
	private function getFileName($set = array()) {
		return $set['dirname'] . '/' . $set['filename'] . $set['extension'];
	}

}

<?php
/**
 * 数据表操作
 */
class TableControl extends AuthControl {
	public function contentReplace() {
		if (IS_POST) {			$WHERE = !empty($_POST['replacewhere']) ? " WHERE {$_POST['replacewhere']}" : '';
			$VALUE = "replace({$_POST['field']},'{$_POST['searchcontent']}','{$_POST['replacecontent']}')";
			$sql = "UPDATE " . $_POST['table'] . " SET {$_POST['field']}=$VALUE $WHERE";
			if ( M() -> exe($sql)) {
				$this -> success('替换成功!');
			} else {
				$this -> error('替换失败...');
			}
		} else {
			$tableCache = cache('table');
			if (!$tableCache) {
				$Model = M();
				$tableInfo = $Model -> getTableInfo();
				$tables = $tableInfo['table'];
				cache('table', $tables);
				$tableCache = $tables;
			}
			$this -> assign("tablesJson", json_encode($tableCache));
			$this -> assign('tables', $tableCache);
			$this -> display();
		}
	}

	//验证码
	public function code() {
		$code = new Code();
		$code -> show();
	}

	//验证码验证
	public function checkCode() {
		if (empty($_POST['code'])) {
			echo 0;
			exit ;
		} else if (strtoupper($_POST['code']) != $_SESSION['code']) {
			echo 0;
			exit ;
		} else {
			echo 1;
			exit ;
		}
	}

}

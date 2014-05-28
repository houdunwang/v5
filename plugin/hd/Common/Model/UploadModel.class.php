<?php
//附件表
class UploadModel extends  ViewModel {
	public $table = 'upload';
	public $view = array('user' => array('type' => INNER_JOIN, 'on' => 'upload.uid=user.uid'));
}
?>

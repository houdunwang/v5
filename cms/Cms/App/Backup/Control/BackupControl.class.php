<?php
//网站备份
class BackupControl extends AuthControl{

    //备份设置
    public function set(){
    	  $this->display();
    }
    //执行备份任务
    public function backup(){
    	$url = U("Recovery/index");
    	Backup::backup(
    			array(
    				'url'=>$url,
    				'size'=>Q("size",null,'intval'),
    				'step_time'=>Q('step_time',null,'intval')
    			)

    	);
    }
}
?>
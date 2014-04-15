<?php
//测试控制器类
class IndexControl extends Control{
	public function __init(){
		if(is_file('lock.php')){
			$this->error('请删除lock.php文件后安装',dirname(__ROOT__));
		}
	}
	//欢迎界面
    	public function index(){
        	$this->display();
    	}
    	/**
    	 * CMS系统的目录、函数、扩展库检测
    	 * @return [type] [description]
    	 */
    	public function check(){
    		//需要检测的目录
    		$dir=array(
    			'../backup',
    			'../Data',
    			'../Data/cache',
    			'../Data/config',
    			'../upload'
    		);
    		//函数检测
    		$functions=array(
    			'mb_substr',
    			'mysql_connect',
    			'imagecreatetruecolor'
    		);
    		$this->dir= $dir;
    		$this->functions=$functions;
    		$this->display();
    	}
    	//设置数据库连接
    	public function set_db(){
    		if(IS_POST){
    			if(!mysql_connect($_POST['DB_HOST'],$_POST['DB_USER'],
    				$_POST['DB_PASSWORD'])){
    				$this->error('数据库帐号或密码错误');
    			}
    			//创建数据库
    			mysql_query("CREATE DATABASE IF NOT EXISTS ".$_POST['DB_DATABASE'].' CHARSET UTF8');
    			//数据库连接正常
    			C($_POST);
    			$db_prefix=$_POST['DB_PREFIX'];
    			$db = M();
    			//导入数据
    			$files = Dir::tree('db');
    			foreach($files as $f){
    				require $f['path'];
    			}
    			//修改配置文件
    			$config = array(
    'DB_HOST'                       =>$_POST['DB_HOST'], //数据库连接主机  如127.0.0.1
    'DB_PORT'                       => $_POST['DB_PORT'],        //数据库连接端口
    'DB_USER'                       => $_POST['DB_USER'],      //数据库用户名
    'DB_PASSWORD'                   => $_POST['DB_PASSWORD'],          //数据库密码
    'DB_DATABASE'                   => $_POST['DB_DATABASE'],          //数据库名称
    'DB_PREFIX'                  => $_POST['DB_PREFIX'],          //表前缀
    );
    			$data="<?php
if(!defined('HDPHP_PATH'))exit;\nreturn ".var_export($config,true).";\n?>";
    			file_put_contents('../data/config/db.inc.php', $data);
    			//更新管理员信息
    			$db->table('admin')->save(array(
    				'aid'=>1,
    				'username'=>$_POST['username'],
    				'password'=>md5($_POST['password'])));
    			touch('lock.php');
    			$this->root=dirname(__ROOT__);
    			$this->display('success');
    		}else{
    			$this->display();
    		}
    	}
}
?>
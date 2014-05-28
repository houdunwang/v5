<?php
if (!defined('HDPHP_PATH')) exit('No direct script access allowed');
$globalConfig = require './data/config/config.inc.php';
$config = array(
 		//数据库驱动
		'DB_DRIVER'                     => 'mysql',   
		 //数据库持久链接
		'DB_PCONNECT'                     => true,  
        //标签
        'TPL_TAGS' => array(
            '@@.Common.Lib.ContentTag'
        ),
        //自动加载文件
        'AUTO_LOAD_FILE' => array(
            'hd/Common/Functions/functions.php'
        ),
        //404跳转url
        '404_URL' => '',
        //session处理
        'SESSION_ENGINE' => 'mysql',
        //普通模式 GET方式
        'URL_TYPE' => 2, 
        //默认组
        'DEFAULT_GROUP' => 'Hdcms',
        //默认应用
        'DEFAULT_APP' => 'Index',
        //模板后缀
        'TPL_FIX' => '.php',
        //图片上传缩放开启
        'UPLOAD_IMG_RESIZE_ON' => true,
        //编辑器上传文件储存位置
        'EDITOR_SAVE_PATH' => ROOT_PATH . 'upload/editor/' . date('Y/m/d/'), //文件储存目录
        'TPL_ERROR' => 'hd/Common/Template/error.html', //错误页面
        'TPL_SUCCESS' => 'hd/Common/Template/success.html', //正确页面
        
    );
//首页或Index应用时设置Rewrite规则
if(!isset($_GET['a']) || (!isset($_GET['g']) || $_GET['a']=='Index')){
	//url重写模式
    $config['URL_REWRITE']=intval($globalConfig['open_rewrite']);
    //类型1 pathinfo  2 普通GET方式
	$config['URL_TYPE']=intval($globalConfig['pathinfo_type'])?1:2;
	$config['ROUTE']=array(
            //首页分页
            '/^(\d+).html$/'=>'Index/Index/index/page/#1',
            //栏目
            '/^list_(\d+)_(\d+).html$/'=>'Index/Category/category/mid/#1/cid/#2',
            //栏目分页
            '/^list_(\d+)_(\d+)_(\d+).html$/'=>'Index/Category/category/mid/#1/cid/#2/page/#3',
            //普通文章
            '/^(\d+)_(\d+)_(\d+).html$/'=>'Index/Article/show/mid/#1/cid/#2/aid/#3',
            //单文章
            '/^single_(\d+).html$/'=>'Index/Single/show/cid/#1',
            //个人主页
            '/^([0-9a-z]+)$/'=>'a=Member&c=Space&m=index&u=#1',
		);
}
return array_merge(
	//网站配置
    $globalConfig,
    //数据库
    require './data/config/db.inc.php',
    $config
    
);

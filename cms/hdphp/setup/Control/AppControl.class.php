<?php
if (!defined("PATH_HD")) exit('No direct script access allowed');
/**
 * Copyright    [HDPHP框架] (C)2011-2012 houdunwang.com ,Inc.
 * Licensed     www.apache.org/licenses/LICENSE-2.0
 * Encoding     UTF-8
 * Version      $Id: appControl.php   2012-5-13  9:32:35
 * @author      向军  houdunwangxj@gmail.com
 * Link         www.hdphp.com
 */
class AppControl extends AuthControl {

    function index() {
        $this->display();
    }
    function setup() {
        $post = $_POST;
        $file = $post['path_root'] .'/'. trim($post['filename'], '.php') . '.php';
        $appgroup = empty($post['appgroup']) ? '' : "\tdefine('APP_GROUP','{$post['appgroup']}');//应用组目录 \n";
        $appname = empty($post['appname']) ? '' : "\tdefine('APP_NAME','{$post['appname']}');//应用名 \n";
        $compile = $post['compile'] ? "\tdefine('COMPILE',true);//是否生成核心编译文件\n" : "define('COMPILE',false);//是否生成核心编译文件 \n";
        $path_hdphp = dirname(PATH_ROOT).'/hdphp/hdphp.php';
        $str = '<?php ' . "\n\t//www.hdphp.com 向军\n" . $appgroup .
                $appname .
                $compile .
                "\tinclude '$path_hdphp'; //HD框架核心包 \n" .
                '?>';
        $appgroup = empty($post['appgroup']) ? $post['appgroup'] : $post['appgroup'] . '/';

        $url = $post['root'].'/'.basename($file);
        $appDir = PATH_ROOT . '/' . $appgroup . $post['appname'];
        //删除缓存
        $cachefiles = glob($_POST['path_root'].'/temp/*');

        foreach ($cachefiles as $v) {
            $fileName = basename($v);
            if (in_array($fileName, array("log", "Session"))) {
                continue;
            }
            Dir::del($v);
        }
        if (is_dir($appDir)) {
            $this->error("应用{$post['appname']}已经创建，请删除后再创建");
        }
        if (is_file($file)) {
            $this->error("单入口文件已经存在");
        }
        if (file_put_contents($file, $str)) {
            $this->success("单入口文件创建成功", $url);
        } else {
            $this->error('文件创建失败，请检查目录权限');
        }
    }

}

?>

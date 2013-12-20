<?php
if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
//.-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.05
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com.All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * 生成编译文件
 * @package hdphp
 * @supackage core
 * @author hdxj<houdunwangxj@gmail.com>
 */
final class Boot
{
    static private $_dirs = array(); //初始目录
    static private $_compile = ''; //编译内容
    /**
     * 运行框架
     * 在单入口文件引入框架hdphp.php文件会自动执行run()方法，所以不用单独执行run方法
     * @access public
     * @return void
     */
    static public function run()
    {
        define("DS", DIRECTORY_SEPARATOR); //目录分隔符
        define("IS_WIN", strstr(PHP_OS, 'WIN') ? true : false); //window环境
        define("HDPHP_DATA_PATH", HDPHP_PATH . 'Data/'); //数据目录
        define("HDPHP_LIB_PATH", HDPHP_PATH . 'Lib/'); //lib目录
        define("HDPHP_CONFIG_PATH", HDPHP_PATH . 'Config/'); //配置目录
        define("HDPHP_CORE_PATH", HDPHP_LIB_PATH . 'Core/'); //核心目录
        define("HDPHP_EXTEND_PATH", HDPHP_PATH . 'Extend/'); //扩展目录
        define("HDPHP_ORG_PATH", HDPHP_EXTEND_PATH . 'Org/'); //org目录
        define("HDPHP_DRIVER_PATH", HDPHP_LIB_PATH . 'Driver/'); //驱动目录
        define("HDPHP_EVENT_PATH", HDPHP_LIB_PATH . 'Event/'); //事件目录
        define("HDPHP_FUNCTION_PATH", HDPHP_LIB_PATH . 'Function/'); //函数目录
        define("HDPHP_LANGUAGE_PATH", HDPHP_LIB_PATH . 'Language/'); //语言目录
        define("HDPHP_TPL_PATH", HDPHP_LIB_PATH . 'Tpl/'); //框架模板目录
        defined("COMMON_PATH") or define("COMMON_PATH", IS_GROUP ? GROUP_PATH . 'Common/' : APP_PATH); //应用组公共目录
        defined("COMMON_CONFIG_PATH") or define("COMMON_CONFIG_PATH", IS_GROUP ? COMMON_PATH . 'Config/' : APP_PATH); //应用组公共目录
        defined("COMMON_MODEL_PATH") or define("COMMON_MODEL_PATH", IS_GROUP ? COMMON_PATH . 'Model/' : APP_PATH); //应用组公共目录
        defined("COMMON_CONTROL_PATH") or define("COMMON_CONTROL_PATH", IS_GROUP ? COMMON_PATH . 'Control/' : APP_PATH); //应用组公共目录
        defined("COMMON_LANGUAGE_PATH") or define("COMMON_LANGUAGE_PATH", IS_GROUP ? COMMON_PATH . 'Language/' : APP_PATH); //应用组语言包目录
        defined("COMMON_EXTEND_PATH") or define("COMMON_EXTEND_PATH", IS_GROUP ? COMMON_PATH . 'Extend/' : APP_PATH); //应用组扩展目录
        defined("COMMON_EVENT_PATH") or define("COMMON_EVENT_PATH", IS_GROUP ? COMMON_PATH . 'Event/' : APP_PATH); //应用组事件目录
        defined("COMMON_TAG_PATH") or define("COMMON_TAG_PATH", IS_GROUP ? COMMON_PATH . 'Tag/' : APP_PATH); //应用组标签目录
        defined("COMMON_LIB_PATH") or define("COMMON_LIB_PATH", IS_GROUP ? COMMON_PATH . 'Lib/' : APP_PATH); //应用组扩展包目录
        //加载核心文件
        self::loadCoreFile();
        //系统配置
        C(require(HDPHP_CONFIG_PATH . 'config.php'));
        //系统事件
        C("CORE_EVENT", require(HDPHP_CONFIG_PATH . 'event.php'));
        //应用组配置与语言包处理
        if (IS_GROUP) {
            is_file(COMMON_CONFIG_PATH . 'config.php') and C(require(COMMON_CONFIG_PATH . 'config.php'));
        }
        //系统语言
        L(require(HDPHP_LANGUAGE_PATH . 'zh.php'));
        //别名
        alias_import(require(HDPHP_CORE_PATH . 'Alias.php'));
        //编译核心文件
        self::compile();
        //获得应用变量
        HDPHP::init();
        //创建应用目录
        self::mkDirs();
        //自动加载文件
        self::compileAppLib();
        //运行应用
        App::run();
    }


    /**
     * 加载核心文件
     * @access private
     * @return void
     */
    static private function loadCoreFile()
    {
        $files = array(
            HDPHP_CORE_PATH . 'HDPHP.class.php', //HDPHP顶级类
            HDPHP_CORE_PATH . 'Control.class.php', //HDPHP顶级类
            HDPHP_CORE_PATH . 'HdException.class.php', //异常处理类
            HDPHP_CORE_PATH . 'App.class.php', //HDPHP顶级类
            HDPHP_CORE_PATH . 'Route.class.php', //URL处理类
            HDPHP_CORE_PATH . 'Event.class.php', //事件处理类
            HDPHP_CORE_PATH . 'Log.class.php', //公共函数
            HDPHP_FUNCTION_PATH . 'Functions.php', //应用函数
            HDPHP_FUNCTION_PATH . 'Common.php', //公共函数
        );
        foreach ($files as $v) {
            require($v);
        }
    }

    /**
     * 创建项目运行目录
     * @access private
     * @return void
     */
    static public function mkDirs()
    {
        //应用组时不自动创建应用目录
        if (defined("GROUP_PATH") && is_dir(GROUP_PATH)) {
            is_dir(TEMP_PATH) or mkdir(TEMP_PATH);
            return;
        }
        //如果应用已经存在，不进行创建
        if (is_dir(CONTROL_PATH) && is_dir(TEMP_PATH)) return;
        //目录
        $dirs = array(
            COMMON_PATH,
            COMMON_CONFIG_PATH,
            COMMON_MODEL_PATH,
            COMMON_CONTROL_PATH,
            COMMON_LANGUAGE_PATH,
            COMMON_EVENT_PATH,
            COMMON_TAG_PATH,
            COMMON_LIB_PATH,
            APP_PATH,
            CONTROL_PATH,
            CONFIG_PATH,
            LANGUAGE_PATH,
            MODEL_PATH,
            CONFIG_PATH,
            EVENT_PATH,
            TAG_PATH,
            LIB_PATH,
            COMPILE_PATH,
            CACHE_PATH,
            TABLE_PATH,
            LOG_PATH,
            TPL_PATH,
            PUBLIC_PATH,
            TEMP_PATH
        );
        foreach ($dirs as $d) {
            if (is_dir($d) || dir_create($d, 0755, true)):
            else:
                header("Content-type:text/html;charset=utf-8");
                exit("目录" . $d . "创建失败，请检查权限");
            endif;
        }
        //复制公共模板文件
        is_file(PUBLIC_PATH . "success.html") or copy(HDPHP_TPL_PATH . "app_success.html", PUBLIC_PATH . "success.html");
        is_file(PUBLIC_PATH . "error.html") or copy(HDPHP_TPL_PATH . "app_error.html", PUBLIC_PATH . "error.html");
        //复制配置文件
        is_file(CONFIG_PATH . "config.php") or copy(HDPHP_TPL_PATH . "config.php", CONFIG_PATH . "config.php");
        is_file(CONFIG_PATH . "event.php") or copy(HDPHP_TPL_PATH . "event.php", CONFIG_PATH . "event.php");
        //创建测试控制器
        is_file(CONTROL_PATH . 'IndexControl.class.php') or file_put_contents(CONTROL_PATH . 'IndexControl.class.php', file_get_contents(HDPHP_TPL_PATH . 'control_test.php'));
        //创建安全文件
        self::safeFile();
    }

    /**
     * 创建安全文件
     * @access private
     * @return void
     */
    static private function safeFile()
    {
        if (!defined("DIR_SAFE")) return;
        $dirs = array(
            COMMON_PATH,
            COMMON_CONFIG_PATH,
            COMMON_MODEL_PATH,
            COMMON_LANGUAGE_PATH,
            COMMON_EVENT_PATH,
            COMMON_TAG_PATH,
            COMMON_LIB_PATH,
            APP_PATH,
            CONTROL_PATH,
            CONFIG_PATH,
            LANGUAGE_PATH,
            MODEL_PATH,
            CONFIG_PATH,
            EVENT_PATH,
            TAG_PATH,
            LIB_PATH,
            COMPILE_PATH,
            CACHE_PATH,
            TABLE_PATH,
            LOG_PATH,
            TPL_PATH,
            PUBLIC_PATH,
            TEMP_PATH
        );
        $file = HDPHP_TPL_PATH . '/index.html';
        foreach ($dirs as $d) {
            is_file($d . '/index.html') || copy($file, $d . '/index.html');
        }
    }

    /**
     * 编译核心文件
     * @access private
     */
    static private function compile()
    {
        $boot = TEMP_PATH . TEMP_FILE;
        if (DEBUG) {
            is_file($boot) and unlink($boot);
            return;
        }
        $compile = '';
        //常量编译
        $_define = get_defined_constants(true);
        foreach ($_define['user'] as $n => $d) {
            if ($d == '\\') $d = "'\\\\'";
            else $d = is_int($d) ? intval($d) : "'{$d}'";
            $compile .= "defined('{$n}') OR define('{$n}',{$d});";
        }
        $files = array(
            HDPHP_CORE_PATH . 'App.class.php', //HDPHP顶级类
            HDPHP_CORE_PATH . 'Control.class.php', //控制器基类
            HDPHP_CORE_PATH . 'Debug.class.php', //Debug处理类
            HDPHP_CORE_PATH . 'Event.class.php', //事件处理类
            HDPHP_CORE_PATH . 'HDPHP.class.php', //HDPHP顶级类
            HDPHP_CORE_PATH . 'HdException.class.php', //异常处理类
            HDPHP_CORE_PATH . 'Log.class.php', //Log日志类
            HDPHP_CORE_PATH . 'Route.class.php', //URL处理类
            HDPHP_FUNCTION_PATH . 'Functions.php', //应用函数
            HDPHP_FUNCTION_PATH . 'Common.php', //公共函数
            HDPHP_DRIVER_PATH . 'Cache/Cache.class.php', //缓存基类
            HDPHP_DRIVER_PATH . 'Cache/CacheFactory.class.php', //缓存工厂类
            HDPHP_DRIVER_PATH . 'Cache/CacheFile.class.php', //文件缓存处理类
            HDPHP_DRIVER_PATH . 'Db/Db.class.php', //数据处理基类
            HDPHP_DRIVER_PATH . 'Db/DbFactory.class.php', //数据工厂类
            HDPHP_DRIVER_PATH . 'Db/DbInterface.class.php', //数据接口类
            HDPHP_DRIVER_PATH . 'Model/Model.class.php', //模型基类
            HDPHP_DRIVER_PATH . 'Model/RelationModel.class.php', //关联模型类
            HDPHP_DRIVER_PATH . 'Model/ViewModel.class.php', //视图模型类
            HDPHP_DRIVER_PATH . 'Session/SessionAbstract.class.php', //Session抽象类
            HDPHP_DRIVER_PATH . 'Session/SessionFactory.class.php', //Session工厂类
            HDPHP_DRIVER_PATH . 'Session/SessionFile.class.php', //Session文件处理类
            HDPHP_DRIVER_PATH . 'View/ViewHd.class.php', //Hd视图驱动类
            HDPHP_DRIVER_PATH . 'View/View.class.php', //视图库
            HDPHP_DRIVER_PATH . 'View/ViewFactory.class.php', //视图工厂库
            HDPHP_DRIVER_PATH . 'View/ViewCompile.class.php', //模板编译类
            HDPHP_EXTEND_PATH . 'Tool/Dir.class.php', //目录操作类
        );
        foreach ($files as $f) {
            $con = compress(trim(file_get_contents($f)));
            $compile .= substr($con, -2) == '?>' ? trim(substr($con, 5, -2)) : trim(substr($con, 5));
        }
        $compile .= 'C(' . var_export(C(), true) . ');';
        $compile .= 'L(' . var_export(L(), true) . ');';
        $compile .= 'alias_import(' . var_export(alias_import(), true) . ');';
        self::$_compile = $compile;
    }

    /**
     * 编译Boot.php文件
     */
    static private function compileAppLib()
    {
        $compile = '';
        //自动加载文件列表
        $files = C("AUTO_LOAD_FILE");
        if (is_array($files) && !empty($files)) {
            foreach ($files as $f) {
                $f = preg_replace('@\.php@i', '', trim($f)) . '.php';
                //加载应用文件
                if (strpos($f, '/') === false) {
                    $f = LIB_PATH . $f;
                    if (!is_file($f)) {
                        $f = COMMON_LIB_PATH . $f;
                    }
                }
                //检测文件
                if (!is_file($f) && !is_readable($f)) {
                    continue;
                }
                require_cache($f);
                //编译自动加载文件
                if (!DEBUG) {
                    $con = trim(file_get_contents($f));
                    $compile .= substr($con, -2) == '?>' ? trim(substr($con, 5, -2)) : trim(substr($con, 5));
                }
            }
        }
        //DEBUG时删除编译文件
        $boot = TEMP_PATH . TEMP_FILE;
        if (DEBUG) {
            is_file($boot) and unlink($boot);
            return;
        }
        //公共文件编译
        $compile = self::$_compile . $compile . 'HDPHP::init();';
        //如果网址发生变化，生新生成编译文件
        $compile .= 'define("CLEAR_TPL_COMPILE_FILE",strstr(__HOST__,$_SERVER["SERVER_NAME"])==false);';
        //编译内容
        $compile = '<?php ' . $compile . 'App::run();?>';
        //创建编译文件
        if (is_dir(TEMP_PATH) or dir_create(TEMP_PATH) and is_writable(TEMP_PATH))
            return file_put_contents($boot, compress($compile));
        header("Content-type:text/html;charset=utf-8");
        exit("<div style='border:solid 1px #dcdcdc;padding:30px;'>目录创建失败，请修改" . realpath(dirname(TEMP_PATH)) . "目录权限</div>");
    }
}

?>

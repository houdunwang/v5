<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
//'-----------------------------------------------------------------------------------
final class HDPHP
{
    /**
     * 初始化应用
     */
    static public function init()
    {
        //加载应用组配置
        if(IS_GROUP){
            is_file(COMMON_CONFIG_PATH . 'config.php')              and C(require(COMMON_CONFIG_PATH . 'config.php'));
            is_file(COMMON_CONFIG_PATH . 'event.php')               and C('GROUP_EVENT', require COMMON_CONFIG_PATH . 'event.php');
            is_file(COMMON_CONFIG_PATH . 'alias.php')               and alias_import(COMMON_CONFIG_PATH . 'alias.php');
            is_file(COMMON_LANGUAGE_PATH . C('LANGUAGE') . '.php')  and L(require COMMON_LANGUAGE_PATH . C('LANGUAGE') . '.php');
        }
        IS_GROUP                                        and Route::group();
        defined('GROUP_NAME')                           or define('GROUP_NAME', isset($_GET[C('VAR_GROUP')]) ? $_GET[C('VAR_GROUP')] : C('DEFAULT_GROUP'));
        defined('APP')                                  or define('APP',ucfirst(IS_GROUP ? $_GET[C('VAR_APP')] : basename(substr(APP_PATH, 0, -1))));
        IS_GROUP                                        and define('APP_PATH', GROUP_PATH . GROUP_NAME . '/' . APP . '/');
        //常量
        defined('CONTROL_PATH')                         or define('CONTROL_PATH', APP_PATH . 'Control/');
        defined('MODEL_PATH')                           or define('MODEL_PATH', APP_PATH . 'Model/');
        defined('CONFIG_PATH')                          or define('CONFIG_PATH', APP_PATH . 'Config/');
        defined('EVENT_PATH')                           or define('EVENT_PATH', APP_PATH . 'Event/');
        defined('LANGUAGE_PATH')                        or define('LANGUAGE_PATH', APP_PATH . 'Language/');
        defined('TAG_PATH')                             or define('TAG_PATH', APP_PATH . 'Tag/');
        defined('LIB_PATH')                             or define('LIB_PATH', APP_PATH . 'Lib/');
        defined('COMPILE_PATH')                         or define('COMPILE_PATH', TEMP_PATH . (IS_GROUP ? GROUP_NAME . '/' . APP . '/Compile/' : 'Compile/'));
        defined('CACHE_PATH')                           or define('CACHE_PATH', TEMP_PATH . (IS_GROUP ? GROUP_NAME . '/' . APP . '/Cache/' : 'Cache/'));
        defined('TABLE_PATH')                           or define('TABLE_PATH', TEMP_PATH . (IS_GROUP ? GROUP_NAME . '/' . APP . '/Table/' : 'Table/'));
        defined('LOG_PATH')                             or define('LOG_PATH', TEMP_PATH . 'Log/');
        //应用配置
        is_file(CONFIG_PATH . 'config.php')             and C(require(CONFIG_PATH . 'config.php'));
        is_file(CONFIG_PATH . 'event.php')              and C('APP_EVENT', require CONFIG_PATH . 'event.php');
        is_file(CONFIG_PATH . 'alias.php')              and alias_import(CONFIG_PATH . 'alias.php');
        is_file(LANGUAGE_PATH . C('LANGUAGE') . '.php') and L(require LANGUAGE_PATH . C('LANGUAGE') . '.php');
        //模板目录
        $tpl_style = C('TPL_STYLE');
        if($tpl_style and substr($tpl_style,-1)!='/')
            $tpl_style.='/';
        defined('TPL_PATH')                             or define('TPL_PATH', (C('TPL_PATH') ?C('TPL_PATH') : APP_PATH.'Tpl/').$tpl_style);
        defined('PUBLIC_PATH')                          or define('PUBLIC_PATH', TPL_PATH . 'Public/');
        //应用url解析并创建常量
        Route::app();
        //=========================环境配置
        date_default_timezone_set(C('DEFAULT_TIME_ZONE'));
        @ini_set('memory_limit',                        '128M');
        @ini_set('register_globals',                    'off');
        @ini_set('magic_quotes_runtime',                0);
        define('NOW',                                   $_SERVER['REQUEST_TIME']);
        define('NOW_MICROTIME',                         microtime(true));
        define('REQUEST_METHOD',                        $_SERVER['REQUEST_METHOD']);
        define('IS_GET',                                REQUEST_METHOD == 'GET' ? true : false);
        define('IS_POST',                               REQUEST_METHOD == 'POST' ? true : false);
        define('IS_PUT',                                REQUEST_METHOD == 'PUT' ? true : false);
        define('IS_AJAX',                               ajax_request());
        define('IS_DELETE',                             REQUEST_METHOD == 'DELETE' ? true : false);
        define('HTTP_REFERER',                          isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null);
        //注册自动载入函数
        spl_autoload_register(array(__CLASS__,          'autoload'));
        set_error_handler(array(__CLASS__,              'error'), E_ALL);
        set_exception_handler(array(__CLASS__,          'exception'));
        register_shutdown_function(array(__CLASS__,     'fatalError'));
        HDPHP::_appAutoLoad();
    }

    /**
     * 自动加载应用文件
     */
    static private function _appAutoLoad()
    {
        //自动加载文件列表
        $files = C('AUTO_LOAD_FILE');
        if (is_array($files) && !empty($files)) {
            foreach ($files as $file) {
                require_array(array(
                    LIB_PATH . $file,
                    COMMON_LIB_PATH . $file
                )) || require_cache($file);
            }
        }
    }

    /**
     * 自动载入函数
     * @param string $className 类名
     * @access private
     * @return void
     */
    static public function autoload($className)
    {
        $class = ucfirst($className) . '.class.php'; //类文件
        if (substr($className, -5) == 'Model') {
            if (require_array(array(
                HDPHP_DRIVER_PATH . 'Model/' . $class,
                MODEL_PATH . $class,
                COMMON_MODEL_PATH . $class
            ))
            ) return;
        } elseif (substr($className, -7) == 'Control') {
            if (require_array(array(
                HDPHP_CORE_PATH . $class,
                CONTROL_PATH . $class,
                COMMON_CONTROL_PATH . $class
            ))
            ) return;
        } elseif (substr($className, 0, 2) == 'Db') {
            if (require_array(array(
                HDPHP_DRIVER_PATH . 'Db/' . $class
            ))
            ) return;
        } elseif (substr($className, 0, 5) == 'Cache') {
            if (require_array(array(
                HDPHP_DRIVER_PATH . 'Cache/' . $class,
            ))
            ) return;
        } elseif (substr($className, 0, 4) == 'View') {
            if (require_array(array(
                HDPHP_DRIVER_PATH . 'View/' . $class,
            ))
            ) return;
        } elseif (substr($className, -5) == 'Event') {
            if (require_array(array(
                EVENT_PATH . $class,
                COMMON_EVENT_PATH . $class
            ))
            ) return;
        } elseif (substr($className, -3) == 'Tag') {
            if (require_array(array(
                TAG_PATH . $class,
                COMMON_TAG_PATH . $class
            ))
            ) return;
        } elseif (alias_import($className)) {
            return;
        } elseif (require_array(array(
            LIB_PATH . $class,
            COMMON_LIB_PATH . $class,
            HDPHP_CORE_PATH . $class,
            HDPHP_EXTEND_PATH . $class,
            HDPHP_EXTEND_PATH . '/Tool/' . $class
        ))
        ) {
            return;
        }
        $msg = "Class {$className} not found";
        Log::write($msg);
        halt($msg);
    }

    /**
     * 自定义异常理
     * @param $e
     */
    static public function exception($e)
    {
        halt($e->__toString());
    }

    //错误处理
    static public function error($errno, $error, $file, $line)
    {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                ob_end_clean();
                $msg = $error. $file . " 第 $line 行.";
                if(C('LOG_RECORD')) Log::write("[$errno] " . $msg, Log::ERROR);
                function_exists('halt') ? halt($msg) : exit('ERROR:' . $msg);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                $errorStr = "[$errno] $error " . $file . " 第 $line 行.";
                trace($errorStr, 'NOTICE');
                //SHUT_NOTICE关闭提示信息
                if (DEBUG && C('SHOW_NOTICE'))
                    require HDPHP_TPL_PATH . 'notice.html';
                break;
        }
    }

    //致命错误处理
    static public function fatalError()
    {
        if ($e = error_get_last()) {
            self::error($e['type'], $e['message'], $e['file'], $e['line']);
        }
    }
}

?>

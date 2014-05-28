<?php
/**
 * 根据配置文件的URL参数重新生成URL地址
 * @param String $pathinfo 访问url
 * @param array $args GET参数
 * <code>
 * $args = "nid=2&cid=1"
 * $args=array("nid"=>2,"cid"=>1)
 * </code>
 * @return string
 */
function U($pathinfo, $args = array())
{
	$_old_url =$pathinfo;
	$pathinfo=str_ireplace(array(__WEB__,__ROOT__),'',$pathinfo);
    if (preg_match("/^https?:\/\//i", $pathinfo) || empty($pathinfo))
        return $_old_url;
    //是否指定单入口
    $end = strpos($pathinfo, '.php');
    if ($end) {
        $web = __ROOT__ . '/' . trim(substr($pathinfo, 0, $end + 4),'/');
        $pathinfo = trim(substr($pathinfo, $end + 4),'/');
    } else {
        $web = __WEB__;
    }
    //参数$args为字符串时转数组
    if (is_string($args)) {
        parse_str($args, $args);
    }
    $parseUrl = parse_url(trim($pathinfo, '/'));
    if(!isset($parseUrl['path']))return $_old_url;
    $path = trim($parseUrl['path'], '/');
    //解析字符串的?后参数 并与$args合并
    if (isset($parseUrl['query'])) {
        parse_str($parseUrl['query'], $query);
        $args = array_merge($query, $args);
    }
    //组合出索引数组  将?后参数与$args传参
    $gets = array();
    if (is_array($args)) {
        foreach ($args as $n => $q) {
            array_push($gets, $n);
            array_push($gets, $q);
        }
    }
    $vars = explode("/", $path);
    //入口文件类型
    $urlType = C("URL_TYPE"); //1 pathinfo 2 get
    switch ($urlType) {
        case 1:
            $root = $web . '/'; //入口位置
            break;
        case 2:
        default:
            $root = $web . '?';
            break;
    }
    //是否定义应用组
    $set_app_group = false;
    if (defined("GROUP_PATH")) {
        $set_app_group = true;
    }
    //组合出__WEB__后内容
    $data = array();
    switch (count($vars)) {
        case 2: //应用
            if ($set_app_group) {
                $data[] = C("VAR_APP");
                $data[] = APP;
            }
            $data[] = C("VAR_CONTROL");
            $data[] = array_shift($vars);
            $data[] = C("VAR_METHOD");
            $data[] = array_shift($vars);
            break;
        case 1: //方法
            if ($set_app_group) {
                $data[] = C("VAR_APP");
                $data[] = APP;
            }
            $data[] = C("VAR_CONTROL");
            $data[] = CONTROL;
            $data[] = C("VAR_METHOD");
            $data[] = array_shift($vars);
            break;
        default: //应用组及其他情况
            $data[] = C("VAR_APP");
            $data[] = array_shift($vars);
            $data[] = C("VAR_CONTROL");
            $data[] = array_shift($vars);
            $data[] = C("VAR_METHOD");
            $data[] = array_shift($vars);
            if (is_array($vars)) {
                foreach ($vars as $v) {
                    $data[] = $v;
                }
            }
    }
    //合并GET参数
    $varsAll = array_merge($data, $gets);
    $url = '';
    switch ($urlType) {
        case 1:
            foreach ($varsAll as $value) {
                $url .= C('PATHINFO_Dli') . $value;
            }
            $url = str_replace(array("/" . C("VAR_APP") . "/", "/" . C("VAR_CONTROL") . "/", "/" . C("VAR_METHOD") . "/"), "/", $url);
            $url = substr($url, 1);
            break;
        case 2:
        default:
            foreach ($varsAll as $k => $value) {
                if ($k % 2) {
                    $url .= '=' . $value;
                } else {
                    $url .= '&' . $value;
                }
            }
            $url = substr($url, 1);
            break;
    }
    $pathinfo_html = $urlType == 1 ? C("PATHINFO_HTML") : ''; //伪表态后缀如.html
    if (C("URL_REWRITE")) {
        $root = preg_replace('/\w+?\.php(\/|\?)?/i', '', $root);
    }
    return $root . Route::toUrl($url) . $pathinfo_html;
}

/**
 * 记录缓存读写与数据库操作次数
 * @param string $name 缓存的KEY
 * @param int $num 缓存次数
 * @return void
 */
function N($name, $num = NULL)
{
    //记数静态变量
    static $data = array();
    if (!isset($data[$name])) {
        $data[$name] = 0;
    }
    if (is_null($num)) { //获得计数
        return $data[$name];
    } else { //更改缓存记数
        $data[$name] += (int)$num;
    }
}

/**
 * 生成序列字符串
 * @param $var
 * @return string
 */
function md5_d($var)
{
    return md5(serialize($var));
}

/**
 * Hash函数
 */
function hash_hd($data, $len)
{
    $hash = crc32($data) & 0xfffffff;
    return $hash % $len;
}

/**
 * 递归创建目录
 * @param string $dirName 目录
 * @param int $auth 权限
 * @return bool
 */
function dir_create($dirName, $auth = 0755)
{
    $dirName = str_replace("\\", "/", $dirName);
    $dirPath = rtrim($dirName, '/');
    if (is_dir($dirPath))
        return true;
    $dirs = explode('/', $dirPath);
    $dir = '';
    foreach ($dirs as $v) {
        $dir .= $v . '/';
        is_dir($dir) or @mkdir($dir, $auth, true);
    }
    return is_dir($dirPath);
}

/**
 * 日期格式化
 * 使用自定义标签时格式化标准ISO日期
 * @param int $time
 * @param string $format
 * @return bool|string
 */
function hd_date($time, $format = 'Y-m-d')
{
    return date($format, $time);
}

/**
 * 截取长度
 * 使用自定义标签时截取字符串
 * @param $string 字符串
 * @param int $len 长度
 * @param string $end 结尾符
 * @return string
 */
function hd_substr($string, $len = 20, $end = '...')
{
    return mb_substr($string, 0, $len, 'utf-8') . $end;
}

/**
 * 加载文件并缓存
 * @param null $path 导入的文件
 * @return bool
 */
function require_cache($path = null)
{
    static $_files = array();
    if (is_null($path)) return $_files;
    //缓存中存在  即代表文件已经加载  停止加载
    if (isset($_files[$path])) {
        return true;
    }
    //区分大小写的文件判断
    if (!file_exists_case($path)) {
        return false;
    }
    require($path);
    $_files[$path] = true;
    return true;
}

/**
 * 加载文件
 * @param string $file 文件名
 * @return bool
 */
function load($file)
{
    $file = str_replace(".", "/", preg_replace('@\.php@i', '', $file));
    //加载Lib中的文件
    if (!strstr($file, '/')) {
        $app = LIB_PATH . $file . '.php';
        $group = COMMON_LIB_PATH . $file . '.php';
        return require_cache($app) || (IS_GROUP && require_cache($group));
    }
    //其他文件
    $info = explode('/', $file);
    if ($info[0] == '@' || APP == $info[0]) {
        $file = APP_PATH . substr_replace($file, '', 0, strlen($info[0]) + 1);
    }
    return require_cache($file);
}


/**
 * 别名导入
 * @param string | array $name 别名
 * @param string $path 路径
 * @return bool
 */
function alias_import($name = null, $path = null)
{
    static $_alias = array();
    if (is_null($name)) return $_alias;
    if (is_string($name)) $name = strtolower($name);
    if (is_array($name)) {
        $_alias = array_merge($_alias, array_change_key_case($name));
        return true;
    } elseif (!is_null($path)) {
        return $_alias[$name] = $path;
    } elseif (isset($_alias[$name])) {
        return require_cache($_alias[$name]);
    }
    return false;
}

/**
 * 导入文件数组
 */
function require_array($fileArr)
{
    foreach ($fileArr as $file) {
        if (is_file($file) && require_cache($file)) return true;
    }
    return false;
}

/**
 * 区分大小写的判断文件判断
 * @param string $file 需要判断的文件
 * @return boolean
 */
function file_exists_case($file)
{
    if (is_file($file)) {
        //windows环境下检测文件大小写
        if (IS_WIN && C("CHECK_FILE_CASE")) {
            if (basename(realpath($file)) != basename($file)) {
                return false;
            }
        }
        return true;
    }
    return false;
}

/**
 * 移除URL中的指定GET变量
 * @param string $var 要移除的GET变量名称
 * @param string $url 操作的url
 * @return string 移除GET变量后的URL地址
 */
function url_param_remove($var, $url = null)
{
    return Route::removeUrlParam($var, $url);
}

/**
 * 根据大小返回标准单位 KB  MB GB等
 */
function get_size($size, $decimals = 2)
{
    switch (true) {
        case $size >= pow(1024, 3):
            return round($size / pow(1024, 3), $decimals) . " GB";
        case $size >= pow(1024, 2):
            return round($size / pow(1024, 2), $decimals) . " MB";
        case $size >= pow(1024, 1):
            return round($size / pow(1024, 1), $decimals) . " KB";
        default:
            return $size . 'B';
    }
}

/**
 * 数组转为常量
 * @param array $arr 数据
 * @return bool
 */
function array_defined($arr)
{
    foreach ($arr as $k => $v) {
        $k = strtoupper($k);
        if (is_string($v)) {
            define($k, $v);
        } elseif (is_numeric($v)) {
            defined($k, $v);
        } elseif (is_bool($v)) {
            $v = $v ? 'true' : 'false';
            define($k, $v);
        }
    }
    return true;
}

/**
 * 将数组键名变成大写或小写
 * @param array $arr 数组
 * @param int $type 转换方式 1大写   0小写
 * @return array
 */
function array_change_key_case_d($arr, $type = 0)
{
    $function = $type ? 'strtoupper' : 'strtolower';
    $newArr = array(); //格式化后的数组
    if (!is_array($arr) || empty($arr))
        return $newArr;
    foreach ($arr as $k => $v) {
        $k = $function($k);
        if (is_array($v)) {
            $newArr[$k] = array_change_key_case_d($v, $type);
        } else {
            $newArr[$k] = $v;
        }
    }
    return $newArr;
}

/**
 * 不区分大小写检测数据键名是否存在
 */
function array_key_exists_d($key, $arr)
{
    return array_key_exists(strtolower($key), array_change_key_case_d($arr));
}

/**
 * 数组转对象
 */
function array_to_object($arr)
{
    if (!is_array($arr) || empty($arr)) {
        return null;
    }
    return (object)$arr;
}

/**
 * 将数组中的值全部转为大写或小写
 * @param array $arr
 * @param int $type 类型 1值大写 0值小写
 * @return array
 */
function array_change_value_case($arr, $type = 0)
{
    $function = $type ? 'strtoupper' : 'strtolower';
    $newArr = array(); //格式化后的数组
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            $newArr[$k] = array_change_value_case($v, $type);
        } else {
            $newArr[$k] = $function($v);
        }
    }

    return $newArr;
}

/**
 * 多个PHP文件合并
 * @param array $files 文件列表
 * @param bool $space 是否去除空白
 * @param bool $tag 是否加<?php标签头尾
 * @return string 合并后的字符串
 */
function file_merge($files, $space = false, $tag = false)
{
    $str = ''; //格式化后的内容
    foreach ($files as $file) {
        $con = trim(file_get_contents($file));
        if ($space)
            $con = compress($con);
        $str .= substr($con, -2) == '?>' ? trim(substr($con, 5, -2)) : trim($con, 5);
    }
    return $tag ? '<?php if(!defined("HDPHP_PATH")){exit("No direct script access allowed");}' . $str . "\t?>" : $str;
}


/**
 * 去空格，去除注释包括单行及多行注释
 * @param string $content 数据
 * @return string
 */
function compress($content)
{
    $str = ""; //合并后的字符串
    $data = token_get_all($content);
    $end = false; //没结束如$v = "hdphp"中的等号;
    for ($i = 0, $count = count($data); $i < $count; $i++) {
        if (is_string($data[$i])) {
            $end = false;
            $str .= $data[$i];
        } else {
            switch ($data[$i][0]) { //检测类型
                //忽略单行多行注释
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                //去除格
                case T_WHITESPACE:
                    if (!$end) {
                        $end = true;
                        $str .= " ";
                    }
                    break;
                //定界符开始
                case T_START_HEREDOC:
                    $str .= "<<<HDPHP\n";
                    break;
                //定界符结束
                case T_END_HEREDOC:
                    $str .= "HDPHP;\n";
                    //类似str;分号前换行情况
                    for ($m = $i + 1; $m < $count; $m++) {
                        if (is_string($data[$m]) && $data[$m] == ';') {
                            $i = $m;
                            break;
                        }
                        if ($data[$m] == T_CLOSE_TAG) {
                            break;
                        }
                    }
                    break;

                default:
                    $end = false;
                    $str .= $data[$i][1];
            }
        }
    }
    return $str;
}

/**
 * 获得常量
 * @param   string $name 常量名称，默认为获得所有常量
 * @param   void $value 常量不存在时的返回值
 * @param   string $type 常量类型，默认为用户自定义常量,参数为true获得所有常量
 * @return  array   常量数组
 */
function get_defines($name = "", $value = null, $type = 'user')
{
    if ($name) {
        $const = get_defined_constants();
        return defined($name) ? $const[$name] : $value;
    }
    $const = get_defined_constants(true);
    return $type === true ? $const : $const[$type];
}


/**
 * 抛出异常
 * @param string $msg 错误信息
 * @param string $type 异常类
 * @param int $code 编码
 * @throws
 */
function throw_exception($msg, $type = "HdException", $code = 0)
{
    if (class_exists($type, false)) {
        throw new $type($msg, $code, true);
    } else {
        halt($msg);
    }
}

/**
 * 将错误记录到日志
 * @param $error 错误信息
 */
function log_write($error)
{
    $trace = debug_backtrace();
    $e['message'] = $error;
    $e['file'] = $trace[0]['file'];
    $e['line'] = $trace[0]['line'];
    $e['class'] = isset($trace[0]['class']) ? $trace[0]['class'] : "";
    $e['function'] = isset($trace[0]['function']) ? $trace[0]['function'] : "";
    $msg = ("[Error]" . $e['message'] . " [Time]" . date("y-m-d h:i") . " [File]" . $e['file'] . " [Line]" . $e['line']);
    //写入日志
    Log::write($msg);
}

/**
 * 错误中断
 * @param string | array $error 错误内容
 */
function halt($error)
{
    $e = array();
    if (DEBUG) {
        if (!is_array($error)) {
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['line'] = $trace[0]['line'];
            $e['class'] = isset($trace[0]['class']) ? $trace[0]['class'] : "";
            $e['function'] = isset($trace[0]['function']) ? $trace[0]['function'] : "";
            ob_start();
            debug_print_backtrace();
            $e['trace'] = htmlspecialchars(ob_get_clean());
        } else {
            $e = $error;
        }
    } else {
        //错误显示url
        if ($_url = C('ERROR_URL')) {
            go($_url);
        } else {
            $e['message'] = C('ERROR_MESSAGE');
        }
    }
    //显示DEBUG模板，开启DEBUG显示trace
    require HDPHP_TPL_PATH . 'halt.html';
    exit;
}

/**
 * 错误中断
 * @param $error 错误内容
 */
function error($error)
{
    halt($error);
}

/**
 * trace记录
 * @param string $value 错误信息
 * @param string $level
 * @param bool $record
 * @return mixed
 */
function trace($value = '[HDPHP]', $level = 'DEBUG', $record = false)
{
    static $_trace = array();
    if ('[HDPHP]' === $value) { // 获取trace信息
        return $_trace;
    } else {
        $info = ' : ' . print_r($value, true);
        //调试模式时处理ERROR类型
        if (DEBUG && 'ERROR' == $level) {
            throw_exception($info);
        }
        if (!isset($_trace[$level])) {
            $_trace[$level] = array();
        }
        $_trace[$level][] = $info;
        if (IS_AJAX || $record) {
            Log::record($info, $level, $record);
        }
    }
}

/**
 * 404错误
 * @param string $msg 提示信息
 * @param string $url 跳转url
 */
function _404($msg = "", $url = "")
{
    DEBUG && halt($msg);
    //写入日志
    Log::write($msg);
    if (empty($url) or C("404_URL")) {
        $url = C("404_URL");
    }
    if ($url)
        go($url);
    else
        set_http_state(404);
    exit;
}

/**
 * firebug调试模式
 * 需要firefox下安装firebug和firephp插件
 * @param $data 打印的数据
 */
function firephp($data)
{
    ob_start();
    $firephp = FirePHP::getInstance(true);
    $firephp->log($data, 'Iterators');
    ob_flush();
    ob_clean();
}

/**
 * 返回错误类型
 * @param int $type
 * @return strings
 */
function FriendlyErrorType($type)
{
    switch ($type) {
        case E_ERROR: // 1 //
            return 'E_ERROR';
        case E_WARNING: // 2 //
            return 'E_WARNING';
        case E_PARSE: // 4 //
            return 'E_PARSE';
        case E_NOTICE: // 8 //
            return 'E_NOTICE';
        case E_CORE_ERROR: // 16 //
            return 'E_CORE_ERROR';
        case E_CORE_WARNING: // 32 //
            return 'E_CORE_WARNING';
        case E_CORE_ERROR: // 64 //
            return 'E_COMPILE_ERROR';
        case E_CORE_WARNING: // 128 //
            return 'E_COMPILE_WARNING';
        case E_USER_ERROR: // 256 //
            return 'E_USER_ERROR';
        case E_USER_WARNING: // 512 //
            return 'E_USER_WARNING';
        case E_USER_NOTICE: // 1024 //
            return 'E_USER_NOTICE';
        case E_STRICT: // 2048 //
            return 'E_STRICT';
        case E_RECOVERABLE_ERROR: // 4096 //
            return 'E_RECOVERABLE_ERROR';
        case E_DEPRECATED: // 8192 //
            return 'E_DEPRECATED';
        case E_USER_DEPRECATED: // 16384 //
            return 'E_USER_DEPRECATED';
    }
    return $type;
}

/**
 * 验证扩展是否加载
 * @param string $ext
 * @return bool
 */
function extension_exists($ext)
{
    $ext = strtolower($ext);
    $loaded_extensions = get_loaded_extensions();
    return in_array($ext, array_change_value_case($loaded_extensions, 0));
}

/**
 * 调用标签函数
 * @param $tag 标签名
 * @param array $attr 属性
 * @param string $content 内容
 * @return bool
 */
function tag($tag, $attr = array(), $content = "")
{
    $tag = "_" . $tag;
    //标签库类
    $tagClass = array();
    //加载扩展标签库
    $tags = C('TPL_TAGS');
    //如果配置文件中存在标签定义
    if (!empty($tags) && is_array($tags)) {
        //加载其他模块或应用中的标签库
        foreach ($tags as $k) {
            //如果拆分后大于1的为其他模块或应用的标签定义
            $arr = explode('.', $k);
            if (import($k)) {
                //压入标签库类
                $tagClass[] = array_pop($arr);
            }
        }
    }
    //加载框架核心标签库
    $tagClass[] = 'ViewTag';
    foreach ($tagClass as $_class) {
        $obj = new $_class;
        if (method_exists($obj, $tag)) {
            return $obj->$tag($attr, $content);
        }
    }
    return false;
}

/**
 * 创建目录安全文件
 * @param $dirs
 */
function safeFile($dirs)
{
    $file = HDPHP_TPL . '/index.html';
    foreach ($dirs as $d) {
        is_file($d . '/index.html') || copy($file, $d . '/index.html');
    }
}

?>
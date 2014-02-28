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
// '-----------------------------------------------------------------------------------
/**
 * URL处理类
 * @package     Core
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Route
{
    /**
     * 根据不同url处理方式，得到Url参数
     */
    static private function formatUrl()
    {
        //请求内容
        $query = C('URL_TYPE') == 3 && isset($_GET[C("PATHINFO_VAR")]) ? $_GET[C("PATHINFO_VAR")] :
            (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['QUERY_STRING']);
        //分析路由 && 清除伪静态后缀
        $url = self::parseRoute(str_ireplace(C('PATHINFO_HTML'), '', trim($query, '/')));
        //拆分后的GET变量
        $gets = '';
        if (!empty($_SERVER['PATH_INFO']) || (C('URL_TYPE') == 3 && isset($_GET[C("PATHINFO_VAR")]))) {
            $url = str_replace(array('&', '='), C("PATHINFO_DLI"), $url);
        } else {
            //解析URL
            parse_str($url, $gets);
            $_GET = array_merge($_GET, $gets);
        }
        //pathinfo形式
        return $gets || empty($url) ? array() : explode(C("PATHINFO_DLI"), $url);
    }

    /**
     * 解析应用组获得应用
     * @access public
     */
    static public function group()
    {
        $args = self::formatUrl();
        //应用名
        $a = C("VAR_APP");
        if (isset($_GET[$a])) {
        } elseif (isset($args[0])) {
            if ($args[0] == $a) {
                $_GET[$a] = $args[1];
            } else {
                $_GET[$a] = $args[0];
            }
        } else {
            $_GET[$a] = C("DEFAULT_APP");
        }
    }


    /**
     * 解析应用
     */
    static public function app()
    {
        $args = self::formatUrl();
        //应用组模式时删除应用名变量
        if (IS_GROUP && !empty($args)) {
            if ($args[0] == C("VAR_APP")) {
                array_shift($args);
                array_shift($args);
            } else {
                array_shift($args);
            }
        }
        //控制器
        if (isset($_GET[C("VAR_CONTROL")])) {
        } elseif (isset($args[0]) && !empty($args[0])) {
            if ($args[0] == C("VAR_CONTROL")) {
                $_GET[C("VAR_CONTROL")] = $args[1];
                array_shift($args);
                array_shift($args);
            } else {
                $_GET[C("VAR_CONTROL")] = $args[0];
                array_shift($args);
            }
        } else {
            $_GET[C('VAR_CONTROL')] = C('DEFAULT_CONTROL');
        }
        //方法
        if (isset($_GET[C("VAR_METHOD")])) {
        } elseif (isset($args[0]) && !empty($args[0])) {
            if ($args[0] == C("VAR_METHOD")) {
                $_GET[C("VAR_METHOD")] = $args[1];
                array_shift($args);
                array_shift($args);
            } else {
                $_GET[C("VAR_METHOD")] = $args[0];
                array_shift($args);
            }
        } else {
            $_GET[C('VAR_METHOD')] = C('DEFAULT_METHOD');
        }
        //以下划线分隔的模块名称改为pascal命名如hdphp_user=>HDPhpUser
        $_GET[C('VAR_CONTROL')] = ucwords(preg_replace('@_([a-z]?)@ei', 'strtoupper("\1")', $_GET[C('VAR_CONTROL')]));
        //获得$_GET数据
        if (!empty($args)) {
            $count = count($args);
            for ($i = 0; $i < $count;) {
                $_GET[$args [$i]] = isset($args [$i + 1]) ? $args [$i + 1] : '';
                $i += 2;
            }
        }
        //兼容模式删除其变量
        if (C('URL_TYPE') == 2) {
            unset($_GET[C('PATHINFO_VAR')]);
        }
        $_REQUEST=array_merge($_REQUEST,$_GET);
        //设置常量
        self::setConst();
    }

    /**
     * 设置常量
     */
    static private function setConst()
    {
        //域名
        $host = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
        define("__HOST__", C("HTTPS") ? "https://" : "http://" .$host);
        //网站根-不含入口文件
        $script_file = rtrim($_SERVER['SCRIPT_NAME'],'/');
        $root = rtrim(dirname($script_file),'/');
        define("__ROOT__", __HOST__ . ($root=='/' || $root=='\\'?'':$root));
        //网站根-含入口文件
        define("__WEB__", __HOST__ . $_SERVER['SCRIPT_NAME']);
        //完整URL地址
        define("__URL__", __HOST__ . '/' . trim($_SERVER['REQUEST_URI'],'/'));
        //框架目录相关URL
        define("__HDPHP__", __HOST__ . '/' . trim(str_ireplace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), "", HDPHP_PATH), '/'));
        define("__HDPHP_DATA__", __HDPHP__ . '/Data');
        define("__HDPHP_TPL__", __HDPHP__ . '/Lib/Tpl');
        define("__HDPHP_EXTEND__", __HDPHP__ . '/Extend');
        //控制器
        define("CONTROL", ucwords($_GET[C('VAR_CONTROL')]));
        //方法
        define("METHOD", $_GET[C('VAR_METHOD')]);
        // URL类型    1:pathinfo  2:普通模式  3:rewrite 重写  4:兼容模式
        switch (C("URL_TYPE")) {
            //普通模式
            case 2:
                define("__APP__", __WEB__ . (IS_GROUP ? '?' . C('VAR_APP') . '=' . APP : ''));
                define("__CONTROL__", __APP__ . (IS_GROUP ? '&' . C('VAR_CONTROL') . '=' . CONTROL : '?c=' . CONTROL));
                define("__METH__", __CONTROL__ . '&' . C('VAR_METHOD') . '=' . METHOD);
                break;
            //兼容模式
            case 3:
                define("__APP__", __WEB__ . '?' . C("PATHINFO_VAR") . '=' . (IS_GROUP ? '/' . APP : ''));
                define("__CONTROL__", __APP__ . '/' . CONTROL);
                define("__METH__", __CONTROL__ . '/' . METHOD);
                break;
            //pathinfo|rewrite
            case 1:
            default:
                define("__APP__", __WEB__ . (IS_GROUP ? '/' . APP : ''));
                define("__CONTROL__", __APP__ . '/' . CONTROL);
                define("__METH__", __CONTROL__ . '/' . METHOD);
                break;
        }
        if (defined("GROUP_PATH"))
            defined("__GROUP__") or define("__GROUP__", __ROOT__ . '/'.rtrim(GROUP_PATH,'/'));
        //网站根-Static目录
        defined("__TPL__") or define("__TPL__", __ROOT__  . '/'.rtrim(TPL_PATH,'/'));
        defined("__CONTROL_TPL__") or define("__CONTROL_TPL__", __TPL__  .'/'. CONTROL);
        defined("__STATIC__") or define("__STATIC__", __ROOT__ . '/Static');
        defined("__PUBLIC__") or define("__PUBLIC__", __TPL__ . '/Public');
        //历史页码
        $history= isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:null;
        define("__HISTORY__",$history);
    }

    /**
     * 分析路由
     * @param string $query
     * @return mixed
     */
    static private function parseRoute($query)
    {
        $route = C("ROUTE");
        if (!$route or !is_array($route)) return $query;
        foreach ($route as $k => $v) {
            //正则路由
            if (preg_match("@^/.*/[isUx]*$@i", $k)) {
                //如果匹配URL地址
                if (preg_match($k, $query)) {
                    //元子组替换
                    $v = str_replace('#', '\\', $v);
                    //匹配当前正则路由,url按正则替换
                    return preg_replace($k, $v, $query);
                }
                //下一个路由规则
                continue;
            }
            //非正则路由
            $search = array(
                '@(:year)@i',
                '@(:month)@i',
                '@(:day)@i',
                '@(:num)@i',
                '@(:any)@i',
                '@(:[a-z0-9]+\\\d)@i',
                '@(:[a-z0-9]+\\\w)@i',
                '@(:[a-z0-9]+)@i'
            );
            $replace = array(
                '\d{4}',
                '\d{1,2}',
                '\d{1,2}',
                '\d+',
                '.+',
                '\d+',
                '\w+',
                '([a-z0-9]+)'
            );
            //将:year等替换
            $base_preg = "@^" . preg_replace($search, $replace, $k) . "$@i";
            //不满足路由规则
            if (!preg_match($base_preg, $query)) {
                continue;
            }
            //满足路由，但不存在参数如:uid等
            if (!strstr($k, ":")) {
                return $v;
            }
            /**
             * user/:id=>user/1
             */
            $vars = "";
            preg_match('/[^:\sa-z0-9]/i', $k, $vars);
            //:id=>"index/index"
            if (isset($vars[0])) {
                //拆分路由获得:id
                $roles_ex = explode($vars[0], $k);
                //上例中拆分请求参数获得1
                $url_args = explode($vars[0], $query);
            } else {
                $roles_ex = array($k);
                $url_args = array($query);
            }
            //匹配路由规则
            $query = $v;
            foreach ($roles_ex as $m => $n) {
                if (!strstr($n, ":")) {
                    continue;
                }
                $_GET[str_replace(":", "", $n)] = $url_args[$m];
            }
            return $query;
        }
        return $query;
    }


    /**
     * 将URL按路由规则进行处理
     * U()函数等使用
     * @access public
     * @param  string $url url字符串不含__WEB__.'?|/'
     * @return string
     */
    static public function toUrl($url)
    {
        $route = C("route");
        //未定义路由规则
        if (!$route) {
            return $url;
        }
        foreach ($route as $routeKey => $routeVal) {
            $routeKey = trim($routeKey);
            //正则路由
            if (substr($routeKey, 0, 1) === '/') {
                $regGroup = array(); //识别正则路由中的原子组
                preg_match_all("@\(.*?\)@i", $routeKey, $regGroup, PREG_PATTERN_ORDER);
                $searchRegExp = $routeVal; //匹配URL的正则
                //将正则路由的$v中的值#1换成$r中的(\d+)形式
                for ($i = 0, $total = count($regGroup[0]); $i < $total; $i++) {
                    $searchRegExp = str_replace('#' . ($i + 1), $regGroup[0][$i], $searchRegExp);
                }
                $urlArgs = array(); //URL参数
                preg_match_all("@" . $searchRegExp . "@i", $url, $urlArgs, PREG_SET_ORDER);
                //满足路由规则
                if ($urlArgs) {
                    //清除路由中的/$与/正则边界
                    $routeUrl = trim(str_replace(array('/^', '$/'), '', $routeKey), '/');
                    foreach ($regGroup[0] as $k => $v) {
                        $v = preg_replace('@([\*\$\(\)\+\?\[\]\{\}\\\])@', '\\\$1', $v);
                        $routeUrl = preg_replace('@' . $v . '@', $urlArgs[0][$k + 1], $routeUrl, $count = 1);
                    }

                    return trim($routeUrl, '/');
                }
            } else {
                //获得如 "info/:city_:row" 中的:city与:row
                $routeGetVars = array();
                //普通路由处理
                preg_match_all('/:([a-z]*)/i', $routeKey, $routeGetVars, PREG_PATTERN_ORDER); //获得路由规则中以:开始的变量
                $getRouteUrl = $routeVal;
                switch (C("URL_TYPE")) {
                    case 1:
                        $getRouteUrl .= '/';
                        foreach ($routeGetVars[1] as $getK => $getV) {
                            $getRouteUrl .= $getV . '/(.*)/';
                        }
                        $getRouteUrl = '@' . trim($getRouteUrl, '/') . '@i';
                        break;
                    case 2:
                        $getRouteUrl .= '&';
                        foreach ($routeGetVars[1] as $getK => $getV) {
                            $getRouteUrl .= $getV . '=(.*)' . '&';
                        }
                        $getRouteUrl = '@' . trim($getRouteUrl, '&') . '@i';
                        break;
                }
                $getArgs = array();
                preg_match_all($getRouteUrl, $url, $getArgs, PREG_SET_ORDER);
                if ($getArgs) {
                    //去除路由中的传参数如:uid
                    $newUrl = $routeKey;
                    foreach ($routeGetVars[0] as $rk => $getName) {
                        $newUrl = str_replace($getName, $getArgs[0][$rk + 1], $newUrl);
                    }
                    return $newUrl;
                }
            }
        }
        return $url;
    }


    /**
     * 移除URL中的指定GET变量
     * 使用函数remove_url_param()调用
     * @param string $var 要移除的GET变量
     * @param null $url url地址
     * @return mixed|string 移除GET变量后的URL地址
     */
    static public function removeUrlParam($var, $url = null)
    {
        $pathinfo_dli = C("PATHINFO_DLI");
        if (!is_null($url)) {
            $url_format = strstr($url, "&") ? $url . '&' : $url . $pathinfo_dli;
            $url = str_replace($pathinfo_dli, "###", $url_format);
            $search = array(
                "/$var" . "###" . ".*?" . "###" . "/",
                "/$var=.*?&/i",
                "/\?&/",
                "/&&/"
            );
            $replace = array(
                "",
                "",
                "?",
                ""
            );
            $url_replace = preg_replace($search, $replace, $url);
            $url_rtrim = rtrim(rtrim($url_replace, "&"), "###");
            return str_replace("###", $pathinfo_dli, $url_rtrim);
        }
        $get = $_GET;
        unset($get[C("VAR_APP")]);
        unset($get[C("VAR_CONTROL")]);
        unset($get[C("VAR_METHOD")]);
        $url = '';
        $url_type = C("URL_TYPE");
        foreach ($get as $k => $v) {
            if ($k === $var)
                continue;
            if ($url_type == 1) {
                $url .= $pathinfo_dli . $k . $pathinfo_dli . $v;
            } else {
                $url .= "&" . $k . "=" . $v;
            }
        }
        $url_rtrim = trim(trim($url, $pathinfo_dli), '&');
        $url_str = empty($url_rtrim) ? "" : $pathinfo_dli . $url_rtrim;
        if ($url_type == 1) {
            return __METH__ . $url_str;
        } else {
            return __METH__ . "&" . trim($url_str, "&");
        }
    }
}

?>
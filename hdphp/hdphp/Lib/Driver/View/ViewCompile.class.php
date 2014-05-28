<?php
if (!defined("HDPHP_PATH")) exit('No direct script access allowed');
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
 * HD模板引擎编译处理类
 * 推荐使用session()函数完成处理
 * @package     View
 * @subpackage  HDPHP模板
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class ViewCompile
{
    public $view; //视图对象HdView
    public $content; //编译内容
    private $left; //模板左标签
    private $right; //模板右标签
    private $condition = array(
        "\s+neq\s+" => " <> ", "\s+eq\s+" => " == ",
        "\s+gt\s+" => " > ", "\s+egt\s+" => " >= ",
        "\s+lt\s+" => " < ", "\s+elt\s+" => " <= "
    );
    //函数别名
    private $functionAlias = array(
        "default" => "_default"
    );

    /**
     * @param Object $view HdView对象
     */
    function __construct(&$view = null)
    {
        $this->left = C("TPL_TAG_LEFT"); //左侧标签
        $this->right = C("TPL_TAG_RIGHT"); //右侧标签
        $this->view = $view; //HdView对象
    }

    //运行编译
    public function run()
    {
        $this->content = file_get_contents($this->view->tplFile); //获得模板内容
        $this->loadParseTags(); //加载标签库  及解析标签
        $this->replaceGlobalFunc(); //解析全局函数{U:'index'}
        $this->compile(); //解析全局内容
        $this->parseTokey(); //解析POST令牌Token
        $this->replaceConst(); //将所有常量替换   如把__APP__进行替换
        $this->content = '<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?>' . $this->content;
        if (!is_dir(COMPILE_PATH)) {
            Dir::create(COMPILE_PATH);
            copy(HDPHP_TPL_PATH . 'index.html', COMPILE_PATH . 'index.html');
        }
        file_put_contents($this->view->compileFile, $this->content);
        //创建安全文件
        $safeFile = dirname($this->view->compileFile) . "/index.html";
        is_file($safeFile) or Dir::safeFile(dirname($safeFile));
    }

    //替换非标签属性的配置项与语言项
    private function replaceLangConfig($content)
    {
        $preg = array(
            '/\$hd.config\.(\w+)\s*/is',
            '/\$hd.language\.(\w+)\s*/is'
        );
        $replace = array(
            'C("\1")',
            'L("\1")'
        );
        return preg_replace($preg, $replace, $content);
    }

    //解析全局函数{|U:'index'}
    private function replaceGlobalFunc()
    {
        $this->content = preg_replace('/\{\|(\w+):(.*?)\}/i', '<?php echo \1(\2);?>', $this->content);
        $this->content = preg_replace('/\{\|(\w+)\((.*?)\}/i', '<?php echo \1(\2;?>', $this->content);
    }

    /**
     * 加载标签库与解析标签
     */
    private function loadParseTags()
    {
        //标签库类
        $tagClass = array();
        //加载扩展标签库
        $tags = C('TPL_TAGS');
        //如果配置文件中存在标签定义
        if (!empty($tags) && is_array($tags)) {
            //加载其他模块或应用中的标签库
            foreach ($tags as $file) {
                $file = str_replace(".", "/", $file);
                $info = explode("/", $file);
                //类名
                $class=array_pop($info);
                if (class_exists($class, false)) {
                } else if (require_array(array(
                    TAG_PATH . $file . '.class.php',
                    COMMON_TAG_PATH . $file . '.class.php'
                ))) {}
                else if (import($file)) {}
                else {
                    if (DEBUG) {
                        halt("标签类文件{$class}不存在");
                    } else {
                        continue;
                    }
                }
                $tmp = explode(".", $class);
                $tagClass[] = array_pop($tmp);
            }
        }
        //加载框架核心标签库
        if (import('HDPHP.Lib.Driver.View.ViewTag')) {
            $tagClass[] = 'ViewTag';
            $this->parseTagClass($tagClass);
        }
    }

    /**
     * 解析所有标签
     * @param array $tagClass 所有标签类
     */
    private function parseTagClass($tagClass)
    {
        foreach ($tagClass as $class) {
            //加载标签类
            $tagObj = new $class(); //标签类对象
            $tagMethod = get_class_methods($class); //标签库中的标签方法
            foreach ($tagMethod as $tagName) {
                $block = 1; //是否为块标签  默认为块标签
                $level = 1; //嵌套层级
                $tagName = substr($tagName, 1); //标签名，因为标签类中以_开始，所以要截取
                if (isset($tagObj->tag)) { //标签属性是否存在
                    $tagSet = $tagObj->tag; //标签设置
                    $block = isset($tagSet[$tagName]['block']) ? $tagSet[$tagName]['block'] : 1; //检测是否为块标签
                    $level = isset($tagSet[$tagName]['level']) ? $tagSet[$tagName]['level'] : 1; //嵌套层级
                }
                for ($i = 0; $i < $level; $i++) {
                    if (!$this->compileTag($tagName, $tagObj, $block)) {
                        $i = 100;
                    }
                }
            }
        }
    }

    /**
     * 编译标签
     * @param string $tagName 标签名
     * @param obj $tagObj 标签类对象
     * @param int $block 是否为块标记
     * @return bool 是否为块标记
     */
    private function compileTag($tagName, &$tagObj, $block = 1)
    {
        $arr = ''; //标签内容  所有含属性 及内容
        if ($block) {
            #<if>
            #<if value="abc"
            $preg = '/' . $this->left . $tagName . "(?:\s+(.*)" . $this->right . "|" . $this->right . ")(.*)" . substr($this->left, 0, 1) . "\/" . substr($this->left, 1) . $tagName . $this->right . '/isU'; //对标签正则
        } else {
            // $preg = '/' . $this->left . $tagName . '[\s\/>]+(.*)\/?' . $this->right . "/isU"; //独立正则
            $preg = '/' . $this->left . $tagName . '(?:\s+(.*)\/?' . $this->right . "|(\s*)\/?" . $this->right . ")/isU"; //独立正则
        }
        $stat = preg_match_all($preg, $this->content, $arr, PREG_SET_ORDER); //找到所有当前标签名的内容区域

        if (!$stat) { //模板中不存在当前标签 返回
            return false;
        }
        foreach ($arr as $k) {
            $k[1] = $this->replaceCondition($k[1]); //替换GT LT等
            $attr = $this->getTagAttr($k[1]); //属性数组
            $k[2] = isset($k[2]) ? $k['2'] : ''; //内容部分
            $content = call_user_func_array(array($tagObj, '_' . $tagName), array($attr, $k[2], $this->view));
            $this->content = str_replace($k[0], $content, $this->content);
        }
        return true;
    }

    /**
     * 获得标签所有属性  组成为数组
     * @param $attrCon 标签属性行文本内容
     * @return array 标签名如foreach
     */
    private function getTagAttr($attrCon)
    {
        $pregAttr = '/\s*' . '(\w+)\s*=\s*(["\'])(.*)\2/iU'; //属性正则
        $attrs = ''; //属性集合字符串
        preg_match_all($pregAttr, $attrCon, $attrs, PREG_SET_ORDER);
        $attrArr = array();
        foreach ($attrs as $k) {
            $k[3] = trim($this->parsePhpVar($k[3])); //格式化变量
            $attrArr[$k[1]] = strstr($k[3], '$') ? $k[3] : (is_numeric($k[3]) ? $k[3] : (defined($k[3]) ? $k[3] : $k[3])); //格式化规则属性
        }
        return array_change_key_case($attrArr);
    }

    /**
     * 统一解析变量如$_GET $_POST $hd
     * @param $content
     * @return mixed
     */
    private function parseVar($content)
    {
        $stripContent = stripslashes($content);
        $parseConstContent = $this->parseConst($stripContent);
        $content = $this->parsePhpVar($parseConstContent, 1);
        return $content;
    }

    /**
     * 替换连接标题  如gt 替换 >
     * @param $content
     * @return mixed
     */
    private function replaceCondition($content)
    {
        foreach ($this->condition as $k => $v) {
            $content = preg_replace("/$k/", $v, $content);
        }
        return $content;
    }

    /**
     * 将内容中的所有PHP变量进行格式化
     * @param $content 要解析的内容 里面有变量或没有
     * @param int $type
     * @return mixed
     */
    # $b.c     $b|date:y-m-d h:i:s,@@
    private function parsePhpVar($content, $type = 0)
    {
        $parseConstCon = $this->parseConst($content);
        $parseGlobalCon = $this->parseGlobalConst($parseConstCon);
        $replaceLangCon = $this->replaceLangConfig($parseGlobalCon);
        $content = $this->removeEmpty($replaceLangCon); //去除变量空格
        if ($type == 0) {
            $preg = '/([\'\"]?)(\$[^=!<>\s\)\(]+)\1/is'; //得到所有变量表示如$c.a.d|date:"y-m-d",@@
        } else {
            $preg = '/([\'\"]?)(\$[^=!<>\)\(]+)\1/is'; //得到所有变量表示如$c.a.d|date:"y-m-d",@@
        }
        $vars = false; //内容中的变量数组
        preg_match_all($preg, $content, $vars, PREG_SET_ORDER);
        if (empty($vars)) {
            return $content;
        }
        foreach ($vars as $v) {
            $v[2] = trim($v[2]); //清除空格
            $content = str_replace($v[2], $this->formatVar($v[2]), $content);
        }
        return $content;
    }

    /**
     * 解析超全局数组如$_GET,$_POST,$_REQUEST,$_COOKIE,$_SESSION
     */
    private function parseGlobalConst($content)
    {
        $preg = '/\$Hd.(get|post|request|cookie|session|server)\./ise';
        $replace = '\'\$_\'.strtoupper("\1").".";';
        return preg_replace($preg, $replace, $content);
    }

    /**
     * 去除变量中的多余空格如 date | "y-m-d"中的|左右空格就要清除
     */
    private function removeEmpty($content)
    {
        $preg = array(
            '/[{}]/',
            '/\s*\|\s*/',
            '/\s*:\s*/',
            '/\s*,\s*/',
        );
        $replace = array(
            '',
            '|',
            ':',
            ',',
        );
        return preg_replace($preg, $replace, $content); //将变量空格删除，否$a | date等带空格的不能识别
    }

    /**
     * 将一个PHP变量进行格式化  组合成函数或普通变量的形式
     * @param $var 一定要是模版表示的变量内容字符串
     * @return string
     */
    private function formatVar($var)
    {
        $varArr = preg_split("/\s*\|\s*/", $var); //通过|拆分数组  如果有函数
        $varBase = array_shift($varArr); //变量名
        $func = $varArr; //函数数组
        $preg = array(
            "/\.\'/",
            "/'\./",
            '/\."/',
            '/"\./',
            '/{/',
            '/}/',
        );
        $replace = array(
            "/\./",
            "/\./",
            '/\./',
            '/\./',
            '/{/',
            '/}/',
        );
        $con = preg_replace($preg, $replace, $varBase);
        //将变量字符串组合成以.进行分隔的字符串
        $var = explode('.', $con);
        //得到变量名
        $varName = array_shift($var);
        $varStr = ''; //变量字符串
        if (count($var) > 0) {
            foreach ($var as $v) {
                $varStr .= is_numeric($v) || strstr($v, '$') ? "[{$v}]" : '[\'' . $v . '\']';
            }
        }
        $varName .= str_replace("]'", "']", $varStr);
        if (!empty($func)) {
            if (!function_exists("replaceyinhao")) {

                function replaceyinhao($con)
                {
                    return "'" . str_replace(":", "####", $con[2]) . "'";
                }

            }
            foreach ($func as $function) {
                //将内容中的:替换为####以免与标签中的:产生二义
                $function = preg_replace_callback('/(\'|")(.*)\1/i', "replaceyinhao", $function);
                $funcArr = explode(":", $function); //拆分函数  是否有参数
                $functionName = array_shift($funcArr); //函数名称
                //函数别名替换
                $funcName = array_key_exists($functionName, $this->functionAlias) ? $this->functionAlias[$functionName] : $functionName;
                if (isset($funcArr[0])) { //检测函数是否存在参数
                    if (strstr($funcArr[0], "@@")) {
                        $varName = str_replace("@@", trim($varName, ','), $funcArr[0]); //将@@替换为变量
                    } else {
                        $varName = trim($varName, ',') . ',' . $funcArr[0];
                    }
                }
                $varName = str_replace("####", ":", $varName);
                $varName = $funcName . '(' . trim($varName, ',') . '),';
            }
        }
        return trim($varName, ',');
    }

    /**
     * 将变量或常量进行替换
     * @return boolean
     */
    public function compile()
    {
//        $preg = '/{\s*(\$[^=!<>\)\(\+\;]+)}/ieU'; //以{$或$开头的进行解析处理
        $preg = '/{(\$[^=!<>\)\(\+\;]+)}/ieU'; //以{$或$开头的进行解析处理
        $this->content = preg_replace($preg, '\'<?php echo \'. $this->parseVar(\'\1\').\';?>\';', $this->content);
    }

    /**
     * 系统常量解析
     * @param $content 模板内容
     * @return mixed 1加php  0 不加
     */
    private function parseConst($content)
    {
        #$Hd.const.sdf
        $preg = '/\$Hd[\.\[]([\'"])?const\1?[\.\]]([^=!<>\}]*)/is';
        if (!function_exists("replace_view_const")) {

            function replace_view_const($args)
            {
                $name = strtoupper($args[2]);
                return defined($name) ? $name : $args[2];
            }

        }
        return preg_replace_callback($preg, "replace_view_const", $content);
    }

    /**
     * 解析Token
     */
    private function parseTokey()
    {
        if (!C("TOKEN_ON")) return;
        Token::create(); //生成token
        $preg = '/<\/form>/iUs';
        $content = '<input type="hidden" name="<?php echo C("TOKEN_NAME");?>" value="<?php echo $_SESSION[C("TOKEN_NAME")]?>"/></form>';
        $this->content = preg_replace($preg, $content, $this->content);
    }

    /**
     * 将全局常量进行解析替换
     */
    private function replaceConst()
    {
        $const = print_const(false, true);
        foreach ($const as $k => $v) {
            if (!strstr($k, '__'))
                continue;
            $this->content = str_replace($k, $v, $this->content);
        }
    }

}

?>
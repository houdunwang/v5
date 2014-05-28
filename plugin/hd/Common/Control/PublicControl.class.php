<?php


/**
 * 前台使用的公共控制器
 * Class PublicControl
 */
class PublicControl extends CommonControl
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        //网站开启验证
        if (!$this->verification()) {
            $this->display("./data/Template/web_close.html");
            exit;
        }
        //分配模板目录URL
        defined("__TEMPLATE__") or define("__TEMPLATE__", __ROOT__ . "/template/" . C("WEB_STYLE"));
    }


    /**
     * 验证网站是否开启
     */
    private function verification()
    {
        /**
         * 以下情况会进行验证
         * 1. 非管理员
         * 2. 网站没有关闭
         */
        if (session('admin') || C("web_open") == 1) {
            return true;
        }
    }

    /**
     * 调用模板
     */
    protected function display($tplFile = null, $cacheTime = null, $cachePath = null, $stat = false, $contentType = "text/html", $charset = "", $show = true)
    {
        //验证模板文件
        if (is_file($tplFile) && is_readable($tplFile)) {
            //设置缓存目录
            $cachePath = $this->get_cache_path();
            parent::display($tplFile, $cacheTime, $cachePath);
        }
    }
	
}

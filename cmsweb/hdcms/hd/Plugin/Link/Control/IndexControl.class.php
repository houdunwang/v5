<?php

/**
 * 友情链接前台
 * Class IndexControl
 */
class IndexControl extends CommonControl
{
    //模型
    private $_db;
    //配置
    private $_conf;

    //构造函数
    public function __init()
    {
        $conf = M('link_config')->find();
        //是否关闭链接申请
        if ($conf['allow'] == 0) {
            $this->display('close.php');
            exit;
        }
        $this->_db = K('Link');
        $this->_conf = $conf;
    }

    /**
     * 申请友情链接
     */
    public function index()
    {
        $field = $this->_db->table('link_config')->find();
        $this->hdcms = $field;
        //友链分类
        $this->type = $this->_db->table('link_type')->all();
        $this->conf = $this->_conf;
        $this->display('link.php');
    }

    /**
     * 申请友情链接验证码
     */
    public function code()
    {
        if (IS_POST) {
            if(Q('code',null,'strtoupper')==session('code')){
                echo 1;exit;
            }
        } else {
            $code = new Code();
            $code->show();
        }
    }

    /**
     * 添加友情链接
     */
    public function add()
    {
        if (IS_POST) {
            if ($this->_db->add_link()) {
                $this->success('申请链接成功', U('index', array('g' => 'Plugin')));
            } else {
                $this->error($this->_db->error, U('index', array('g' => 'Plugin')));
            }
        }
    }
}
<?php

/**
 * 友情链接配置
 * Class SetControl
 */
class SetControl extends AuthControl
{
    //模型
    private $_db;

    //构造函数
    public function __init()
    {
        $this->_db = K('LinkConfig');
    }

    /**
     * 友情链接配置
     */
    public function set()
    {
        if (IS_POST) {
            if ($this->_db->set_config()) {
                $this->success('设置成功');
            } else {
                $this->error($this->_db->error);
            }
        } else {
            $this->field = $this->_db->find();
            $this->display();
        }
    }
}
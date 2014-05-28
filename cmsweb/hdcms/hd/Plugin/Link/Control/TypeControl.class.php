<?php

class TypeControl extends AuthControl
{
    private $_db;

    public function __init()
    {
        $this->_db = K('LinkType');
    }

    /**
     * 显示类型列表
     */
    public function index()
    {
        $this->type = $this->_db->all();
        $this->display();
    }

    /**
     * 添加分类
     */
    public function add()
    {
        if (IS_POST) {
            if ($this->_db->add_type()) {
                $this->_ajax(1, '添加分类成功');
            } else {
                $this->_ajaxj(0, '添加分类失败');
            }
        } else {
            $this->display();
        }
    }

    /**
     * 添加分类
     */
    public function edit()
    {
        if (IS_POST) {
            if ($this->_db->edit_type()) {
                $this->_ajax(1, '修改分类成功');
            } else {
                $this->_ajaxj(0, '修改分类失败');
            }
        } else {
            $this->field = $this->_db->find(Q('tid'));
            $this->display();
        }
    }

    /**
     * 删除链接类型
     */
    public function del()
    {
        $this->_db->del_type();
        $this->_ajax(1, '删除成功');
    }
}


















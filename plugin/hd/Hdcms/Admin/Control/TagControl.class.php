<?php

/**
 * 内容tag管理
 * Class TagControl
 * @author <houdunwangxj@gmail.com>
 */
class TagControl extends AuthControl
{
    private $_db;

    public function __init()
    {
        $this->_db = K("tag");
    }

    //显示关键词列表
    public function index()
    {
        $page = new Page($this->_db->join()->count(), 15);
        $this->data = $this->_db->join()->limit($page->limit())->order("total DESC")->all();
        $this->page = $page->show();
        $this->display();
    }

    //删除tag
    public function del()
    {
        $tid = Q("post.tid");
        if (!empty($tid)) {
            if (!is_array($tid))
                $tid = array($tid);
            foreach ($tid as $i) {
                $this->_db->del_tag(intval($i));
            }
            $this->_ajax(1, '删除成功!');
        }
    }

    //修改tag
    public function edit()
    {
        if (IS_POST) {
            if ($this->_db->add_tag()) {
                $this->_ajax(1, '修改成功!');
            }
        } else {
            $tid = Q("get.tid", NULL, "intval");
            $this->field = $this->_db->find($tid);
            $this->display();
        }
    }

    //添加tag
    public function add()
    {
        if (IS_POST) {
            if ($this->_db->add_tag()) {
                $this->_ajax(1, '添加成功!');
            }
        } else {
            $this->display();
        }
    }
}
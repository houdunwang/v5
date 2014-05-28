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
        $this->_db = M("tag");
    }

    //显示关键词列表
    public function index()
    {
        $page = new Page($this->_db->count(), 15);
        $this->data = $this->_db->limit($page->limit())->order("total DESC")->all();
        $this->page = $page->show();
        $this->display();
    }

    //删除tag
    public function del()
    {
        $tid = Q("tid",0,'intval');
        if ($tid) {
            if (!is_array($tid))
                $tid = array($tid);
            foreach ($tid as $i) {
                $this->_db->del(intval($i));
            }
            $this->success('删除成功!');
        }
    }

    //修改tag
    public function edit()
    {
        if (IS_POST) {
            if ($this->_db->save()) {
                $this->success('修改成功!');
            }
        } else {
            $tid = Q("get.tid", 0, "intval");
            $this->field = $this->_db->find($tid);
            $this->display();
        }
    }

    //添加tag
    public function add()
    {
        if (IS_POST) {
            if ($this->_db->add()) {
                $this->success( '添加成功!');
            }
        } else {
            $this->display();
        }
    }
}
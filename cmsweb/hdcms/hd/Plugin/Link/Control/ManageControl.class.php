<?php

/**
 * 友情链接管理
 * Class LinkControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ManageControl extends AuthControl
{
    //模型
    protected $_db;

    /**
     * 构造函数
     */
    public function __init()
    {
        $this->_db = K('Link');
    }

    /**
     * 链接列表
     */
    public function index()
    {
        $this->link = $this->_db->where('state=1')->order('id ASC')->all();
        $this->display();
    }

    /**
     * 审核申请
     */
    public function audit()
    {
        $this->link = $this->_db->where('state=0')->all();
        $this->display();
    }

    /**
     * 添加链接
     */
    public function add()
    {
        if (IS_POST) {
            if ($this->_db->add_link()) {
                $this->success('添加链接成功', U('index', array('g' => 'Plugin')));
            } else {
                $this->error($this->_db->error, U('index', array('g' => 'Plugin')));
            }
        } else {
            //友链分类
            $this->type = $this->_db->table('link_type')->all();
            $this->display();
        }
    }

    /**
     * 修改链接
     */
    public function edit()
    {
        if (IS_POST) {
            if ($this->_db->edit_link()) {
                $action =$_POST['state']==1?'index':'audit';
                $this->success('修改链接成功', U($action, array('g' => 'Plugin')));
            } else {
                $this->error($this->_db->error);
            }
        } else {
            //友链分类
            $this->type = $this->_db->table('link_type')->all();
            $this->field = $this->_db->find(Q('id'));
            $this->display();
        }
    }

    /**
     * 删除链接
     */
    public function del()
    {
        if ($this->_db->del_link()) {

            $this->success('删除成功', __HISTORY__);
        }
    }
}
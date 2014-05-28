<?php

/**
 * 文章审核
 * Class ContentControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ContentAuditControl extends AuthControl
{
    //栏目缓存
    private $_category;
    //模型缓存
    private $_model;
    //模型mid
    private $_mid;
    //模型对象
    private $_db;

    //构造函数
    public function __init()
    {
        $this->_model = cache("model", false);
        $this->_category = cache("category", false);
        $this->_mid = Q('mid', 1, 'intval');
        if (!isset($this->_model[$this->_mid])) {
            $this->error("模型不存在！");
        }
        $this->_db = ContentViewModel::getInstance($this->_mid);
    }

    /**
     * 文章列表
     */
    public function content()
    {
        $count = $this->_db->where($this->_db->tableFull.'.content_state=0')->count();
        $page = new Page($count, 15);
        $this->page = $page->show();
        $this->data = $this->_db->where($this->_db->tableFull.'.content_state=0')->limit($page->limit())->order('updatetime DESC')->all();
        $this->mid =$this->_mid;
        $this->model = $this->_model;
        $this->display();
    }

    /**
     * 删除文章
     */
    public function del()
    {
        $aids = Q("request.aid");
        if (!empty($aids)) {
            if (!is_array($aids)) {
                $aids = array($aids);
            }
            foreach ($aids as $aid){
                $this->_db->del($aid);
                $this->_db->table($this->_db->tableFull.'_data',true)->where('aid='.$aid)->del();
            }
            $this->_ajax(1, '删除成功');
        } else {
            $this->_ajax(0, '参数错误');
        }

    }

    /**
     * 审核或取消审核
     */
    public function audit()
    {
        //1 审核  0 取消审核
        $state = Q("state", 1, "intval");
        //文章id
        $aids = Q("post.aid");
        foreach ($aids as $aid) {
            $this->_db->join()->save(array("aid" => $aid, "state" => $state));
        }
        $this->_ajax(1, '操作成功！');
    }
}

































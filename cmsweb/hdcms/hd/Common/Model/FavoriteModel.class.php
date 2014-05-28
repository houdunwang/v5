<?php

/**
 * 收藏夹处理模型
 * Class FavoriteModex
 */
class FavoriteModel extends ViewModel
{
    public $table = 'favorite';
    public $_mid;
    public $_cid;
    public $_aid;
    public $_category;
    public $_model;

    public function __init()
    {
        $this->_category = cache("category");
        $this->_model = cache("model");
        $this->_mid = isset($options['mid']) ? intval($options['mid']) : Q('mid', 1, 'intval');
        $this->_cid = Q('cid', null, 'intval');
        $this->_aid = Q('aid', null, 'intval');
        //主表
        $content_table = $this->_model[$this->_mid]['table_name'];
        //表关联
        $this->view[$content_table] = array(
            'type' => INNER_JOIN,
            'on' => $content_table . '.aid=favorite.aid'
        );
        $this->view['category'] = array(
            'type' => INNER_JOIN,
            'on' => $this->table . '.cid=category.cid'
        );
    }
}
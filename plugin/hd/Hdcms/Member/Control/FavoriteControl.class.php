<?php

/**
 * 收藏夹管理
 * Class FavoriteControl
 */
class FavoriteControl extends MemberAuthControl
{
    public $_db;

    public function __init()
    {
        $this->_db = K('Favorite');
    }

    public function index()
    {
        $where = C('DB_PREFIX').'favorite.uid=' . $_SESSION['uid'];
        $count = $this->_db->join()->where($where)->count();
        $page = new Page($count, 10);
        $this->data = $this->_db->where($where)->limit($page->limit())->all();
        $this->page = $page->show();
        $this->count=$count;
        $this->display();
    }
}
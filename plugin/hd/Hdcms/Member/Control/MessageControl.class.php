<?php

/**
 * 短消息管理
 * Class MessageControl
 */
class MessageControl extends MemberAuthControl
{
    public $_db;

    public function __init()
    {
        $this->_db = K('Message');
    }

    //私信列表
    public function index()
    {
        $where = 'to_uid=' . $_SESSION['uid'];
        $sql = "SELECT count(distinct from_uid) AS c FROM " . C("DB_PREFIX") . "user_message AS um
                WHERE to_uid=" . $_SESSION['uid'];
        $count = $this->_db->query($sql);
        $page = new Page($count[0]['c'], 10);
        $this->data = $this->_db->where($where)->limit($page->limit())->order("mid DESC")->group('from_uid')->all();
        $this->page = $page->show();
        $this->count = $count;
        $this->display();
    }

    /**
     * 查看私信
     */
    public function show()
    {
        $from_uid = Q('from_uid', null, 'intval');
        if ($from_uid) {
            $uid= $_SESSION['uid'];
            $sql = "SELECT * FROM " . C("DB_PREFIX") . "user_message AS um
                WHERE (um.from_uid={$from_uid} AND um.to_uid={$uid}) or
                (um.from_uid={$uid} AND um.to_uid={$from_uid}) ORDER BY mid DESC
                ";
            $this->data = $this->_db->query($sql);
            //更改私信状态为已读
            $this->_db->where("from_uid={$from_uid} AND to_uid={$uid}")->save(array('state' => 1));
            $this->display();
        } else {
            $this->error('参数错误');
        }
    }

    /**
     * 发送私信
     */
    public function send()
    {
        $to_uid = Q('to_uid', null, 'intval');
        if (!isset($_SESSION['uid'])) {
            $this->_ajax(0, '请登录后操作');
        } else if ($to_uid == $_SESSION['uid']) {
            $this->_ajax(0, '不能给自己发信息！');
        } else if (!$to_uid) {
            $this->_ajax(0, '参数错误');
        } else {
            $data = array(
                'from_uid' => $_SESSION['uid'],
                'to_uid' => $to_uid,
                'content' => Q('content'),
                'sendtime' => time()
            );
            $db = M('user_message');
            if ($db->add($data)) {
                $this->_ajax(1, '发送成功');
            } else {
                $this->_ajax(0, '信息发送失败！');
            }
        }
    }
    /**
     * 回复私信
     */
    public function reply()
    {
        $_POST['from_uid'] = $_SESSION['uid'];
        $_POST['sendtime'] = time();
        if ($this->_db->add()) {
            $this->_ajax(1, '回复成功');
        } else {
            $this->_ajax(0, '回复失败');
        }
    }
}
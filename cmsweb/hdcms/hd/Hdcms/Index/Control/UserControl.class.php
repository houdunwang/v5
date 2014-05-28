<?php

/**
 * 前台用户信息
 * Class UserControl
 */
class UserControl extends CommonControl
{
    //获得用户信息
    public function user()
    {
        $uid = Q('uid', null, 'intval');
        if ($uid) {
            $db = M('user');
            $field = $db->find($uid);
            if ($field) {
                //用户角色
                $role = $db->table('role')->where("rid={$field['rid']}")->order('creditslower ASC')->find();
                $field['rname'] = $role['rname'];
                //获得距下一等级的积分差
                $nextRole = $db->table('role')->where("creditslower>{$role['creditslower']}")->order("creditslower ASC")->find();
                $this->nextRole = $nextRole;
                $this->role = $role;
                $this->field = $field;
                //关注状态（已关注 互相关注 关注）
                $db = M('user_follow');
                $result = $db->where("uid={$field['uid']} AND fans_uid=" . $_SESSION['uid'])->find();
                if ($result) {
                    //对方是否关注我
                    $r = $db->where("uid=" . $_SESSION['uid'] . " AND fans_uid={$field['uid']}")->find();
                    if ($r) {
                        $follow = '互相关注';
                    } else {
                        $follow = '已关注';
                    }
                } else {
                    $follow = '关注';
                }
                $this->follow = $follow;
                $con = $this->fetch();
                $this->success($con);
            } else {
                 _404('会员不存在');
            }
        } else {
           _404('会员不存在');
        }

    }
}
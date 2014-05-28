<?php

/**
 * 会员中心权限控制
 * Class MemberAuthControl
 */
class MemberAuthControl extends CommonControl
{
    public function __construct()
    {
        parent::__construct();
        //会员中心是否关闭
        if (C("member_open") == 0 && empty($_SESSION['admin'])) {
            $this->display("./data/Template/close_member");
            exit;
        } else if (!session('uid')) {
            go(U("Member/Login/login"));
        } else if (!empty($_SESSION['lock'])) {
            //锁定用户无法操作（IP禁止，限制访问日期等)
            $this->error('您已被锁定，无法进行操作',__WEB__);
        }

    }

}
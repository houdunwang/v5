<?php

/**
 * 会员（好友）动态
 * Class IndexControl
 */
class DynamicControl extends MemberAuthControl
{
    /**
     * 网站会员动态
     */
    public function index()
    {
        $db = V('user_dynamic');
        $db->view=array(
	        	'user'=>array(
	        		'type'=>INNER_JOIN,
	        		'on'=>'user_dynamic.uid=user.uid'
	        	)
        	);
        $count = $db->join(null)->count();
        $page = new Page($count, 9);
        $this->page = $page->show();
        $this->data = $db->limit($page->limit())->order("did DESC")->all();
        $this->display();
    }

    /**
     * 好友动态
     */
    public function friend()
    {
        $db = V('user_dynamic');
        $db->view=array(
        	'user'=>array(
        		'type'=>INNER_JOIN,
        		'on'=>'user_dynamic.uid=user.uid'
        	),
           'user_follow'=>array(
               'type'=>INNER_JOIN,
               'on'=>'user_follow.uid=user_dynamic.uid'
           )
        );
        $count = $db->where('fans_uid='.$_SESSION['uid'])->count();
        $page = new Page($count, 9);
        $this->page = $page->show();
        $this->data = $db->where('fans_uid='.$_SESSION['uid'])->limit($page->limit())->order("did DESC")->all();
        $this->display();
    }

}
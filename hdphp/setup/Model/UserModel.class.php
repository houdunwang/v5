<?php
if (!defined("HDPHP_PATH")) exit('No direct script access allowed');
/**
 * Copyright    [HDPHP框架] (C)2011-2012 houdunwang.com ,Inc.
 * Licensed     www.apache.org/licenses/LICENSE-2.0
 * Encoding     UTF-8
 * Version      $Id: userModel.php   2012-2-20  17:13:25
 * @author      向军  houdunwangxj@gmail.com
 * Link         www.hdphp.com
 */
class userModel extends relationModel {
    public $join = array(
        'role' => array(//关联表
            'type' => 'MANY_TO_MANY', //包含一条主表记录
            'relation_table' => 'user_role', //中间关联表
            'relation_table_parent_key' => 'uid',
            'relation_table_foreign_key' => 'rid',
            "table"=>'role',
            'field' => 'rid,rname,title', //关联表检索的字段，起别名group_id
            "as"=>"role"
            
        )
    );
}

?>

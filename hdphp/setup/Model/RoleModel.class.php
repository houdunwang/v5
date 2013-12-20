<?php
if (!defined("HDPHP_PATH")) exit('No direct script access allowed');
/**
 * Copyright    [HDPHP框架] (C)2011-2012 houdunwang.com ,Inc.
 * Licensed     www.apache.org/licenses/LICENSE-2.0
 * Encoding     UTF-8
 * Version      $Id: roleModel.php   2012-2-20  20:06:47
 * @author      向军  houdunwangxj@gmail.com
 * Link         www.hdphp.com
 */
class RoleModel extends Model {

    public $view = array(
        "user_role" => array(
            "uid",
            "rid",
            "left=>role.rid=user_role.rid",
        ),
    );

}

?>

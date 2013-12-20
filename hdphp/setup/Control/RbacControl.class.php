<?php

if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');

/**
 * Copyright    [HDPHP框架] (C)2011-2012 houdunwang.com ,Inc.
 * Licensed     www.apache.org/licenses/LICENSE-2.0
 * Encoding     UTF-8
 * Version      $Id: rbacControl.php   2012-2-19  18:46:35
 * @author      向军  houdunwangxj@gmail.com
 * Link         www.hdphp.com
 */
//rbac控制器
class RbacControl extends SetupControl
{

    function index()
    {
        $this->display();
    }

    //设置配置文件
    function setconfig()
    {
        $this->assign("Config", C());
        $this->display();
    }

    //锁定RBAC配置功能
    function lock()
    {
        if (file_put_contents("lock.php", '后盾网 人人做后盾')) {
            $this->success("锁定成功");
        } else {
            $this->error("加锁失败，请修改SETUP目录为可写");
        }
    }

    //修改配置项
    function updateconfig()
    {
        $config = array();
        $config["RBAC_DB_SET"] = 1;
        $config["db_host"] = $_POST['dbhost'];
        $config["db_port"] = empty($_POST['dbport']) ? 3306 : $_POST['dbport'];
        $config["db_user"] = $_POST['dbuser'];
        $config["db_password"] = $_POST['dbpwd'];
        $config["db_database"] = $_POST['dbname'];
        $config["db_prefix"] = $_POST['dbfix'];
        C($config);
        $this->checkDb(); //验证数据库
        $str = "<?php \r\n";
        $str .= "if (!defined('HDPHP_PATH'))exit;\nreturn ";
        $str .= var_export($config, true);
        $str .= " \r\n?>";
        $configFile = CONFIG_PATH . 'config.db.php';
        if (!file_put_contents($configFile, $str)) {
            $this->error("修改RBAC配置文件失败，请修改文件{$configFile}为777");
        }

        $this->success("修改配置文件成功", "index");
    }

    //验证数据库
    private function checkDb()
    {
        $stat = mysql_connect(C("db_host") . ':' . C("db_port"), C("db_user"), C("db_password"));
        mysql_query("CREATE DATABASE IF NOT EXISTS ".C("db_database"));
        if (!$stat || !mysql_select_db(C("db_database"))) {
            $this->error("数据库连接错误，请修改配置项", "setconfig");
        }
    }

    //根据DATA目录中的rbac.sql数据源安装RBAC表
    function createrbactable()
    {
        $this->checkDb(); //验证数据库
        $sqlData = file_get_contents(APP_PATH . '/Data/rbac.sql');
        $tbfix = C("DB_PREFIX");
        $sql = str_replace("hd_", $tbfix, $sqlData);
        $sqlArr = array_filter(explode(';', $sql));
        $db = M();
        foreach ($sqlArr as $v) {
            $db->exe($v);
        }
        $this->success("创建RBAC表完成", 'index');
    }

    //添加角色
    function addrole()
    {
        $this->display();
    }

    //编辑角色视图
    function editroleshow()
    {
        $this->checkDb(); //验证数据库
        $this->assign("role", M("role")->find($_GET['rid']));
        $this->display();
    }

    //编辑角色
    function editrole()
    {
        $this->checkDb(); //验证数据库
        $db = M("role");
        if ($db->save() >= 0) {
            $this->success("修改角色成功", "showrole");
        } else {
            $this->error("修改角色失败", "showrole");
        }
    }

    function showrole()
    {
        $this->checkDb(); //验证数据库
        $db = M("role");
        $row = $db->all();
        if (!$row) {
            $this->error("没有任何组(角色)信息，请先设置", "addrole");
        }
        $this->assign("row", $row);
        $this->display();
    }

    function addentrance()
    {
        $this->checkDb(); //验证数据库
        $db = M("role");
        if ($db->add()) {
            $this->success("添加用户组成功", "showrole");
        } else {
            $this->error("添加失败");
        }
    }

    function delrole()
    {
        $this->checkDb(); //验证数据库
        $db = M("role");
        if ($db->del($_GET['rid'])) {
            $this->success("删除成功");
        } else {
            $this->success("删除失败");
        }
    }

//添加用户视图
    function showadduser()
    {
        $this->checkDb(); //验证数据库
        $db = M("role");
        $role = $db->all();
        if (!$role) {
            $this->error("没有用户组(角色)，先添加用户组", "addrole");
        }
        $this->assign("role", $role);
        $this->display();
    }

//添加用户
    function adduser()
    {
        $this->checkDb(); //验证数据库
        $db = M("user");
        $_POST['password'] = md5($_POST['password']);
        if ($db->add()) {
            $newUid = $db->getInsertId();
            if (!$newUid) {
                $this->error("添加用户失败，请重试");
            }
            $db->table = "user_role";
            $_POST['uid'] = $newUid;
            $db->add();
            $this->success("添加成功", "index");
        } else {
            $this->error("添加用户失败");
        }
    }

//查看用户
    function showuser()
    {
        $this->checkDb(); //验证数据库
        $db = k('user');
        $row = $db->field(array("uid", "username"))->findall();
        if (!$row) {
            $this->error("没有用户信息，请先设置", "showadduser");
        }
        $this->assign("row", $row);
        $this->display();
    }

//删除用户
    function deluser()
    {
        $this->checkDb(); //验证数据库
        $db = M("user");
        if ($db->del($_GET['uid'])) {
            $db->table = "user_role";
            if ($db->del("uid=" . $_GET['uid'])) {
                $this->success("删除用户成功", "index");
            }
        } else {
            $this->error("删除用户失败");
        }
    }

    //自动获取节点信息
    function getnode()
    {
        $this->display();
    }

    function shownode()
    {
        $this->checkDb(); //验证数据库
        $node = Rbac::getNodeList();
        if (!$node) {
            $this->error("还没有设置权限节点，请设置", 'showaddnode');
        }
        $this->assign("node", $node);
        $this->display();
    }

    function showaddnode()
    {
        $level = isset($_GET['level']) ? $_GET['level'] : 0;
        switch ($level) {
            case 0:
                $node = array(
                    array('level' => 1, 'name' => '应用'),
                    array('level' => 2, 'name' => '模块控制器'),
                    array('level' => 3, 'name' => '控制器方法'),
                );
                break;
            case 1:
                $node = array(
                    array('level' => 2, 'name' => '模块控制器'),
                    array('level' => 3, 'name' => '控制器方法'),
                );
                break;
            case 2:
                $node = array(
                    array('level' => 3, 'name' => '控制器方法'),
                );
                break;
            default:
                $this->error("操作错误,当前节点已经是控制器方法，不能再添加");
        }
        $this->assign("node", $node);
        $this->display();
    }

    //删除节点
    function delnode()
    {
        $this->checkDb(); //验证数据库
        $db = M("node");
        $nid = $_GET['nid'];
        if ($db->where("pid=$nid")->find()) {
            $this->error("请先删除子节点");
        }
        if ($db->del($nid)) {
            $this->success('删除成功');
        } else {
            $this->error("删除失败");
        }
    }

    function addnode()
    {
        $db = M("node");
        if ($db->add()) {
            $this->success("添加节点成功", 'shownode');
        } else {
            $this->error("节点添加失败");
        }
    }

    //设置角色权限
    function setaccess()
    {
        $rid = $_GET['rid'];
        $db = k("role");
        $role = $db->find($rid);
        $this->assign('role', $role);
        $node = Rbac::getNodeList($rid);
        if (!$node) {
            $this->error("还没有设置权限节点，请设置", 'showaddnode');
        }
        $this->assign('node', $node);
        $this->display();
    }

    /**
     * 添加角色权限
     */
    function addaccess()
    {
        $db = M("access");
        $db->where("rid=" . $_POST['rid'])->del();
        if (empty($_POST['node'])) {
            $this->success("已经全部删除");
        } else {
            foreach ($_POST['node'] as $v) {
                $db->rid = $_POST['rid'];
                $db->nid = $v;
                $db->add($db);
            }
            $this->success("操作成功");
        }
    }

}

?>

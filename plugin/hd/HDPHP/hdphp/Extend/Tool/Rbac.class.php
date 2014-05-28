<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * RBAC基于角色的权限控制
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Rbac
{

    static public $error; //错误信息

    /**
     * 获得所有RBAC表，自动根据配置文件处理，加表前缀
     * @return array
     */

    static private function getRbacTable()
    {
        $tableName = array(
            "RBAC_USER_TABLE", "RBAC_ROLE_TABLE", "RBAC_NODE_TABLE", "RBAC_ROLE_USER_TABLE", "access_table"
        );
        $preFix = C("DB_PREFIX");
        $tables = array();
        foreach ($tableName as $name) {
            $table = C($name);
            if (strpos($preFix, $name) !== 0) {
                $table = $preFix . $table;
            }
            $tables[$name] = $table;
        }
        return $tables;
    }

    /**
     * 根据SESSION值验证用户是否登录
     * @return boolean
     */
    static public function isLogin()
    {
        return session(C("RBAC_AUTH_KEY")) ? true : false;
    }

    /**
     * 用户登录操作
     * 用户登录成功后将权限信息写入$_SESSION
     * 如果用户登录成功并且用户名与$superadmin参数相同，此用户即为超级用户，不受任何访问权限限制
     * @param string $username              用户名
     * @param string $password              密码
     * @param string $superadmin            超级管理员帐号
     * @param string $fieldUserName         用户表中的用户名字段名称
     * @param string $fieldPassword         用户表中的密码字段名称
     * @return boolean
     */
    static public function login($username, $password, $superadmin = null, $fieldUserName = null, $fieldPassword = null)
    {
        $superadmin = is_null($superadmin) ? C("RBAC_SUPER_ADMIN") : $superadmin;
        $fieldUserName = is_null($fieldUserName) ? C("RBAC_USERNAME_FIELD") : $fieldUserName; //用户表中的用户名字段名称
        $fieldPassword = is_null($fieldPassword) ? C("RBAC_PASSWORD_FIELD") : $fieldPassword; //用户表中的密码字段名称
        if (!C("RBAC_USER_TABLE")) {
            halt('用户表设置错误，请在配置文件中添加用户表');
        }
        $table_user = C('DB_PREFIX') . str_ireplace(C('DB_PREFIX'), "", C("RBAC_USER_TABLE")); //验证有无前缀得到用户表
        $db = M($table_user, true);
        $user = $db->find("$fieldUserName='$username'");
        if (!$user) {
            self::$error = '用户不存在';
            return false;
        }
        if ($user[$fieldPassword] != $password) {
            self::$error = '密码输入错误';
            return false;
        }
        $uid = C("RBAC_AUTH_KEY");//验证session中的key
        $db->table(C("RBAC_ROLE_USER_TABLE"));
        $sql = "SELECT * FROM " . C("DB_PREFIX") . C("RBAC_ROLE_TABLE") . " AS r," .
            C('DB_PREFIX') . C('RBAC_ROLE_USER_TABLE') .
            " AS r_u WHERE r_u.rid = r.rid AND {$uid} = '" .
            $user[$uid] . "'";
        $userRoleInfo = $db->query($sql); //获得用户组信息

        $_SESSION['username'] = $user['username'];
        $_SESSION[C("RBAC_AUTH_KEY")] = $user[$uid];
        $_SESSION['role'] = $userRoleInfo[0]['rname'];
        $_SESSION['rid'] = $userRoleInfo[0]['rid'];
        //是否判断超管理员
        if (strtoupper($user['username']) == strtoupper($superadmin)) {
            //登录成功
            $_SESSION[C("RBAC_SUPER_ADMIN")] = 1;
            $_SESSION["RBAC"] = array();
            return true;
        }
        if (!$_SESSION['rid']) { //不属于任何角色
            self::$error = '不属于任何组，没有访问权限';
            return false;
        }
        self::getAccess(); //获得权限写入SESSION
        return true;
    }

    /**
     * 将rbac信息保存到$_SESSION中
     * $_SESSION['RBAC'] 权限数据组
     */
    static private function getAccess()
    {
        //清空原RBAC数据
        if (isset($_SESSION['RBAC'])) {
            $_SESSION['RBAC'] = '';
        }
        $table = self::getRbacTable(); //获得所有RBAC表
        $nodeTable = $table['RBAC_NODE_TABLE']; //节点表
        $accessTable = $table['access_table']; //权限表
        $roleTable = $table['RBAC_ROLE_TABLE']; //角色表
        $rid = intval($_SESSION['rid']); //角色ID
        //数据库权限
        $sql = "SELECT  n.nid AS n_nid, n.name AS n_name, " .
            "n.title AS n_title,n.level AS n_level, n.pid AS n_pid " .
            "FROM " . $nodeTable . " AS n " .
            "INNER JOIN " . $accessTable . " AS a ON n.nid = a.nid " .
            "INNER JOIN " . $roleTable . " AS r ON r.rid = a.rid " .
            "WHERE a.rid =" . $rid . " AND n.state =1 " .
            "AND r.state =1 " .
            "ORDER BY n.level,n.sort";
        $info = M()->query($sql);
        if (!$info)
            return false;
        $accessNode = array_change_value_case($info);
        $access = array();
        foreach ($accessNode as $v) {
            if ($v['n_level'] == 1) {
                $access[$v['n_name']] = array();
                foreach ($info as $n) {
                    if ($n['n_pid'] == $v['n_nid']) {
                        $access[$v['n_name']][$n['n_name']] = array();
                        foreach ($info as $j) {
                            if ($j['n_pid'] == $n['n_nid']) {
                                $access[$v['n_name']][$n['n_name']][] = $j["n_name"];
                            }
                        }
                    }
                }
            }
        }
        $_SESSION["RBAC"] = array_change_key_case_d(array_change_value_case($access)); //将权限保存到SESSION
        return true;
    }

    /**
     * 获得角色所有节点
     * @param int $rid 角色ID，角色id如果传值将获得角色的所有权限信息
     * @return array
     */
    static public function getNodeList($rid = null)
    {
        $table = self::getRbacTable(); //获得所有RBAC表
        $nodeTable = $table['RBAC_NODE_TABLE']; //节点表
        $accessTable = $table['access_table']; //权限表
        $where = $rid ? " WHERE rid =$rid" : "";
        $sql = "SELECT n.nid,n.name ,n.title,n.state,n.pid ,n.level, " .
            " a.rid AS rid FROM " .
            $nodeTable . " AS n " .
            "LEFT JOIN (select * from $accessTable  $where) AS a " .
            "ON n.nid = a.nid " .
            "ORDER BY n.level,n.sort ASC";
        $data = M()->query($sql);
        if (!$data)
            return array();
        $nodes = array(); //组合后的节点
        foreach ($data as $n) {
            if ($n['level'] == 1) {
                $nodes[$n['nid']] = $n;
                $nodes[$n['nid']]['node'] = array();
                foreach ($data as $m) {
                    if ($n['nid'] == $m['pid']) {
                        $nodes[$n['nid']]['node'][$m['nid']] = $m;
                        $nodes[$n['nid']]['node'][$m['nid']]['node'] = array();
                        foreach ($data as $c) {
                            if ($m['nid'] == $c['pid']) {
                                $nodes[$n['nid']]['node'][$m['nid']]['node'][$c['nid']] = $c;
                            }
                        }
                    }
                }
            }
        }
        return array_change_key_case_d(array_change_value_case($nodes));
    }

    /**
     * 验证用户访问权限
     * @return boolean
     */
    static public function checkAccess()
    {
        //不验证标识
        if (isset($_SESSION[C("RBAC_SUPER_ADMIN")]) && !empty($_SESSION[C("RBAC_SUPER_ADMIN")]))
            return true;
        //不需要验证
        if (self::noAuth()) {
            return true;
        }
        //没有登录
        if (!isset($_SESSION[C('RBAC_AUTH_KEY')])) {
            return false;
        }
        //时时认证
        if (C("RBAC_TYPE") == 1) {
            self::getAccess();
        }
        //不需要验证的方法 例app/control/method
        if (self::noAuth()) {
            return true;
        }
        //如果不存在RBAC内容 不验证返回
        if (!isset($_SESSION['RBAC']) || empty($_SESSION['RBAC'])) {
            return false;
        }
        $access = $_SESSION['RBAC'];
        if (!is_array($access)) {
            return false;
        }
        $_app = strtolower(APP);
        $_control = strtolower(CONTROL);
        $_method = strtolower(METHOD);
        if (array_key_exists_d($_app, $access)) {
            if (array_key_exists_d($_control, $access[$_app])) {
                if (in_array($_method, $access[$_app][$_control])) {
                    return true;
                }
            }
        }
        return false;
    }

    //检测不需要验证的方法
    static private function noAuth()
    {
        $noAuth = C("RBAC_NO_AUTH");
        if (empty($noAuth) || !is_array($noAuth)) {
            return false;
        }
        foreach ($noAuth as $v) {
            $arr = preg_split("/\||\//", $v);
            if (count($arr) != 2) {
                error("配置项:RBAC_NO_AUTH 设置错误必须为[控制器/方法]格式", false);
            }
            if (strtolower(CONTROL) == strtolower($arr[0]) AND strtolower(METHOD) == strtolower($arr[1])) {
                return true;
            }
        }
        return false;
    }

}
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
 * 数据处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Data
{
    /**
     * 本函数即将废弃
     * @param $data
     * @param string $fieldPri
     * @param string $fieldPid
     * @param int $pid
     * @param null $sid
     * @param int $type 1 获得多层栏目  | 2 获得所有子栏目 3 获得父级栏目 4 判断是否为子栏目
     * @param string $html
     * @param int $level
     * @return array|bool
     */
    static public function channel($data, $fieldPri = 'cid', $fieldPid = 'pid', $pid = 0, $sid = null, $type = 2, $html = "&nbsp;", $level = 1)
    {
        switch ($type) {
            case 1:
                return self::channelLevel($data, $pid, $html, $fieldPri, $fieldPid, $level);
            case 2:
                return self::channelList($data, $pid, $html, $fieldPri, $fieldPid, $level);
            case 3:
                return self::parentChannel($data, $sid, $html, $fieldPri, $fieldPid, $level);
            case 4:
                return self::isChild($data, $sid, $pid, $fieldPri, $fieldPid);
        }
    }

    /**
     * 获得所有子栏目
     * @param $data 栏目数据
     * @param int $pid 操作的栏目
     * @param string $html 栏目名前字符
     * @param string $fieldPri 表主键
     * @param string $fieldPid 父id
     * @param int $level 等级
     * @return array
     */
    static public function channelList($data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1)
    {
        if (empty($data) || !is_array($data) || !is_array(current($data))) {
            return array();
        }
        $arr = array();
        $id = 0;
        foreach ($data as $v) {
            if ($v[$fieldPid] == $pid) {
                $arr[$id] = $v;
                $arr[$id]['level'] = $level;
                $arr[$id]['html'] = str_repeat($html, $level - 1);
                $sArr = self::channelList($data, $v[$fieldPri], $html, $fieldPri, $fieldPid, $level + 1);
                $arr = array_merge($arr, $sArr);
                $id = count($arr);
            }
        }
        if (count($data) == $id) {
            foreach ($arr as $n => $m) {
                //第一层不处理
                if ($m['level'] == 1) {
                    $arr[$n]['_end'] = $arr[$n]['_pre'] = true;
                    continue;
                }
                $arr[$n]['_end'] = $arr[$n]['_pre'] = false;
                if (isset($arr[$n + 1]) && $arr[$n]['level'] > $arr[$n + 1]['level']) {
                    $arr[$n]['_end'] = true;
                }
                if ($arr[$n - 1]['level'] != $m['level']) {
                    $arr[$n]['_pre'] = true;
                }
            }
        }
        return $arr;
    }

    /**
     * 获得树状数据
     * @param $data 数据
     * @param $title 字段描述
     * @param string $fieldPri 主键id
     * @param string $fieldPid 父id
     * @return array
     */
    static public function tree($data, $title, $fieldPri = 'cid', $fieldPid = 'pid')
    {
        if (!is_array($data) || empty($data)) return array();
        $arr = Data::channelList($data, 0, "", $fieldPri, $fieldPid);
        foreach ($arr as $k => $v) {
            $str = "";
            if ($v['level'] > 2) {
                for ($i = 1; $i < $v['level'] - 1; $i++) {
                    $str .= "│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            if ($v['level'] != 1) {
                $t = $title? $v[$title]:"";
                if (isset($arr[$k + 1]) && $arr[$k + 1]['level'] >= $arr[$k]['level']) {
                    $arr[$k][$title] = $str . "├─" . $v['html'] . $t;
                } else {
                    $arr[$k][$title] = $str . "└─" . $v['html'] . $t;
                }
            }
        }
        return $arr;
    }

    /**
     * 返回多层栏目
     * @param $data 操作的数组
     * @param int $pid 一级PID的值
     * @param string $html 栏目名称前缀
     * @param string $fieldPri 唯一键名，如果是表则是表的主键
     * @param string $fieldPid 父ID键名
     * @param int $level 不需要传参数（执行时调用）
     * @return array
     */
    static public function channelLevel($data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1)
    {
        if (!$data) {
            return array();
        }
        $arr = array();
        foreach ($data as $v) {
            if ($v[$fieldPid] == $pid) {
                $arr[$v[$fieldPri]] = $v;
                $arr[$v[$fieldPri]]['html'] = str_repeat($html, $level - 1);
                $arr[$v[$fieldPri]]["data"] = self::channelLevel($data, $v[$fieldPri], $html, $fieldPri, $fieldPid, $level + 1);
            }
        }
        return $arr;
    }


    /**
     * 获得所有父级栏目
     * @param $data 栏目数据
     * @param $sid 子栏目
     * @param string $html 栏目名称前缀
     * @param string $fieldPri 唯一键名，如果是表则是表的主键
     * @param string $fieldPid 父ID键名
     * @return array
     */
    static public function parentChannel($data, $sid, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid')
    {
        if (!$data) {
            return NULL;
        }
        static $arr = array();
        foreach ($data as $v) {
            if ($v[$fieldPri] == $sid) {
                $arr[] = $v;
                self::parentChannel($data, $v[$fieldPid], $html, $fieldPri, $fieldPid);
            }
        }
        return $arr;
    }

    /**
     * 判断$s_cid是否是$d_cid的子栏目
     * @param $data 栏目数据
     * @param $sid 子栏目id
     * @param $pid 父栏目id
     * @param string $fieldPri 主键
     * @param string $fieldPid 父id字段
     * @return bool
     */
    static function isChild($data, $sid, $pid, $fieldPri = 'cid', $fieldPid = 'pid')
    {
        $_data = self::channelList($data, $pid, "", $fieldPri, $fieldPid);
        foreach ($_data as $c) {
            //目标栏目为源栏目的子栏目
            if ($c[$fieldPri] == $sid) return true;
        }
        return false;
    }

    /**
     * 递归实现迪卡尔乘积
     * @param $arr 操作的数组
     * @param array $tmp
     * @return array
     */
    static function descarte($arr, $tmp = array())
    {
        static $n_arr = array();
        foreach (array_shift($arr) as $v) {
            $tmp[] = $v;
            if ($arr) {
                self::descarte($arr, $tmp);
            } else {
                $n_arr[] = $tmp;
            }
            array_pop($tmp);
        }
        return $n_arr;
    }

}

?>
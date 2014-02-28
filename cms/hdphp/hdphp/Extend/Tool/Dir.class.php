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
 * 目录处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Dir
{

    /**
     * @param string $dir_name 目录名
     * @return mixed|string
     */
    static public function dirPath($dir_name)
    {
        $dirname = str_ireplace("\\", "/", $dir_name);
        return substr($dirname, "-1") == "/" ? $dirname : $dirname . "/";
    }

    /**
     * 获得扩展名
     * @param string $file 文件名
     * @return string
     */
    static public function getExt($file)
    {
        return strtolower(substr(strrchr($file, "."), 1));
    }

    /**
     * 遍历目录内容
     * @param string $dirName 目录名
     * @param string $exts 读取的文件扩展名
     * @param int $son 是否显示子目录
     * @param array $list
     * @return array
     */
    static public function tree($dirName = null, $exts = '', $son = 0, $list = array())
    {
        if (is_null($dirName)) $dirName = '.';
        $dirPath = self::dirPath($dirName);
        static $id = 0;
        if (is_array($exts))
            $exts = implode("|", $exts);
        foreach (glob($dirPath . '*') as $v) {
            $id++;
            if (is_dir($v) || !$exts || preg_match("/\.($exts)/i", $v)) {
                $list [$id] ['name'] = basename($v);
                $list [$id] ['path'] = str_replace("\\", "/", realpath($v));
                $list [$id] ['type'] = filetype($v);
                $list [$id] ['filemtime'] = filemtime($v);
                $list [$id] ['fileatime'] = fileatime($v);
                $list [$id] ['size'] = is_file($v) ? filesize($v) : self::get_dir_size($v);
                $list [$id] ['iswrite'] = is_writeable($v) ? 1 : 0;
                $list [$id] ['isread'] = is_readable($v) ? 1 : 0;
            }
            if ($son) {
                if (is_dir($v)) {
                    $list = self::tree($v, $exts, $son = 1, $list);
                }
            }
        }
        return $list;
    }

    static public function get_dir_size($f)
    {
        $s = 0;
        foreach (glob($f . '/*') as $v) {
            $s += is_file($v) ? filesize($v) : self::get_dir_size($v);
        }
        return $s;
    }

    /**
     * 只显示目录树
     * @param null $dirName 目录名
     * @param int $son
     * @param int $pid 父目录ID
     * @param array $dirs 目录列表
     * @return array
     */
    static public function treeDir($dirName = null, $son = 0, $pid = 0, $dirs = array())
    {
        if (!$dirName) $dirName = '.';
        static $id = 0;
        $dirPath = self::dirPath($dirName);
        foreach (glob($dirPath . "*") as $v) {
            if (is_dir($v)) {
                $id++;
                $dirs [$id] = array("id" => $id, 'pid' => $pid, "dirname" => basename($v), "dirpath" => $v);
                if ($son) {
                    $dirs = self::treeDir($v, $son, $id, $dirs);
                }
            }
        }
        return $dirs;
    }

    /**
     * 删除目录及文件，支持多层删除目录
     * @param string $dirName 目录名
     * @return bool
     */
    static public function del($dirName)
    {
        if (is_file($dirName)) {
            unlink($dirName);
            return true;
        }
        $dirPath = self::dirPath($dirName);
        foreach (glob($dirPath . "*") as $v) {
            is_dir($v) ? self::del($v) : unlink($v);
        }
        return @rmdir($dirName);
    }

    /**
     * 批量创建目录
     * @param $dirName 目录名数组
     * @param int $auth 权限
     * @return bool
     */
    static public function create($dirName, $auth = 0755)
    {
        $dirPath = self::dirPath($dirName);
        if (is_dir($dirPath))
            return true;
        $dirs = explode('/', $dirPath);
        $dir = '';
        foreach ($dirs as $v) {
            $dir .= $v . '/';
            if (is_dir($dir))
                continue;
            mkdir($dir, $auth);
        }
        return is_dir($dirPath);
    }

    /**
     * 复制目录
     * @param string $olddir 原目录
     * @param string $newdir 目标目录
     * @param bool $strip_space 去空白去注释
     * @return bool
     */
    static public function copy($olddir, $newdir, $strip_space = false)
    {
        $olddir = self::dirPath($olddir);
        $newdir = self::dirPath($newdir);
        if (!is_dir($olddir))
            error("复制失败：" . $olddir . "目录不存在");
        if (!is_dir($newdir))
            self::create($newdir);
        foreach (glob($olddir . '*') as $v) {
            $to = $newdir . basename($v);
            if (is_file($to))
                continue;
            if (is_dir($v)) {
                self::copy($v, $to, $strip_space);
            } else {
                if ($strip_space) {
                    $data = file_get_contents($v);
                    file_put_contents($to, strip_space($data));
                } else {
                    copy($v, $to);
                }
                chmod($to, "0777");
            }
        }
        return true;
    }

    /**
     * 目录下创建安全文件
     * @param $dirName 操作目录
     * @param bool $recursive 为true会递归的对子目录也创建安全文件
     */
    static public function safeFile($dirName, $recursive = false)
    {
        //记录已经操作过的目录
        static $s = array();
        $file = HDPHP_TPL_PATH . '/index.html';
        if (!is_dir($dirName)) return;
        $dirPath = self::dirPath($dirName);
        is_file($dirPath . 'index.html') || copy($file, $dirPath . 'index.html');
        foreach (glob($dirPath . "*") as $d) {
            if (is_dir($d) && !in_array($d, $s)) {
                $s[] = $d;
                is_file($d . '/index.html') || copy($file, $d . '/index.html');
                $recursive && self::safeFile($d);
            }
        }
    }

}
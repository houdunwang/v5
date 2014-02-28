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
 * 上传处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class Upload
{

    //上传类型
    public $ext = array();
    //上传文件大小
    public $size;
    //上传路径
    public $path;
    //错误信息
    public $error;
    //缩略图处理
    public $thumbOn;
    //缩略图参数
    public $thumb = array();
    //是否加水印
    public $waterMarkOn;
    //上传成功文件信息
    public $uploadedFile = array();

    /**
     * 构造函数
     * @param string $path 上传路径
     * @param array $ext 允许的文件类型,传入数组如array('jpg','jpeg','png','doc')
     * @param array $size 允许上传大小,如array('jpg'=>200000,'rar'=>'39999') 如果不设置系统会依据配置项C("UPLOAD_EXT_SIZE")值
     * @param bool $waterMarkOn 是否加水印
     * @param bool $thumbOn 是否生成缩略图
     * @param array $thumb 缩略图处理参数  只接收3个参数 1缩略图宽度 2缩略图高度  3缩略图生成规则
     */
    public function __construct($path = '', $ext = array(), $size = array(), $waterMarkOn = null, $thumbOn = null, $thumb = array())
    {
        $path = empty($path) ? C("UPLOAD_PATH") : $path; //上传路径
        $this->path = rtrim(str_replace('\\', '/', $path), '/') . '/';
        $_ext = empty($ext) ? array_keys(C("UPLOAD_EXT_SIZE")) : $ext; //上传类型
        foreach ($_ext as $v) {
            $this->ext[] = strtoupper($v);
        }
        $this->size = $size ? $size : array_change_key_case_d(C("UPLOAD_EXT_SIZE"), 1);
        $this->waterMarkOn = is_null($waterMarkOn) ? C("WATER_ON") : $waterMarkOn;
        $this->thumbOn = is_null($thumbOn) ? C("UPLOAD_THUMB_ON") : $thumbOn;
        $this->thumb = $thumb;
    }


    /**
     * 将$_FILES中的文件上传到服务器
     * 可以只上传$_FILES中的一个文件
     * @param null $fieldName 上传的图片name名
     * @return array|bool
     * <code>
     * 示例1：
     * $upload= new Upload();
     * $upload->upload();
     * 示例2:
     * $upload= new Upload();
     * $upload->upload("pic");
     * </code>
     */
    public function upload($fieldName = null)
    {
        if (!$this->checkDir($this->path)) {
            $this->error = $this->path . '图片上传目录创建失败或不可写';
            return false;
        }
        $files = $this->format($fieldName);
        //验证文件
        foreach ($files as $v) {
            $info = pathinfo($v ['name']);
            $v ["ext"] = isset($info ["extension"]) ? $info['extension'] : '';
            $v['filename'] = isset($info['filename']) ? $info['filename'] : '';
            if (!$this->checkFile($v)) {
                continue;
            }
            $uploadedFile = $this->save($v);
            if ($uploadedFile) {
                $this->uploadedFile [] = $uploadedFile;
            }
        }
        return $this->uploadedFile;
    }

    /**
     * 储存文件
     * @param string $file 储存的文件
     * @return boolean
     */
    private function save($file)
    {
        $is_img = 0;
        $uploadFileName = mt_rand(1, 9999) . time() . "." . $file['ext'];
        $filePath = $this->path . $uploadFileName;
        if (in_array(strtolower($file ['ext']), array("jpeg", "jpg", "bmp", "gif", "png")) && getimagesize($file ['tmp_name'])) {
            $imgDir = C("UPLOAD_IMG_DIR") ? C("UPLOAD_IMG_DIR") . "/" : "";
            $filePath = $this->path . $imgDir . $uploadFileName;
            if (!$this->checkDir($this->path . $imgDir)) {
                $this->error = '图片上传目录创建失败或不可写';
                return false;
            }
            $is_img = 1;
        }
        if (!move_uploaded_file($file ['tmp_name'], $filePath)) {
            $this->error('移动临时文件失败');
            return false;
        }

        if (!$is_img) {
            $filePath = ltrim(str_replace(ROOT_PATH, '', $filePath), '/');
            $arr = array("path" => $filePath, 'fieldname' => $file['fieldname'], 'image' => 0);
        } else {
            //处理图像类型文件
            $img = new image ();
            $imgInfo = getimagesize($filePath);
            //对原图进行缩放
            if (C("UPLOAD_IMG_RESIZE_ON") && ($imgInfo[0] > C("UPLOAD_IMG_MAX_WIDTH") || $imgInfo[1] > C("UPLOAD_IMG_MAX_HEIGHT"))) {
                $img->thumb($filePath, $uploadFileName, C("UPLOAD_IMG_MAX_WIDTH"), C("UPLOAD_IMG_MAX_HEIGHT"), 5, $this->path);
            }
            //生成缩略图
            if ($this->thumbOn) {
                $args = array();
                if (empty($this->thumb)) {
                    array_unshift($args, $filePath);
                } else {
                    array_unshift($args, $filePath, "", "");
                    $args = array_merge($args, $this->thumb);
                }
                $thumbFile = call_user_func_array(array($img, "thumb"), $args);
            }
            //加水印
            if ($this->waterMarkOn) {
                $img->water($filePath);
            }
            $filePath = trim(str_replace(ROOT_PATH, '', $filePath), '/');
            if ($this->thumbOn) {
                $thumbFile = trim(str_replace(ROOT_PATH, '', $thumbFile), '/');
                $arr = array("path" => $filePath, "thumb" => $thumbFile, 'fieldname' => $file['fieldname'], 'image' => 1);
            } else {
                $arr = array("path" => $filePath, 'fieldname' => $file['fieldname'], 'image' => 1);
            }
        }
        $arr['path'] = preg_replace('@\./@', '', $arr['path']);
        //上传时间
        $arr['uptime'] = time();
        $info = pathinfo($filePath);
        $arr['fieldname'] = $file['fieldname'];
        $arr['basename'] = $info['basename'];
        $arr['filename'] = $info['filename'];
        $arr['size'] = $file['size'];
        $arr['ext'] = $file['ext'];
        $dir= str_ireplace("\\", "/", dirname($arr['path']));
        $arr['dir']=substr($dir, "-1") == "/" ? $dir : $dir . "/";
        return $arr;
    }

    //将上传文件整理为标准数组
    private function format($fieldName)
    {
        if ($fieldName == null) {
            $files = $_FILES;
        } else if (isset($_FILES[$fieldName])) {
            $files[$fieldName] = $_FILES[$fieldName];
        }
        if (!isset($files)) {
            $this->error = '没有任何文件上传';
            return false;
        }
        $info = array();
        $n = 0;
        foreach ($files as $name => $v) {
            if (is_array($v ['name'])) {
                $count = count($v ['name']);
                for ($i = 0; $i < $count; $i++) {
                    foreach ($v as $m => $k) {
                        $info [$n] [$m] = $k [$i];
                    }
                    $info [$n] ['fieldname'] = $name; //字段名
                    $n++;
                }
            } else {
                $info [$n] = $v;
                $info [$n] ['fieldname'] = $name; //字段名
                $n++;
            }
        }
        return $info;
    }

    /**
     * 验证目录
     * @param string $path 目录
     * @return bool
     */
    private function checkDir($path)
    {
        return Dir::create($path) && is_writeable($path) ? true : false;
    }

    private function checkFile($file)
    {
        if ($file ['error'] != 0) {
            $this->error($file ['error']);
            return false;
        }
        $ext = strtoupper($file ['ext']);
        $ext_size = is_array($this->size) && isset($this->size[$ext]) ? $this->size[$ext] : $this->size;
        if (!in_array($ext, $this->ext)) {
            $this->error = '文件类型不允许';
            return false;
        }
        if (strstr(strtolower($file['type']), "image") && !getimagesize($file['tmp_name'])) {
            $this->error = '上传内容不是一个合法图片';
            return false;
        }
        if ($file ['size'] > $ext_size) {
            $this->error = '上传文件大于' . get_size($ext_size);
            return false;
        }

        if (!is_uploaded_file($file ['tmp_name'])) {
            $this->error = '非法文件';
            return false;
        }
        return true;
    }

    private function error($error)
    {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE :
                $this->error = '上传文件超过PHP.INI配置文件允许的大小';
                break;
            case UPLOAD_ERR_FORM_SIZE :
                $this->error = '文件超过表单限制大小';
                break;
            case UPLOAD_ERR_PARTIAL :
                $this->error = '文件只上有部分上传';
                break;
            case UPLOAD_ERR_NO_FILE :
                $this->error = '没有上传文件';
                break;
            case UPLOAD_ERR_NO_TMP_DIR :
                $this->error = '没有上传临时文件夹';
                break;
            case UPLOAD_ERR_CANT_WRITE :
                $this->error = '写入临时文件夹出错';
                break;
        }
    }

    /**
     * 返回上传时发生的错误原因
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}
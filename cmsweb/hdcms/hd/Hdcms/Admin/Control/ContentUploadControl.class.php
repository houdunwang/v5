<?php
if(!defined("HDPHP_PATH"))exit;
/**
 * 文章附件上传(Thumb,Image,Images)
 * Class IndexControl
 * @author hdxj<houdunwangxj@gmail.com>
 */
class ContentUploadControl extends CommonControl
{
	private $_db;
	public function __init(){
		$this->_db = M('upload');
	}
    //显示文件列表
    public function index()
    {
        //上传类型
        $type = Q('type', null, 'strtolower');
        //上传目录
        $dir = C('UPLOAD_PATH')."/" . Q("get.dir", "content") . "/" .date("Y/m/d/");
        //上传数量
        $limit = Q("get.num", 1, "intval");
        //上传文件类型
        $filetype = Q('filetype', 'jpg,png,gif,jpeg', 'strtolower');
        //uploadify插件使用的上传类型
        $uploadtype = '*.' . str_replace(',', ',*.', $filetype);
        switch ($type) {
            case 'thumb':
                //最大上传图片尺寸
                $upload_img_max_width = C('upload_img_max_width');
                $upload_img_max_height = C('upload_img_max_height');
                $tag = array(
                    "type" => $filetype,
                    "name" => "hdcms",
                    "dir" => $dir,
                    "limit" => 1,
                    "width" => 88,
                    "height" => 78,
                    "waterbtn" => 1,
                    "upload_img_max_width" => $upload_img_max_width,
                    "upload_img_max_height" => $upload_img_max_height,
                );
                break;
            case 'image':
                //最大上传图片尺寸
                $upload_img_max_width = C('upload_img_max_width');
                $upload_img_max_height = C('upload_img_max_height');
                $tag = array(
                    "type" => $filetype,
                    "name" => "hdcms",
                    "dir" => $dir,
                    "limit" => 1,
                    "width" => 88,
                    "height" => 78,
                    "waterbtn" => 1,
                    "upload_img_max_width" => $upload_img_max_width,
                    "upload_img_max_height" => $upload_img_max_height,
                );
                break;
            case 'images';
                //最大上传图片尺寸
                $upload_img_max_width = Q('upload_img_max_width') ? Q('upload_img_max_width') : C('upload_img_max_width');
                $upload_img_max_height = Q('upload_img_max_height') ? Q('upload_img_max_height') : C('upload_img_max_height');
                $tag = array(
                    "type" => $uploadtype,
                    "name" => "hdcms",
                    "dir" => $dir,
                    "limit" => $limit,
                    "width" => 88,
                    "height" => 78,
                    "waterbtn" => 1,
                    "upload_img_max_width" => $upload_img_max_width,
                    "upload_img_max_height" => $upload_img_max_height,
                );
                break;
            case 'files':
                $tag = array(
                    "type" => $uploadtype,
                    "name" => "hdcms",
                    "dir" => $dir,
                    "width" => 88,
                    "height" => 78,
                    "limit" => $limit,
                    "waterbtn" => 0,
                    "size"=>10
                );
                break;
        }
        $upload = tag("upload", $tag);
        $get = '';
        foreach ($_GET as $name => $v) {
            $get .= "var $name='$v';\n";
        }
        $this->get = $get;
        $this->upload = $upload;
        //站内图片
        $this->site($filetype);
        //未使用图片
        $this->untreated($filetype);
        $this->display();
    }
    /**
     * Uploadify上传文件处理
     */
    public function hd_uploadify()
    {
    	$uploadModel = M('upload');
        //开启裁切
        C('UPLOAD_IMG_RESIZE_ON', true);
        C('upload_img_max_width', $_POST['upload_img_max_width']);
        C('upload_img_max_height', $_POST['upload_img_max_height']);
		$size=Q('size')?Q('size'):C('allow_size');
        $upload = new Upload(Q('post.upload_dir'), array(), $size, Q("water"));
        $file = $upload->upload();
        if (!empty($file)) {
            $file = $file[0];
			$file['uid']=session('uid');
            $data['stat'] = 1;
            $data['url'] = __ROOT__ . '/' . $file['path'];
            $data['path'] = $file['path'];
            $data['filename'] = $file['filename'];
            $data['name'] = $file['name'];
            $data['basename'] = $file['basename'];
            $data['thumb'] = array();
            $data['isimage'] = $file['image'];
            //写入upload表
            $uploadModel->add($file);
        } else {
            $data['stat'] = 0;
            $data['msg'] = $upload->error;
        }
        echo json_encode($data);
        exit;
    }

    /**
     * 当修改图片的alt表单数据时，Ajax更改upload表中的name字段值
     */
    public function update_file_name()
    {
        $name = Q('name');
        $id = Q('id', null, 'intval');
        $this->_db->save(array(
            "id" => $id,
            "name" => $name
        ));
    }

    /**
     * 站内文件
     */
    public function site()
    {
        //上传文件类型
        $type = explode(',', Q('filetype'));
        $type = implode("','", $type);
        //只查找自己的图片
        $where = 'uid=' . $_SESSION['uid'] . " AND ext IN('$type') AND state=1";
        $count = $this->_db->where($where)->count();
        $page = new Page($count, 10, 8, '', '', __WEB__ . '?a=Admin&c=ContentUpload&m=site&filetype=' . Q('filetype'));
        $this->site_data = $this->_db->where($where)->limit($page->limit())->all();
        $this->site_page = $page->show();
        if (METHOD == 'site') {
            $this->display('site');
        }
    }

    /**
     * 未使用的文件
     */
    public function untreated()
    {
        //只查找自己的图片
        $type = explode(',', Q('filetype'));
        $type = implode("','", $type);
        //只查找自己的图片
        $where = 'uid=' . $_SESSION['uid'] . " AND ext IN('$type') AND state=0";
        $count = $this->_db->where($where)->count();
        $page = new Page($count, 10, 8, '', '', __WEB__ . '?a=Admin&c=ContentUpload&m=untreated&filetype=' . Q('filetype'));
        $this->untreated_data = $this->_db->where($where)->limit($page->limit())->all();
        $this->untreated_page = $page->show();
        if (METHOD == 'untreated') {
            $this->display('untreated');
        }
    }

}
























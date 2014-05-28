<?php

/**
 * 会员资料修改
 * Class UserControl
 */
class ProfileControl extends MemberAuthControl {
	public $_db;

	//构造函数
	public function __init() {
		$this -> _db = K("User");
	}

	//修改昵称
	public function editNickname() {
		$Model = M("user");
		$state = $Model -> save(array('uid' => $_SESSION['uid'], 'nickname' => $_POST['nickname']));
		if ($state) {
			$_SESSION['nickname'] = $_POST['nickname'];
			$this -> success('修改昵称成功!');
		} else {
			$this -> error('昵称修改失败');
		}

	}

	//修改用户资料
	public function edit() {
		$this -> field = M('user') -> find(session("uid"));
		$this -> display();
	}

	//编辑基本信息（个性签名，个性域名）
	public function edit_message() {
		$_POST['signature'] = mb_substr($_POST['signature'], 0, 50, 'utf-8');
		//修改资料
		if ($this -> _db -> where("uid=" . session('uid')) -> save()) {
			$_SESSION['domain'] = $_POST['domain'];
			$_SESSION['signature'] = $_POST['signature'];
			$this -> _ajax(1, '修改成功!');
		}
	}

	//验证个性域名
	public function check_domain() {
		$domain = $_POST['domain'];
		$user = $this -> _db -> where("uid<>{$_SESSION['uid']} AND domain='{$domain}'") -> find();
		if (!$user) {
			$this -> ajax(1);
		} else {
			$this -> ajax(0);
		}
	}

	//修改密码时，异步验证原密码
	public function check_password() {
		$oldpassword = $_POST['oldpassword'];
		$user = $this -> _db -> find(session('uid'));
		if (md5($oldpassword . $user['code']) == $user['password']) {
			$this -> ajax(1);
		} else {
			$this -> ajax(0);
		}
	}

	//修改密码
	public function edit_password() {
		$Model = K("User");
		if (empty($_POST['password'])) {
			$this -> error('密码不能为空');
		} else {
			$_POST['uid'] = session("uid");
			if ($Model -> editUser($_POST)) {
				$this -> success('修改密码成功');
			} else {
				$this -> error('修改失败');
			}
		}
	}

	//设置头像
	public function set_face() {
		//关闭水印
		C('WATER_ON', false);
		//头像文件
		$file = $_POST['img_face'];
		$dst_image=imagecreatetruecolor(250, 250);
		$fileInfo = getimagesize($file);
		switch($fileInfo[2]){
			case 1://gif
				$src_image=imagecreatefromgif($file);
				break;
			case 2://jpeg
				$src_image=imagecreatefromjpeg($file);
				break;
			case 3://png
				$src_image=imagecreatefrompng($file);
				break;
		}
		//裁切图片
		$dst_x=$dst_y=0;
		$dst_w=$dst_h=250;
		$src_x=$_POST['x1']*2;
		$src_y=$_POST['y1']*2;
		$src_w=$_POST['w']*2;
		$src_h=$_POST['h']*2;
		imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		$func = str_replace('/','',$fileInfo['mime']);
		if($fileInfo[2]==2){
			$func($dst_image,$file,100);
		}else{
			$func($dst_image,$file);
		}
		$data = array(50 => str_replace(250, 50, $file), 100 => str_replace(250, 100, $file), 150 => str_replace(250, 150, $file));
		$img = new Image();
		foreach ($data as $size => $f) {
			$img -> thumb($file, $f, $size, $size, 6);
		}
		//修改用户表
		M("user") -> save(array('uid' => $_SESSION['uid'], 'icon' => $file));
		$_SESSION['icon50'] = str_replace(250, 50, $file);
		$_SESSION['icon100'] = str_replace(250, 100, $file);
		$_SESSION['icon150'] = str_replace(250, 150, $file);
		$this -> success('修改成功');
	}

	//上传头像文件
	public function uploadFace() {
		//关闭水印
		C('WATER_ON', false);
		$dir = 'upload/user/' . date("Y/m/d/");
		$upload = new Upload($dir);
		$file = $upload -> upload();
		if (empty($file)) {
			$this -> error('上传失败！文件不能超过2Mb');
		} else {
			$file = $file[0];
			$img = new Image();
			$newFile = $file['dir'] . 'u' . $_SESSION['uid'] . '_250.' . $file['ext'];
			$img -> thumb($file['path'], $newFile, 500, 500, 6);
			@unlink($file['path']);
			$this -> _ajax(1, array('url' => __ROOT__ . '/' . $newFile, 'path' => $newFile));
		}
	}

}

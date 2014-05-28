<?php
/**
 * 密码处理
 */
class PasswordControl extends Control {
	//找回密码
	public function findPassword() {
		$this -> display();
	}

	//发送邮件
	public function sendEmail() {
		$username = Q('username');
		$email = Q('email');
		if (!$username || !$email) {
			$this->error('参数错误');
		} else {
			$Model = M('user');
			$user = $Model -> where(array('username' => $username, 'email' => $email)) -> find();
			if (!$user) {
				$this -> error('用户不存在');
			} else {
				$data=array();
				$data['uid']=$user['uid'];
				$data['code'] = substr(md5(mt_rand(1,1000).time()),0,8);
				$newPassword = substr(md5(mt_rand(1,1000).time()),0,6);
				$data['password'] = md5($newPassword.$data['code']);
				$Model->save($data);
				$emailCon = "您在".C('WEB_NAME')."的新密码为：{$newPassword}，请即刻修改密码!!!";
				$state = Mail::send($email, $user['username'], C('WEBNAME'), $emailCon);
				if ($state) {
					$message = "我们已经向" . $email . '发送了重置密码邮件<br/>请登录邮箱查看新密码';
				} else {
					$masterEmail = C('EMAIL');
					$message = "邮件发送失败，请联系管理员<a href='mailto:{$masterEmail}'>{$masterEmail}</a>";
				}
			}
		}
		$this->assign('message',$message);
		$this -> display();
	}

}
?>

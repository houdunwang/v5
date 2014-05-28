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
 * 邮件处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
require HDPHP_EXTEND_PATH . 'Org/Mail/Class.phpmailer.php';
class Mail{

	static private $mail;
	//邮件对象

	/**
	 * 发送邮件
	 * @param string $tomail        收件人邮箱
	 * @param string $toName        发件人名称
	 * @param string $title         邮件标题
	 * @param string $body          邮件内容
	 * @return boolean
	 */
	static public function send($tomail, $toName, $title, $body) {
		self::config();
		self::$mail -> Subject = $title;
		//邮件标题
		self::$mail -> MsgHTML($body);
		//或正文内容
		self::$mail -> AltBody = "";
		// 客户端提示信息摘要内容
		self::$mail -> AddAddress($tomail, $toName);
		//添加收件人，参数1：收件人邮箱  参数2：收件人名称
		if (self::$mail -> send()) {
			return true;
		} else {
			return false;
		}
	}

	//配置参数
	static private function config() {
		self::$mail = new PHPMailer();
		self::$mail -> PluginDir = HDPHP_EXTEND_PATH . 'Org/Mail/';
		self::$mail -> SetLanguage("en", HDPHP_EXTEND_PATH . '/Mail/Language/');
		self::$mail -> IsSMTP();
		//是否为SMTP 必须设置

		self::$mail -> CharSet = C("EMAIL_CHARSET");
		//字符集设置，中文乱码就是这个没有设置好 如utf8
		if (preg_match("/utf8/i", self::$mail -> CharSet)) {
			self::$mail -> CharSet = "utf-8";
		}
		self::$mail -> SMTPAuth = true;
		//是否需要验证
		if (C("EMAIL_SSL")) {
			self::$mail -> SMTPSecure = "ssl";
			//是否为ssl  gmail邮箱需要设置   126等不要设置注释掉
		}
		self::$mail -> Host = C("EMAIL_HOST");
		//邮箱服务器smtp地址如smtp.gmail.com或smtp.126.com
		self::$mail -> Port = C("EMAIL_PORT");
		//邮箱服务器smtp端口，126等25，gmail 465
		self::$mail -> Username = C("EMAIL_USERNAME");
		//发送邮件邮箱用户名
		self::$mail -> Password = C("EMAIL_PASSWORD");
		//发送邮件邮箱密码
		self::$mail -> SetFrom(C("EMAIL_FORMMAIL"), C("EMAIL_FROMNAME"));
		//发件人
		self::$mail -> AddReplyTo(C("EMAIL_FORMMAIL"), C("EMAIL_FROMNAME"));
		//回复时显示的用户名
		self::$mail -> WordWrap = 50;
		//换行文字
		self::$mail -> IsHTML(true);
		//以HTML形式发送邮件
	}

}
?>

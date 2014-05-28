<?php
/**
 * 后台网站配置管理
 * Class ConfigControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ConfigControl extends AuthControl {
	//修改
	function edit() {
		$Model = K("config");
		if (IS_POST) {
			if ($Model -> saveConfig($_POST)) {
				$this -> success("修改成功");
			} else {
				$this -> error($Model -> error);
			}
		} else {
			$data = $Model -> order('order_list ASC') -> all();
			$config = array();
			foreach ($data as $d) {
				$config[$d['name']] = $d;
			}
			//删除模型风格配置
			unset($config['web_style']);
			//======================================会员角色
			$roleData = $Model -> table("role") -> where("admin=0") -> all();
			$config['DEFAULT_MEMBER_GROUP']['html'] = '<select name="DEFAULT_MEMBER_GROUP">';
			foreach ($roleData as $role) {
				$checked = $config['DEFAULT_MEMBER_GROUP']['value'] == $role['rid'] ? "selected='selected'" : "";
				$config['DEFAULT_MEMBER_GROUP']['html'] .= "<option value='{$role['rid']}' {$checked}>{$role['rname']}</option>";
			}
			$config['DEFAULT_MEMBER_GROUP']['html'] .= '</select>';
			//邮箱密码设置字段为PASSWORD
			$config['EMAIL_PASSWORD']['html']="<input type='password' name='EMAIL_PASSWORD' value='{$config['EMAIL_PASSWORD']['value']}' class='w400'/>";
			//========================================水印位置
			ob_start();
			require TPL_PATH . 'Config/water.php';
			$con = ob_get_clean();
			$config['WATER_POS']['html'] = $con;
			//=======================================其他字段
			foreach ($config as $name => $c) {
				if (in_array($name, array('DEFAULT_MEMBER_GROUP', 'WATER_POS','EMAIL_PASSWORD')))
					continue;
				switch ($c['show_type']) {
					case '数字' :
					case '文本' :
						$config[$name]['html'] = "<input type='text' name='{$c['name']}' value='{$c['value']}' class='w400'/>";
						break;
					//布尔
					case '布尔(1/0)' :
						$Yes = $No = '';
						if ($c['value'] == 1) {
							$Yes = "checked='checked'";
						} else {
							$No = "checked='checked'";
						}
						$config[$name]['html'] = "<label><input type='radio' name='{$c['name']}' value='1'  $Yes/> 是</label>
                                        <label><input type='radio' name='{$c['name']}' value='0' $No/> 否</label>";
						break;
					//多行文本
					case '多行文本' :
						$config[$name]['html'] = "<textarea class='w400 h100' name='{$c['name']}'>{$c['value']}</textarea>";
						break;
				}
			}
			$this -> assign("config", $config);
			$this -> display();
		}
	}
	//验证EMAIL发送
	public function checkEmail(){
		 $Config  = array(
			'EMAIL_USERNAME'=>$_POST['EMAIL_USERNAME'],
			'EMAIL_PASSWORD'=>$_POST['EMAIL_PASSWORD'],
			'EMAIL_HOST'=>$_POST['EMAIL_HOST'],
			'EMAIL_PORT'=>$_POST['EMAIL_PORT'],
			'EMAIL_SSL'=>false,
			'EMAIL_CHARSET'=>'utf-8',
			'EMAIL_FORMMAIL'=>$_POST['EMAIL_USERNAME'],
			'EMAIL_FROMNAME'=>$_POST['EMAIL_FROMNAME'],
		);
		C($Config);
		$state = Mail::send("houdunwangxj@gmail.com","houdunwangxj@gmail.com","HDCMS系统测试邮件","使用者网站:".__HOST__);
		if($state){
			$this->success('邮箱配置正确，发送正常!');
		}else{
			$this->error('邮箱配置错误...');
		}
	}
	//更新缓存
	public function updateCache() {
		$Model = K('config');
		if ($Model -> updateCache()) {
			$this -> success('缓存更新成功！');
		} else {
			$this -> error($Model -> error);
		}
	}

}

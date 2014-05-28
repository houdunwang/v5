<?php

/**
 * 插件安装
 * Class InstallControl
 */
class PluginControl extends AuthControl {
	private $_db;
	//插件环境错误
	private $_error;
	public function __init() {
		$this -> _db = K("Plugin");
	}

	/**
	 * 插件列表
	 */
	public function plugin_list() {
		$Model = K("Plugin");
		$dir = Dir::tree('hd/Plugin');
		$plugin = array();
		if (!empty($dir)) {
			foreach ($dir as $d) {
				//插件应用名
				$app = $d['name'];
				$conf =
				require "hd/Plugin/$app/Config/config.php";
				$conf['app'] = $app;
				//转为小写，方便视图调用
				$conf = array_change_key_case_d($conf);
				$plugin[$d['name']] = $conf;
				$plugin[$d['name']]['dirname'] = $app;
				//是否安装
				$installed = $Model -> where("app='$app'") -> find();
				$plugin[$d['name']]['installed'] = $installed ? 1 : 0;
			}
		}
		$this -> assign("plugin", $plugin);
		$this -> display();
	}

	/**
	 * 验证插件
	 */
	private function check_plugin($plugin) {
		$pluginDir = 'hd/Plugin/' . $plugin . '/';
		//安装sql检测
		if (!is_file($pluginDir . 'Data/install.sql')) {
			$this -> _error = '安装sql文件install.sql不存在';
			return false;
		}
		//删除sql
		if (!is_file($pluginDir . 'Data/uninstall.sql')) {
			$this -> _error = '删除Sql文件uninstall.sql不存在';
			return false;
		}
		//删除sql
		if (!is_file($pluginDir . 'Data/help.php')) {
			$this -> _error = '插件帮助文件help.php不存在';
			return false;
		}
		//检测配置文件
		if (!is_file($pluginDir . 'Config/config.php')) {
			$this -> _error = '配置文件config.php不存在';
			return false;
		}
		return true;
	}

	//安装插件
	public function install() {
		$plugin = Q('plugin', null);
		if (!$this -> check_plugin($plugin)) {
			$this -> error($this -> _error);
		}

		if (!$plugin) {
			$this -> error('参数错误');
			exit ;
		}
		if (IS_POST) {
			//检测插件是否已经存在
			if ($this -> _db -> where(array('app' => $plugin)) -> find()) {
				$this -> error = '插件已经存在，请删除后再安装';
			}
			//创建数据表
			$installSql = "hd/Plugin/{$plugin}/Data/install.sql";
			if (is_file($installSql)) {
				$sqls = explode(';', file_get_contents($installSql));
				if (!empty($sqls) && is_array($sqls)) {
					foreach ($sqls as $sql) {
						$sql = trim($sql);
						if (empty($sql)) {
							continue;
						}
						if (! M() -> exe($sql)) {
							$this -> error('执行SQL失败');
						}
					}
				} else {
					$this -> error('安装SQL文件错误');
				}
			}
			$data =
			require 'hd/Plugin/' . $plugin . '/Config/config.php';
			$data = array_change_key_case_d($data);
			$data['app'] = $plugin;
			$data['install_time'] = date("Y-m-d");
			//添加菜单
			if ($this -> _db -> add($data)) {
				$data = array('title' => $data['name'], //节点名称
				'app_group' => 'Plugin', //应用组
				'app' => $plugin, //应用名称
				'control' => 'Manage', //默认控制器
				'method' => 'index', //默认方法
				'state' => 1, //状态
				'pid' => 94, //父级菜单id(正在使用)
				'plugin' => 1, //是否为插件
				'type' => 2, //普通菜单
				);
				M('node') -> add($data);
				$NodeModel = K('Node');
				$NodeModel -> updateCache();
				$this -> success('插件安装成功');
			} else {
				$this -> error('插件安装失败');
			}
		} else {
			//分配配置项
			$field = array_change_key_case_d(
			require 'hd/Plugin/' . $plugin . '/Config/config.php');
			$field['plugin'] = $plugin;
			$this -> field = $field;
			$this -> display();
		}
	}

	//卸载插件
	public function uninstall() {
		$plugin = Q('plugin', null);
		if (!$plugin) {
			$this -> error('参数错误');
			exit ;
		}
		if (IS_POST) {
			$uninstallSql = "hd/Plugin/{$plugin}/Data/uninstall.sql";
			if (is_file($uninstallSql)) {
				$sqls = explode(';', file_get_contents($uninstallSql));
				if (!empty($sqls) && is_array($sqls)) {
					foreach ($sqls as $sql) {
						$sql = trim($sql);
						if (empty($sql)) {
							continue;
						}
						if (! M() -> exe($sql)) {
							$this -> error('执行SQL失败');
						}
					}
				} else {
					$this -> error('卸载SQL文件错误');
				}
			}
			//删除Plugin表信息
			$this -> _db -> del("app='$plugin'");
			//删除插件菜单信息
			M('node') -> where(array('app_group' => 'Plugin', 'app' => $plugin)) -> del();
			$NodeModel = K('Node');
			$NodeModel -> updateCache();
			//删除文件
			if (Q('del_dir')) {
				if (!dir::del('hd/Plugin/' . $plugin)) {
					$this -> error('插件目录删除失败');
				}
			}
			$this -> success('插件卸载成功');
		} else {
			//分配配置项
			$field = array_change_key_case_d(
			require 'hd/Plugin/' . $plugin . '/Config/config.php');
			$field['plugin'] = $plugin;
			$this -> assign("field", $field);
			$this -> display();
		}
	}

	//使用帮助
	public function help() {
		$plugin = Q('plugin');
		$help_file = "hd/Plugin/" . $plugin . '/Data/help.php';
		if (is_file($help_file)) {
			$this -> help = file_get_contents($help_file);
			$this -> display();
		}
	}

}

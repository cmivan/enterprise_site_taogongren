<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_default extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//初始化用户id
		$this->logid = $this->data["power_system"]["logid"];
	}

	function index()
	{
		//注销session
		$login = $this->input->get('login');
		if($login=='out')
		{
			$this->login_out();
		}

		$this->load->view_system('system_default',$this->data);
	}
	
	
	function login_out()
	{
		$url = site_url('ver/urlto').'?url=loginout&T';
		redirect($url, 'location', 301);
	}
	
	
	function system_left()
	{
		$this->load->view_system('system_left',$this->data);
	}
	
	
	//查看系统信息
	function system_info()
	{
		$this->load->view_system('system_info',$this->data);
	}
	
	//一键登录页
	function system_onekey()
	{
		//获取用户信息
		$this->load->model('System_user_Model');
		$rs = $this->System_user_Model->view($this->logid);
		if(!empty($rs))
		{
			$token_key = pass_token($rs->username.$rs->password.$rs->power.$rs->super);
			$this->data['token_time'] = $rs->token_time;
			$this->data['token_key'] = $rs->token_key;
		}
		else
		{
			json_echo('服务器繁忙!');
		}
		
		//提交操作
		$this->data['tip'] = '';
		$cmd = $this->input->post('cmd');
		$action = $this->input->get('action');
		if($cmd=='0'&&$action=='go')
		{
			//注销链接
			$data['token_key'] = 0;
			$data['token_time'] = dateTime();
			$this->db->where('id',$this->logid);
			$this->db->update('km_admin',$data);
			$this->data['tip'] = '成功注销一键登录链接!';
		}
		elseif($cmd=='1'&&$action=='go')
		{
			//生成链接
			if(!empty($rs)&&!empty($token_key))
			{
				//更新数据
				$data['token_key'] = 1;
				$data['token_time'] = dateTime();
				$this->db->where('id',$this->logid);
				$this->db->update('km_admin',$data);
				//生成下载数据
				$this->load->helper('download');
				$name = '淘工人一键登录.url';
				$name = iconv("utf-8","gb2312",$name);
				$Down = '[InternetShortcut]'.chr(10);
				$Down.= 'URL='.siteurl().site_url('ver/system_token/'.$token_key.'/'.$this->logid).chr(10);
				$Down.= 'IDList='.chr(10);
				$Down.= '[{000214A0-0000-0000-C000-000000000046}]'.chr(10);
				$Down.= 'Prop3=19,2'.chr(10);
				force_download($name, $Down);
				$this->data['tip'] = '成功生成一键登录链接!';
			}
		}

		$this->load->view_system('system_onekey',$this->data);
	}
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
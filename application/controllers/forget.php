<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forget extends QT_Controller {

	//找回密码记录
	public $step;

	function __construct()
	{
		parent::__construct();

		//英雄榜(全局)
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);
		
		//$this->session->set_userdata(array('get_step' => '1'));
		
		//找回密码页面参数
		$this->step = get_num($this->session->userdata('get_step'));
		if($this->step==false)
		{
			$this->session->set_userdata(array('get_step' => '1')); //初始化设置步骤
			$this->step = $this->session->userdata('get_step'); //初始化步骤
		}

		//css样式
		$this->data['cssfiles'][] = 'style/mod_page.css';
		//Js
		$this->data['jsfiles'][]  = 'js/mod_page.js';
	}


    #忘记密码
	function index()
	{
		if($this->step==1)
		{
			//css样式
			$this->data['cssfiles'][] = 'style/mod_form.css';
			
			//表单配置
			$this->data['formTO']->url = 'forget/step_1';
			$this->data['formTO']->backurl = '';
			$this->load->view('forget/step_1',$this->data);
		}
		elseif($this->step==2)
		{
			//第二步
			$this->data['formTO']->url = 'forget/step_2';
			$this->data['formTO']->backurl = 'index';
			$this->load->view('forget/step_2',$this->data);
		}
	}
	
	
	function step_1()
	{
		//第一步检测
		if($this->step==1)
		{
			$code = $this->input->postnum('code');
			$get_mobile = $this->session->userdata('forget_mobile');
			$get_code = get_num($this->session->userdata('forget_code'));
			if(empty($get_mobile)||$get_code==false)
			{
				json_form_no('请先获取验证码!');
			}
			elseif($code!=$get_code)
			{
				json_form_no('验证码不正确!');
			}
			
			//数据符合，则进入第二阶段
			$data = array('get_step' => '2','get_mobile' => $get_mobile);
			$this->session->set_userdata($data);
			json_form_yes('验证通过，正进入第二步...');
		}
	}
	
	
	function step_2()
	{
		//第二步检测
		if($this->step==2)
		{
			$password  = $this->input->post('userpassword');
			$password2 = $this->input->post('userpassword2');
			$get_mobile = $this->session->userdata('forget_mobile');
			if($get_mobile=='')
			{
				json_form_no('未找到你的手机号码!');
			}
			elseif($password=='')
			{
				json_form_no('请输入密码!');
			}
			elseif($password!=$password2)
			{
				json_form_no('两次输入的密码不一致哦!');
			}
			
			$data["password"] = pass_user($password);
			$this->db->where('mobile',$get_mobile);
			$this->db->update('user',$data);
			//清空记录
			$data = array('get_step' => NULL,'get_mobile' =>NULL);
			$this->session->set_userdata($data);
			json_form_yes('密码设置成功，请牢记您的新密码!');
		}
	}

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
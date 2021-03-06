<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bind_mobile extends E_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	
	//记录步骤
	public $bind_step;
	public $mobile;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];

		//$this->session->set_userdata(array('bind_step' => '1'));
		
		//页面参数
		$this->bind_step = $this->session->userdata('bind_step');
		if(is_num($this->bind_step)==false){
		   //初始化设置步骤
		   $this->session->set_userdata(array('bind_step' => '1'));
		   //初始化步骤
		   $this->bind_step = $this->session->userdata('bind_step');
		}

		$this->mobile = $this->User_Model->mobile($this->logid);
		$this->data["mobile"] = $this->mobile;
	}
	


	function index()
	{
		if($this->bind_step==1){
			//第一步
			$this->load->view('wuser/user/bind_mobile/step_1',$this->data);
		}elseif($this->bind_step==2){
			//第二步,表单配置
			$this->data['formTO']->url = $this->data["c_urls"].'/step_2';
			$this->data['formTO']->backurl = '';
		
			$this->load->view('wuser/user/bind_mobile/step_2',$this->data);
		}
	}
	
	
	function step_1()
	{
		//第一步检测
		if($this->bind_step==1){
			$bind_mobile = $this->mobile;
			$code = is_num($this->input->post('code'));
			$bind_code = is_num($this->session->userdata('bind_code'));
			if(empty($bind_mobile)||$bind_code==false){
				json_form_no('请先获取验证码!');
			}elseif($code!=$bind_code){
				json_form_no('验证码不正确!');
			}
			//数据符合，则进入第二阶段
			$data = array('bind_step' => '2','bind_mobile' => $bind_mobile,'bind_code' => NULL,'bind_timeout' => NULL);
			$this->session->set_userdata($data);
			json_form_yes('验证通过，正进入第二步...');
		}
	}
	
	
	function step_2()
	{
		//第二步检测
		if($this->bind_step==2){
			
		  $mobile   = $this->input->post('mobile');
		  $code     = $this->input->post('code');
		  $bind_mobile = $this->session->userdata('bind_mobile');
		  $bind_code   = $this->session->userdata('bind_code');
		  
		  if($bind_mobile==''||empty($bind_mobile)){ json_form_no('未找到你的手机号码!'); }
		  if($mobile==''||empty($mobile)){ json_form_no('请输入你要绑定的手机号码!'); }
		  if($code!=$bind_code){ json_form_no('验证码不正确!'); }
		  
		  //更新手机,及设置手机已认证
		  $this->db->where('id',$this->logid);
		  $this->db->update('user',array('mobile' => $bind_mobile,'approve_sj' => 1));
		  
		  //清空记录
		  $data = array('bind_step' => NULL,'bind_mobile' => $bind_mobile,'bind_code' =>NULL);
		  $this->session->set_userdata($data);
		  json_form_yes('已成功重新绑定手机!');
		}
	}
	
	
	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
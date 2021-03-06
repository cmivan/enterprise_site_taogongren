<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bind_email extends E_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];

	}
	
	//绑定邮箱的界面
	function index()
	{
		//$this->data["mobile"] = $this->User_Model->mobile($this->logid);
		$this->data["email"] = $this->User_Model->email($this->logid);
		
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/send';
		$this->data['formTO']->backurl = '';

		/*输出到视窗*/
		$this->load->view_euser('user/bind_email',$this->data);
	}
	
	//发送绑定验证链接
	function send()
	{
		$this->load->helper('file');
		$this->load->helper('send');

		//生成链接
		$email = $this->input->post('email');
		$link  = email_link($this->logid,$email);
		$user  = $this->User_Model->name($this->logid);
		
		//获取并处理邮件模板
		$note  = read_file('./application/views/tpl/email_bind.tpl');
		$note  = str_replace("{user}",$user,$note);
		$note  = str_replace("{link}",$link,$note);
		
		//处理发送程序
		$eok = emailto('淘工人网',$email,'邮箱绑定验证',$note);
		if($eok){
			$data['email'] = $email;
			$data['approve_yx'] = 0;
			$this->db->where('id',$this->logid);
			$this->db->update('user',$data);
		}
		
		//返回处理结果
		json_form_yes('已成功发送，请登录您的邮箱并查看!');
	}
	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
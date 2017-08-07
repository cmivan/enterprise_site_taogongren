<?php
/*
 * 登录后的任务的向导
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid  = 0;
	public $zscost = 5; //登录向导，赠送后

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
	}
	
	
	
	#活动--登录向导
	function login_task()
	{
		if(is_num($this->logid)==false){ json_echo('系统繁忙!'); }
		
		//检测设置
		$checked = $this->input->get('checked');
		if($checked!='')
		{
			if($checked=='1')
			{
				$num = $this->db->query('select id from user_gift_ok where uid='.$this->logid.' LIMIT 1')->num_rows();
				if($num<=0){ $this->db->query("insert user_gift_ok set uid=".$this->logid.",ip='".ip()."',ok=0"); }
				json_echo('设置成功,下次登录后将不显示该提示!');
			}elseif($checked=='0'){
				$this->db->query("delete from user_gift_ok where uid=".$this->logid." and ok<>1"); 
				json_echo('设置成功,下次登录后将继续显示该提示!');
			}
			exit;
		}
		
		$this->data['zscost'] = $this->zscost;
		//显示页面
		$this->data['classid'] = $this->session->userdata("classid");
		$this->load->view('ads/activity_login_task',$this->data);
	}

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
/*
 * 登录后的任务的向导
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends QT_Controller {

	public $zscost = 5; //登录向导，赠送后

	function __construct()
	{
		parent::__construct();
	}

	#活动--登录向导
	function login_task()
	{
		$this->load->model('User_gift_Model');
		
		if(is_num($this->logid)==false)
		{
			json_echo('系统繁忙!');
		}
		
		//设置下次登录是否显示
		$this->login_task_set();

		$this->data['zscost'] = $this->zscost;
		//显示页面
		$this->data['classid'] = $this->session->userdata("classid");
		$this->load->view('ads/activity_login_task',$this->data);
	}

	#活动--登录向导设置(是否下次登录提示)
	function login_task_set()
	{
		$checked = $this->input->get('checked');
		if($checked!='')
		{
			if($checked=='1')
			{
				//判断是否已赠送
				if( $this->User_gift_Model->is_gift($this->logid) == false )
				{
					$data = array(
						 'ok' => 0,
						 'uid' => $this->logid,
						 'ip' => ip()
						 );
					$this->User_gift_Model->add_gift($data);
				}
				json_echo('设置成功,下次登录后将不显示该提示!');
			}
			elseif($checked=='0')
			{
				$this->User_gift_Model->del_gift($this->logid);
				json_echo('设置成功,下次登录后将继续显示该提示!');
			}
			exit;
		}
	}

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
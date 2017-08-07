<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_select extends E_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('Paging');
		$this->load->model('Orders_Model');

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '上门单','link' => 'orders_door'),
					array('title' => '简化单','link' => 'orders_simple'),
					array('title' => '工程单','link' => 'orders_project'),
					array('title' => '我要下单','link' => 'orders_select')
		            );
	}
	
	
	
	function index($uid='')
	{
		$this->load->model('Friends_Model');
		
		$to_uid = is_num($uid) ? $uid : $this->input->getnum('to_uid');
		if($to_uid==false)
		{
			//步骤1--获取分页列表sql
		    $this->data["list"] = $this->Friends_Model->User_Friends1($this->logid);
			$this->load->view($this->data["c_url"].'orders/select_user',$this->data);	
		}
		else
		{
			//步骤2
			$this->data['to_uid'] = $to_uid;
			$this->load->view($this->data["c_url"].'orders/select_type',$this->data);	
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
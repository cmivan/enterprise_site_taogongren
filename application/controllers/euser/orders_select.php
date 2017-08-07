<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_select extends E_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Paging');
		$this->load->model('Orders_Model');

		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "上门单";
		$this->data["thisnav"]["nav"][0]["link"]  = "orders_door";
		$this->data["thisnav"]["nav"][1]["title"] = "简化单";
		$this->data["thisnav"]["nav"][1]["link"]  = "orders_simple";
		$this->data["thisnav"]["nav"][2]["title"] = "工程单";
		$this->data["thisnav"]["nav"][2]["link"]  = "orders_project";
		$this->data["thisnav"]["nav"][3]["title"] = "我要下单";
		$this->data["thisnav"]["nav"][3]["link"]  = "orders_select";
		//当前控制器名称
		$this->data["thisnav"]["on"] = $this->uri->segment(2);
		if($this->data["thisnav"]["on"]==""){$this->data["thisnav"]["on"] = $this->data["thisnav"]["nav"][0]["link"];}
	}
	
	
	
	function index()
	{
		$this->load->model('Friends_Model');
		
		$to_uid = is_num($this->input->get('to_uid'));
		if($to_uid==false)
		{
			//步骤1--获取分页列表sql
		    $this->data["list"] = $this->Friends_Model->User_Friends1($this->logid);
			$this->load->view($this->data["c_url"].'orders/select_user',$this->data);	
		}else{
			//步骤2
			$this->data['to_uid'] = $to_uid;
			$this->load->view($this->data["c_url"].'orders/select_type',$this->data);	
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
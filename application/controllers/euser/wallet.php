<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet extends E_Controller {
	
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
		$this->load->model('Records_Model');
		
		
		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "收入记录";
		$this->data["thisnav"]["nav"][0]["link"]  = "index";
		$this->data["thisnav"]["nav"][1]["title"] = "支出记录";
		$this->data["thisnav"]["nav"][1]["link"]  = "apply";
		$this->data["thisnav"]["nav"][2]["title"] = "我要充值";
		$this->data["thisnav"]["nav"][2]["link"]  = "charge";
		
		/*个人信息*/
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		
		$this->data["cost_T"] = $this->Records_Model->balance_cost($this->logid,'T');
		$this->data["cost_S"] = $this->Records_Model->balance_cost($this->logid,'S');
	}
	
	
	
	function index()
	{
		$this->sql = $this->Records_Model->record_in($this->logid);
		$this->data["list"] = $this->Paging->show($this->sql);
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'wallet/index',$this->data);
	}
	
	
	function apply()
	{
		$this->sql = $this->Records_Model->record_out($this->logid);
	    $this->data["list"] = $this->Paging->show($this->sql);
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'wallet/apply',$this->data);
	}

	
	function charge()
	{
		/*获取订单号*/
		$this->data["order_no"] = order_no($this->logid,1);
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/take_save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/records';
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'wallet/charge',$this->data);
	}
	
	

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
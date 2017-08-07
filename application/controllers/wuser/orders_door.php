<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_door extends W_Controller {
	
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
		
		$this->load->helper('orders');
		$this->load->model('Common_Model');

		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "上门单";
		$this->data["thisnav"]["nav"][0]["link"]  = "orders_door";
		$this->data["thisnav"]["nav"][1]["title"] = "简化单";
		$this->data["thisnav"]["nav"][1]["link"]  = "orders_simple";
		$this->data["thisnav"]["nav"][2]["title"] = "工程单";
		$this->data["thisnav"]["nav"][2]["link"]  = "orders_project";
		//当前控制器名称
		$this->data["thisnav"]["on"] = $this->uri->segment(2);
		if($this->data["thisnav"]["on"]==""){$this->data["thisnav"]["on"]=$this->data["thisnav"]["nav"][0]["link"];}
	}
	
	
	
	function index()
	{
	    $this->data["list"] = $this->Paging->show("select * from order_door where uid_2=".$this->logid." order by id desc",10);
		/*输出到视窗*/
		$this->load->view_wuser('orders/door',$this->data);
	}
	
	
	function view($id=0)
	{
		$this->load->model('Orders_Model');
		
		$id = is_num($id);
		$action = $this->input->get('action');
		if($id){
			
		  #<><><><>处理事件<><><><><>
		  if($action=="yes"){ //工人同意退款，记录步骤、所有步骤状态->完成，订单状态->完成
			 $this->Orders_Model->order_door_w_newstep($id,$this->logid,"同意退回费用！",1);
		  }elseif($action=="no"){ //工人不同意退款，记录步骤、登录雇主操作
			 $this->Orders_Model->order_door_w_newstep($id,$this->logid,"不同意退回！");
		  }
		  
		  
		  //根据合同步骤状态获取当前合同的状态(是否完成)
		  $ostat = $this->Orders_Model->order_door_stat($id);
		  //订单评分状态
		  $isevaluate = $this->Common_Model->isevaluate_order_door($id,$this->logid);
		  //返回订单状态按钮
		  $this->data['order_stat_btu'] = order_stat($ostat,$isevaluate,$id);
		  

		  #<><><><>处理输出<><><><><>
		  $this->data["view"] = $this->db->query("select * from order_door where uid_2=".$this->logid." and id=".$id." order by id desc")->row();
		  $this->data["view_step"]=$this->db->query("select * from order_door_step where stepid=".$id." order by id desc")->result();
		  /*输出到视窗*/
		  $this->load->view_wuser('orders/door_view',$this->data);
			
		}

	}


	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
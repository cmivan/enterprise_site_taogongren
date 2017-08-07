<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_door extends COMPANY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('Paging');
		$this->load->model('Orders_Model');
		$this->load->model('Orders_door_Model');
		$this->load->helper('orders');
		$this->load->model('Common_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '上门单','link' => 'orders_door'),
					array('title' => '简化单','link' => 'orders_simple'),
					array('title' => '工程单','link' => 'orders_project')
		            );
	}
	
	
	
	function index()
	{
		$listsql = $this->Orders_door_Model->user_orders_sql( $this->logid );
	    $this->data["list"] = $this->paging->show( $listsql , 10 );
		//输出到视窗
		$this->load->view_wuser('orders/door',$this->data);
	}
	
	
	function view($id=0)
	{
		$this->load->model('Orders_Model');
		
		$id = get_num($id);
		$action = $this->input->get('action');
		if( $id )
		{
			if($action=="yes")
			{
				//工人同意退款，记录步骤、所有步骤状态->完成，订单状态->完成
				$this->Orders_Model->order_door_w_newstep($id,$this->logid,"同意退回费用！",1);
			}
			elseif($action=="no")
			{
				//工人不同意退款，记录步骤、登录雇主操作
				$this->Orders_Model->order_door_w_newstep($id,$this->logid,"不同意退回！");
			}
			
			//根据合同步骤状态获取当前合同的状态(是否完成)
			$ostat = $this->Orders_Model->order_door_stat($id);
			//订单评分状态
			$isevaluate = $this->Common_Model->isevaluate_order_door($id,$this->logid);
			//返回订单状态按钮
			$this->data['order_stat_btu'] = order_stat($ostat,$isevaluate,$id);

			//<><><><>处理输出<><><><><>
			$this->data["view"] = $this->Orders_door_Model->user_orders_view( $this->logid , $id );
			$this->data["view_step"] = $this->Orders_door_Model->user_orders_view_step($id);
			//输出到视窗
			$this->load->view_wuser('orders/door_view',$this->data);
		}
	}


	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
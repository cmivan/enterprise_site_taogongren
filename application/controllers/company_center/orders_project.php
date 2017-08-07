<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_project extends COMPANY_Controller {

	public $id;

	function __construct()
	{
		parent::__construct();

		$this->load->library('Paging');
		$this->load->model('Orders_Model');
		
		$this->load->model('Orders_project_Model');
		//用于工人、团队、公司，必须设置为0
		$this->Orders_simple_Model->user_type = 0;
		
		$this->load->model('Common_Model');
		
		$this->load->helper('orders');
		$this->lang->load('order', 'cn');

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '上门单','link' => 'orders_door'),
					array('title' => '简化单','link' => 'orders_simple'),
					array('title' => '工程单','link' => 'orders_project')
		            );

	}
	
	
	
	function index()
	{
		$listsql = $this->Orders_project_Model->user_orders_sql( $this->logid );
	    $this->data["list"] = $this->paging->show($listsql,10);
		//输出到视窗
		$this->load->view_wuser('orders/project',$this->data);
	}
	

	
	function view($id=0)
	{
		$id = get_num($id,'404');
		$this->lang->load('order', 'cn');
		
		//页面上的操作(删除或审核)
		$action = $this->input->get('action');
		if($action!='')
		{
			$this->id = $id;
			$pid = $this->input->getnum('pid');
			switch ($action)
			{
				//删除报价
				case 'price_del': $this->price_del($pid); break;
				//用户确认合同
				case 'deal_ok': $this->deal_ok(); break;  
			}
		}

		//读取订单基本信息
	    $orders_view = $this->Orders_project_Model->user_orders_view( $this->logid , $id );
		if(!empty($orders_view))
		{
			$this->data["id"] = $id;
			$this->data["view"] = $orders_view;
			$order2uid = $orders_view->uid; 
			$this->data['user_links'] = $this->User_Model->links($order2uid);
			$this->data['note'] = $orders_view->note;
			$this->data['addtime'] = $orders_view->addtime;
			//相应的任务id
			$r_rid = $orders_view->retrieval_id;
		}
			
		//返回订单中是否有新的报价项目
		$this->data['new_quote'] = $this->Orders_Model->new_quote($id);
		//总的标价
		$this->data['allprice']  = $this->Orders_Model->order_project_allprice($id);
		//有效的标价
		$this->data['allprice1'] = $this->Orders_Model->order_project_allprice($id,1);
		
		//获取用户报价信息
		$price_q = $this->Orders_Model->order_project_quote($id);
	    $this->data['price_view'] = $price_q->result();
		$this->data['price_num']  = $price_q->num_rows(); //获取数据库总数量

		//获取合同信息
		$this->data['deal_view'] = $this->Orders_project_Model->user_orders_deal( $id );

		//判断是否已经(添加并双方确认)了合同信息
		$this->data['dealok'] = $this->Orders_Model->order_project_deal_stat($id);
		
		//根据合同步骤状态获取当前合同的状态(是否完成)
		$this->data['ostat'] = $this->Orders_Model->order_project_stat($id);
		
		//订单评分状态
		$isevaluate = $this->Common_Model->isevaluate_order_project($id,$this->logid);
		
		//返回订单状态按钮
		$this->data['order_stat_btu'] = order_stat($this->data['ostat'],$isevaluate,$id);	

		//获取该合同的步骤信息
		$this->data['deal_steps'] = $this->Orders_project_Model->user_orders_steps( $id );

		//输出到视窗
		$this->load->view_wuser('orders/project_view',$this->data);
	}
	
	
	//合同详细信息
	function deal($id)
	{
		$id = get_num($id,'404');
		$orders_view = $this->Orders_project_Model->user_orders_view( $this->logid , $id );
		if(!empty($orders_view))
		{
			$this->data["project_view"] = $orders_view;
		    $this->data["uid"] = $orders_view->uid;
		    $this->data["uid_2"] = $orders_view->uid_2;
		    $this->data["yaoqiu_note"] = $orders_view->note;
		   
		    //判断是否已经同意所有报价
			$this->db->from('order_quote');
			$this->db->where('o_id',$id);
			$this->db->where('u_ok !=',1);
			$count = $this->db->get()->num_rows();
		    if($count>0)
			{
				$this->data["deal_show"] = false;
			}
			else
			{
				$this->data["deal_show"] = true;
			}
		}
		
		//读取合同信息
		if(is_num($id))
		{
		   $deal_view = $this->Orders_project_Model->user_orders_deal( $id );
		   if($deal_view)
		   {
			  //获取合同基本数据
			  $this->data["id"] = $id;
			  $this->data["title"] = $deal_view->title;
			  $this->data["yaoqiu"] = $deal_view->yaoqiu;
			  $this->data["other"] = $deal_view->other;
			  $this->data["total_money"] = $deal_view->total_money;
			  $this->data["cy_money"] = $deal_view->cy_money;
			  
			  //获取合同阶段数据(数组形式)
			  $moneyArr = array();
			  $daysArr = array();
			  $contentArr = array();
			  $deal_steps = $this->Orders_project_Model->user_orders_steps( $id );
			  foreach($deal_steps as $step)
			  {
				  $moneyArr[] = $step->money;
				  $daysArr[] = $step->days;
				  $contentArr[] = $step->content;
			  }
			  $this->data["money"] = $moneyArr;
			  $this->data["days"] = $daysArr;
			  $this->data["content"] = $contentArr;
			  $this->data["countItem"] = count($moneyArr);
		   }
		}
		
		//输出到视窗
		$this->load->view_wuser('orders/project_deal_view',$this->data);
	}
	
	

	/*选择订单报价框*/
	function deal_not_ok_msg()
	{
		/*提交保存操作*/
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$id = $this->input->postnum('id');
			$note = noHtml($this->input->post('note'));
			if($id==false)
			{
				json_form_no($this->lang->line('system_tip_busy'));
			}
			elseif($note=='')
			{
				json_form_no('请填写不同意合同内容的理由!');
			}
			
		    //保证用户有权限操作
		    $this->db->select('order_project.id');
			$this->db->from('order_project');
			$this->db->join('order_project_deal','order_project.id=order_project_deal.o_id','left');
			$this->db->where('order_project.id', $id);
			$this->db->where('order_project.uid_2', $this->logid);
			
			$where_on[] = array('order_project.u_ok !=' => 1);
			$where_on[] = array('order_project_deal.u_ok_2 !=' => 1);
			$this->db->where_on( $where_on );
			//$this->db->where('(' . $this->db->dbprefix('order_project.u_ok') . ' !=1 or ' . $this->db->dbprefix('order_project_deal.u_ok_2') . ' !=1)');
			$rsnum = $this->db->count_all_results();
			if($rsnum>0)
			{
				//有操作权限则写入回复
				$this->db->set('feed',$note);
				$this->db->set('u_ok_2',2);
				$this->db->where('o_id',$id);
				$this->db->update('order_project_deal');
				json_form_yes('意见发送成功!');
		    }
			json_form_no($this->lang->line('system_tip_busy'));
		}
		
		$this->data['id'] = $this->input->getnum('id','404');
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/deal_not_ok_msg';
		$this->data['formTO']->backurl = '';
		
		//输出到视窗
		$this->load->view_wuser('orders/deal_not_ok_msg',$this->data);
	}
	
	
	
	/*订单报价框*/
	function add_price($id=0)
	{
		$id = get_num($id,'404');
		$this->data['id'] = $id;

		//获取当前编辑报价项的信息
		$p_editid = $this->input->postnum("edit_id");
		if( $p_editid==false )
		{
			$p_editid = $this->input->getnum("edit_id");
		}
		
		$p_title = noHtml($this->input->post("project"));
		$p_num = $this->input->post("num");
		$p_units = noHtml($this->input->post("units"));
		$p_r_price = $this->input->postnum("r_price");
		$p_c_price = $this->input->postnum("c_price");
		$p_allprice = $this->input->post("allprice");
		$p_note = noHtml($this->input->post("p_note"));
		$ip = ip();

		if( $this->input->post('go')=="yes" )
		{
			//数据验证
			if($p_title==''){
			   $backinfo="请填写项目名称!";
			}elseif($p_num==''){
			   $backinfo="请填写数量!";
			}elseif(is_num($p_num)==false||$p_num<=0){
			   $backinfo="数量应该为正整数!";
			}elseif($p_units==''){
			   $backinfo="数量至少为1 !";
			}elseif($p_r_price==''){
			   $backinfo="请填写人工单价!";
			}elseif(is_num($p_r_price)==false||$p_r_price<=0){
			   $backinfo="人工单价应为正整数!";
			}elseif($p_c_price==''){
			   $backinfo="请填写材料单价!";
			}elseif(is_num($p_c_price)==false||$p_c_price<0){
			   $backinfo="材料单价应为非负整数!";
			}
			else
			{
			   //开始写入数据
			   $proMD5 = md5($id.$p_title.$p_num.$p_units.$p_r_price.$p_c_price.$p_note);
			   
			   //保证用户有权限操作
			   $this->db->select('id');
			   $this->db->from('order_project');
			   $this->db->where('id', $id);
			   $this->db->where('uid_2', $this->logid);
			   if( $this->db->count_all_results() > 0 )
			   {
				   $backinfoTip = "该项报价已经报价单中,请不要重复添加!";
				   if ( is_num($p_editid) )
				   {
					   $this->db->where('id',$p_editid);
					   $backinfoTip = "您未对该项报价进行任何修改!"; 
				   }
				   
				   $this->db->select('id');
				   $this->db->from('order_quote');
				   $this->db->where('o_id', $id);
				   $this->db->where('proMD5', $proMD5);
				   //判断该项报价是否已经添加(未添加则可以添加)
				   if( $this->db->count_all_results() <= 0 )
				   {
					   $data = array(
							  'o_id' => $id,
							  'u_ok' => 0,
							  'project' => $p_title,
							  'num' => $p_num,
							  'units' => $p_units,
							  'c_price' => $p_c_price,
							  'r_price' => $p_r_price,
							  'note' => $p_note,
							  'addtime' => dateTime(),
							  'ip' => ip(),
							  'proMD5' => $proMD5
							  );
					   //不存在该项信息，允许写入相关报价
					   if($p_editid==false)
					   {
						   $qrs = $this->db->insert('order_quote',$data);
					   }
					   else
					   {
						   $this->db->where('id',$p_editid);
						   $this->db->where('u_ok !=', 1);
						   $qrs = $this->db->update('order_quote',$data);
					   }
					   if($qrs)
					   {
						   json_form_yes('保存成功!');
					   }
					   json_form_no('操作可能失败!');
				   }
				   else
				   {
					   $backinfo = $backinfoTip;
				   } 
			   }
			   json_form_no($backinfo);
			}
		}
		
		
		#编辑状态，读取相应的内容
		if( $p_editid )
		{
			$this->db->select('order_quote.*');
			$this->db->from('order_project');
			$this->db->join('order_quote','order_project.id = order_quote.o_id','left');
			$this->db->where('order_quote.id',$p_editid);
			$this->db->where('order_project.uid_2', $this->logid);
			$this->db->where('order_quote.u_ok !=',1);
			$rsview = $this->db->get()->row();
		    if(!empty($rsview))
		    {
				//$id = $rsview->id;
				if($p_title==''){$p_title=$rsview->project;}
				if($p_num==''){$p_num=$rsview->num;}
				if($p_units=='')  {$p_units=$rsview->units;}
				if($p_r_price==''){$p_r_price=$rsview->r_price;}
				if($p_c_price==''){$p_c_price=$rsview->c_price;}
				if($p_note=='') {$p_note=$rsview->note;}
		    }
		}

		$this->data["p_editid"]   = $p_editid;
		$this->data["p_title"]    = $p_title;
		$this->data["p_num"]      = $p_num;
		$this->data["p_units"]    = $p_units;
		$this->data["p_r_price"]  = $p_r_price;
		$this->data["p_c_price"]  = $p_c_price;
		$this->data["p_allprice"] = $p_allprice;
		$this->data["p_note"]     = $p_note;

		//获取工程单基本信息
		$this->data['pro_view'] = $this->Orders_project_Model->user_orders_view( $this->logid , $id );
		$this->data['allprice'] = $this->Orders_Model->order_project_allprice($id);

		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/add_price/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"].'/view/'.$id;
		
		//输出到视窗
		$this->load->view_wuser('orders/project_add_price',$this->data);
	}
	

	
	/*选择报价项目框*/
	function project_industrys()
	{
		$this->load->model('Industry_Model');
		$industryid = $this->input->getnum("industryid");
		if( $industryid )
		{
			$this->data["Irs"] = $this->Industry_Model->industryes_view( $industryid , 1 );
		}
		
		//获取工种
		$this->data["industrys"] = $this->Industry_Model->industrys();
		$this->data["industry_class"] = $this->Industry_Model->industry_class();
		//输出到视窗
		$this->load->view_wuser('orders/project_industrys',$this->data);
	}
	
	

	
	/*用户确认合同(需要限定权限)*/
	function deal_ok()
	{
		$id = $this->id;
		if( is_num($pid) )
		{
			//保证用户有权限操作
			$this->db->select('order_project.id');
			$this->db->from('order_project');
			$this->db->join('order_project_deal','order_project.id = order_project_deal.o_id','left');
			$this->db->where('order_project.id',$id);
			$this->db->where('order_project.uid_2', $this->logid);
			$this->db->where('order_project_deal.u_ok',1);
			if( $this->db->count_all_results() > 0 )
		    {
				$this->db->set('u_ok_2', 1);
				$this->db->set('oktime', dateTime());
				$this->db->where('u_ok_2 !=', 1);
				$this->db->where('u_ok', 1);
				$this->db->where('o_id', $id);
				$this->db->update('order_project_deal');
				header("Location:".reUrl("action=null"));exit;
		    }
		}
	}
	
	/*用户删除合同(需要限定权限)*/
	function price_del($pid=0)
	{
		if( is_num($pid) )
		{
			//保证用户有权限操作
			$this->db->select('order_project.id');
			$this->db->from('order_project');
			$this->db->join('order_quote','order_project.id = order_quote.o_id','left');
			$this->db->where('order_quote.id',$pid);
			$this->db->where('order_project.uid_2', $this->logid);
			$this->db->where('order_quote.u_ok !=',1);
			if( $this->db->count_all_results() > 0 )
			{
				$this->db->where('u_ok !=', 1);
				$this->db->where('id =', $pid);
				$this->db->delete('order_quote');
				header("Location:".reUrl("action=null&pid=null"));exit;
			}
		}
	}
	
	
	

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
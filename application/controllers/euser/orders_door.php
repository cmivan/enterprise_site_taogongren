<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_door extends E_Controller {

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
					array('title' => '工程单','link' => 'orders_project'),
					array('title' => '我要下单','link' => 'orders_select')
		            );
	}
	
	
	
	function index()
	{
		$listsql = $this->Orders_door_Model->user_orders_sql($this->logid, 1);
	    $this->data["list"] = $this->paging->show($listsql,10);
		//输出到视窗
		$this->load->view_euser('orders/door',$this->data);
	}
	
	
	function view($id=0)
	{
		$id = get_num($id);
		$action = $this->input->get('action');
		if($id)
		{
			//处理事件
			$stepnum = $this->Orders_Model->order_door_steps($id);
			switch($stepnum)
			{
				case 1:
					if( $action == 'ok' )
					{
						$this->Orders_Model->order_door_e_newstep($id,$this->logid,"同意打款",1);
					}
					elseif( $action == 'back' )
					{
						$this->Orders_Model->order_door_e_newstep($id,$this->logid,"申请退款");
					}
				    break;
				
				case 3:
					if($action == 'cancel')
					{
						//业主同意退款，记录步骤、所有步骤状态->完成，订单状态->完成
						$this->Orders_Model->order_door_e_newstep($id,$this->logid,"取消追究",1);
					}
					elseif($action == 'feed')
					{
						//工人不同意退款，记录步骤、记录业主操作
						$this->Orders_Model->order_door_e_newstep($id,$this->logid,"提交申诉");
						//behacking("业主 ".g_url($uid)." 选择向网站申诉上门单请及时处理");
						//向网站发送申诉请求
						//{程序部分}
					}
				    break;
			}
			//根据合同步骤状态获取当前合同的状态(是否完成)
			$ostat = $this->Orders_Model->order_door_stat($id);
			//订单评分状态
			$isevaluate = $this->Common_Model->isevaluate_order_door($id,$this->logid);
			//返回订单状态按钮
			$this->data['order_stat_btu'] = order_stat($ostat,$isevaluate,$id);
			
			//处理输出
			$this->data["view"] = $this->Orders_door_Model->user_orders_view($this->logid, $id);
			$this->data["view_step"] = $this->Orders_door_Model->user_orders_view_step($id);
			//输出到视窗
			$this->load->view_euser('orders/door_view',$this->data);	
		}

	}
	
	
	
	function add($to_uid='')
	{
		//$to_uid 指订单下给哪位?
		$to_uid = get_num($to_uid,'404');

		$this->data["to_uid"]   = $to_uid;
		$this->data["order_no"] = order_no($this->logid,1);
		$this->data["rid"]      = '0';

		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		//输出到视窗
		$this->load->view_euser('orders/door_add',$this->data);
	}
	
	
	function save()
	{
		$this->load->model('Records_Model');
		$this->load->library('Cost_rate');
		$this->lang->load('order', 'cn');

		#获取数据
		$logid   = $this->logid;
		$uid_2   = $this->input->postnum("to_uid");
		$cost    = $this->input->postnum("cost");
		$place   = noHtml($this->input->post("place"));
		$note    = noHtml($this->input->post("note"));
		$orderid = noHtml($this->input->post("order_no"));
		$retrieval_id = $this->input->postnum("rid",0);
		#添加记录订单信息的md5值，用于防止重复下单和订单信息真实性依据
		$orderMD5 = $logid.$uid_2.$cost.$place.$note.$orderid.$retrieval_id;
		$orderMD5 = md5($orderMD5);
		
		#查找是否已经存在该上门单
		$row = $this->Orders_door_Model->user_orders_md5_view($this->logid, $orderMD5);
		if(!empty($row))
		{
			json_form_no('该上门单已经在 ['.$row->addtime.'] 成功下发,请不要重复下单!');
		}
		
		#验证数据
		if(is_num($uid_2)==false)
		{
			json_form_no('用户无效!');
		}
		elseif($orderid==""||$orderid==NULL)
		{
			json_form_no('单号无效!');
		}
		elseif((is_num($cost)==false||$cost<=0))
		{
			json_form_no('请填写正确的费用金额!');
		}
		elseif($place==""||$place==NULL)
		{
			json_form_no('请填写地址!');
		}
		elseif($note==""||$note==NULL)
		{
			json_form_no('请填写订单描述!');
		}

		#处理费用
		$this->cost_rate->cost = $cost;
		$cost_this = $this->cost_rate->cost_this();  //订单费用
		$cost_ser  = $this->cost_rate->cost_ser();   //服务费
		$cose_sum  = $this->cost_rate->cost_sum();   //订单费+服务费
		$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
		$cost_rate = '<span class="chenghong">'.$cost_rate.'</span>';

		#获取账户余额
		$balance_costs = $this->Records_Model->balance_cost($this->logid,"S");
		#保证账户余额足够
		if($balance_costs < $cose_sum)
		{
			$backtip = "需预付上门单费".$cost_this."元，服务费".$cost_this."&times;".$cost_rate."&asymp;".$cost_ser."元！";
			$backtip.= "<br>您的余额为：".$balance_costs."元。<a href='".site_url($this->data["e_url"].'wallet/charge')."' target='_blank'>请先充值</a>！";
			$backtip = txt2json($backtip);
			json_form_no($backtip);
		}

		#生成数组，用于写入库
		$data['uid']     = $logid;
		$data['uid_2']   = $uid_2;
		$data['cost']    = $cost;
		$data['place']   = $place;
		$data['note']    = $note;
		$data['orderid'] = $orderid;
		$data['retrieval_id'] = $retrieval_id;
		//$data['cost_ser']= $cost_ser;
		$data['addtime'] = dateTime();
		$data['ip'] = ip();
		$data['orderMD5']= $orderMD5;
		$this->db->insert('order_door',$data);

		#获取新添加的订单id
		$insert_id = $this->db->insert_id();
				
		if($insert_id)
		{
			#设置该工人为任务选中人
			if($retrieval_id!=0 && $uid_2)
			{
				$this->load->model('Retrieval_election_Model');
				$this->Retrieval_election_Model->set_seleted($uid_2, $retrieval_id);
			}

			#创建订单的第一个步骤
			$data = array(
				  'stepid' => $insert_id,
				  'steptime' => dateTime(),
				  'stepnote' => '创建订单',
				  'ok' => 0,
				  'isend' => 0
				  );
			$this->Orders_door_Model->user_orders_step_add($data);
		    //"insert into order_door_step (stepid,steptime,stepnote,ok,isend) values(".$insert_id.",'".dateTime()."','创建订单',0,0)"
			
			#下单成功：1.即时扣除费用到系统帐户2.后期处理在按步骤扣除费用
			$order_e_url = site_url($this->data["e_url"].'orders_door/view/'.$insert_id);
			$order_w_url = site_url($this->data["w_url"].'orders_door/view/'.$insert_id);
			
			$order_2e_link = $this->lang->line('order_link');
		    $order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
			$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
			
			$order_2w_link = $this->lang->line('order_link');
		    $order_2w_link = str_replace('{orderid}',$orderid,$order_2w_link);
			$order_2w_link = str_replace('{order_url}',$order_w_url,$order_2w_link);
			
			$user_w_links = $this->User_Model->links($uid_2);
			
			$order_door_cost_tip = $this->lang->line('order_door_cost_tip');
			$order_door_cost_tip = str_replace('{user_w_links}',$user_w_links,$order_door_cost_tip);
			$order_door_cost_tip = str_replace('{order_link}',$order_2e_link,$order_door_cost_tip);
			$order_door_cost_tip = str_replace('{cost_this}',$cost_this,$order_door_cost_tip);
			$order_door_cost_tip = str_replace('{cost_ser}',$cost_ser,$order_door_cost_tip);

			#<><><>初始化金额,转换成负值，保证扣除费用
		    if($cose_sum>0){$c_r_cost = -$cose_sum;}else{$c_r_cost = $cose_sum;}
			$this->Records_Model->balance_control($logid,$c_r_cost,$order_door_cost_tip,'S');

			#***** 加载发送辅助函数 ******
			$this->load->helper('send');
			#***************************
			
		    #<><><>发送站内消息[通知工人] 0代表系统发送的
			$tip ="你好! 业主&nbsp;".$this->User_Model->links($logid)."&nbsp;";
			$tip.='给你下了新的上门订单，单号：'.$order_2w_link.'<br>';
			$tip.="费用：<span class=chenghong>".$cost_this."元</span>。";
			msgto(0,$uid_2,$tip);
			
		    #<><><>获取业主信息 发送短信消息[通知工人]
			$names1 = $this->User_Model->name($logid); 
			$mobile1 = $this->User_Model->mobile($logid);
			$mobile2 = $this->User_Model->mobile($uid_2);
			if(is_num($mobile1) && is_num($mobile2))
			{
				$tip ="业主".$names1."(".$mobile1.") 给你下了新的上门单；地点：".$place."，描述：".$note;
				$tip.="，费用：".$cost_this."元。详情请登录淘工人网！";
				smsto($mobile2,$tip);
			}
			
			#操作成功后，页面跳转
			$backtip = "成功下单！需预付上门单费".$cost_this."元，服务费".$cost_ser."元！";
			$backtip = txt2json($backtip);
			json_form_yes($backtip);
		}
		else
		{
			json_form_no('订单添加失败!');
		}

//		运行事务
//		$this->db->trans_start();
//		$('一条SQL查询...');
//		$('另一条查询...');
//		$('还有一条查询...');
//		$this->db->trans_complete();

		
	}

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
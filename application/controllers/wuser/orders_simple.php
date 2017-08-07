<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_simple extends W_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->library('Paging');
		$this->load->model('Orders_simple_Model');
		
		$this->load->helper('orders');
		
		$this->load->model('Common_Model');
		$this->load->model('Records_Model');
		$this->load->library('Cost_rate');
		$this->lang->load('order', 'cn');
		
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '上门单','link' => 'orders_door'),
					array('title' => '简化单','link' => 'orders_simple'),
					array('title' => '工程单','link' => 'orders_project')
		            );
	}
	
	
	
	function index()
	{
		$listsql = $this->Orders_simple_Model->user_orders_sql($this->logid);
	    $this->data["list"] = $this->paging->show($listsql,10);
		/*输出到视窗*/
		$this->load->view_wuser('orders/simple',$this->data);
	}
	
	
	
	function simple_ok()
	{
		$logid = $this->logid;
		$sid = $this->input->postnum('sid');
		if($sid==false)
		{
			$sid = $this->input->getnum('sid','404');
		}
		
		//处理提交事件
		$go = $this->input->post('go');	
		//获取该订单的基本信息.判断当前步骤是否已经打款，如果已打款并且业主已提交退款申请则允许操作
		//select * from `order_simple` where uid_2=$logid and id=$sid and ok=2 and refund_ok=1 LIMIT 1
		$row = $this->Orders_simple_Model->user_orders_info($this->logid,$sid);
		if(!empty($row) && $go=='yes')
		{
			$uid      = $row->uid;
			$uid_2    = $row->uid_2;
			$note     = $row->note;
			$thiscost = $row->cost;
			$paycost  = $row->refund;
			$orderid  = $row->orderid;
			//获取主单号的id,用于返回链接地址
			$o_id = get_num($row->o_id,$sid);

			//**不超过订单金额数*****************
			if($paycost>=0 && $thiscost>=$paycost)
			{
				//初始化金额(用于写入数据库的),操作工人帐户的(从平台上划到工人账户上)
				$c_r_cost_1 = $thiscost-$paycost;  //返回给业主的
				$c_r_cost_2 = $paycost;  //充值给工人的
				
				//<><><>处理费用
				$this->cost_rate->cost = $c_r_cost_2;
				//工人确认的(订单费用-订单费用的*0.05)
				$cost_this = $this->cost_rate->cost_less();  //订单费用
				//提取交易费用的5%存入该工人的信用账户
				$cost_ser  = $this->cost_rate->cost_ser();   //服务费
				//交易抽取的比率
				$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
				$cost_rate_last = $this->cost_rate->cost_rate_last();  //剩余的
  
				#下单成功：1.即时扣除费用到系统帐户2.后期处理在按步骤扣除费用
				$user_e_links = $this->User_Model->links($uid);
				$user_w_links = $this->User_Model->links($logid);
				#<><><><>---<><><><>
				$order_e_url = site_url($this->data["e_url"].'orders_simple/view/'.$o_id);
				$order_2e_link = $this->lang->line('order_link');
				$order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
				$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
				#<><><><>---<><><><>
				$order_w_url = site_url($this->data["w_url"].'orders_simple/view/'.$o_id);
				$order_2w_link = $this->lang->line('order_link');
				$order_2w_link = str_replace('{orderid}',$orderid,$order_2w_link);
				$order_2w_link = str_replace('{order_url}',$order_w_url,$order_2w_link);
				
				//支付给工人,基本金额
				$order_simple_cost_ok = $this->lang->line('order_simple_cost_ok');
				$order_simple_cost_ok = str_replace('{user_e_links}',$user_e_links,$order_simple_cost_ok);
				$order_simple_cost_ok = str_replace('{order_link}',$order_2e_link,$order_simple_cost_ok);
				$order_simple_cost_ok = str_replace('{c_r_cost_2}',$c_r_cost_2,$order_simple_cost_ok);
				$order_simple_cost_ok = str_replace('{cost_ser}',$cost_ser,$order_simple_cost_ok);
				$this->Records_Model->balance_control($uid_2,$cost_this,$order_simple_cost_ok,"S");
  
				//支付给工人,信用金额
				$order_simple_cost_xy_ok = $this->lang->line('order_simple_cost_xy_ok');
				$order_simple_cost_xy_ok = str_replace('{user_e_links}',$user_e_links,$order_simple_cost_xy_ok);
				$order_simple_cost_xy_ok = str_replace('{order_link}',$order_2e_link,$order_simple_cost_xy_ok);
				$order_simple_cost_xy_ok = str_replace('{c_r_cost_2}',$c_r_cost_2,$order_simple_cost_xy_ok);
				$order_simple_cost_xy_ok = str_replace('{cost_rate}',$cost_rate,$order_simple_cost_xy_ok);
				$order_simple_cost_xy_ok = str_replace('{cost_ser}',$cost_ser,$order_simple_cost_xy_ok);
				$this->Records_Model->balance_control($uid_2,$cost_ser,$order_simple_cost_xy_ok,"S_XY");

				# 如果支付费用后，有余额（$c_r_cost_1>0）则，返回到业主账户上
				if($c_r_cost_1>0)
				{
					$order_simple_cost_ok_2e = $this->lang->line('order_simple_cost_ok_2e');
				    $order_simple_cost_ok_2e = str_replace('{user_w_links}',$user_w_links,$order_simple_cost_ok_2e);
				    $order_simple_cost_ok_2e = str_replace('{order_link}',$order_2w_link,$order_simple_cost_ok_2e);
				    $order_simple_cost_ok_2e = str_replace('{c_r_cost_1}',$c_r_cost_1,$order_simple_cost_ok_2e);
				    $this->Records_Model->balance_control($uid,$c_r_cost_1,$order_simple_cost_ok_2e,"S");
				}
				   
				# 支付成功,更新状态,将当前单设置为已成功支付的订单
				//update `order_simple` set refund_ok=2,ok=1,updatetime='".dateTime()."' where uid_2=$logid and id=$sid and ok=2
				if( $this->Orders_simple_Model->user_orders_update($this->logid,$sid) )
				{
					#获取业主手机号，用于短信通知
				    $names2  = $this->User_Model->name($uid_2);
				    $mobile1 = $this->User_Model->mobile($uid);
				    $mobile2 = $this->User_Model->mobile($uid_2);
				   
				    $order_simple_ok_msg_2e = $this->lang->line('order_simple_ok_msg_2e');
				    $order_simple_ok_msg_2e = str_replace('{user_w_links}',$user_w_links,$order_simple_ok_msg_2e);
				    $order_simple_ok_msg_2e = str_replace('{order_link}',$order_2e_link,$order_simple_ok_msg_2e);
				    $order_simple_ok_msg_2e = str_replace('{c_r_cost_2}',$c_r_cost_2,$order_simple_ok_msg_2e);
				    $order_simple_ok_msg_2e = str_replace('{cost_ser}',$cost_ser,$order_simple_ok_msg_2e);
				  
				    $order_simple_ok_sms_2e = $this->lang->line('order_simple_ok_sms_2e');
				    $order_simple_ok_sms_2e = str_replace('{user_w}',$names2,$order_simple_ok_sms_2e);
				    $order_simple_ok_sms_2e = str_replace('{mobile2}',$mobile2,$order_simple_ok_sms_2e);
				    $order_simple_ok_sms_2e = str_replace('{c_r_cost_2}',$c_r_cost_2,$order_simple_ok_sms_2e);
				   
				    msgto(0,$uid,$order_simple_ok_msg_2e);
				    smsto($mobile1,$order_simple_ok_sms_2e,1); //最后的参数1表示不需要返回倒计时

				    # 用于最终弹出的提示
				    $backinfo = "您已同意了业主的验收申请，验收费用为 <span class=chenghong>".colorT($c_r_cost_2)."元</span>，";
				    $backinfo.= "其中的 ".colorT($cost_rate_last)." 将存入你的现金账户，";
				    $backinfo.= colorT($cost_rate)." 将存入你的信用账户！";
				   
				    json_form_yes(txt2json($backinfo));
				}
				json_form_no($this->lang->line('system_tip_busy'));
			}
			json_form_no($this->lang->line('system_tip_busy'));
		}elseif($go=='yes'){
			json_form_no($this->lang->line('system_tip_busy'));
		}elseif($row){
			
			//返回显示数据
			$this->data['paycost']  = $row->refund;
			$this->data['sid']      = $sid;

			/*表单配置*/
			$this->data['formTO']->url = $this->data["c_urls"].'/simple_ok';
			$this->data['formTO']->backurl = '';
			$this->load->view_wuser('orders/simple_ok_box',$this->data);
		}else{
			json_echo('<br /><div style="text-align:center;">'.$this->lang->line('system_tip_busy').'</div>');
		}

	}
	
	
	
	function simple_not_msg()
	{
		$logid = $this->logid;
		//处理提交事件
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$id   = $this->input->postnum('id');
		    $msg  = noHtml($this->input->post('note'));	
		    if($id==false){ json_form_no($this->lang->line('system_tip_busy')); }
		    if($msg==''){ json_form_no('请填写原因!'); }
		   
		    # 获取该订单的基本信息,判断当前步骤是否已经打款，如果已打款并且业主已提交退款申请则允许操
		    //select * from `order_simple` where uid_2=$logid and id=$id and ok=2 and refund_ok=1
		    $row = $this->Orders_simple_Model->user_orders_info($this->logid,$sid);
		    if(!empty($row))
		    {
				#<>获取相应的数据
			    $uid       = $row->uid;
			    $r_note    = $row->note;
			    $r_cost    = $row->cost;
			    $r_paycost = $row->refund;
			    $orderid   = $row->orderid;
			    $o_id      = $row->o_id;
			   
			    //当非补单时,直接获取id值
			    if(empty($o_id)||$o_id<=0){$o_id=$id;}

			    #<>下单成功：1.即时扣除费用到系统帐户2.后期处理在按步骤扣除费用
			    $order_e_url= site_url($this->data["e_url"].'orders_simple/view/'.$o_id);
			    $order_2e_link = $this->lang->line('order_link');
			    $order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
			    $order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);

			    //更新状态
				$this->Orders_simple_Model->user_orders_update_msg($this->logid,$id,$msg);
/*			    update `order_simple` set 
								refund_ok=0,
								msg='".$msg."',
								updatetime='".dateTime()."' where 
								uid_2=$logid and 
								id=$id and ok=2 and refund_ok=1*/
			   
			    #<>发送站内通知
			    $tip = "您好!用户 ".$this->User_Model->links($logid)." 不同意你对编号:".$order_2e_link." 的订单的验收申请。";
			    $tip.= colorT("原因:".$msg."!",'red');
			    msgto(0,$uid,$tip);

			    #<><><>获取工人称呼 发送短信消息[通知业主]
			    $names1  = $this->User_Model->name($uid); 
			    $mobile1 = $this->User_Model->mobile($uid);
			    $names2  = $this->User_Model->name($logid);
			    $mobile2 = $this->User_Model->mobile($logid);
			    if(is_num($mobile1)&&get_num($mobile2))
			    {
					$tip = "手机".$mobile2."的用户 ".$names2." 不同意你的验收申请,原因：".$msg."。详情请登陆淘工人网!";
					smsto($mobile1,$tip,1); //最后的参数1表示不需要返回倒计时
			    }

		   }else{
			   json_form_no($this->lang->line('system_tip_busy'));
		   }
		   json_form_yes('提交成功，请等待处理!');
		}
		
		$this->data['id'] = $this->input->getnum('id','404');
		
		$this->data['formTO']->url = $this->data["c_urls"].'/simple_not_msg';
		$this->data['formTO']->backurl = '';
		/*输出到视窗*/
		$this->load->view_wuser('orders/simple_not_msg',$this->data);
	}


	
	function add($to_uid='')
	{
		//$to_uid 指订单下给哪位?
		$to_uid = get_num($to_uid,'404');
		$action = $this->input->get('action');
		if($action == 'deel.read.ok')
		{
			$this->session->set_userdata(array('deel.read' => 'ok'));
		}
		$deel_read = $this->session->userdata('deel.read');
		/*输出到视窗*/
		if(empty($deel_read)||$deel_read!='ok')
		{
		   $this->load->view_wuser('orders/simple_deel',$this->data);
		}
		else
		{
		   $this->data["to_uid"]   = $to_uid;
		   $this->data["order_no"] = order_no($this->logid,1);
		   $this->data["rid"]      = '0';

		   /*表单配置*/
		   $this->data['formTO']->url = $this->data["c_urls"].'/save';
		   $this->data['formTO']->backurl = $this->data["c_urls"];
		   
		   $this->load->view_wuser('orders/simple_add',$this->data);
		}
	}
	
	
	
	/*添加简化单的补单信息*/
	function patch($to_oid='')
	{
		//保证id值合法
		$to_oid = get_num($to_oid,'404');
		//判断该订单id是否存在，并该用户有操作权限
		//select * from order_simple where id='.$to_oid.' and uid_2='.$this->logid.' and o_id=0 LIMIT 1
		$rs = $this->Orders_simple_Model->user_orders_patch_info($this->logid,$to_oid);
		if(empty($rs))
		{
		    json_echo($this->lang->line('system_tip_busy'));
		}
		else
		{
			$this->data["to_oid"]   = $to_oid;
			$this->data["to_uid"]   = $rs->uid;
			$this->data["to_uid_2"]   = $rs->uid_2;
			$this->data["order_no"] = $rs->orderid;
			
			#判断是否已经添加评价,对方是都已经对订单评分(订单已互评,则应该返回订单)
			$isevaluate = $this->Common_Model->evaluate_order_simple($to_oid,$this->data["to_uid"]);
			$beevaluate = $this->Common_Model->evaluate_order_simple($to_oid,$this->data["to_uid_2"]);
			if($isevaluate!=false&&!empty($isevaluate)&&$beevaluate!=false&&!empty($beevaluate))
			{
				redirect($this->data['c_urls'].'/view/'.$to_oid, 'refresh');
			}

		    /*表单配置*/
		    $this->data['formTO']->url = $this->data["c_urls"].'/save';
		    $this->data['formTO']->backurl = $this->data["c_urls"];
			
			$this->load->view_wuser('orders/simple_add',$this->data);
		}
	}
	
	
	
	function view($id=0)
	{
		$id = get_num($id,'404');
		
		//获取基本信息
		$this->data["view"] = $this->Orders_simple_Model->user_orders_view($this->logid,$id);
		$this->data["view_step"] = $this->Orders_simple_Model->user_orders_view_step($this->logid,$id);
		
		/*输出到视窗*/
		$this->load->view_wuser('orders/simple_view',$this->data);
	}
	
	
	
	function save()
	{
		$this->load->model('Records_Model');
		$this->load->library('Cost_rate');
		$this->lang->load('order', 'cn');
		
		#获取数据
		$logid   = $this->logid;
		$uid     = $this->input->postnum("to_uid");
		$cost    = $this->input->postnum("cost");
		$bx_time = noHtml($this->input->post("bx_time"));
		$place   = noHtml($this->input->post("place"));
		$note    = noHtml($this->input->post("note"));
		$orderid = noHtml($this->input->post("order_no"));
		$rid = $this->input->postnum("rid",0);
		$retrieval_id = 0;
		
		#根据$o_id获取用户id
		$o_id = $this->input->postnum("to_oid",0);
		if($o_id!=0)
		{
		   $rs = $this->Orders_simple_Model->user_orders_view($this->logid,$o_id);
		   if(empty($rs))
		   {
			   $this->Records_Model->balance_control($uid,$cost,'',"S");
			   json_form_no($this->lang->line('system_tip_busy'));
		   }
		   else
		   {
			   $uid = $rs->uid;
			   $orderid = $rs->orderid;
			   $retrieval_id = $rs->retrieval_id; 
		   }
		}
		$retrieval_id = get_num($retrieval_id,0);
		
		
		#添加记录订单信息的md5值，用于防止重复下单和订单信息真实性依据
		$orderMD5 = $logid.$uid.$cost.$bx_time.$place.$note.$orderid.$retrieval_id.$o_id;
		$orderMD5 = md5($orderMD5);

		#查找是否已经存在该上门单
		$rs = $this->Orders_simple_Model->user_ordersmd5_view($this->logid,$orderMD5);
		if(!empty($rs))
		{
			json_form_no('该简化单已经在 ['.$rs->addtime.'] 成功下发,请不要重复下单!');
		}
		
		#<><><>验证数据
		if(is_num($uid)==false){ json_form_no('用户无效!'); }
		elseif($orderid==''||$orderid==NULL){ json_form_no('单号无效!'); }
		elseif((is_num($cost)==false||$cost<=0)){ json_form_no('请填写正确的费用金额!'); }
		elseif($place==''||$place==NULL){ json_form_no('请填写地址!'); }
		elseif($note==''||$note==NULL){ json_form_no('请填写订单描述!'); }
		
		#<><><>处理费用
		$this->cost_rate->cost = $cost;
		$cost_this = $this->cost_rate->cost_this();  //订单费用
		$cost_ser  = $this->cost_rate->cost_ser();   //服务费
		$cose_sum  = $this->cost_rate->cost_sum();   //订单费+服务费
		$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
		$cost_rate = '<span class="chenghong">'.$cost_rate.'</span>';
		
		#<><><>生成数组，用于添加简化单
		$data['uid']     = $uid;
		$data['uid_2']   = $logid;
		$data['cost']    = $cost;
		$data['bx_time'] = $bx_time;
		$data['place']   = $place;
		$data['note']    = $note;
		$data['w_uid']   = $logid;
		$data['orderid'] = $orderid;
		$data['o_id']    = $o_id;
		$data['retrieval_id'] = $retrieval_id;
		$data['cost_ser']     = $cost_ser;
		$data['addtime']      = dateTime();
		$data['updatetime']   = dateTime();
		#ok=0 表示未打款到平台
		$data['ok'] = 0;
		$data['ip'] = ip();
		$data['orderMD5']= $orderMD5;
		$this->db->insert('order_simple',$data);
		#获取新添加的订单id
		$insert_id = $this->db->insert_id();
		$insert_id = 50;
		$insert_id = get_num($insert_id);
		
	    #操作成功后，页面跳转
	    if(is_num($insert_id))
		{
			#获取最新录入的id值
			if($o_id){$insert_id = $o_id;}
			
			#下单成功：1.即时扣除费用到系统帐户2.后期处理在按步骤扣除费用
			$order_e_url= site_url($this->data["e_url"].'orders_simple/view/'.$insert_id);
			#<><><>
			$order_2e_link = $this->lang->line('order_link');
		    $order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
			$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
			
			$tip ="您好!用户 ".$this->User_Model->links($logid)."补充了简化单,订单编号:".$order_2e_link.",请查看!";
			msgto(0,$uid,$tip);  //$tip = txt2json($tip);
			
		    #<><><>获取工人称呼 发送短信消息[通知业主]
			$names1  = $this->User_Model->name($uid); 
			$mobile1 = $this->User_Model->mobile($uid);
			$names2  = $this->User_Model->name($logid);
			$mobile2 = $this->User_Model->mobile($logid);
			
			if(is_num($mobile1)&&get_num($mobile2))
			{
				if($place!=''){$tip = ",地点：".$place;}else{$tip = '';}
				$tip = "手机".$mobile2."的用户 ".$names2." 补充了简化单".$tip;
				$tip.= ",描述：".$note.",费用：".$cost."元! 【淘工人网】";
				smsto($mobile1,$tip,1); //最后的参数1表示不需要返回倒计时
			}
			
			json_form_yes('成功添加补单，并已短信通知业主!');
	    }
		
	}


	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
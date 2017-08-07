<?php
#订单信息

class Orders_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/**
 * 成交的次数
 */	
	function order_oks($uid)
	{
		$this->db->from('order_project');
    	$this->db->where('uid_2', $uid);
    	return $this->db->count_all_results();
	}

/**
 * 获取上门单的基本信息
 */	
	function order_doors($id,$uid)
	{
		$this->db->select('id,note,uid,uid_2');
		$this->db->from('order_door');
		$this->db->where('id',$id);
		$where_on[] = array('uid'=>$uid);
		$where_on[] = array('uid_2'=>$uid);
		$this->db->where_on($where_on);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}

/**
 * 上门单是否已完成
 */	
	function order_door_stat($oid)
	{
		$this->db->from('order_door_step');
    	$this->db->where('stepid', $oid);
		$this->db->where('isend', 1);
    	$stat_num = $this->db->count_all_results();
		if($stat_num>=0)
		{
			return true;
		}
		return false;
	}

/**
 * 获取上门单处理的步骤数
 */	
	function order_door_steps($id=0)
	{
		$this->db->from('order_door_step');
    	$this->db->where('stepid', $id);
    	$num = $this->db->count_all_results();
		return get_num($num,0);
	}

/**
 * 返回(限定用户权限)工程单详细信息
 */	
	function order_projects($id,$uid)
	{
		$this->db->select('id,note,uid,uid_2');
		$this->db->from('order_project');
		$this->db->where('id',$id);
		$where_on[] = array('uid'=>$uid);
		$where_on[] = array('uid_2'=>$uid);
		$this->db->where_on($where_on);
		$this->db->limit(1);
		return $this->db->get()->row();
	}


/**
 * 返回工程单的合同详细信息
 */
	function order_project_deal_view($oid=0)
	{
		$this->db->from('order_project_deal');
		$this->db->where('o_id',$oid);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	

/**
 * 判断并返回工程单的合同状态（是否双方确认同意）
 */
	function order_project_deal_stat($oid)
	{
		$this->db->select('u_ok,u_ok_2');
		$this->db->from('order_project_deal');
		$this->db->where('o_id',$oid);
		$this->db->limit(1);
		$deal_rs = $this->db->get()->row();
		if($deal_rs)
		{
			if($deal_rs->u_ok==1&&$deal_rs->u_ok_2==1)
			{
				return true;
			}
		}
		return false;
	}

/**
 * 获取工程单总有多少个阶段
 */	
	function order_project_steps($id=0)
	{
		$this->db->from('order_project_step');
    	$this->db->where('o_id', $id);
    	$num = $this->db->count_all_results();
		return get_num($num,0);
	}	

/**
 * 返回(限定用户权限)工程单详细信息
 */	
	function order_simples($id,$uid)
	{
		$this->db->select('id,note,uid,uid_2');
		$this->db->from('order_simple');
		$this->db->where('id',$id);
		$where_on[] = array('uid'=>$uid);
		$where_on[] = array('uid_2'=>$uid);
		$this->db->where_on($where_on);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}


/**
 * 获取工程单当前的状态(是否完成)
 */	
	function order_project_stat($id=0)
	{
		$id = get_num($id,'');
		#获取订单步骤(是否完成)
		$this->db->from('order_project_step');
    	$this->db->where('o_id', $id);
		$this->db->where('ispay !=', 2);
    	$rowsnum = $this->db->count_all_results();

		$this->db->from('order_project_step');
    	$this->db->where('o_id', $id);
    	$allsnum = $this->db->count_all_results();

		if($rowsnum>0||$allsnum<=0)
		{
			return false; //订单经行中...
		}
		else
		{
			return true;  //订单已经完成
		}
	}

/**
 * 根据id返回工程单信息
 */
	function order_project_info($id,$f)
	{
		if(is_num($id))
		{
			$this->db->select($f);
			$this->db->from('order_project');
			$this->db->where('id',$id);
			$this->db->limit(1);
			$oprs = $this->db->get()->row();
			if(!empty($oprs))
			{
				return $oprs->$f;
		    }
		}
		return '';
	}
	
	
/**
 * 判断是否已经添加评价
 * $T 评价的类型(简化单或工程单)
 */	
/*	function order_simple_comm($id=0,$uid=0,$T='0')
	{
		#判断是否已经添加评价
		$id  = get_num($id,0);
		$uid = get_num($uid,0);
		$rowsnum = "select id from `evaluate` where oid=".$id." and uid=".$uid." and T='".$T."' LIMIT 1
		if($rowsnum>0){ return true; }else{ return false; }
	}*/


/**
 * 返回所有报价总额$id=订单id
 * $t=0 总报价,$t=1有效报价
 */	
	function order_project_allprice($id=0,$t=0)
	{
		$aprice = 0;
		$id = get_num($id);
		if($id)
		{
			$this->db->select('order_quote.num,order_quote.c_price,order_quote.r_price');
			$this->db->from('order_project');
			$this->db->join('order_quote','order_project.id = order_quote.o_id','left');
			$this->db->where('order_project.id',$id);
			if($t!=0)
			{
				$this->db->where('order_quote.u_ok',1);
			}
			$pall = $this->db->get()->result();
			
			if(!empty($pall))
			{
				foreach($pall as $prs)
				{
					$aprice = $aprice + ($prs->c_price + $prs->r_price)*$prs->num;
				}
			}
		}
		return $aprice;
	}



/**
 * 返回指定订单的所有报价信息
 */
	function order_project_quote($id=0)
	{
		$this->db->select('*');
		$this->db->from('order_quote');
		$this->db->where('o_id',$id);
		$this->db->order_by('id','desc');
		return $this->db->get();
	}
	
	
	

/**
 * 工程项目报价的状态(是否已经审核)
 */	
	function prostat($ok=0,$t=0){
		if($t==0)
		{
			if($ok==0)
			{
				echo "<span class=red>New</span>";
			}
			elseif($ok==1)
			{
				echo "<span class='green tip' title=已同意给出的报价>&radic;</span>";
			}
			else
			{
				echo "<span class='red tip' title=不同意给出的报价>&times;</span>";
			}
		}
		elseif($ok==1)
		{
			echo "-";
		}
		else
		{
			echo "<a href='javascript:void(0);' class=delpro>删除</a>&nbsp;";
			echo "<a href='javascript:void(0);' class=editpro>修改</a>";
		}
	}
	




/**
 * $oid 表示订单 id
 * $step 表示合同步骤
 * $T表示返回类型，$T=0当前步骤是否已经完成，$T=1上一步是否已经完成$T=2是否全部已经完成
 */	
	function project_step_stat($logid=0,$oid=0,$step,$T=0)
	{
		$this->db->from('order_project');
		$this->db->join('order_project_step','order_project.id=order_project_step.o_id','left');
		$this->db->where('order_project.id',$oid);
		$data_on[] = array('order_project.uid'=>$logid);
		$data_on[] = array('order_project.uid_2'=>$logid);
		$this->db->where_on($data_on);
				
		if($T==0)
		{
			$this->db->select('order_project.id,order_project_step.ispay');
			$this->db->where('order_project_step.stepNO',$step);
			$row = $this->db->get()->row();
			//$sql1 = "select OP.id,OPS.ispay from `order_project` OP left join `order_project_step` OPS on OP.id=OPS.o_id where OP.id=".$oid." and (OP.uid=".$logid." or OP.uid_2=".$logid.") and OPS.stepNO=".$step;
			if(!empty($row))
			{
				return $row->ispay;
		    }
		    return 0;
		}
		elseif($T==1)
		{
			$UPstep = $step-1;
			if($UPstep>0)
			{
				$this->db->select('order_project.id,order_project_step.ispay');
				$this->db->where('order_project_step.stepNO',$UPstep);
				$this->db->where('order_project_step.ispay',2);
				$row = $this->db->get()->row();
				//$sql1 = "select OP.id,OPS.ispay from `order_project` OP left join `order_project_step` OPS on OP.id=OPS.o_id where OP.id=".$oid." and (OP.uid=".$logid." or OP.uid_2=".$logid.") and OPS.stepNO=$UPstep and OPS.ispay=2";
				if(!empty($row))
				{
					return $row->ispay;
				}
				return 0;
			}
			$this->db->_reset_select();
			return 2;
		}
		elseif($T==2)
		{
			$this->db->select('order_project.id');
			$this->db->where('order_project_step.ispay',2);
			$rownum = $this->db->count_all_results();
			//$sql1 = "select OP.id from `order_project` OP left join `order_project_step` OPS on OP.id=OPS.o_id where OP.id=".$oid." and (OP.uid=".$logid." or OP.uid_2=".$logid.") and OPS.ispay<>2";
			if($rownum>0)
			{
				return false;
			}
			return true;
		}
		$this->db->_reset_select();
		return false;
	}



/**
 * 返回订单中是否有新的报价项目$id=订单id (当id<>1时，显示按钮)
 * u_ok: 0新报价，1同意，2不同意
 */
	function new_quote($id=0)
	{
		$id = get_num($id);
		if( $id )
		{
			//缓存该部分查询
			$this->db->start_cache();
			$this->db->select('order_project.id');
			$this->db->from('order_project');
			$this->db->join('order_quote','order_project.id=order_quote.o_id','left');
			$this->db->where('order_project.id',$id);
			$this->db->stop_cache();
			
			//存在【新】的报价项目
			$this->db->where('order_quote.u_ok',0);
			$prows = $this->db->count_all_results();
			if($prows>0)
			{
				$this->db->flush_cache();
				return 0;
			}
			
			//存在【不同意】的报价项目
			$this->db->where('order_quote.u_ok',2);
			$prows = $this->db->count_all_results();
			if($prows>0)
			{
				$this->db->flush_cache();
				return 2;
			}
			
			//当不存在新报价和不存在不同意的报价时，则为 【全部同意】
			$where_on[] = array('order_quote.u_ok'=>0);
			$where_on[] = array('order_quote.u_ok'=>2);
			$this->db->where_on($where_on);
			$prows = $this->db->count_all_results();
			$this->db->flush_cache();
			if($prows<=0)
			{
				return 1;
			}
		}
		return 9;  //代表未找到报价项目
	}





/**
 * 工人处理订单步骤
 * $id 订单编号，$t步骤类型-普通或结尾步骤
 */
	function order_door_w_newstep($id=0,$uid_2=0,$note='',$t=0)
	{
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');
		$this->load->library('Cost_rate');
		$this->load->model('Records_Model');
		$this->lang->load('order', 'cn');
		
		//定义操作的超时时间，超过指定时间范围则 操作无效
		$limtDay = time()-(3600*24*7); 

		#检查订单是否存在、工人是否可以操作该订单(限制：只有第二步工人才可以操作该信息)
		$id    = get_num($id);
		$uid_2 = get_num($uid_2);
		$stepnum = $this->order_door_steps($id);
		
		if($id&&$uid_2&&$stepnum==2)
		{
			//查找指定最后操作步骤没超过7天的上门订单，如果超过了则不能操作
			$this->db->select('id,orderid,cost,uid,uid_2');
			$this->db->from('order_door');
			$this->db->where('id',$id);
			$this->db->where('uid_2',$uid_2);
			$this->db->limit(1);
			$orow = $this->db->get()->row();
			/////////////////////
			$this->db->from('order_door_step');
			$this->db->where('UNIX_TIMESTAMP(steptime) >'.$limtDay);
			$this->db->where('stepid',$id);
			$this->db->where('ok !=',1);
			$onum = $this->db->count_all_results();
			if($orow && $onum>0)
			{
				$date = dateTime();
				$cost = $orow->cost;
				$uid  = $orow->uid;
				$orderid = $orow->orderid;
				#获取业主手机号，用于短信通知
				$names2  = $this->User_Model->name($uid_2);  //工人称呼
				$mobile1 = $this->User_Model->mobile($uid);  //业主手机
				//工人链接
				$user_w_links = $this->User_Model->links($uid_2);
				//工人、业主打开订单的链接
				$order_w_url = site_url($this->data["w_url"].'orders_door/view/'.$orow->id);
				$order_e_url = site_url($this->data["e_url"].'orders_door/view/'.$orow->id);
				#<><><><>---<><><><>
				$order_2e_link = $this->lang->line('order_link');
				$order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
				$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
				#<><><><>---<><><><>
				$order_2w_link = $this->lang->line('order_link');
				$order_2w_link = str_replace('{orderid}',$orderid,$order_2w_link);
				$order_2w_link = str_replace('{order_url}',$order_w_url,$order_2w_link);
				#可以操作，设置该订单下的所有步骤为完成状态
				$this->db->where('stepid', $id);
				$this->db->update('order_door_step',array('ok' => 1)); 
				if($t==0)
				{
					#不同意退回金额,新建普通步骤
					$thisdata = array(
						'stepid' => $id ,
						'steptime' => $date ,
						'stepnote' => $note ,
						'ok' => 0 ,
						'isend' => 0
						);
					$this->db->insert('order_door_step',$thisdata); 
					#发送站内消息[通知雇主]
					$order_no_2e_msg = $this->lang->line('order_no_2e_msg');
					$order_no_2e_msg = str_replace('{user_w_links}',$user_w_links,$order_no_2e_msg);
					$order_no_2e_msg = str_replace('{order_link}',$order_2e_link,$order_no_2e_msg);
					#<><><><>---<><><><>
					$order_no_2e_sms = $this->lang->line('order_no_2e_sms');
					$order_no_2e_sms = str_replace('{user_w}',$names2,$order_no_2e_sms);
					$order_no_2e_sms = str_replace('{orderid}',$orderid,$order_no_2e_sms);
					#<><><><>发送<><><><>
					msgto(0,$uid,$order_no_2e_msg);  
					smsto($mobile1,$order_no_2e_sms);
				}
				elseif(is_numeric($cost)&&$cost>0)
				{
					#结束步骤，表示工人同意退款（故需退款给雇主）   
					/*同意退回订单费用 费用操作记录*/
					$order_ok_balance_tip = $this->lang->line('order_ok_balance_tip');
					$order_ok_balance_tip = str_replace('{user_w_links}',$user_w_links,$order_ok_balance_tip);
					$order_ok_balance_tip = str_replace('{order_link}',$order_2e_link,$order_ok_balance_tip);
					#<><><><>---<><><><>
					$order_ok_2e_msg = $this->lang->line('order_ok_2e_msg');
					$order_ok_2e_msg = str_replace('{user_w_links}',$user_w_links,$order_ok_2e_msg);
					$order_ok_2e_msg = str_replace('{order_link}',$order_2e_link,$order_ok_2e_msg);
					$order_ok_2e_msg = str_replace('{cost}',$cost,$order_ok_2e_msg);
					#<><><><>---<><><><>
					$order_ok_2e_sms = $this->lang->line('order_ok_2e_sms');
					$order_ok_2e_sms = str_replace('{user_w}',$names2,$order_ok_2e_sms);
					$order_ok_2e_sms = str_replace('{orderid}',$orderid,$order_ok_2e_sms);
					$order_ok_2e_sms = str_replace('{cost}',$cost,$order_ok_2e_sms);
	
					$this->Records_Model->balance_control($uid,$cost,$order_ok_balance_tip,"S");
				   
					#成功,则新建结束步骤
					$thisdata = array(
						'stepid' => $id ,
						'steptime' => $date ,
						'stepnote' => $note ,
						'ok' => 1 ,
						'isend' => 1
						);
					$this->db->insert('order_door_step',$thisdata); 
					
					#发送站内消息[通知雇主]
					msgto(0,$uid,$order_ok_2e_msg); 
					smsto($mobile1,$order_ok_2e_sms);
				}
		  }
		}
	}
 



	
/**
 * 业主处理订单步骤
 * $id 订单编号，$t步骤类型-普通或结尾步骤
 */
	function order_door_e_newstep($id=0,$uid=0,$note='',$t=0)
	{
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');
		$this->load->library('Cost_rate');
		$this->load->model('Records_Model');
		$this->lang->load('order', 'cn');
		
		//定义操作的超时时间，超过指定时间范围则 操作无效
		$limtDay = time()-(3600*24*7);  
		
		#检查订单是否存在、业主是否可以操作该订单(限制：只有第三步业主才可以操作该信息)
		$id = get_num($id);
		$uid= get_num($uid);
		$stepnum = $this->order_door_steps($id);
		
		if($id&&$uid&&($stepnum==1||$stepnum==3))
		{
			$this->db->select('id,orderid,cost,uid,uid_2');
			$this->db->from('order_door');
			$this->db->where('id',$id);
			$this->db->where('uid',$uid);
			$this->db->limit(1);
			$orow = $this->db->get()->row();
			/////////////////////
			$this->db->from('order_door_step');
			$this->db->where('UNIX_TIMESTAMP(steptime) >'.$limtDay);
			$this->db->where('stepid',$id);
			$this->db->where('ok =',0);
			$onum = $this->db->count_all_results();
			if($orow && $onum>0)
			{
				$date  = dateTime();
				$cost  = $orow->cost;
				$uid_2 = $orow->uid_2;
				$orderid = $orow->orderid;
				
				//获取业主称呼，用于发送消息
				$names1  = $this->User_Model->name($orow->uid); //业主称呼
				$mobile2 = $this->User_Model->mobile($uid_2);   //工人手机号
				
				//工人链接
				$user_e_links = $this->User_Model->links($uid);
				//工人、业主打开订单的链接
				$order_w_url = site_url($this->data["w_url"].'orders_door/view/'.$orow->id);
				$order_e_url = site_url($this->data["e_url"].'orders_door/view/'.$orow->id);
				#<><><><>---<><><><>
				$order_2e_link = $this->lang->line('order_link');
				$order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
				$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
				#<><><><>---<><><><>
				$order_2w_link = $this->lang->line('order_link');
				$order_2w_link = str_replace('{orderid}',$orderid,$order_2w_link);
				$order_2w_link = str_replace('{order_url}',$order_w_url,$order_2w_link);
				
				#处理费用问题
				$this->cost_rate->cost = $cost;
				$cost_this = $this->cost_rate->cost_this();  //订单费用
				$cost_ser  = $this->cost_rate->cost_ser();   //服务费
				$cose_sum  = $this->cost_rate->cost_sum();   //订单费+服务费
				$cost_less = $this->cost_rate->cost_less();  //订单费-服务费
				$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
				$cost_rate = '<span class="chenghong">'.$cost_rate.'</span>';
	
				//返回该订单的链接
				$order_2w_msg = $this->lang->line('order_2w_msg');
				$order_2w_msg = str_replace('{user_e_links}',$user_e_links,$order_2w_msg);
				$order_2w_msg = str_replace('{order_link}',$order_2w_link,$order_2w_msg);
				$order_2w_msg = str_replace('{order_tip}',$note,$order_2w_msg);
				#<><><><>---<><><><>
				$order_2w_sms = $this->lang->line('order_2w_sms');
				$order_2w_sms = str_replace('{user_e}',$names1,$order_2w_sms);
				$order_2w_sms = str_replace('{orderid}',$orderid,$order_2w_sms);
				$order_2w_sms = str_replace('{order_tip}',$note,$order_2w_sms);
				#<><><><>---<><><><>
				$order_2w_balance_tip1 = $this->lang->line('order_2w_balance_tip1');
				$order_2w_balance_tip1 = str_replace('{cost}',$cost,$order_2w_balance_tip1);
				$order_2w_balance_tip1 = str_replace('{cost_rate}',$cost_rate,$order_2w_balance_tip1);
				$order_2w_balance_tip1 = str_replace('{cost_ser}',$cost_ser,$order_2w_balance_tip1);
				#<><><><>---<><><><>
				$order_2w_balance_tip2 = $this->lang->line('order_2w_balance_tip2');
				$order_2w_balance_tip2 = str_replace('{order_link}',$order_2e_link,$order_2w_balance_tip2);
				$order_2w_balance_tip2 = str_replace('{cost}',$cost,$order_2w_balance_tip2);
				$order_2w_balance_tip2 = str_replace('{cost_rate}',$cost_rate,$order_2w_balance_tip2);
				$order_2w_balance_tip2 = str_replace('{cost_ser}',$cost_ser,$order_2w_balance_tip2);
				
				#可以操作，设置该订单下的所有步骤为完成状态
				$this->db->where('stepid', $id);
				$this->db->update('order_door_step',array('ok' => 1)); 
				if($t==0){
					#新建普通步骤
					$thisdata = array(
							'stepid' => $id ,
							'steptime' => $date ,
							'stepnote' => $note ,
							'ok' => 0 ,
							'isend' => 0
							);
					$this->db->insert('order_door_step',$thisdata); 
				   
					#发送站内消息\手机信息[通知工人]
					msgto(0,$uid_2,$order_2w_msg);
					smsto($mobile2,$order_2w_sms);
					return true;
				}
				elseif(is_numeric($cost_this)&&$cost_this>0)
				{
					#结束步骤，表示工人同意退款（故需退款给业主）
					/*将相应的订单费用打到工人帐号上*/
					$this->Records_Model->balance_control($uid_2,$cost_this,$order_2w_msg.$order_2w_balance_tip1,"S");
					$this->Records_Model->balance_control($uid_2,$cost_ser,$order_2w_balance_tip2,"S_XY");
					#成功,则新建结束步骤
					$thisdata = array(
							'stepid' => $id ,
							'steptime' => $date ,
							'stepnote' => $note ,
							'ok' => 1 ,
							'isend' => 1
							);
					$this->db->insert('order_door_step',$thisdata); 
					#发送站内消息\手机信息[通知工人]
					msgto(0,$uid_2,$order_2w_msg); 
					smsto($mobile2,$order_2w_sms);
					return true;
				}
			}
		}
	}
  

  


	
}
?>
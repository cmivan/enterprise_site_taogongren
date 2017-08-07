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
		return $this->db->query("select id from `order_project` where uid_2=".$uid)->num_rows();
	}
	
	

	
/**
 * 获取上门单的基本信息
 */	
	function order_doors($id,$uid)
	{
		return $this->db->query("select id,note,uid,uid_2 from `order_door` where id=".$id." and (uid=".$uid." or uid_2=".$uid.") LIMIT 1")->row();
	}



	
/**
 * 上门单是否已完成
 */	
	function order_door_stat($oid)
	{
		$stat_num = $this->db->query("select isend from order_door_step where stepid=".$oid." and isend=1")->num_rows();
		if($stat_num>=0){ return true; }
		return false;
	}


	
/**
 * 获取上门单处理的步骤数
 */	
	function order_door_steps($id)
	{
		$num = 0;
		if(is_num($id)){ $num = $this->db->query("select id from order_door_step where stepid=".$id)->num_rows(); }
		return $num;
	}
	
	
	
/**
 * 返回(限定用户权限)工程单详细信息
 */	
	function order_projects($id,$uid)
	{
		return $this->db->query("select id,note,uid,uid_2 from `order_project` where id=".$id." and (uid=".$uid." or uid_2=".$uid.") LIMIT 1")->row();
	}


/**
 * 判断并返回工程单的合同状态（是否双方确认同意）
 */
	function order_project_deal_stat($oid)
	{
		$deal_rs = $this->db->query("select u_ok,u_ok_2 from `order_project_deal` where o_id=".$oid." LIMIT 1")->row();
		if($deal_rs)
		{
			if($deal_rs->u_ok==1&&$deal_rs->u_ok_2==1){ return true; }
		}
		return false;
	}

 

	
/**
 * 获取工程单总有多少个阶段
 */	
	function order_project_steps($id)
	{
		$num = 0;
		if(is_num($id)){ $num = $this->db->query("select o_id from order_project_step where o_id=".$id)->num_rows(); }
		return $num;
	}	


/**
 * 返回(限定用户权限)工程单详细信息
 */	
	function order_simples($id,$uid)
	{
		return $this->db->query("select id,note,uid,uid_2,orderid from `order_simple` where id=".$id." and (uid=".$uid." or uid_2=".$uid.") LIMIT 1")->row();
	}
	

/**
 * 获取简化单当前的状态(是否完成)
 */	
	function order_simple_stat($id=0)
	{
		$id = is_num($id,0);
		$num = $this->db->query("select id from `order_simple` where (id=".$id." or o_id=".$id.") and ok<>1")->num_rows(); //ok<>1表示未付款
		if($num>0){ return false; }else{ return true; }
	}
	

/**
 * 获取工程单当前的状态(是否完成)
 */	
	function order_project_stat($id=0)
	{
		$id = is_num($id,0);
		#获取订单步骤(是否完成)
		$rowsnum = $this->db->query("select o_id from `order_project_step` where o_id=".$id." and ispay<>2")->num_rows();
		$allsnum = $this->db->query("select o_id from `order_project_step` where o_id=".$id)->num_rows();
		if($rowsnum>0||$allsnum<=0){
			return false; //订单经行中...
		}else{
			return true;  //订单已经完成
		}
	}
	
	
/**
 * 根据id返回工程单信息
 */
	function order_project_info($id,$F)
	{
		if(is_num($id)){
		   $oprs=$this->db->query("select ".$F." from `order_project` where id=$id LIMIT 1")->row();
		   if(!empty($oprs)){return $oprs->$F;}
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
		$id  = is_num($id,0);
		$uid = is_num($uid,0);
		$rowsnum = $this->db->query("select id from `evaluate` where oid=".$id." and uid=".$uid." and T='".$T."' LIMIT 1")->num_rows();
		if($rowsnum>0){ return true; }else{ return false; }
	}*/


/**
 * 返回所有报价总额$id=订单id
 * $t=0 总报价,$t=1有效报价
 */	
	function order_project_allprice($id=0,$t=0)
	{
	  $id = is_num($id);
	  if($id){
		if($t==0){
		   $pall = $this->db->query("select OQ.num,OQ.c_price,OQ.r_price from `order_project` OP left join `order_quote` OQ
						  on OP.id=OQ.o_id where OP.id=$id")->result();
		}else{
		   $pall = $this->db->query("select OQ.num,OQ.c_price,OQ.r_price from `order_project` OP left join `order_quote` OQ
						  on OP.id=OQ.o_id where OP.id=$id and OQ.u_ok=1")->result();
		}
		$aprice = 0;
		if(!empty($pall)){ foreach($pall as $prs){ $aprice = $aprice + ($prs->c_price + $prs->r_price)*$prs->num; } }
		return $aprice;
	  }
	  return 0;
	}


/**
 * 返回指定订单的所有报价信息
 */
	function order_project_quote($id=0)
	{
		return $this->db->query("select * from `order_quote` where o_id=".$id." order by id desc");
	}
	
	
	

/**
 * 工程项目报价的状态(是否已经审核)
 */	
	function prostat($ok=0,$t=0){
		if($t==0){
			if($ok==0){
				echo "<span class=red>New</span>";
			}elseif($ok==1){
				echo "<span class='green tip' title=已同意给出的报价>&radic;</span>";
			}else{
				echo "<span class='red tip' title=不同意给出的报价>&times;</span>";
			}
		}elseif($ok==1){
			echo "-";
		}else{
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
		if($T==0){
		   $sql1 = "select OP.id,OPS.ispay from `order_project` OP left
		   join `order_project_step` OPS on OP.id=OPS.o_id where OP.id=".$oid." and (OP.uid=".$logid." or OP.uid_2=".$logid.") and OPS.stepNO=".$step;
		   $row1 = $this->db->query($sql1)->row();
		   if(!empty($row1)){return $row1->ispay;}else{return 0;}
		   
		}elseif($T==1){
		   $UPstep = $step-1;
		   if($UPstep>0){
			  $sql1 = "select OP.id,OPS.ispay from `order_project` OP left join `order_project_step` OPS on OP.id=OPS.o_id where OP.id=".$oid." and (OP.uid=".$logid." or OP.uid_2=".$logid.") and OPS.stepNO=$UPstep and OPS.ispay=2";
			  $row1 = $this->db->query($sql1)->row();
			  if(!empty($row1)){return $row1->ispay;}else{return 0;}
		   }else{
			  return 2;
		   }
	
		}elseif($T==2){
		   $sql1 = "select OP.id from `order_project` OP left join `order_project_step` OPS on OP.id=OPS.o_id where OP.id=".$oid." and (OP.uid=".$logid." or OP.uid_2=".$logid.") and OPS.ispay<>2";
		   $rownum = $this->db->query($sql1)->num_rows();
		   if($rownum>0){return false;}else{return true;}
		   
		}else{
		   return false;
		}
	}



/**
 * 返回订单中是否有新的报价项目$id=订单id (当id<>1时，显示按钮)
 * u_ok: 0新报价，1同意，2不同意
 */
	function new_quote($id=0)
	{
		$id = is_num($id);
		if($id)
		{
			//存在【新】的报价项目
			$prows = $this->db->query("select OQ.id from `order_project` OP left join `order_quote` OQ
						  on OP.id=OQ.o_id where OP.id=$id and OQ.u_ok=0")->num_rows(); 
			if($prows>0){ return 0; }
			//存在【不同意】的报价项目
			$prows = $this->db->query("select OQ.id from `order_project` OP left join `order_quote` OQ
						  on OP.id=OQ.o_id where OP.id=$id and OQ.u_ok=2")->num_rows(); 
			if($prows>0){ return 2; }
			//当不存在新报价和不存在不同意的报价时，则为 【全部同意】
			$prows = $this->db->query("select OQ.id from `order_project` OP left join `order_quote` OQ
						  on OP.id=OQ.o_id where OP.id=$id and (OQ.u_ok=0 or OQ.u_ok=2)")->num_rows();
			if($prows<=0){ return 1; }
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
		#***************************
		$this->load->library('Cost_rate');
		$this->load->model('Records_Model');
		$this->lang->load('order', 'cn');
		
		//定义操作的超时时间，超过指定时间范围则 操作无效
		$limtDay = time()-(3600*24*7); 

		#检查订单是否存在、工人是否可以操作该订单(限制：只有第二步工人才可以操作该信息)
		$id    = is_num($id);
		$uid_2 = is_num($uid_2);
		$stepnum = $this->order_door_steps($id);
		
		if($id&&$uid_2&&$stepnum==2){
		//查找指定最后操作步骤没超过7天的上门订单，如果超过了则不能操作
		  $orow = $this->db->query("select id,orderid,cost,uid,uid_2 from order_door where id=$id and uid_2=$uid_2 and (select count(id) from order_door_step where UNIX_TIMESTAMP(steptime)>$limtDay and stepid=$id and ok<>1)>0 limit 1")->row();
		  if($orow){
			  
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
			$this->db->query("update order_door_step set ok=1 where stepid=$id");
			
			if($t==0){
				
		       #不同意退回金额,新建普通步骤
		       $this->db->query("insert into order_door_step (stepid,steptime,stepnote,ok,isend) value($id,'$date','$note',0,0)");
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
			   
			}elseif(is_numeric($cost)&&$cost>0){
				
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
		       $this->db->query("insert into order_door_step (stepid,steptime,stepnote,ok,isend) value($id,'$date','$note',1,1)");
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
		#***************************
		$this->load->library('Cost_rate');
		$this->load->model('Records_Model');
		$this->lang->load('order', 'cn');
		
		//定义操作的超时时间，超过指定时间范围则 操作无效
		$limtDay = time()-(3600*24*7);  
		
		#检查订单是否存在、业主是否可以操作该订单(限制：只有第三步业主才可以操作该信息)
		$id = is_num($id);
		$uid= is_num($uid);
		$stepnum = $this->order_door_steps($id);
		
		if($id&&$uid&&($stepnum==1||$stepnum==3)){
		  $orow = $this->db->query("select id,orderid,cost,uid,uid_2 from order_door where id=$id and uid=$uid and (select count(id) from order_door_step where UNIX_TIMESTAMP(steptime)>$limtDay and stepid=".$id." and ok=0)>0 limit 1")->row();
		  if($orow){
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
			$this->db->query("update order_door_step set ok=1 where stepid=".$id);	
			
			if($t==0){
			   #新建普通步骤
			   $this->db->query("insert into order_door_step (stepid,steptime,stepnote,ok,isend) value($id,'$date','$note',0,0)");
			   #发送站内消息\手机信息[通知工人]
			   msgto(0,$uid_2,$order_2w_msg);
			   smsto($mobile2,$order_2w_sms);
			   return true;
			}elseif(is_numeric($cost_this)&&$cost_this>0){
			   #结束步骤，表示工人同意退款（故需退款给业主）
			   /*将相应的订单费用打到工人帐号上*/
			   $this->Records_Model->balance_control($uid_2,$cost_this,$order_2w_msg.$order_2w_balance_tip1,"S");
			   $this->Records_Model->balance_control($uid_2,$cost_ser,$order_2w_balance_tip2,"S_XY");
			   #成功,则新建结束步骤
			   $this->db->query("insert into order_door_step (stepid,steptime,stepnote,ok,isend) value($id,'$date','$note',1,1)");
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
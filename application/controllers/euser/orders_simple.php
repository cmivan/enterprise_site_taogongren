<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_simple extends E_Controller {
	
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
		$this->load->model('Records_Model');
		$this->load->library('Cost_rate');
		$this->lang->load('order', 'cn');
		
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');

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
		if($this->data["thisnav"]["on"]==''){$this->data["thisnav"]["on"] = $this->data["thisnav"]["nav"][0]["link"];}
	}
	
	
	
	function index()
	{
		$this->data["list"] = $this->Paging->show("select * from order_simple where uid=".$this->logid." and o_id=0 order by id desc",10);
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'orders/simple',$this->data);
	}
	
	
	/*添加简化单*/
	function add($to_uid='')
	{
		//$to_uid 指订单下给哪位?
		$to_uid = is_num($to_uid,'404');
		$to_rid = is_num($this->input->get('to_rid'));

		$action = $this->input->get('action');
		if($action = 'deel.read.ok'){ $this->session->set_userdata(array('deel.read' => 'ok'));}
		$deel_read = $this->session->userdata('deel.read');
		
		/*输出到视窗*/
		if(empty($deel_read)||$deel_read!='ok'){
		   $this->load->view($this->data["c_url"].'orders/simple_deel',$this->data);
		}else{
		   $this->data["to_oid"]   = 0;
		   $this->data["to_uid"]   = $to_uid;
		   $this->data["order_no"] = order_no($this->logid,1);
		   $this->data["rid"]      = 0;
		   
		   /*表单配置*/
		   $this->data['formTO']->url = $this->data["c_urls"].'/save';
		   $this->data['formTO']->backurl = $this->data["c_urls"];
		   
		   $this->load->view($this->data["c_url"].'orders/simple_add',$this->data);
		}
		
	}
	
	
	/*添加简化单的补单信息*/
	function patch($to_oid='')
	{
		//保证id值合法
		$to_oid = is_num($to_oid,'404');
		//判断该订单id是否存在，并该用户有操作权限
		$rs = $this->db->query('select * from order_simple where uid='.$this->logid.' and id='.$to_oid.' and o_id=0 LIMIT 1')->row();
		if(empty($rs)){
		    json_echo('系统繁忙,请稍后再试!');
		}else{
			$this->data["to_oid"]   = $to_oid;
			$this->data["to_uid"]   = $rs->uid;
			$this->data["to_uid_2"]   = $rs->uid_2;
			$this->data["order_no"] = $rs->orderid;

			#判断是否已经添加评价,对方是都已经对订单评分(订单已互评,则应该返回订单)
			$isevaluate = $this->Common_Model->evaluate_order_simple($to_oid,$this->data["to_uid"]);
			$beevaluate = $this->Common_Model->evaluate_order_simple($to_oid,$this->data["to_uid_2"]);
			if($isevaluate!=false&&!empty($isevaluate)&&$beevaluate!=false&&!empty($beevaluate)){
				redirect($this->data['c_urls'].'/view/'.$to_oid, 'refresh');
				}

			$this->load->view($this->data["c_url"].'orders/simple_add',$this->data);
		}

	}
	
	
	/*保存内容*/
	function save()
	{

		#获取数据
		$logid   = $this->logid;
		$uid_2   = is_num($this->input->post("to_uid"));
		$cost    = is_num($this->input->post("cost"));
		$bx_time = noHtml($this->input->post("bx_time"));
		$place   = noHtml($this->input->post("place"));
		$note    = noHtml($this->input->post("note"));
		$orderid = noHtml($this->input->post("order_no"));
		$rid = is_num($this->input->post("rid"),0);
		$retrieval_id = 0;
		
		#通过任务信息,获取用户等信息
		if(is_num($rid)){
		   $rs = $this->db->query('select id,retrievalid,uid from `retrieval_election` where id='.$rid.' LIMIT 1')->row();
		   if(!empty($rs)){
			   #读取相应的任务信息
			   $uid_2 = $row->uid; //覆盖与上面的uid
			   $retrievalid = $row->retrievalid;
			   $rs1 = $this->db->query("select title from `retrieval` where id=".$rid." and uid=$logid LIMIT 1")->row();
			   if(!empty($rs1)){ $retrieval_title = $rs1->title; }
		   }
		}
		
		#根据$o_id获取用户id
		$o_id = is_num($this->input->post("to_oid"),0);
		if($o_id!=0){
		   $rs = $this->db->query("select * from order_simple where uid=".$logid." and id=".$o_id." and o_id=0 LIMIT 1")->row();
		   if(empty($rs)){
			   json_form_no('系统繁忙,请稍后再试!');
		   }else{
			   $uid_2   = $rs->uid_2;
			   $orderid = $rs->orderid;
			   $retrieval_id = $rs->retrieval_id; 
		   }
		}
		$retrieval_id = is_num($retrieval_id,0);

		

		#添加记录订单信息的md5值，用于防止重复下单和订单信息真实性依据
		$orderMD5 = $logid.$uid_2.$cost.$bx_time.$place.$note.$orderid.$retrieval_id.$o_id;
		$orderMD5 = md5($orderMD5);

		#查找是否已经存在该上门单
		$rs=$this->db->query("select addtime from `order_simple` where `orderMD5`='$orderMD5' and uid=$logid LIMIT 1")->row();
		if(!empty($rs)){ json_form_no('该简化单已经在 ['.$rs->addtime.'] 成功下发,请不要重复下单!'); }
		
		#验证数据
		if(is_num($uid_2)==false){ json_form_no('用户无效!'); }
		elseif($orderid==""||$orderid==NULL){ json_form_no('单号无效!'); }
		elseif((is_num($cost)==false||$cost<=0)){ json_form_no('请填写正确的费用金额!'); }
		elseif($place==""||$place==NULL){ json_form_no('请填写地址!'); }
		elseif($note==""||$note==NULL){ json_form_no('请填写订单描述!'); }
		
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
		if($balance_costs < $cose_sum){
			$backtip = "需预付工程单费".$cost_this."元，服务费".$cost_this."&times;".$cost_rate."&asymp;".$cost_ser."元!";
			$backtip.= "<br>您的余额为：".$balance_costs."元。<a href='".site_url($this->data["e_url"].'wallet/charge')."' target='_blank'>请先充值</a>!";
			$backtip = txt2json($backtip);
			json_form_no($backtip);
		}
			
		#生成数组，用于写入库
		$data['uid']     = $logid;
		$data['uid_2']   = $uid_2;
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
		$data['ok'] = 2;
		$data['ip'] = ip();
		$data['orderMD5']= $orderMD5;
		$this->db->insert('order_simple',$data);
		#获取新添加的订单id
		$insert_id = $this->db->insert_id();
		$insert_id = is_num($insert_id);
		
		if($insert_id){
			#获取最新录入的id值
			if($o_id){$insert_id = $o_id;}

			#下单成功：1.即时扣除费用到系统帐户2.后期处理在按步骤扣除费用
			$order_e_url= site_url($this->data["e_url"].'orders_simple/view/'.$insert_id);
			$order_w_url= site_url($this->data["w_url"].'orders_simple/view/'.$insert_id);
			#<><><>
			$order_2e_link = $this->lang->line('order_link');
		    $order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
			$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
			#<><><>
			$order_2w_link = $this->lang->line('order_link');
		    $order_2w_link = str_replace('{orderid}',$orderid,$order_2w_link);
			$order_2w_link = str_replace('{order_url}',$order_w_url,$order_2w_link);
			#<><><>
			$user_w_links  = $this->User_Model->links($uid_2);
			
			#提示语
			$order_simple_cost_tip = $this->lang->line('order_simple_cost_tip');
			$order_simple_cost_tip = str_replace('{user_w_links}',$user_w_links,$order_simple_cost_tip);
			$order_simple_cost_tip = str_replace('{order_link}',$order_2e_link,$order_simple_cost_tip);
			$order_simple_cost_tip = str_replace('{cost_this}',$cost_this,$order_simple_cost_tip);
			$order_simple_cost_tip = str_replace('{cost_ser}',$cost_ser,$order_simple_cost_tip);

			#<><><>初始化金额,转换成负值，保证扣除费用
		    if($cose_sum>0){$c_r_cost = -$cose_sum;}else{$c_r_cost = $cose_sum;}
			$this->Records_Model->balance_control($logid,$c_r_cost,$order_simple_cost_tip,'S');
			
		    #<><><>发送站内消息[通知工人]  0代表系统发送的
			$tip ='你好! 业主&nbsp;'.$this->User_Model->links($logid).'&nbsp;';
			$tip.='给你下了新的简化单，单号：'.$order_2w_link.' <br>';
			$tip.='费用：<span class=chenghong>'.$cost_this.'元</span>。';
			msgto(0,$uid_2,$tip);

		    #<><><>获取业主信息 发送短信消息[通知工人]
			$names1  = $this->User_Model->name($logid); 
			$mobile1 = $this->User_Model->mobile($logid);
			$mobile2 = $this->User_Model->mobile($uid_2);
			if(is_num($mobile1)&&is_num($mobile2))
			{
				$tip = "业主".$names1."(".$mobile1.") 给你下了新的上门单；地点：".$place."，描述：".$note;
				$tip.= "，费用：".$cost_this."元。详情请登录淘工人网!";
				smsto($mobile2,$tip,1); //最后的参数1表示不需要返回倒计时
			}
			
		    #操作成功后,页面跳转
		    if(is_num($o_id)==false){
				//新订单
				$backtip = "成功下简化单，相应的订单费（".$cost_this."元）及服务费（".$cost_ser."元），已支付到平台并短信通知工人!";
			}else{
				//补单
				$backtip = "成功添加补单，相应的订单费（".$cost_this."元）及服务费（".$cost_ser."元），已支付到平台并短信通知工人!";
			}
			
			#下单<>设置该工人为任务选中人
			if(is_num($retrieval_id)&&is_num($o_id)){
			   $this->db->query("update retrieval_election set ok=1 where uid=$logid and retrievalid=$retrieval_id");
			}
			json_form_yes($backtip);
		}else{
			json_form_no('订单添加失败!');
		}
		
	}
	
	
	
	/*显示订单详情*/
	function view($id=0)
	{

		$id = is_num($id,'404');
		$logid = $this->logid;
		
		//<><><>操作订单步骤信息
		$action = $this->input->get('action');
		$v_id   = is_num($this->input->get('v_id'));
		if($action!=''&&$v_id){
			/* 获取该订单的基本信息 判断当前步骤是否已经打款，如果没打款 则允许操作*/
			switch($action)
			{
				case 'ok':
				   $thisok_sql = " and ok=2 and refund_ok=0";break;
				case 'ok_order':
				   $thisok_sql = " and ok=0 and refund_ok=0";break;
				case 'feed_yes':
				case 'feed_not':
				   $thisok_sql = " and ok=1 and refund_ok=3";break;
			}
			
			###操作处理
			if(!empty($thisok_sql)&&$thisok_sql!='')
			{
				# 判断该步骤是否存在,否符合要求操作要求
				$row=$this->db->query("select * from `order_simple` where uid=".$logid." and id=$v_id".$thisok_sql)->row();
				if($row){
					# 返回该订单的基本信息
					$note     = $row->note;
					$cost_this= $row->cost;
					$cost_ser = $row->cost_ser;
					$uid      = $row->uid;
					$uid_2    = $row->uid_2;
					$place    = $row->place;
					$note     = $row->note;
					$orderid  = $row->orderid;
					
					#下单成功：1.即时扣除费用到系统帐户2.后期处理在按步骤扣除费用
					$order_e_url= site_url($this->data["e_url"].'orders_simple/view/'.$id);
					$order_w_url= site_url($this->data["w_url"].'orders_simple/view/'.$id);
					#<><><>
					$order_2e_link = $this->lang->line('order_link');
					$order_2e_link = str_replace('{orderid}',$orderid,$order_2e_link);
					$order_2e_link = str_replace('{order_url}',$order_e_url,$order_2e_link);
					#<><><>
					$order_2w_link = $this->lang->line('order_link');
					$order_2w_link = str_replace('{orderid}',$orderid,$order_2w_link);
					$order_2w_link = str_replace('{order_url}',$order_w_url,$order_2w_link);
					#<><><>
					$user_e_links  = $this->User_Model->links($uid);
					$user_w_links  = $this->User_Model->links($uid_2);
	
	
					switch($action)
					{
						/*业主申请验收*/
						case 'ok':
							#业主申请付款
							$monery = is_num($this->input->post('monery'));
							#获取当前订单的金额,保证提交的验收金额不超出范围
							if($monery==false||$monery<0){
								$backinfo = "申请支付失败,填写的金额数有误!";
							}elseif($monery>$cost_this){
								$backinfo = "申请支付失败,申请支付的费用高于订单预算费用!";
							}else{
								# 给工人发送付款请求,refund_ok=1 表示“已提交付款申请”
								$this->db->query("update `order_simple` set refund=$monery,refund_ok=1,updatetime='".dateTime()."' where uid=$logid and id=$v_id");
								$backinfo = "已成功提交验收申请（$monery 元）!";
							 
								$names1  = $this->User_Model->name($logid); 
								$mobile1 = $this->User_Model->mobile($logid);
								$mobile2 = $this->User_Model->mobile($uid_2);
								
								#<><><>发送站内消息[通知工人]  0代表系统发送的
								$tip = "手机 $mobile1 的业主".$user_e_links."，申请验收订单: ".$order_2w_link."，";
								$tip.= "描述：".$note."，验收费用为：".$monery."元,请查看并确认！";
								msgto(0,$uid_2,$tip);
								
								#<><><>获取业主信息 发送短信消息[通知工人]
								if(is_num($mobile1)&&is_num($mobile2))
								{
									$tip = "手机 $mobile1 的业主$names1 ，申请验收订单:".$orderid."，";
									$tip.= "描述：".$note."，验收费用为：".$monery."元,请查看并确认！【淘工人网】";
									smsto($mobile2,$tip,1); //最后的参数1表示不需要返回倒计时
								}
							}
							if($backinfo!=''){ json_echo('<script>alert("'.$backinfo.'");window.location.href="?";</script>'); }
						break;
						
						/*工人补充订单信息的情况下,业主确认订单信息,并将相应的费用支付到平台上*/
						case 'ok_order':
							#提示语
							$order_simple_cost_tip = $this->lang->line('order_simple_cost_tip');
							$order_simple_cost_tip = str_replace('{user_w_links}',$user_w_links,$order_simple_cost_tip);
							$order_simple_cost_tip = str_replace('{order_link}',$order_2e_link,$order_simple_cost_tip);
							$order_simple_cost_tip = str_replace('{cost_this}',$cost_this,$order_simple_cost_tip);
							$order_simple_cost_tip = str_replace('{cost_ser}',$cost_ser,$order_simple_cost_tip);
							
						 $this->db->trans_start();
							#设置当前订单状态为 ok=2，表示已经支付到平台,扣费成功，则将订单设置 ok=2
							$this->db->query("update `order_simple` set ok=2 where uid=$logid and id=$v_id".$thisok_sql." LIMIT 1");
							#<><><>初始化金额,转换成负值，保证扣除费用
							$cose_sum = $cost_this+$cost_ser;
							if($cose_sum>0){$c_r_cost = -$cose_sum;}else{$c_r_cost = $cose_sum;}
							$this->Records_Model->balance_control($logid,$c_r_cost,$order_simple_cost_tip,'S');
							#<><><>发送站内消息[通知工人]  0代表系统发送的
							$tip ='你好! 业主&nbsp;'.$this->User_Model->links($logid).'&nbsp;';
							$tip.='确定了简化单信息，订单编号：'.$order_2w_link.' <br>';
							$tip.='费用：<span class=chenghong>'.$cost_this.'元</span>。';
							msgto(0,$uid_2,$tip);
						 $this->db->trans_complete();
						 
							#<><><>获取业主信息 发送短信消息[通知工人]
							$names1  = $this->User_Model->name($logid); 
							$mobile1 = $this->User_Model->mobile($logid);
							$mobile2 = $this->User_Model->mobile($uid_2);
							if(is_num($mobile1)&&is_num($mobile2))
							{
								$tip = "业主".$names1."(".$mobile1.") 确定了订单信息；工作地点：".$place."，描述：".$note;
								$tip.= "，费用：".$cost_this."元。详情请登录淘工人网!";
								smsto($mobile2,$tip,1); //最后的参数1表示不需要返回倒计时
							}
						break;
						
						/*提交申诉*/
						case 'feed_yes':
							$this->db->query("update `order_simple`
											 set refund_ok=4,updatetime='".dateTime()."' where uid=$logid and id=$v_id and ok=1");
							sys_msg(0,$uid_2,"你好!业主 ".$user_e_links." 已经提交订单:".$order_2w_link."的验收申诉!");
							# 手机提示
							$names1  = $this->User_Model->name($logid); 
							$mobile1 = $this->User_Model->mobile($logid);
							$mobile2 = $this->User_Model->mobile($uid_2);
							if(is_num($mobile1)&&is_num($mobile2))
							{
								$tip ="业主".$names1."(".$mobile1.") 已提交了订单: ".$order_2w_link." 的验收申诉，详情请登录淘工人网！";
								smsto($mobile2,$tip,1); //最后的参数1表示不需要返回倒计时
							}
						break;
						
						/*不提交申诉 refund_ok=5 不追究*/
						case 'feed_not':
						    $this->db->query("update `order_simple`
											 set refund_ok=5,updatetime='".dateTime()."' where uid=$logid and id=$v_id and ok=1");
							# 发送通知
							sys_msg(0,$uid_2,"业主 ".$user_e_links."已取消申请退回订单编号: ".$order_2w_link." 的费用!");
						break;
					}
				}
			}
		}
		

	
		
		//<><><>显示数据
	    $this->data["view"] = $this->db->query("select * from order_simple where uid=".$this->logid." and id=".$id." and o_id=0 order by id desc")->row();
		$this->data["view_step"] = $this->db->query("select * from order_simple where uid=".$this->logid." and o_id<>0 and o_id=".$id." order by id desc")->result();
		//输出到视窗
		$this->load->view($this->data["c_url"].'orders/simple_view',$this->data);
	}





	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
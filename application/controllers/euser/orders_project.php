<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_project extends E_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	public $id;    //订单id

	function __construct()
	{
		parent::__construct();

		/*初始化加载application/core/MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Paging');
		$this->load->model('Orders_Model');
		
		$this->load->helper('orders');
		$this->load->model('Common_Model');

		//初始化页面导航,当前导航设置
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
	
	
	/*<><><>订单列表页<><><>*/
	function index()
	{
	    $this->data["list"] = $this->Paging->show("select * from `order_project` where uid=".$this->logid." order by id desc",10);
		/*输出到视窗*/
		$this->load->view_euser('orders/project',$this->data);
	}
	
	
	/*<><><>订单详细页<><><>*/
	function view($id=0)
	{
		$id = is_num($id,'404');
		$this->id = $id;
		$logid = $this->logid;
		$this->lang->load('order', 'cn');
		
		//<><><> 获取用户操作信息 <><><>
		$action = $this->input->get('action');
		switch($action){
			#同意报价信息
			case 'agree_price': $this->agree_price(); break;
			#开始阶段
			case 'step_start': $this->step_start(); break; 
			#验收阶段
			case 'step_ok': $this->step_ok(); break; 
		}


		//读取订单基本信息
		$this->order_project_view();

		//报价状态
		$this->data['new_quote'] = $this->Orders_Model->new_quote($id);
		//总的标价
		$this->data['allprice']  = $this->Orders_Model->order_project_allprice($id);
		//有效的标价
		$this->data['allprice1'] = $this->Orders_Model->order_project_allprice($id,1);
		
		//获取用户报价信息
		$price_q = $this->Orders_Model->order_project_quote($id);
	    $this->data['price_view'] = $price_q->result();
		$this->data['price_num']  = $price_q->num_rows(); //获取数据库总数量

		//<><><> 获取合同信息
		$this->data['deal_view'] = $this->db->query("select * from `order_project_deal` where o_id=".$id." LIMIT 1")->row();
		
		#判断是否已经(添加并双方确认)了合同信息
		$this->data['dealok'] = $this->Orders_Model->order_project_deal_stat($id);
		
		//根据合同步骤状态获取当前合同的状态(是否完成)
		$this->data['ostat'] = $this->Orders_Model->order_project_stat($id);

		//订单评分状态
		$isevaluate = $this->Common_Model->isevaluate_order_project($id,$this->logid);
		
		//返回订单状态按钮
		$this->data['order_stat_btu'] = order_stat($this->data['ostat'],$isevaluate,$id);	

		//获取该合同的阶段信息
		$this->data['deal_steps'] = $this->db->query("select * from `order_project_step` where o_id=".$id." order by stepNO asc")->result();

		/*输出到视窗*/
		$this->load->view_euser('orders/project_view',$this->data);
	}
	
	
	
	/*<><><>订单添加页<><><>*/
	function add($to_uid='')
	{
		//$to_uid 指订单下给哪位?
		$to_uid = is_num($to_uid,'404');
		
		$this->data["to_uid"]   = $to_uid;
		$this->data["order_no"] = order_no($this->logid,1);
		$this->data["rid"]      = '0';
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view_euser('orders/project_add',$this->data);
	}


	/*<><><>订单保存页<><><>*/
	function save()
	{
		$this->load->model('Records_Model');
		$this->load->library('Cost_rate');
		$this->lang->load('order', 'cn');
		
		#获取数据
		$logid   = $this->logid;
		$uid_2   = is_num($this->input->post("to_uid"));
		$note    = noHtml($this->input->post("note"));
		$orderid = noHtml($this->input->post("order_no"));
		$retrieval_id = is_num($this->input->post("rid"),0);
		#添加记录订单信息的md5值，用于防止重复下单和订单信息真实性依据
		$orderMD5 = $logid.$uid_2.$note.$orderid.$retrieval_id;
		$orderMD5 = md5($orderMD5);
		
		#查找是否已经存在该上门单
		$rs = $this->db->query("select addtime from `order_project` where `orderMD5`='$orderMD5' and uid=$logid LIMIT 1")->row();
		if(!empty($rs)){ json_form_no('该工程单已经在 ['.$rs->addtime.'] 成功下发,请不要重复下单!'); }

		#验证数据
		if(is_num($uid_2)==false){ json_form_no('用户无效!'); }
		elseif($orderid==""||$orderid==NULL){ json_form_no('单号无效!'); }
		elseif($note==""||$note==NULL){ json_form_no('请填写订单描述!'); }
		
		#生成数组，用于写入库
		$data['uid']     = $logid;
		$data['uid_2']   = $uid_2;
		$data['note']    = $note;
		$data['orderid'] = $orderid;
		$data['retrieval_id'] = $retrieval_id;
		$data['addtime'] = dateTime();
		$data['ip'] = ip();
		$data['orderMD5']= $orderMD5;
		$this->db->insert('order_project',$data);
		#获取新添加的订单id
		$insert_id = $this->db->insert_id();
		$insert_id = is_num($insert_id);

		if($insert_id){
			
			#设置该工人为任务选中人
			if($retrieval_id!=0&&$uid_2){
				$this->db->query("update retrieval_election set ok=1 where uid=$uid_2 and retrievalid=$retrieval_id");
			}

			#***** 加载发送辅助函数 ******
			$this->load->helper('send');
			#***************************

		    #<><><>发送站内消息[通知工人] 0代表系统发送的
			$tip = "你好! 业主&nbsp;".$this->User_Model->links($logid)."&nbsp;";
			$tip.= '给你下了新的工程订单，单号：<a href="'.site_url($this->data["w_url"].'orders_project/view/'.$insert_id).'" target="_blank">'.$orderid.'</a>。';
			msgto(0,$uid_2,$tip);
			
		    #<><><> 获取业主信息 发送短信消息[通知工人]
			$names1  = $this->User_Model->name($logid); 
			$mobile1 = $this->User_Model->mobile($logid);
			$mobile2 = $this->User_Model->mobile($uid_2);
			if(is_num($mobile1)&&is_num($mobile2))
			{
				$tip = "业主".$names1."(".$mobile1.") 给你下了新的工程订单，单号：".$orderid."，详情请登录淘工人网!";
				smsto($mobile2,$tip);
			}
			json_form_yes('成功下单!');
		}else{
			json_form_no('订单添加失败!');
		}
	}
	
	
	//添加合同
	function deal_edit($id=0)
	{
		$this->id = is_num($id,'404');
		$logid = $this->logid;
		
	    $this->data['title']  = '';
	    $this->data['yaoqiu'] = '';
	    $this->data['other']  = '';
	    $this->data['total_money'] = '';
	    $this->data['cy_money']  = '';
	    $this->data['money']     = '';
	    $this->data['days']      = '';
		$this->data['content']   = '';
	    $this->data['countItem'] = 0;
	    $this->data['editstr']   = '';
		$this->data['xyok']      = '';
		
		/*保证用户有操作订单权限*/
		if($this->order_project_view(1)==false){ json_form_no('该订单不存在或已经删除!'); };
		/*获取订单详细信息*/
		$this->order_project_view();
		
		//<><><> 总的标价
		$allprice  = $this->Orders_Model->order_project_allprice($id);
		
		if($allprice<=0){
			/*判断是否已经给出报价*/
			echo '<script>alert("未给出报价,不允许编辑合同!");window.close();</script>';exit;
		}elseif($this->order_deal_allok()==false){
			/*判断是否已经同意全部报价信息*/
			echo '<script>alert("存在未通过审核的项目报价,不允许编辑合同!");window.close();</script>';exit;
		}elseif($this->order_deal_allow2edit()==false){
			/*判断是否有编辑权限*/
			//echo '{"//cmd":"n","info":"合同已经生效,不允许再次编辑!"}';exit;
			echo '<script>alert("合同已经生效,不允许再次编辑!");window.close();</script>';exit;
		}

		//<><><> 读取订合同信息 <><><>
		$this->order_project_deal_view();
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/order_project_deal_save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/view/'.$id;
		/*输出到视窗*/
		$this->load->view_euser('orders/project_deal',$this->data);
	}
	
	
	
	function deal($id=0)
	{
		$this->id = is_num($id,'404');
		//<><><> 防止非法查看 <><><>
		$this->order_deal_allok();
		//<><><> 读取订单基本信息 <><><>
		$this->order_project_view();
		//<><><> 读取订合同信息 <><><>
		$this->order_project_deal_view();
		/*输出到视窗*/
		$this->load->view_euser('orders/project_deal_view',$this->data);
	}
	
	
	
	
	/*#提交合同数据时响应保存数据*/
	function order_project_deal_save()
	{
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');
		
		$id = is_num($this->input->post('edit_id'));
		if($id==false){ json_form_no('系统繁忙,请稍候再试!'); }
		
		$this->id = $id;
		
		/*保证用户有操作订单权限*/
		if($this->order_project_view(1)==false){ json_form_no('该订单不存在或已经删除!'); };
		/*获取订单详细信息*/
		$this->order_project_view();
		
		/*判断是否已经同意全部报价信息*/
		if($this->order_deal_allok()==false){ json_form_no('存在未通过审核的项目报价,不允许编辑合同!'); }
		/*判断是否有编辑权限*/
		if($this->order_deal_allow2edit()==false){ json_form_no('合同已经生效,不允许再次编辑!'); }
		
		$uid    = $this->data['uid'];
		$uid_2  = $this->data['uid_2'];
		$orderid= $this->data['orderid'];
		
		$title  = noHtml($this->input->post('title'));
		$yaoqiu = noHtml($this->input->post('yaoqiu'));
		$other  = noHtml($this->input->post('other'));
		$total_money = is_num($this->input->post('total_money'));
		$cy_money    = is_num($this->input->post('cy_money'));
		
		$backtip = '';
		//<><><><><><><><><><><><><><><><><><><><><><><><><>
		if($title=='') { $backtip = $backtip."请填写项目名称!<br>";}
		if($yaoqiu==''){ $backtip = $backtip."请填写项目要求!<br>";}

		if($total_money==false||$total_money!=$this->input->post('total_money')||$total_money<0)
		{$backtip = $backtip."总金额应为非零整数!<br>";}
		if($cy_money!=''){
		   if($cy_money==false||$cy_money!=$this->input->post('cy_money')||$cy_money<0)
		   {$backtip = $backtip."诚意押金应为非零整数!";}
		}else{ $cy_money=0; }

	    #阶段参数
	    $money   = $this->input->post('money');
	    $days    = $this->input->post('days');
	    $content = $this->input->post('content');
	    $countItem = count($money);
	    if($countItem<1){$backtip = '至少要有一个阶段!';}

	    $sqls = '';
	    $moneyAll = 0;
		for($i=0;$i<$countItem;$i++){
			#判断数据是否符合
			$t_money = is_num($money[$i]);
			$t_days  = is_num($days[$i]);
			$t_content = noHtml($content[$i]);
			if($t_money==false||$t_money!=$money[$i]||$t_money<=0){$backtip=$backtip."第".($i+1)."阶段[ 预付金额 ]需要填写正整数!<br>";}
			if($t_days==false||$t_days!=$days[$i]||$t_days<=0){$backtip=$backtip."第".($i+1)."阶段[ 完成天数 ]需要填写正整数!<br>";}
			if($t_content==''){$backtip=$backtip."第".($i+1)."阶段[ 具体工作内容 ]不能为空!<br>"; }
			#数据完全符合则生成相应的阶段sql
			if($t_money&&$t_days&&$t_content!=""){
			   $moneyAll=$moneyAll+$t_money;
			   if($sqls==""){ $sqls="($id,$t_money,$t_days,'$t_content',$i+1)"; }
			   else{ $sqls=$sqls.",($id,$t_money,$t_days,'$t_content',$i+1)"; } 
			}
		}


		#没有错误提示的情况下写入数据
		if($moneyAll!=0&&$moneyAll!=$total_money){
			#保证阶段金额和总金额一致
			$backtip = '合同的阶段总预付金额和合同总金额不一致，请核对!';
		}elseif($backtip==""&&$sqls!=""){
			
			$to_w_url = site_url($this->data['c_urls'].'/deal/'.$id);
			$to_w_url = str_replace('euser','wuser',$to_w_url);								 
			
			#判断是否已经录入合同，已录入则直接更新
			$rsnum = $this->db->query('select id from order_project_deal where o_id='.$id)->num_rows();
			if($rsnum>0){
				#更新合同数据,如果业主已经确认了合同则重新设置为未确认状态
				$opd = $this->db->query("update order_project_deal set `title`='$title',`yaoqiu`='$yaoqiu',`other`='$other',`feed`='',`cy_money`=$cy_money,`total_money`=$total_money,`u_ok`=1,`u_ok_2`=0 where o_id=".$id);
			    if($opd){
				  #发送站内消息[通知工人]  0代表系统发送的
				  $nr = '你好!业主 '.$this->User_Model->links($uid).' 更新了工程订单:';
				  $nr.= '<a target="_blank" href="'.$to_w_url.'">'.$orderid.'</a>';
				  $nr.= '的合同信息。';
				  msgto(0,$uid_2,$nr);
				}
			}else{
				#创建合同数据
				$opd = $this->db->query("insert into order_project_deal(`o_id`,`title`,`yaoqiu`,`other`,`cy_money`,`total_money`,`addtime`,`u_ok`) values($id,'".$title."','".$yaoqiu."','".$other."',$cy_money,$total_money,'".dateTime()."',1)");  
			    if($opd){
				  #发送站内消息[通知工人]  0代表系统发送的
				  $nr = '你好!业主 '.$this->User_Model->links($uid).' 创建了工程订单:';
				  $nr.= '<a target="_blank" href="'.$to_w_url.'">'.$orderid.'</a>';
				  $nr.= '的合同信息。';
				  msgto(0,$uid_2,$nr);
			    }
			}
			//合同完成后
			if($opd){
				#删除原有的阶段,重新写入
				$this->db->query("delete from order_project_step where o_id=$id");
				#写入阶段数据
				$sqls = "insert into order_project_step (`o_id`,`money`,`days`,`content`,`stepNO`) values".$sqls; 
				$this->db->query($sqls);
				json_form_yes('成功生成合同!');
			}
		}
		
		json_form_no(txt2json($backtip));
	}
	
	
	
	

	/*不同意报价并回复意见*/
	function price_not_ok_msg()
	{
		$logid = $this->logid;
		/*********************************/
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$id = is_num($this->input->post('id'));
			$note = noHtml($this->input->post('note'));
			if($id==false){ json_form_no(txt2json($this->lang->line('system_tip_busy'))); }
			if($note==''){ json_form_no('请填写不同意报价的理由!'); }
		    #保证用户有权限操作
		    $rows = $this->db->query("select OP.id,OP.uid_2,OP.orderid from `order_project` OP left join `order_quote` OQ on OP.id=OQ.o_id where OP.id=$id and OP.uid=".$logid." and OQ.u_ok<>1");
		    if($rows->num_rows()>0){
				$rs = $rows->row();
				$uid_2   = is_num($rs->uid_2);
				$orderid = $rs->orderid;
				if($uid_2){
					#有操作权限则写入回复
					$this->db->query("update `order_project` set `feed`='$note' where id=$id and uid=".$logid);
					#更新订单状态
					$this->db->query("update `order_quote` set u_ok=2 where u_ok<>1 and o_id=$id");
					#发送站内消息[通知工人] 0代表系统发送的
					$nr = "你好! 业主&nbsp;".$this->User_Model->links($logid)."&nbsp;";
					$nr.= '不同意工程单号：<a href="'.site_url($this->data["w_url"].'orders_project/view/'.$id).'" target="_blank">'.$orderid.'</a> 的报价!请查看订单详情!';
					
					#***** 加载发送辅助函数 ******
					$this->load->helper('send');
					msgto(0,$uid_2,$nr);
					json_form_yes('意见发送成功!');
				}
		    }
			json_form_yes(txt2json($this->lang->line('system_tip_busy'))); 
		}
		
		/*********************************/
		$this->data['id'] = is_num($this->input->get('id'),'404');
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/price_not_ok_msg';
		$this->data['formTO']->backurl = '';
		
		/*输出到视窗*/
		$this->load->view_euser('orders/price_not_ok_msg',$this->data);
	}
	
	
	

	
	/*判断是否已经同意所有报价(为完全同意报价前不允许创建或编辑合同)*/
	function order_deal_allok()
	{
		$id = is_num($this->id);
		$allok = false;
		if($id){
			$rsnum = $this->db->query("select id from `order_quote` where o_id=$id and u_ok<>1")->num_rows();
			if($rsnum<=0){ $allok = true; }
		}
		return $allok;
	}
	
	
	/*判断是否允许编辑(双方都已经同意合同后则不允许编辑)*/
	function order_deal_allow2edit()
	{
		$id = is_num($this->id);
		$allow2edit = false;
		if($id){
			$rsnum = $this->db->query("select id from `order_project_deal` where o_id=$id and u_ok=1 and u_ok_2=1")->num_rows();
			if($rsnum<=0){ $allow2edit = true; }
			}
		return $allow2edit;
	}

	
	/*订单基本信息*/
	function order_project_view($T=0)
	{
		$id = is_num($this->id,0);
		$view = $this->db->query("select * from order_project where uid=".$this->logid." and id=".$id." order by id desc")->row();
		if(!empty($view)){
			$this->data["id"]    = $id;
			$this->data["view"]  = $view;
			$this->data['note']  = $view->note;
			$this->data['uid']   = $view->uid;
			$this->data['uid_2'] = $view->uid_2;
			$this->data['yaoqiu_note'] = $view->note;
			$this->data['addtime']     = $view->addtime;
			$this->data["orderid"]     = $view->orderid;
			$this->data['retrieval_id']= $view->retrieval_id;  //相应的任务id
			$this->data['user_links']  = $this->User_Model->links($view->uid_2);
			if($T==1){return true;}
		}else{
			if($T==1){return false;}else{echo '系统繁忙!';exit;}
		}
	}
	
	
	/*订单合同基本信息*/
	function order_project_deal_view()
	{
		$id = is_num($this->id);
		if($id){
			$this->data['editstr'] = '起草';
			$view = $this->db->query('select * from `order_project_deal` where o_id='.$this->id.' LIMIT 1')->row();
			if(!empty($view)){
				#获取合同基本数据
				$this->data['title']   = $view->title;
				$this->data['yaoqiu']  = $view->yaoqiu;
				$this->data['other']   = $view->other;
				$this->data['total_money'] = $view->total_money;
				$this->data['cy_money'] = $view->cy_money;
				#获取合同阶段数据(数组形式)
				$moneyArr  =array();
				$daysArr   =array();
				$contentArr=array();
				$OPS = $this->db->query("select * from `order_project_step` where o_id=$id order by stepNO asc")->result();
				if(!empty($OPS)){
				  foreach($OPS as $opsRS){
					$moneyArr[]   = $opsRS->money;
					$daysArr[]    = $opsRS->days;
					$contentArr[] = $opsRS->content;
				  }}
				$this->data['money']     = $moneyArr;
				$this->data['days']      = $daysArr;
				$this->data['content']   = $contentArr;
				$this->data['countItem'] = count($moneyArr);
				$this->data['editstr']   = '编辑';
			}
		}
	}
	
	
	
	
	
	
	
	
/**
  ******************************************************************
  * <> 工程订单操作 <> <> <> <> <> <> <> <> <> <> <> <> <> <> <> <> <
  ******************************************************************
  */
	
	
	/*同意工程订单报价*/
	function agree_price()
	{
		$id = is_num($this->id);
		if($id){
		   #用户同意所有报价项目,保证用户有权限操作
		   $rows = $this->db->query("select OP.id,OP.uid_2,OP.orderid from `order_project` OP left join `order_quote` OQ on OP.id=OQ.o_id where OP.id=$id and OP.uid=".$this->logid." and OQ.u_ok<>1");
		   if($rows->num_rows()>0){
			   $rs = $rows->row();
			   #获取用户id
			   $orderid = $rs->orderid;
			   $uid = $this->logid;
			   $uid_2 = $rs->uid_2;
			   $mobile_2 = $this->User_Model->mobile($uid_2);
			   #站内通知-工人
			   $this->load->helper('send');
			   msgto(0,$uid_2,"业主 ".$this->User_Model->links($uid)." 同意了你的工程单 ".$orderid." 的报价!");
			   smsto($mobile_2,"业主 ".$this->User_Model->name($uid)." 同意了你的工程单 ".$orderid." 的报价!",'1');
			   #更新订单状态
			   $this->db->query("update `order_quote` set u_ok=1 where u_ok<>1 and o_id=$id");
			   redirect($this->data['c_urls'].'/view/'.$id, 'refresh');
		   }
		}
	}
	
	
	/**
	  * 用户确认合同(需要限定权限)
	  */
	function deal_ok()
	{
		$id = is_num($this->id);
		if($id){
		   $rows=$this->db->query("select id,orderid from `order_project` where id=".$id." and uid=".$this->logid);
		   if($rows->num_rows()>0){
			   $rs = $rows->row();
			   #获取用户id
			   $uid_2   =getOPinfo($id,"uid_2");
			   $mobile_2=g_user($uid_2,"mobile");
			   $orderid =getOPinfo($id,"orderid");
	
			   #站内通知-工人
			   sys_msg(0,$uid_2,"业主 ".g_url($uid)." 更新了订单：".$orderid." 的合同内容!");
			   #手机通知工人
			   smsto($mobile_2,"业主 ".g_user($uid,"name")." 更新了订单：".$orderid." 的合同内容，请查看!");
	
			   $this->db->query("update `order_project_deal` set u_ok=1 where u_ok<>1 and o_id=$id");
			   #返回页面
			   header("Location:".reUrl("action=&id="));exit;   
		   }
		}
	}
	
	
	
	/**
	  * 用户删除合同(需要限定权限)
	  */
	function deal_del()
	{
		$id = is_num($this->id);
		if($id){
		  #用户删除合同(需要限定权限)
		  $rsnum = $this->db->query("select OP.id from `order_project` OP left join `order_project_deal` OPD on OP.id=OPD.o_id where OP.id=$id and OP.uid=".$this->logid." and (OPD.u_ok<>1 or OPD.u_ok_2<>1)")->num_rows();
		  if($rsnum>0){
			 $this->db->query("delete from `order_project_deal` where o_id=$id");
			 $this->db->query("delete from `order_project_step` where o_id=$id");
			 #返回页面
			 header("Location:".reUrl("action=&id="));exit; 
		  }
		}
	}
	
	
	
	/**
	  * 开始阶段,验证上一步是否已经完成(需要限定权限)
	  */
	function step_start()
	{
		#***** 费用模块 ******
		$this->load->model('Records_Model');
		#***** 费用处理 ******
		$this->load->library('Cost_rate');
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');
		
		$id   = is_num($this->id);
		$step = is_num($this->input->get('step'));
		if($id&&$step)
		{
			$pss_1 = $this->Orders_Model->project_step_stat($this->logid,$id,$step,1);
			$pss_2 = $this->Orders_Model->project_step_stat($this->logid,$id,$step,0);
			
			if($pss_1==2&&$pss_2==0){
				#支付每个阶段的费用才可以开始
				$pssRS = $this->db->query("select OPD.cy_money,OPS.money from `order_project_deal` OPD left join `order_project_step` OPS on OPD.o_id=OPS.o_id where OPD.o_id=$id and OPS.stepNO=$step and OPS.ispay=0")->row();
				if(!empty($pssRS)){
					#获取用户id
					$uid      = $this->logid;
					$uid_2    = $this->Orders_Model->order_project_info($id,"uid_2");
					$orderid  = $this->Orders_Model->order_project_info($id,"orderid");
					$mobile_2 = $this->User_Model->mobile($uid_2,"mobile");
					#阶段费用
					$thismoney   = $pssRS->money;   //当前阶段费用
					$thisCYmoney = $pssRS->cy_money;  //质保押金
					
					#计算并处理费用,@@@实例化费用处理类
					$this->cost_rate->cost = $thismoney;
					$cost_this = $this->cost_rate->cost_this();  //订单费用
					$cost_ser  = $this->cost_rate->cost_ser();   //服务费
					$cose_sum  = $this->cost_rate->cost_sum();   //订单费+服务费
					$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
					$cost_rate = '<span class="chenghong">'.$cost_rate.'</span>';
					
					//用于业主页面
					$orderlink_1 = '<a target="_blank" href="'.site_url($this->data['c_urls'].'/view/'.$id).'">'.$orderid.'</a>';
					//用于工人页面
					$orderlink_2 = str_replace($this->data['e_url'],$this->data['w_url'],$orderlink_1);
					
					if($this->Records_Model->balance_cost($uid,"S")>$cost_this){
						#在第一阶段暂扣除诚意金
						if($thisCYmoney>0&&$step==1){ $this->Records_Model->balance_control($uid,(-$thisCYmoney),"支付订单：".$orderlink_1." 的诚意金到平台上","S");}
						#扣除阶段费用(当前订单费用+服务费)
						$this->Records_Model->balance_control($uid,(-$cose_sum),"将订单：".$orderlink_1." 第".colorT($step)."阶段费用".colorT($cose_sum)."元预付到平台上，其中服务费".colorT($cost_ser)."元!","S");
						
						#发送通知
						$msg = "业主 ".$this->User_Model->links($uid)." 确认开始订单：".$orderlink_2." 的第".colorT($step)."阶段,并将相应的费用".colorT($cost_this)."元 预付到平台上";
						order_sendmsg($uid_2,$msg);

						#开始阶段
						$this->db->query("update `order_project_step` set `ispay`=1,`startdate`='".dateTime()."' where ispay=0 and stepNO=$step and o_id=$id");
						
						#返回页面
						header("Location:".reUrl("action=null&id=null"));exit; 
						  
					}else{
						$backinfo="你的现金帐户余额不足，<a href='user-employer-echarge.php' target=_blank>请先充值</a>!";	 
					} 
				}
			}else{
				#不允许开始阶段
				$backinfo="该阶段不允许开始!请查看上一阶段是否已经验收!";
			}
		}
	}
	
	
	
	/**
	  * 验收阶段(需要限定权限)
	  */
	function step_ok()
	{
		#***** 费用模块 ******
		$this->load->model('Records_Model');
		#***** 费用处理 ******
		$this->load->library('Cost_rate');
		#***** 加载发送辅助函数 ******
		$this->load->helper('send');
		
		$id   = is_num($this->id);
		$step = is_num($this->input->get('step'));
		
		if($id&&$step)
		{
			#验收步骤,验证上一步是否已经完成
			$pss_1 = $this->Orders_Model->project_step_stat($this->logid,$id,$step,1);
			$pss_2 = $this->Orders_Model->project_step_stat($this->logid,$id,$step,0);
			if($pss_1==2&&$pss_2==1){
				#支付每个阶段的费用才可以开始
				$pssRS = $this->db->query("select OP.uid,OP.uid_2,OPD.total_money,OPD.cy_money,OPS.money from `order_project` OP left join `order_project_deal` OPD on OP.id=OPD.o_id left join `order_project_step` OPS on OPD.o_id=OPS.o_id where OPD.o_id=$id and OPS.stepNO=$step and OPS.ispay=1")->row();
				if(!empty($pssRS)){
					#获取用户id
					$uid      = $this->logid;
					$uid_2    = $this->Orders_Model->order_project_info($id,"uid_2");
					$orderid  = $this->Orders_Model->order_project_info($id,"orderid");
					$mobile_2 = $this->User_Model->mobile($uid_2,"mobile");
					#阶段费用
					$thismoney   = $pssRS->money;   //当前阶段费用
					$thisCYmoney = $pssRS->cy_money;  //质保押金
					
					#将阶段费用打到工人帐号(验收后)
					if($thismoney<0){ $thismoney=-$thismoney; } //保证为正整数(打款)
					if(is_num($uid_2)&&is_num($thismoney))
					{
						#计算并处理费用,@@@实例化费用处理类
						$this->cost_rate->cost = $thismoney;
						$cost_this = $this->cost_rate->cost_this();  //订单费用
						$cost_ser  = $this->cost_rate->cost_ser();   //服务费
						$cose_sum  = $this->cost_rate->cost_sum();   //订单费+服务费
						$cost_less = $this->cost_rate->cost_less();   //订单费+服务费
						$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
						$cost_rate = '<span class="chenghong">'.$cost_rate.'</span>';
						//交易抽取的比率
						//$cost_rate1=$this_cost->cost_rate1();
						$cost_rate1='';
						
						//用于业主页面
						$orderlink_1 = '<a target="_blank" href="'.site_url($this->data['c_urls'].'/view/'.$id).'">'.$orderid.'</a>';
						//用于工人页面
						$orderlink_2 = str_replace($this->data['e_url'],$this->data['w_url'],$orderlink_1);
						
						$addcost=0; //调用诚意金
						#判断是否最后一步
						if($step==$this->Orders_Model->order_project_steps($id)){
							$allcost  = $this->Orders_Model->order_project_allprice($id,1);  //总有效报价
							$dealcost = $pssRS->total_money;  //合同金额报价
							$CYcost   = $pssRS->cy_money;     //合同诚意金
							if(is_num($allcost)&&is_num($dealcost)&&is_num($CYcost)){
								if($allcost>=$dealcost+$CYcost){
									$addcost = $CYcost; #需要使用全部诚意金
								}elseif(($allcost>$dealcost)&&($allcost<$dealcost+$CYcost)){
								    $addcost = $allcost-$dealcost; #需要使用部分诚意金
								}
								#如果有剩余，剩余的部分返回到业主(当前订单费用+服务费)
								$this->Records_Model->balance_control($uid,($CYcost-$addcost),"订单：".$orderlink_1." 第".colorT($step)."阶段费用进行结算时,诚意金使用了".colorT($cose_sum)."元,返回诚意金".colorT($CYcost-$addcost)."元","S");
							}
						}
						
						
						if($addcost>0){
							#将费用打到工人账户上
							$this->Records_Model->balance_control($uid_2,$cost_less,"业主".$this->User_Model->links($uid)."将订单：".$orderlink_2." 第".colorT($step)."阶段费用(".colorT($cost_this)."元)的".colorT($cost_rate1)."存入你的现金账户下，".colorT($cost_rate)."存入你的信用账户上!","S");
							#将费用中的5%存入工人的信用账户上
							$this->Records_Model->balance_control($uid_2,$cost_ser,"系统自动将订单：".$orderlink_2." 第".colorT($step)."阶段费用(".colorT($cost_this)."元)的".colorT($cost_rate)."存入你的信用账户上!","S_XY");
							#编辑提示
							//$backinfo="您成功确认验收订单：".$orderid." 的第".$step."阶段,将相应的费用".$cost_this."元支付到工人".g_user($uid_2,"name")."帐户，并使用诚意金".$addcost."元进行结算!";
							#发送通知
							$msg = "业主 ".$this->User_Model->links($uid)." 确认验收订单：".$orderlink_2." 的第".colorT($step)."阶段,并将相应的费用".colorT($cost_this)."元 预付到平台上,并使用诚意金".colorT($addcost)."元进行结算";
							order_sendmsg($uid_2,$msg);
						}else{
							#计算并处理费用,@@@实例化费用处理类
							$this->cost_rate->cost = $thismoney;
							$cost_this = $this->cost_rate->cost_this();  //订单费用
							$cost_ser  = $this->cost_rate->cost_ser();   //服务费
							$cose_sum  = $this->cost_rate->cost_sum();   //订单费+服务费
							$cost_less = $this->cost_rate->cost_less();  //订单费-服务费
							$cost_rate = $this->cost_rate->cost_rate();  //交易抽取的比率
							$cost_rate = '<span class="chenghong">'.$cost_rate.'</span>';
							//交易抽取的比率
							//$cost_rate1=$this_cost->cost_rate1();
							$cost_rate1='';

							#普通调用
							$this->Records_Model->balance_control($uid_2,$cost_less,"业主".$this->User_Model->links($uid)."将订单：".$orderlink_2." 第".colorT($step)."阶段费用(".colorT($cost_this)."元)的".colorT($cost_rate1)."划入你的现金账户下，".colorT($cost_rate)."存入你的信用账户上!","S");
							#将费用中的5%存入工人的信用账户上
							$this->Records_Model->balance_control($uid_2,$cost_ser,"系统自动将订单：".$orderlink_2." 第".colorT($step)."的费用(".colorT($cost_this)."元)的".colorT($cost_rate)."存到你的信用账户上!","S_XY");
							  
							#编辑提示
							//$backinfo="您成功确认验收订单：".$orderid." 的第".$step."阶段,将相应的费用".$thismoney."元支付到工人".g_user($uid_2,"name")."帐户!";
							  
							#发送通知
							$msg = "业主 ".$this->User_Model->links($uid)." 确认验收订单：".$orderlink_2." 的第".colorT($step)."阶段,并将相应的费用".colorT($cost_this)."元 预付到平台上";
							order_sendmsg($uid_2,$msg);
						}
						#允许验收步骤
						$this->db->query("update `order_project_step` set `ispay`=2,`paydate`='".dateTime()."' where ispay=1 and stepNO=$step and o_id=$id");
					}
				}
		    }
		}else{
			#不允许开始步骤
			$backinfo="该阶段不允许验收!请查看上一步是否已经验收,当前阶段是否已经开始!";
		}
	}
	
	
	
	
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
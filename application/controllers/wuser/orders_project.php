<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_project extends W_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	public $id;

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
		$this->load->model('Common_Model');
		
		$this->load->helper('orders');
		
		$this->lang->load('order', 'cn');

		//初始化页面导航,当前导航设置
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
	    $this->data["list"] = $this->Paging->show("select * from `order_project` where uid_2=".$this->logid." order by id desc",5);
		/*输出到视窗*/
		$this->load->view_wuser('orders/project',$this->data);
	}
	

	
	function view($id=0)
	{
		$id = is_num($id,'404');
		$this->lang->load('order', 'cn');
		
		//页面上的操作(删除或审核)
		$action = $this->input->get('action');
		if($action!=''){
			$this->id = $id;
			$pid = is_num($this->input->get('pid'));
			switch ($action)
			{
				//删除报价
				case 'price_del': $this->price_del($pid); break;
				//用户确认合同
				case 'deal_ok': $this->deal_ok(); break;  
			}
		}


		//读取订单基本信息 <><><>
	    $view = $this->db->query("select * from order_project 
											   where uid_2=".$this->logid." and id=".$id." order by id desc")->row();
		if(!empty($view)){
			$this->data["id"] = $id;
			$this->data["view"] = $view;
			$order2uid = $view->uid; 
			$this->data['user_links'] = $this->User_Model->links($order2uid);
			$this->data['note'] = $view->note;
			$this->data['addtime'] = $view->addtime;
			$r_rid = $view->retrieval_id;  //相应的任务id
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
		$this->data['deal_view']  = $this->db->query("select * from `order_project_deal` where o_id=".$id." LIMIT 1")->row();
		
		#判断是否已经(添加并双方确认)了合同信息
		$this->data['dealok'] = $this->Orders_Model->order_project_deal_stat($id);
		
		//根据合同步骤状态获取当前合同的状态(是否完成)
		$this->data['ostat'] = $this->Orders_Model->order_project_stat($id);
		
		//订单评分状态
		$isevaluate = $this->Common_Model->isevaluate_order_project($id,$this->logid);
		
		//返回订单状态按钮
		$this->data['order_stat_btu'] = order_stat($this->data['ostat'],$isevaluate,$id);	

		//获取该合同的步骤信息
		$this->data['deal_steps'] = $this->db->query("select * from `order_project_step` where o_id=".$id." order by stepNO asc")->result();

		/*输出到视窗*/
		$this->load->view_wuser('orders/project_view',$this->data);
	}
	
	
	/*合同详细信息*/
	function deal($id)
	{
		$id = is_num($id,'404');
		$project_view = $this->db->query("select * from order_project where id=$id and uid_2=".$this->logid." limit 1")->row();
		if(!empty($project_view)){
		   $this->data["project_view"] = $project_view;
		   $this->data["uid"]   = $project_view->uid;
		   $this->data["uid_2"] = $project_view->uid_2;
		   $this->data["yaoqiu_note"]=$project_view->note;
		   
		   #判断是否已经同意所有报价
		   $count = $this->db->query("select * from `order_quote` where o_id=$id and u_ok<>1")->num_rows();
		   if($count>0){$this->data["deal_show"] = false;}else{$this->data["deal_show"] = true;}
		}
		
		#读取合同信息
		if(is_num($id)){
		   $row = $this->db->query("select * from `order_project_deal` where o_id=$id LIMIT 1")->row();
		   if($row){
			  #获取合同基本数据
			  $this->data["id"]     = $id;
			  $this->data["title"]  = $row->title;
			  $this->data["yaoqiu"] = $row->yaoqiu;
			  $this->data["other"]  = $row->other;
			  $this->data["total_money"] = $row->total_money;
			  $this->data["cy_money"] = $row->cy_money;
			  #获取合同阶段数据(数组形式)
			  $moneyArr  =array();
			  $daysArr   =array();
			  $contentArr=array();
			  $row1 = $this->db->query("select * from `order_project_step` where o_id=$id order by stepNO asc")->result();
			  foreach($row1 as $rs1){
				 $moneyArr[]  = $rs1->money;
				 $daysArr[]   = $rs1->days;
				 $contentArr[]= $rs1->content;
			  }
			  $this->data["money"]   = $moneyArr;
			  $this->data["days"]    = $daysArr;
			  $this->data["content"] = $contentArr;
			  $this->data["countItem"]=count($moneyArr);
		   }
		}
		
		/*输出到视窗*/
		$this->load->view_wuser('orders/project_deal_view',$this->data);
	}
	
	

	/*选择订单报价框*/
	function deal_not_ok_msg()
	{
		$logid = $this->logid;
		
		/*提交保存操作*/
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$id = is_num($this->input->post('id'));
			$note = noHtml($this->input->post('note'));
			if($id==false){ json_form_no($this->lang->line('system_tip_busy')); }
			if($note==''){ json_form_no('请填写不同意合同内容的理由!'); }
			
		    #保证用户有权限操作
		    $rsnum = $this->db->query("select OP.id from `order_project` OP left join `order_project_deal` OPD on OP.id=OPD.o_id where OP.id=$id and OP.uid_2=$logid and (OPD.u_ok<>1 or OPD.u_ok_2<>1)")->num_rows();
		    if($rsnum>0){ #有操作权限则写入回复
				$this->db->query("update `order_project_deal` set `feed`='$note',`u_ok_2`=2 where o_id=$id");
				json_form_yes('意见发送成功!');
		    }else{
				json_form_no($this->lang->line('system_tip_busy'));
		    }
			exit;
		}
		
		$this->data['id'] = is_num($this->input->get('id'),'404');
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/deal_not_ok_msg';
		$this->data['formTO']->backurl = '';
		
		/*输出到视窗*/
		$this->load->view_wuser('orders/deal_not_ok_msg',$this->data);
	}
	
	
	
	/*订单报价框*/
	function add_price($id=0)
	{
		$logid = $this->logid;
		$id    = is_num($id,'404');
		$this->data['id'] = $id;

		//获取当前编辑报价项的信息
		$p_editid   = is_num($this->input->post("edit_id"));
		if($p_editid==false){ $p_editid = is_num($this->input->get("edit_id")); }
		
		$p_title    = noHtml($this->input->post("project"));
		$p_num      = $this->input->post("num");
		$p_units    = noHtml($this->input->post("units"));
		$p_r_price  = is_num($this->input->post("r_price"));
		$p_c_price  = is_num($this->input->post("c_price"));
		$p_allprice = $this->input->post("allprice");
		$p_note     = noHtml($this->input->post("p_note"));
		$ip = ip();

		if($this->input->post('go')=="yes"){
			//数据验证
			if($p_title==""){
			   $backinfo="请填写项目名称!";
			}elseif($p_num==""){
			   $backinfo="请填写数量!";
			}elseif(is_num($p_num)==false||$p_num<=0){
			   $backinfo="数量应该为正整数!";
			}elseif($p_units==""){
			   $backinfo="数量至少为1 !";
			}elseif($p_r_price==""){
			   $backinfo="请填写人工单价!";
			}elseif(is_num($p_r_price)==false||$p_r_price<=0){
			   $backinfo="人工单价应为正整数!";
			}elseif($p_c_price==""){
			   $backinfo="请填写材料单价!";
			}elseif(is_num($p_c_price)==false||$p_c_price<0){
			   $backinfo="材料单价应为非负整数!";
			}else{
				
			   if(is_num($p_editid)==false){
				  $litSql = "";
				  $backinfoTip = "该项报价已经报价单中,请不要重复添加!";
			   }else{
				  $litSql = " and id=".$p_editid; //限制为当前编辑的内容
				  $backinfoTip = "您未对该项报价进行任何修改!"; 
			   }
			   
			   #开始写入数据
			   $proMD5=md5($id.$p_title.$p_num.$p_units.$p_r_price.$p_c_price.$p_note);
			   #保证用户有权限操作
			   $rownum = $this->db->query("select id from `order_project` where id=$id and uid_2=$logid")->num_rows();
			   if($rownum>0){
				  #判断该项报价是否已经添加(未添加则可以添加)
				  $rownum2 = $this->db->query("select id from `order_quote` where o_id=$id and proMD5='".$proMD5."'".$litSql)->num_rows();
				  if($rownum2<=0){
					 #不存在该项信息，允许写入相关报价
					 if($p_editid==false){
						$sql="INSERT INTO `order_quote` (`o_id` ,`u_ok` ,`project` ,`num` ,`units` ,`c_price` ,`r_price` ,`note` ,`addtime` ,`ip` ,`proMD5`) VALUES ('$id', '0', '$p_title', '$p_num', '$p_units', '$p_c_price', '$p_r_price', '$p_note', '".dateTime()."', '".$ip."', '$proMD5')";
					 }else{
						$sql="update `order_quote` set `u_ok`=0,`project`='$p_title',`num`=$p_num,`units`='$p_units',`c_price`=$p_c_price,`r_price`=$p_r_price,`note`='$p_note',`proMD5`='$proMD5' where id=$p_editid and `u_ok`<>1";
					 }
					 $qrs = $this->db->query($sql);
					 if($qrs){
						 json_form_yes('保存成功!');
					 }else{
						 json_form_no('操作可能失败!');
					 }
				  }else{
					  $backinfo = $backinfoTip;
				  } 
			   }
			   
			   json_form_no($backinfo);
			}
		}
		
		
		#编辑状态，读取相应的内容
		if($p_editid){
		   $rsview = $this->db->query("select OQ.* from `order_project` OP left join `order_quote` OQ on OP.id=OQ.o_id where OQ.id=$p_editid and OP.uid_2=$logid and OQ.u_ok<>1")->row();
		   if(!empty($rsview)){
			  //$id = $rsview->id;
			  if($p_title==""){$p_title=$rsview->project;}
			  if($p_num==""){$p_num=$rsview->num;}
			  if($p_units=="")  {$p_units=$rsview->units;}
			  if($p_r_price==""){$p_r_price=$rsview->r_price;}
			  if($p_c_price==""){$p_c_price=$rsview->c_price;}
			  if($p_note=="") {$p_note=$rsview->note;}
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
		$this->data['pro_view'] = $this->db->query("select * from `order_project` where uid_2=$logid and id=$id")->row();
		$this->data['allprice'] = $this->Orders_Model->order_project_allprice($id);

		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/add_price/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"].'/view/'.$id;
		
		/*输出到视窗*/
		$this->load->view_wuser('orders/project_add_price',$this->data);
	}
	
	
	
	
	
	/*选择报价项目框*/
	function project_industrys()
	{
		/*输出到视窗*/
		$industryid = is_num($this->input->get("industryid"));
		if($industryid){
		  $this->data["Irs"] = $this->db->query("select title,units,r_price,c_price,note from industry where industryid<>0 and id=$industryid")->row();
		}
		$this->load->view_wuser('orders/project_industrys',$this->data);
	}
	
	
	
	
	
	//<><><><><><><><><><><><><><>
	
	/*用户确认合同(需要限定权限)*/
	function deal_ok()
	{
		$id = is_num($this->id);
		if($id){
		   #保证用户有权限操作
		   $qnum = $this->db->query("select OP.id from `order_project` OP left join `order_project_deal`
								  OPD on OP.id=OPD.o_id where OP.id=".$id." and OP.uid_2=".$this->logid." and OPD.u_ok=1")->num_rows();
		   if($qnum>0){
			  $this->db->query("update `order_project_deal` set u_ok_2=1,oktime='".dateTime()."' where u_ok_2<>1 and u_ok=1 and o_id=".$id);
			  header("Location:".reUrl("action=null"));exit;
		   }
		}
	}
	
	/*用户删除合同(需要限定权限)*/
	function price_del($pid=0)
	{
		if($pid){
		   #保证用户有权限操作
		   $qnum = $this->db->query("select OP.id from `order_project` OP left join `order_quote`
										  OQ on OP.id=OQ.o_id where OQ.id=".$pid." and OP.uid_2=".$this->logid." and OQ.u_ok<>1")->num_rows();
		   if($qnum>0){
			  $this->db->query("delete from `order_quote` where u_ok<>1 and id=".$pid);
			  header("Location:".reUrl("action=null&pid=null"));exit;
		   }
		}
	}
	
	
	

	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
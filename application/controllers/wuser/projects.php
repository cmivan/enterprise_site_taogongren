<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends W_Controller {
	
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

		$this->load->model('Industry_Model');
		
		
		
		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "我擅长的技能清单";
		$this->data["thisnav"]["nav"][0]["link"]  = "index";
		$this->data["thisnav"]["nav"][0]["tip"]   = "点击相应的项目可以添加报价";
		
		$this->data["thisnav"]["nav"][1]["title"] = "管理擅长技能";
		$this->data["thisnav"]["nav"][1]["link"]  = "skills_management";
		$this->data["thisnav"]["nav"][1]["tip"]   = "在这里可以 添加/删除 你擅长的技能";
		
		$this->data["thisnav"]["nav"][2]["title"] = "参考报价";
		$this->data["thisnav"]["nav"][2]["link"]  = "prices";
		$this->data["thisnav"]["nav"][2]["tip"]   = "";
	}
	
	
	
	function index()
	{
		//用户技能总数
		$this->data["skills_count"] = $this->Industry_Model->skills_count($this->logid);
		//用户擅长工种
		$this->data["goodat_industrys"] = $this->Industry_Model->goodat_industrys($this->logid);
		//用户擅长项目种类
		$this->data["goodat_classes"] = $this->Industry_Model->goodat_classes($this->logid);
		//用户擅长项目种类
		//goodat_class_industrys($classid,$logid);

		/*输出到视窗*/
		$this->load->view_wuser('projects/index',$this->data);
	}
	
	
	
	function skills_management()
	{
		//用户技能总数
		$this->data["skills_count"] = $this->Industry_Model->skills_count($this->logid);
		//用户擅长工种
		$this->data["goodat_industrys"] = $this->Industry_Model->goodat_industrys($this->logid);
		//用户擅长项目种类
		$this->data["goodat_classes"] = $this->Industry_Model->goodat_classes($this->logid);
		/*输出到视窗*/
		$this->load->view_wuser('projects/skills_management',$this->data);
	}
	
	
	
	function prices()
	{
		//删除报价
		$del_id = is_num($this->input->get("del_id"));
		if($del_id!=false){
		   $thisdata["price"] = 0;
		   $thisdata["note"]  = "";
		   $this->db->where('workerid',$this->logid);
		   $this->db->where('id',$del_id);
		   $this->db->update('skills', $thisdata); 
		}
		
		//读取列表
		$this->load->model('Paging');
	    $this->data["list"] = $this->Paging->show("select S.id,S.price,S.note,I.title from skills S left join industry I on S.industryid=I.id where S.workerid=".$this->logid." and S.price<>'' and S.price<>0 and S.note<>''",10);
		/*输出到视窗*/
		$this->load->view_wuser('projects/prices',$this->data);
	}

	
	
	function edit()
	{
		$pro_id = is_num($this->input->get("pro_id"),0);
		$this->data["projects"] = $this->db->query("select I.title,S.id,S.price,S.note from skills S left join industry I on S.industryid=I.id where S.id=".$pro_id." and S.workerid=".$this->logid." LIMIT 1")->row();
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		/*输出到视窗*/
		$this->load->view_wuser('projects/edit',$this->data);
	}
	
	
	
	function save()
	{
		$pro_id = is_num($this->input->post("pro_id"));
		if($pro_id==false){
			json_form_no('提交失败,无法正确获取项目ID,请与管理员联系!');
		}else{
		   $thisdata["price"] = $this->input->post("price",true);
		   $thisdata["note"]  = $this->input->post("note",true);
		   if($thisdata["price"]!=""&&$thisdata["note"]!="")
		   {
			   $this->db->where('workerid',$this->logid);
			   $this->db->where('id',$pro_id);
			   $this->db->update('skills', $thisdata);
			   json_form_yes('保存成功!');
		   }else{
			   json_form_no('请先完整填写信息!');
		   }
		   
		}
	}
	
	
	function checked_one()
	{
		$this->load->model('Skills_Model');
		
		$checked = $this->input->get("checked");
		$industryid = is_num($this->input->get("industryid"),0);
		
		if($checked==0)
		{
		   //删除擅长技能
		   $this->Skills_Model->skills_del($this->logid,$industryid);
		   json_echo("0");
		}elseif($checked==1){
			//添加擅长技能
		   $thisNUM=$this->db->query("select id from skills where `workerid` = ".$this->logid." and `industryid` = ".$industryid." LIMIT 1")->num_rows();

		   if($thisNUM<=0){
			   
			  $this->db->query("INSERT INTO `skills` (`price` ,`note` ,`workerid` ,`industryid`,`addtime`) VALUES ('0',  '',  '".$this->logid."', '".$industryid."','".date("Y-m-d H:i:s")."')");
			  
			  json_echo("1");
		   }
		}
		
	}
	
	
	function checked_all()
	{
		$this->load->model('Skills_Model');
		
		$checked    = $this->input->get("checked");
		$classid    = is_num($this->input->get("classid"),0);
		$industryid = is_num($this->input->get("industryid"),0);
		
		//获取旗下的技能
		$cis = $this->Industry_Model->class_industrys($classid,$industryid);
		if(!empty($cis)){
			if($checked==0){
				foreach($cis as $rs){ //删除擅长技能
					$this->Skills_Model->skills_del($this->logid,$rs->id);
				}
				json_echo("0");
			}elseif($checked==1){
				foreach($cis as $rs){
					//添加擅长技能
					$thisNUM=$this->db->query("select id from skills where `workerid` = ".$this->logid." and `industryid` = ".$rs->id." LIMIT 1")->num_rows();
					if($thisNUM<=0){
					   $this->db->query("INSERT INTO `skills` (`price` ,`note` ,`workerid` ,`industryid`,`addtime`) VALUES ('0',  '',  '".$this->logid."', '".$rs->id."','".date("Y-m-d H:i:s")."')");
					}
				}
				json_echo("1");
			}
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
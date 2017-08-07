<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Center extends COMPANY_Controller {
	
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

		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "基本信息";
		$this->data["thisnav"]["nav"][0]["link"]  = "index";
		$this->data["thisnav"]["nav"][1]["title"] = "企业形象";
		$this->data["thisnav"]["nav"][1]["link"]  = "face";
		$this->data["thisnav"]["nav"][2]["title"] = "企业简介";
		$this->data["thisnav"]["nav"][2]["link"]  = "about";
		$this->data["thisnav"]["nav"][3]["title"] = "服务项目";
		$this->data["thisnav"]["nav"][3]["link"]  = "service";
		$this->data["thisnav"]["nav"][4]["title"] = "参考报价";
		$this->data["thisnav"]["nav"][4]["link"]  = "price";
		$this->data["thisnav"]["nav"][5]["title"] = "修改密码";
		$this->data["thisnav"]["nav"][5]["link"]  = "reset_password";
		
		/*个人信息*/
	    $this->data["info"] = $this->User_Model->info($this->logid);
	}
	


	function index()
	{
		$this->load->helper('forms');
		/*工作年限*/
	    $this->data["age_class"] = $this->User_Model->age_class();

		/*<><><>Js<><><>*/
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/update_save';
		$this->data['formTO']->backurl = 'null';
		/*输出到视窗*/
		$this->load->view_company('user/index',$this->data);
	}

	
	//保存个人信息
	function update_save()
	{
		$data["truename"] = noHtml($this->input->post("truename"));
		$data["name"] = noHtml($this->input->post("name"));
		$data["entry_age"] = is_num($this->input->post("entry_age"),1);
		$data["qq"] = is_num($this->input->post("qq"),0);
		$data["email"] = $this->input->post("email");
		$data["p_id"] = is_num($this->input->post("p_id"),0);
		$data["c_id"] = is_num($this->input->post("c_id"),0);
		$data["a_id"] = is_num($this->input->post("a_id"),0);
		$data["cardnum"]  = noHtml($this->input->post("cardnum"));
		$data["cardnum2"]  = noHtml($this->input->post("cardnum2"));
		$data["address"]  = noHtml($this->input->post("address"));
		$data["addr_adv"] = noHtml($this->input->post("addr_adv"),1);

		$this->db->where('id', $this->logid);
		$this->db->where('classid',2);
		$this->db->where('uid',1);
		$this->db->update('user', $data); 
		json_form_yes('更新成功!');
	}


	//管理头像
	function face()
	{
		$photoID = $this->User_Model->photoID($this->logid);
		$this->data["photoID"] = $photoID;
		$this->data["face"] = $this->User_Model->face($photoID);
		/*输出到视窗*/
		$this->load->view_company('user/face',$this->data);
	}
	
	
	//通用保存
	function page_save($key)
	{
		if($key!=''){
			$content = $this->input->post('content');
			if(empty($content)){ json_form_no('请先填写内容!'); }
			$data[$key] = $content;
			$this->db->where('id',$this->logid);
			$this->db->where('uid',1);
			$this->db->where('classid',2);
			$this->db->update('user',$data);
		}else{
			json_form_no('更新失败!');
		}
		json_form_yes('更新成功!');
	}
	
	//企业简介
	function about()
	{
		$this->load->library('kindeditor');

		$this->data["content"] = '';
		if(!empty($this->data["info"])){
			$this->data["content"] = $this->data["info"]->note;
			}
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/about_save';
		$this->data['formTO']->backurl = 'null';
		/*输出到视窗*/
		$this->load->view_company('user/info/about',$this->data);
	}
	function about_save(){ $this->page_save('note'); }
	
	//服务项目
	function service()
	{
		$this->load->library('kindeditor');

		$this->data["content"] = '';
		if(!empty($this->data["info"])){
			$this->data["content"] = $this->data["info"]->team_fwxm;
			}
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/service_save';
		$this->data['formTO']->backurl = 'null';
		/*输出到视窗*/
		$this->load->view_company('user/info/service',$this->data);
	}
	function service_save(){ $this->page_save('team_fwxm'); }
	
	//参考报价
	function price()
	{
		$this->load->library('kindeditor');

		$this->data["content"] = '';
		if(!empty($this->data["info"])){
			$this->data["content"] = $this->data["info"]->team_ckbj;
			}
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/price_save';
		$this->data['formTO']->backurl = 'null';
		/*输出到视窗*/
		$this->load->view_company('user/info/price',$this->data);
	}
	function price_save(){ $this->page_save('team_ckbj'); }
	
	
	
	
	//修改密码
	function reset_password()
	{
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/reset_password_save';
		$this->data['formTO']->backurl = '';
		/*输出到视窗*/
		$this->load->view_company('user/reset_password',$this->data);
	}
	
	
	//修改密码保存
	function reset_password_save()
	{
		$password = $this->input->post("password");
		$password_new = $this->input->post("password_new");
		if($password==""||$password_new==""){
			json_form_no('信息不完整!');
		}elseif($password==$password_new){
			json_form_no('保存失败，你的密码没有任何改动!');
		}else{
			$rs_num = $this->User_Model->user_is_ok($this->logid,$password);
			if($rs_num>0){
				//修改密码
				$data["password"] = pass_user($password_new);
				$data["approve_mm"] = 1;
				$this->db->where('id', $this->logid);
				$this->db->update('user', $data); 
				json_form_yes('保存成功，请牢记你的新密码!');
			}else{
				json_form_no('原密码不正确!');
			}
		}
	}



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
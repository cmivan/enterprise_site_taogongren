<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Center extends COMPANY_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/
		
		//初始化用户id
		$this->logid = $this->data["logid"];

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '基本信息','link' => 'companyinfo'),
					array('title' => '企业形象','link' => 'face'),
					array('title' => '企业简介','link' => 'about'),
					array('title' => '服务项目','link' => 'service'),
					array('title' => '参考报价','link' => 'price'),
					array('title' => '帐号安全','link' => 'security'),
					array('title' => '修改密码','link' => 'reset_password'),
					array('title' => '企业认证','link' => 'approve_sm')
		            );

		/*企业信息*/
	    $this->data["info"] = $this->User_Model->info($this->logid);
	}
	


	function index()
	{
		$this->center_ajax_pass_url('companyinfo');
		//输出到视窗
		$this->load->view_company('center',$this->data);
	}


	function companyinfo()
	{
		$this->load->helper('forms');
		//工作年限
	    $this->data["age_class"] = $this->User_Model->age_class();
		//Js
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/update_save';
		$this->data['formTO']->backurl = 'null';
		//输出到视窗
		$this->load->view_company('user/companyinfo',$this->data);
	}

	
	//保存个人信息
	function update_save()
	{
		$data["truename"] = noHtml($this->input->post("truename"));
		$data["name"] = noHtml($this->input->post("name"));
		$data["entry_age"] = $this->input->postnum("entry_age",1);
		$data["qq"] = $this->input->postnum("qq",0);
		$data["email"] = $this->input->post("email");
		$data["p_id"] = $this->input->postnum("p_id",0);
		$data["c_id"] = $this->input->postnum("c_id",0);
		$data["a_id"] = $this->input->postnum("a_id",0);
		$data["cardnum"] = noHtml($this->input->post("cardnum"));
		$data["cardnum2"] = noHtml($this->input->post("cardnum2"));
		$data["address"] = noHtml($this->input->post("address"));
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
		//输出到视窗
		$this->load->view_company('user/face',$this->data);
	}
	
	
	//通用保存
	function page_save($key)
	{
		if($key!='')
		{
			$content = $this->input->post('content');
			if(empty($content)){ json_form_no('请先填写内容!'); }
			$data[$key] = $content;
			$this->db->where('id',$this->logid);
			$this->db->where('uid',1);
			$this->db->where('classid',2);
			$this->db->update('user',$data);
			json_form_yes('更新成功!');
		}
		json_form_no('更新失败!');
	}
	
	//企业简介
	function about()
	{
		$this->load->library('kindeditor');

		$this->data["content"] = '';
		if(!empty($this->data["info"]))
		{
			$this->data["content"] = $this->data["info"]->note;
		}
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/about_save';
		$this->data['formTO']->backurl = 'null';
		//输出到视窗
		$this->load->view_company('user/info/about',$this->data);
	}
	function about_save()
	{
		$this->page_save('note'); 
	}
	
	//服务项目
	function service()
	{
		$this->load->library('kindeditor');

		$this->data["content"] = '';
		if(!empty($this->data["info"])){
			$this->data["content"] = $this->data["info"]->team_fwxm;
			}
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/service_save';
		$this->data['formTO']->backurl = 'null';
		//输出到视窗
		$this->load->view_company('user/info/service',$this->data);
	}
	function service_save()
	{
		$this->page_save('team_fwxm');
	}
	
	//参考报价
	function price()
	{
		$this->load->library('kindeditor');

		$this->data["content"] = '';
		if(!empty($this->data["info"]))
		{
			$this->data["content"] = $this->data["info"]->team_ckbj;
		}
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/price_save';
		$this->data['formTO']->backurl = 'null';
		//输出到视窗
		$this->load->view_company('user/info/price',$this->data);
	}
	
	function price_save()
	{
		$this->page_save('team_ckbj');
	}
	
	
	
	//帐号安全
	function security()
	{
		$user = $this->User_Model->approve($this->logid);
		//认证状态
		$this->data["approve_sj"] = $user->approve_sj;
		$this->data["approve_yx"] = $user->approve_yx;
		$this->data["approve_mm"] = $user->approve_mm;
		$this->data["approve_sm"] = $user->approve_sm;
		//css样式
		$this->data['cssfiles'][] = 'style/mod_form.css';
		//输出到视窗
		$this->load->view_company('user/security',$this->data);
	}
	
	
	//身份认证
	function approve_sm()
	{
		//获取该用户信息，判断是否已经提交验证信息
		$yz_sm = $this->User_Model->yz_sm($this->logid);
		//$this->data["yz_sm"] = $yz_sm;
		$this->data['truename'] = '';
		$this->data['sfz'] = '';
		$this->data['photo1'] = 'none_approve.jpg';
		$this->data['photo2'] = 'none_approve.jpg';
		
		if(empty($yz_sm))
		{
			//表单配置
			$this->data['formTO']->url = $this->data["c_urls"].'/approve_sm_save';
			$this->data['formTO']->backurl = $this->data["c_urls"].'/approve_sm';
			//未提交验证信息,或已提交但未审核
			$this->load->view_company('user/approve/add',$this->data);
		}
		else
		{
			//审核处理
			$this->data['truename'] = $yz_sm->truename;
			$this->data['sfz']      = $yz_sm->sfz;
			$this->data['photo1']   = $yz_sm->photo;
			$this->data['photo2']   = $yz_sm->photo2;
			$this->data["addtime"]  = dateYMD($yz_sm->addtime);
			$this->data["errtip"]   = '';

			switch ($yz_sm->ok)
			{
			  case '0':
				  //输出到视窗
				  $this->load->view_company('user/approve/verify',$this->data);
				  break;
			  case '1':
				  //表单配置
				  $this->data['formTO']->url = $this->data["c_urls"].'/approve_sm_save';
				  $this->data['formTO']->backurl = $this->data["c_urls"].'/approve_sm';
				  //输出到视窗
				  $this->load->view_company('user/approve/ok',$this->data);
				  break;
			  case '2':
				  if($yz_sm->errtip!=""){ $this->data["errtip"] = $yz_sm->errtip; }
				  //表单配置
				  $this->data['formTO']->url = $this->data["c_urls"].'/approve_sm_save';
				  $this->data['formTO']->backurl = $this->data["c_urls"].'/approve_sm';
				  //输出到视窗
				  $this->load->view_company('user/approve/false',$this->data);
				  break; 
			}
		}

	}
	
	//身份认证提交
	function approve_sm_save()
	{
		//接收数据
		$truename = noHtml($this->input->post('truename'));
		$sfz      = noHtml($this->input->post('sfz'));
		$photo1   = noSql($this->input->post('pic1'));
		$photo2   = noSql($this->input->post('pic2'));
		//数据检测
		if($truename==""){ json_form_no('请填写姓名!'); }
		if($sfz==""){ json_form_no('请填写身份证号!'); }
		if($photo1==""){ json_form_no('请上传证件的正面图!'); }
		if($photo1==""){ json_form_no('请上传证件的反面图!'); }
		//写入数据
		$data['truename'] = $truename;
		$data['sfz']    = $sfz;
		$data['photo']  = $photo1;
		$data['photo2'] = $photo2;
		$data['ip'] = ip();
		$data['addtime'] = dateTime();
		$data["errtip"] = '';
		//判断是否已经写入
		$yz_sm = $this->User_Model->yz_sm($this->logid);
		if(!empty($yz_sm))
		{
			//更新
			$data['ok'] = 0;
			$this->db->where('uid', $this->logid);
			$this->db->where('ok !=',1);
			$this->db->update('yz_sm',$data);
			json_form_yes('认证信息更新成功!');
		}else{
			//写入
			$data['uid'] = $this->logid;
			$this->db->insert('yz_sm',$data);
			json_form_yes('成功提交认证信息!<br>我们将会在48小时内进行审核!');
		}
	}

	
	
	//修改密码
	function reset_password()
	{
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/reset_password_save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/approve_sm';
		//输出到视窗
		$this->load->view_company('user/reset_password',$this->data);
	}
	
	
	//修改密码保存
	function reset_password_save()
	{
		$password = $this->input->post("password");
		$password_new = $this->input->post("password_new");
		if($password==""||$password_new==""){
			json_form_no('信息不完整!');
		}
		elseif($password==$password_new)
		{
			json_form_no('保存失败，你的密码没有任何改动!');
		}
		else
		{
			$rs_num = $this->User_Model->user_is_ok($this->logid,$password);
			if($rs_num>0)
			{
				//修改密码
				$data["password"] = pass_user($password_new);
				$data["approve_mm"] = 1;
				$this->db->where('id', $this->logid);
				$this->db->update('user', $data); 
				json_form_yes('保存成功，请牢记你的新密码!');
			}
			else
			{
				json_form_no('原密码不正确!');
			}
		}
	}



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
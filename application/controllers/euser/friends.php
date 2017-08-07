<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends E_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Paging');
		$this->load->model('Friends_Model');

		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '我的好友','link' => 'index'),
					array('title' => '好友请求','link' => 'request'),
					array('title' => '我推荐的好友','link' => 'recommend')
					/*,array('title' => '黑名单','link' => 'black')*/
		            );
	}
	


	function index()
	{
		$this->load->model('Recommend_Model');
		
		
		$cmd = $this->input->get("cmd");
		$id  = $this->input->getnum("id");
		//删除
		if($cmd=="del"&&$id!=false)
		{
			$this->Friends_Model->del($id,$this->logid);
		}
		//拉黑
		if($cmd=="black"&&$id!=false)
		{
			$data["isblack"] = 1; 
			$this->db->where('id',$id);
			$this->db->where('uid',$this->logid);
			$this->db->update('friends', $data); 
		}

		//获取分页列表sql
		$listsql=$this->Friends_Model->listsql_friends($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_euser('friends/index',$this->data);
	}
	


	function recommend()
	{
		$this->load->model('Recommend_Model');
		
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
		   $this->Recommend_Model->del($del_id,$this->logid);
		}

		//获取分页列表sql
		$listsql = $this->Recommend_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);

		//输出到视窗
		$this->load->view_euser('friends/recommend',$this->data);
	}
	
	
	function recommend_edit()
	{
		$this->load->model('Recommend_Model');
		
		$fuid = $this->input->getnum("fuid",'404');
		
		$this->data["fuid"] = $fuid;
		$this->data["info"] = $this->Recommend_Model->recommend_view($fuid,$this->logid);
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = '';
		//输出到视窗
		$this->load->view_euser('friends/recommend_edit',$this->data);
	}
	
	
	
	
	function save()
	{
		$fuid = $this->input->postnum("fuid");
		if($fuid==false)
		{
			json_form_no('提交失败,无法正确获取ID,请与管理员联系!');
		}
		else
		{
		   $data["fuid"]  = $fuid;
		   $data["note"]  = noHtml($this->input->post("note"));
		   
		   if($data["fuid"]!=""&&$data["note"]!="")
		   {
			   //判断是否已经存在
			   if( $this->Recommend_Model->is_Recommend($fuid,$this->logid) == false )
			   {
				   $data["uid"]  = $this->logid;
				   $this->db->insert('recommend', $data);
			   }
			   else
			   {
				   $this->db->where('uid',$this->logid);
				   $this->db->where('fuid',$fuid);
				   $this->db->update('recommend', $data);
			   }
			   json_form_yes('保存成功!');
		   }
		   else
		   {
			   json_form_no('请先完整填写信息!');
		   }
		}
	}

	


	function request()
	{
		$cmd = $this->input->get("cmd");
		$id  = $this->input->getnum("id");
		//删除
		if($cmd=="del"&&$id!=false)
		{
			//$data[""] = 
			//$this->db->where('id',$id);
			//$this->db->where('uid',$uid);
			//$this->db->update('cases', $data); 
		}
		//拉黑
		if($cmd=="black"&&$id!=false)
		{
			$data["isblack"] = 1; 
			$this->db->where('id',$id);
			$this->db->where('uid',$this->logid);
			$this->db->update('friends', $data); 
			}
		//同意加为好友
		if($cmd=="ok"&&$id!=false){
			$data["isok"] = 1; 
			$this->db->where('id',$id);
			$this->db->where('uid',$this->logid);
			$this->db->update('friends', $data); 
			}

		//获取分页列表sql
		$listsql=$this->Friends_Model->listsql_request($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_euser('friends/request',$this->data);
	}
	

	function black()
	{
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Friends_Model->del_black($del_id,$this->logid);
		}
		
		//获取分页列表sql
		$listsql=$this->Friends_Model->listsql_black($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_euser('friends/black',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
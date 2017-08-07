<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('Paging');
		$this->load->model('Friends_Model');
		$this->load->model('Recommend_Model');
		
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
		$id = $this->input->getnum('id');
		$cmd = $this->input->get('cmd');
		if( $id )
		{
			switch($cmd)
			{
				case 'del':
				  //删除
				  $this->Friends_Model->del($id,$this->logid);
				  break;
				  
				case 'black':
				  //拉黑
				  $data["isblack"] = 1;
				  $this->db->where('id',$id);
				  $this->db->where('uid',$this->logid);
				  $this->db->update('friends', $data); 
				  break;
			}
		}

		//获取分页列表sql
		$listsql = $this->Friends_Model->listsql_friends($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_wuser('friends/index',$this->data);
	}
	


	function recommend()
	{
		//删除数据
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
		   $this->Recommend_Model->del($del_id,$this->logid);
		}

		//获取分页列表sql
		$listsql = $this->Recommend_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_wuser('friends/recommend',$this->data);
	}
	
	
	function recommend_edit($type=0)
	{
		$fuid = $this->input->getnum('fuid','404');

		$this->data["fuid"] = $fuid;
		$this->data["info"] = $this->Recommend_Model->recommend_view($fuid,$this->logid);
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		if($type==0){
			$this->data['formTO']->backurl = $this->data["c_urls"];
		}else{
			$this->data['formTO']->backurl = $this->data["c_urls"].'/recommend';
		}
		//输出到视窗
		$this->load->view_wuser('friends/recommend_edit',$this->data);
	}
	
	
	
	
	function save()
	{
		$fuid = $this->input->postnum('fuid');
		if( $fuid == false )
		{
			json_form_no('提交失败,无法正确获取ID,请与管理员联系!');
		}
		else
		{
			$data["note"] = noHtml($this->input->post('note'));
			if( $data["note"] != '' )
			{
				//未评论则写入，已评论则添加
				//select id from `recommend` where fuid=".$fuid." and uid=".$this->logid." LIMIT 1
				if( $this->Recommend_Model->recommend_view($fuid,$this->logid) == false )
				{
					$data["fuid"]  = $fuid;
					$data["uid"] = $this->logid;
					$this->db->insert('recommend', $data);
			    }
			    else
				{
					$this->db->where('fuid',$fuid);
					$this->db->where('uid',$this->logid);
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
		$id = $this->input->getnum('id');
		$cmd = $this->input->get('cmd');
		if($id)
		{
			$this->db->where('id',$id);
			$this->db->where('uid',$this->logid);
			
			switch($cmd)
			{
				case 'del':
				 $this->db->delete('friends'); 
				  //删除
				  break;
				  
				case 'black':
				  //拉黑
				  $data["isblack"] = 1; 
				  $this->db->update('friends', $data); 
				  break;
				  
				case 'ok':
				  //同意加为好友
				  $data["isok"] = 1; 
				  $this->db->update('friends', $data); 
				  break;
			}

		}

		//获取分页列表sql
		$listsql = $this->Friends_Model->listsql_request($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show( $listsql );
		//输出到视窗
		$this->load->view_wuser('friends/request',$this->data);
	}
	

	function black()
	{
		//删除数据
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
			$this->Friends_Model->del_black($del_id,$this->logid);
		}
		
		//获取分页列表sql
		$listsql = $this->Friends_Model->listsql_black($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view_wuser('friends/black',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
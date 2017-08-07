<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msg extends E_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		
		//分页模型
		$this->load->model('Paging');
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Sendmsg_Model');
		
		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "收到的消息";
		$this->data["thisnav"]["nav"][0]["link"]  = "receiver";
		$this->data["thisnav"]["nav"][1]["title"] = "发出的消息";
		$this->data["thisnav"]["nav"][1]["link"]  = "send";
		#$this->data["thisnav"]["nav"][2]["title"] = "系统消息";
		#$this->data["thisnav"]["nav"][2]["link"]  = "sys";
	}
	
	
	
	function index()
	{
		/*输出到视窗*/
		$this->receiver();
	}
	
	
	//收到的消息
	function receiver()
	{
		//删除数据
		$del_id = is_num($this->input->get("del_id"));
		if($del_id!=false){
			 $this->Sendmsg_Model->del_receiver($del_id,$this->logid);
			 }
		
		//获取分页列表sql
		$listsql=$this->Sendmsg_Model->listsql_receiver($this->logid);
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql);
		
		//更新数据
		$this->Sendmsg_Model->update_receiver($this->logid);
		
		$this->load->view_euser('msg/receiver',$this->data);
	}
	
	//发送消息
	function send()
	{
		//删除数据
		$del_id = is_num($this->input->get("del_id"));
		if($del_id!=false){
			$this->Sendmsg_Model->del_send($del_id,$this->logid);
			}
			
		//获取分页列表sql
		$listsql=$this->Sendmsg_Model->listsql_send($this->logid);
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql);
		$this->load->view_euser('msg/send',$this->data);
	}
	
	//收到的系统消息
	function sys()
	{
		//删除数据
		$del_id = is_num($this->input->get("del_id"));
		if($del_id!=false){
			$this->Sendmsg_Model->del_receiver($del_id,$this->logid);
			}
		
		//获取分页列表sql
		$listsql=$this->Sendmsg_Model->listsql_sys($this->logid);
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql);
		$this->load->view_euser('msg/sys',$this->data);
	}

	
	
	//返回最新消息数目和内容
	function new_msg_tip()
	{
		$new_msg_num  = $this->User_Model->new_msg_num($this->logid);
		$new_msg_info = '';
		if($new_msg_num>0){
			$new_msg_info = '<p id="WB_new_msg"><b class="red">'.$new_msg_num.'</b>条新消息，<a href="'.site_url($this->data['e_url'].'msg').'">查看我的新消息</a></p>';
			$new_msg = $this->db->query("select * from sendmsg where suid= ".$this->logid." and su_del=0 order by id desc LIMIT 1")->row();
		    if($new_msg){
			   $new_msg_info.='<p>'.$this->User_Model->links($new_msg->uid).'&nbsp;&nbsp;('.$new_msg->addtime.') ...</p>';
			}
		}
		
		json_echo('{"num":"'.$new_msg_num.'","msg":"'.txt2json($new_msg_info).'"}');
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_other extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Sys_page_Model');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['table_title'] = '其他页面';
	}
	
	//管理页面
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		
		//普通删除、数据处理
//		$del_id = $this->input->getnum('del_id');
//		if($del_id){ $this->Sys_page_Model->del($del_id); }
		//批量删除、数据处理
//		$del_id = $this->input->post('del_id');
//		if(!empty($del_id)){
//			foreach($del_id as $delID){
//				if(is_num($delID)){ $this->Sys_page_Model->del($delID); }
//			}
//		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'title'=> $keysword );
			$keylike_on[] = array( 'content'=> $keysword );
			$this->db->like_on($keylike_on);
			//(title like '%".$keysword."%' or content like '%".$keysword."%');
		}
		$this->data['keysword'] = $keysword;

		$this->db->from('sys_page');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		
		$this->load->view_system('page_other/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		$this->load->library('kindeditor');

		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';
		$this->data['content'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Sys_page_Model->view($id);
			if(!empty($rs))
			{
				$this->data['title'] = $rs->title;
				$this->data['content'] = $rs->content;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('page_other/edit',$this->data);
	}


	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$title = $this->input->post('title');
		$content = $this->input->post('content');

		//验证数据
		if($title=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($content=='')
		{
			json_form_no('请填写内容!');
		}
		
		//写入数据
		$data['title'] = $title;
		$data['content'] = $content;
		if($id==false)
		{
			$this->db->insert('sys_page',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('sys_page',$data);
			json_form_yes('修改成功!');
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
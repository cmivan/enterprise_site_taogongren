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
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{
		//分页模型
		$this->load->model('Paging');
		
		
		//<><><>管理页面操作(go)
		
		//普通删除、数据处理
//		$del_id = is_num($this->input->get('del_id'));
//		if($del_id){ $this->Sys_page_Model->del($del_id); }
		//批量删除、数据处理
//		$del_id = $this->input->post('del_id');
//		if(!empty($del_id)){
//			foreach($del_id as $delID){
//				if(is_num($delID)){ $this->Sys_page_Model->del($delID); }
//			}
//		}
		
		//判断搜索
		$keysword = noSql($this->input->post('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(title like '%".$keysword."%' or content like '%".$keysword."%')";
		}else{
			$keysword = noSql($this->input->get('keysword'));
			if($keysword!=''){
				$keyswordSql = "(title like '%".$keysword."%' or content like '%".$keysword."%')";
			}
		}
	 
		//<><><>管理页面操作(end)


		//返回相应的sql
		$key_sql = ''; //初始化该变量
		//无分类筛选
		if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
		$listsql = "select * from sys_page".$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('page_other/manage',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 添加编辑页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit()
	{
		$this->load->library('kindeditor');

		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';
		$this->data['content'] = '';

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Sys_page_Model->view($id);
			if(!empty($rs)){
				$this->data['title'] = $rs->title;
				$this->data['content'] = $rs->content;
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('page_other/edit',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 提交保存 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$title = noSql($this->input->post('title'));
		$content = $this->input->post('content');

		//验证数据
		if($title==''){ json_form_no('请填写标题!'); }
		if($content==''){ json_form_no('请填写内容!'); }
		
		//写入数据
		$data['title'] = $title;
		$data['content'] = $content;
		if($id==false){
			//添加
			$this->db->insert('sys_page',$data);
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->update('sys_page',$data);
			json_form_yes('修改成功!');
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
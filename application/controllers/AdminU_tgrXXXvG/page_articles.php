<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_articles extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Articles_Model');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['table_title'] = '装修文章';
		//获取分类
		$this->data['this_types'] = $this->Articles_Model->get_types();
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
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){ $this->Articles_Model->del($del_id); }
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				if(is_num($delID)){ $this->Articles_Model->del($delID); }
			}
		}
		
		//判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(title like '%".$keysword."%' or content like '%".$keysword."%')";
		}
		
	 
		//<><><>管理页面操作(end)
		
		
		//获取分类
		$type_id = is_num($this->input->get('type_id'));
		$this->data['type_id'] = $type_id;

		//返回相应的sql
		$key_sql = ''; //初始化该变量
		if($type_id==false){
			//无分类筛选
			if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
			$listsql = "select * from articles".$key_sql;
		}else{
			if(!empty($keyswordSql)){ $key_sql = " and ".$keyswordSql; }
			//筛选大类符合的
			$listsql = "select * from articles where type_id=$type_id".$key_sql;
		}
		$listsql.= ' order by id desc';

		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('page_articles/manage',$this->data);
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
		$this->data['type_id'] = '';
		$this->data['content'] = '';

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Articles_Model->view($id);
			if(!empty($rs)){
				$this->data['title'] = $rs->title;
				$this->data['type_id'] = $rs->type_id;
				$this->data['content'] = $rs->content;
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('page_articles/edit',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 提交保存 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$title = noSql($this->input->post('title'));
		//$come = noSql($this->input->post('come'));
		$content = $this->input->post('content');
		$type_id = is_num($this->input->post('type_id'));
		//$description = noSql($this->input->post('description'));
		//$recommen = noSql($this->input->post('recommen'));
		//$popular = noSql($this->input->post('popular'));
		
		//验证数据
		if($title==''){ json_form_no('请填写标题!'); }
		if($type_id==false){ json_form_no('请选择分类!'); }
		if($content==''){ json_form_no('请填写内容!'); }
		
		//写入数据
		$data['title'] = $title;
		$data['type_id'] = $type_id;
		$data['content'] = $content;
		if($id==false){
			//添加
			$data['time'] = dateTime();
			$this->db->insert('articles',$data);
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->update('articles',$data);
			json_form_yes('修改成功!');
		}
	}
	
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 分类页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function type()
	{
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){
			$this->Articles_Model->del_type($del_id);
			//重新获取分类
			$this->data['this_types'] = $this->Articles_Model->get_types();
			}

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes'){
			$cmd = $this->input->post('cmd');
			$type_id = is_num($this->input->post('type_id'));
			if($cmd==''){ json_form_no('未知操作!'); }
			if($type_id==''){ json_form_no('参数丢失,本次操作无效!'); }
			$row = $this->db->query('select * from articles_type where t_id='.$type_id)->row();
			if(!empty($row)){
				//获取当前基本信息
				$at_t_id = is_num($row->t_id);
				$at_t_order_id = is_num($row->t_order_id);
				
				//执行重新排序
				if($cmd=="up"){
					$row_up = $this->db->query('select * from articles_type where t_order_id>'.$at_t_order_id." order by t_order_id asc")->row();
					if(!empty($row_up)){
						$up_t_id = $row_up->t_id;
						$up_t_order_id = $row_up->t_order_id;
						$this->db->query("update articles_type set t_order_id=$at_t_order_id where t_id=$up_t_id");
						$this->db->query("update articles_type set t_order_id=$up_t_order_id where t_id=$at_t_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到上限!');
					}
				}elseif($cmd=="down"){
					$row_down = $this->db->query('select * from articles_type where t_order_id<'.$at_t_order_id." order by t_order_id desc")->row();
					if(!empty($row_down)){
						$down_t_id = $row_down->t_id;
						$down_t_order_id = $row_down->t_order_id;
						$this->db->query("update articles_type set t_order_id=$at_t_order_id where t_id=$down_t_id");
						$this->db->query("update articles_type set t_order_id=$down_t_order_id where t_id=$at_t_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到下限!');
					}
				}
			}	
		}
		
		
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/type';
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('page_articles/type_manage',$this->data);
	}
	
	function type_edit()
	{
		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['t_id'] = $id;
		$this->data['t_title'] = '';
		$this->data['t_order_id'] = 0;

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Articles_Model->get_type($id);
			if(!empty($rs)){
				$this->data['t_title'] = $rs->t_title;
				$this->data['t_order_id'] = $rs->t_order_id;
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/type_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/type';
		
		$this->load->view_system('page_articles/type_edit',$this->data);
	}
	
	
	//保存分类
	function type_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('t_id'));
		$t_title = noSql($this->input->post('t_title'));
		$t_order_id = is_num($this->input->post('t_order_id'));

		//验证数据
		if($t_title==''){ json_form_no('请填写标题!'); }
		if($t_order_id==''){ json_form_no('请在排序处填写正整数!'); }
		
		//写入数据
		$data['t_title'] = $t_title;
		$data['t_order_id'] = $t_order_id;
		
		if($id==false){
			//添加
			$this->db->insert('articles_type',$data);
			
			//重洗分类排序
			$this->re_order_type();
			
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('t_id',$id);
			$this->db->update('articles_type',$data);
			
			//重洗分类排序
			$this->re_order_type();
			
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_type()
	{
		$re_row = $this->Articles_Model->get_types();
		if(!empty($re_row))
		{
			$re_num = $this->Articles_Model->get_types_num();
			foreach($re_row as $re_rs)
			{
				$data['t_order_id'] = $re_num;
				$this->db->where('t_id',$re_rs->t_id);
				$this->db->update('articles_type',$data);
				$re_num--;
			}
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
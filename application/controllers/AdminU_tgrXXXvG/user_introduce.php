<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_introduce extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->load->model('Introduce_Model');
		
		$this->data['table_title'] = '介绍好友';
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{
		//分页模型
		$this->load->model('Paging');
		//收支记录模型
		$this->load->model('Records_Model');
		
		
		//<><><>管理页面操作,更改状态(go)
		$id = is_num($this->input->get('id'));
		$cmd = $this->input->get('cmd');
		if($cmd!=''&&$id){
			if($cmd=="yes"){$ok = 1; /*审核通过的信息*/ }else{$ok = 2; /*审核不通过的信息*/ }
			$rs = $this->db->query('update sys_introduce set ok='.$ok.' where ok=0 and id='.$id);
			//有效，则送淘工币
			if($rs&&$ok==1){
				//获取相关信息
				$row = $this->db->query("select nicename,uid from sys_introduce where id=".$id)->row();
				if(!empty($row)){
					$nicename = $row->nicename;
					$this_uid = is_num($row->uid);
					if($this_uid){
						//这里设定赠送5个淘工币
						$BC_tip = '推荐用户&nbsp;【'.$nicename.'】&nbsp;到淘工人平台,并通过审核!';
						$BC_ok  = $this->Records_Model->balance_control($this_uid,'5',$BC_tip,'T');
					}
				}
			}
		}

		
		//判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(nicename like '%".$keysword."%' or mobile like '%".$keysword."%')";
		}
		
	 
		//<><><>管理页面操作(end)


		//返回相应的sql
		$key_sql = ''; //初始化该变量
		//无分类筛选
		if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
		$listsql = "select * from sys_introduce".$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		$this->data["page"] = $this->input->get('page');
		
		$this->load->view_system('user_introduce/manage',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 添加编辑页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit()
	{
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

		$this->load->view_system('user_introduce/edit',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 提交保存 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$title = noSql($this->input->post('title'));
		$content = noSql($this->input->post('content'));

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
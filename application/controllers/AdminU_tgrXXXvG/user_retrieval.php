<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_retrieval extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//分页模型
		$this->load->model('Paging');
		$this->load->model('Retrieval_Model');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['page'] = is_num($this->input->get('page'));
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{

		$this->data['table_title'] = '投标信息';
		//<><><>管理页面操作(go)
		
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){ $this->Retrieval_Model->del($del_id,'',true); }
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				if(is_num($delID)){ $this->Retrieval_Model->del($delID,'',true); }
			}
		}
		
		//判断搜索
		$keysword = noSql($this->input->post('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(note like '%".$keysword."%' or uid like '%".$keysword."%')";
		}else{
			$keysword = noSql($this->input->get('keysword'));
			if($keysword!=''){
				$keyswordSql = "(note like '%".$keysword."%' or uid like '%".$keysword."%')";
			}
		}
	 
		//<><><>管理页面操作(end)


		//返回相应的sql
		$key_sql = ''; //初始化该变量
		//无分类筛选
		if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
		$listsql = "select * from `retrieval`".$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('user_retrieval/manage',$this->data);
	}
	
	
	
	//投标参加信息
	function election()
	{
		$rid = is_num($this->input->get('rid'),'404');
		
		$this->load->model('Retrieval_election_Model');
		$this->data['table_title'] = '投标参与信息';
		//<><><>管理页面操作(go)
		
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){ $this->Retrieval_election_Model->del($del_id); }
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				if(is_num($delID)){ $this->Retrieval_election_Model->del($delID); }
			}
		}
		
		//判断搜索
		$key_sql = ''; //初始化该变量
		$keysword = noSql($this->input->post('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$key_sql = "(note like '%".$keysword."%' or uid like '%".$keysword."%')";
		}else{
			$keysword = noSql($this->input->get('keysword'));
			if($keysword!=''){
				$key_sql = "(note like '%".$keysword."%' or uid like '%".$keysword."%')";
			}
		}
		if($key_sql!=''){ $key_sql = ' and '.$key_sql; }
		//<><><>管理页面操作(end)
		
		//返回投标信息
		$this->data['view'] = $this->db->query("select * from `retrieval` where id=$rid LIMIT 1")->row();
		
		//返回参与投标相应的sql
		$listsql = "select * from `retrieval_election` where retrievalid=".$rid.$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('user_retrieval/manage_election',$this->data);	
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_feedback extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Feedback_Model');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['table_title'] = '留言反馈';
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
		if($del_id){ $this->Feedback_Model->del($del_id); }
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				if(is_num($delID)){ $this->Feedback_Model->del($delID); }
			}
		}

		//判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(nicename like '%".$keysword."%' or uid like '%".$keysword."%' or qq like '%".$keysword."%')";
		}
		
		
	 
		//<><><>管理页面操作(end)


		//返回相应的sql
		$key_sql = ''; //初始化该变量
		//无分类筛选
		if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
		$listsql = "select * from feedback".$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,10);
		
		$this->load->view_system('user_feedback/manage',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
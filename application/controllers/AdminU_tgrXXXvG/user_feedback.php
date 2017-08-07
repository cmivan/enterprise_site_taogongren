<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_feedback extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Feedback_Model');

		$this->data['table_title'] = '留言反馈';
	}
	
	//管理页面
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		
		//普通删除、数据处理
		$del_id = $this->input->get_or_post('del_id');
		if( is_null($del_id)==FALSE && is_array($del_id) )
		{
			foreach($del_id as $delID)
			{
				if( is_num($delID) )
				{
					$this->Feedback_Model->del($delID);
				}
			}
		}
		elseif( is_num($del_id) )
		{
			$this->Feedback_Model->del($del_id);
		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'nicename'=> $keysword );
			$keylike_on[] = array( 'uid'=> $keysword );
			$keylike_on[] = array( 'qq'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		
		$this->data['keysword'] = $keysword;

		$this->db->from('feedback');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,10);
		
		$this->load->view_system('user_feedback/manage',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
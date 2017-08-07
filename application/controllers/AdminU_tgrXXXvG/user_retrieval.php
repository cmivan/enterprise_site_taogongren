<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_retrieval extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		//分页模型
		$this->load->library('Paging');
		$this->load->model('Retrieval_Model');

		$this->data['page'] = $this->input->getnum('page');
	}
	
	//管理页面
	function index()
	{
		$this->data['table_title'] = '投标信息';

		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
			$this->Retrieval_Model->del($del_id,'',true);
		}
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id))
		{
			foreach($del_id as $delID)
			{
				if(is_num($delID))
				{
					$this->Retrieval_Model->del($delID,'',true);
				}
			}
		}

		//判断搜索
		$keysword = noSql( $this->input->post('keysword') );
		if($keysword == '')
		{
			$keysword = noSql( $this->input->get('keysword') );
		}
		$this->data['keysword'] = $keysword;
		
		if($keysword!='')
		{
			$this->db->like('note',$keysword);
			$this->db->or_like('uid',$keysword);
		}
		
		$this->db->from('retrieval');
		$this->db->order_by('id', 'desc');
		//返回SQL
		$listsql = $this->db->getSQL();

		//获取列表数据
		$this->data["list"] = $this->paging->show( $listsql ,15);
		
		$this->load->view_system('user_retrieval/manage',$this->data);
	}
	
	
	
	//投标参加信息
	function election()
	{
		$rid = $this->input->getnum('rid','404');
		
		$this->load->model('Retrieval_election_Model');
		$this->data['table_title'] = '投标参与信息';
		//<><><>管理页面操作(go)
		
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
			$this->Retrieval_election_Model->del($del_id);
		}
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id))
		{
			foreach($del_id as $delID)
			{
				if( is_num($delID) )
				{
					$this->Retrieval_election_Model->del($delID);
				}
			}
		}

		//返回投标信息
		$this->data['view'] = $this->Retrieval_Model->get_view($rid);
		
		//判断搜索
		$keysword = noSql( $this->input->post('keysword') );
		if($keysword == '')
		{
			$keysword = noSql( $this->input->get('keysword') );
		}
		$this->data['keysword'] = $keysword;
		
		if($keysword!='')
		{
			$this->db->like('note',$keysword);
			$this->db->or_like('uid',$keysword);
		}
		
		//返回参与投标相应的sql
		$this->db->from('retrieval_election');
		$this->db->where('retrievalid', $rid);
		$this->db->order_by('id', 'desc');
		//返回SQL
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		
		$this->load->view_system('user_retrieval/manage_election',$this->data);	
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_approve extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->model('Approve_Model');
		$this->load->model('Introduce_Model');
		
		$this->data['table_title'] = '身份认证';
	}
	
	//管理页面
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		//收支记录模型
		$this->load->model('Records_Model');

		//管理页面操作,更改状态(go)
		$id = $this->input->getnum('id');
		$cmd = $this->input->get('cmd');
		if($cmd!=''&&$id)
		{
			$ok = 0;
			$errtip = '';
			if($cmd=="yes")
			{
				$ok = 1; /*审核通过的信息*/
			}
			elseif($cmd=="no")
			{
				$ok = 2; /*审核不通过的信息*/
				$errtip = noHtml($this->input->get('errtip'));
			}
			if($ok==1 || ( $ok==2 && $errtip!='' ))
			{
				$data['ok'] = $ok;
				$data['errtip'] = $errtip;
				$this->db->where("ok",0);
				$this->db->where("id",$id);
				$this->db->update('yz_sm',$data);
				$this->user_ok($id,$ok);	
			}
		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'truename'=> $keysword );
			$keylike_on[] = array( 'sfz'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		
		$this->data['keysword'] = $keysword;
		$this->data["page"] = $this->input->get('page');
		
		$this->db->from('yz_sm');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,10);
		$this->load->view_system('user_approve/manage',$this->data);
	}
	
	
	
	//修改用户信息，设置为已通过状态
	function user_ok($id=0,$t=0)
	{
		if( is_num($id) && is_num($t) )
		{
			$this->db->select('uid');
			$this->db->from('yz_sm');
			$this->db->where('id',$id);
			$this->db->limit(1);
			$rs = $this->db->get()->row();
			if(!empty($rs))
			{
				$thisuid = $rs->uid;
				if( is_num($thisuid) )
				{
					$this->db->set('approve_sm',$t);
					$this->db->where('id',$thisuid);
					$this->db->update('user');
				}
			}
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
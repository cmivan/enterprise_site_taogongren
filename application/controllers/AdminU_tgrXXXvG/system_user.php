<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_user extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('System_user_Model');

		$this->data['table_title'] = '管理员';
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
					$this->System_user_Model->del($delID);
				}
			}
		}
		elseif( is_num($del_id) )
		{
			$this->System_user_Model->del($del_id);
		}

		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$this->db->like('username',$keysword);
		}
		$this->data['keysword'] = $keysword;
		
		//返回相应的sql
		$this->db->from('km_admin');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();

		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		$this->load->view_system('system_user/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['username'] = '';
		$this->data['password'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->System_user_Model->view($id);
			if(!empty($rs))
			{
				$this->data['username'] = $rs->username;
				$this->data['password'] = '';
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('system_user/edit',$this->data);
	}
	
	
	
	
	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password2= $this->input->post('password2');

		//验证数据
		if($username=='')
		{
			json_form_no('请填写帐号ID!');
		}
		elseif($username!=noSql($username))
		{
			json_form_no('请填写帐号ID可能包含特殊字符!');
		}
		elseif($password=='')
		{
			json_form_no('请填写登录密码!');
		}
		elseif($password!=$password2)
		{
			json_form_no('两次输入的密码不一致!');
		}

		//写入数据
		$data['username'] = $username;
		$data['password'] = pass_system($password);
		$data['addtime'] = dateTime();
		if($id==false)
		{
			//判断帐号ID是否已经存在
			$this->db->from('km_admin');
			$this->db->where('username',$username);
			$rsnum = $this->db->count_all_results();
			if( $rsnum>0 )
			{
				json_form_no('该帐号ID已被使用，请另外再想一个!');
			}
			$this->db->insert('km_admin',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			//判断帐号ID是否已经存在
			$this->db->from('km_admin');
			$this->db->where('id !=',$id);
			$this->db->where('username',$username);
			$rsnum = $this->db->count_all_results();
			if($rsnum>0)
			{
				json_form_no('该帐号ID已被使用，请另外再想一个!');
			}
			$this->db->where('id',$id);
			$this->db->update('km_admin',$data);
			json_form_yes('修改成功!');
		}
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
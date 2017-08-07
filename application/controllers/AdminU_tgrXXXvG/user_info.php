<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_info extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->model('Place_Model');
		$this->load->helper('forms');
		
		$this->data['table_title'] = '工人用户';
	}
	
	//管理页面
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		$this->load->model('Records_Model');

		//普通删除、数据处理
		$del_id = $this->input->get_or_post('del_id');
		if( is_null($del_id)==FALSE && is_array($del_id) )
		{
			foreach($del_id as $delID)
			{
				if( is_num($delID) )
				{
					$this->User_Model->del($delID);
				}
			}
		}
		elseif( is_num($del_id) )
		{
			$this->User_Model->del($del_id);
		}
		
		//获取筛选信息
		$p_id = $this->input->getnum('p_id',0);
		$c_id = $this->input->getnum('c_id',0);
		$a_id = $this->input->getnum('a_id',0);
		
		$this->data['page'] = $this->input->getnum('page',1);
		$this->data['p_id'] = $p_id;
		$this->data['c_id'] = $c_id;
		$this->data['a_id'] = $a_id;

		if($p_id==0)
		{
			$p_id = '';
			$c_id = '';
			$a_id = '';
		}

		//表单select设置
		$b_ps = $this->Place_Model->provinces();
		$this->data['select_p_id'] = cm_form_select('p_id',$b_ps,'p_id','p_name',$p_id);
		$this->data['select_c_id'] = NULL;
		$this->data['select_a_id'] = NULL;
		if($p_id)
		{
			$b_cs = $this->Place_Model->citys($p_id);
			if(!empty($b_cs))
			{
				$this->data['select_c_id'] = cm_form_select('c_id',$b_cs,'c_id','c_name',$c_id);
			}
		}
		if($c_id)
		{
			$b_as = $this->Place_Model->areas($c_id);
			if(!empty($b_as))
			{
				$this->data['select_a_id'] = cm_form_select('a_id',$b_as,'a_id','a_name',$a_id);
			}
		}
		
		
		//地区检索
		if($p_id != false)
		{
			$this->db->where('p_id',$p_id);
		}
		if($c_id != false)
		{
			$this->db->where('c_id',$c_id);
		}
		if($a_id != false)
		{
			$this->db->where('a_id',$a_id);
		}
			
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'name'=> $keysword );
			$keylike_on[] = array( 'truename'=> $keysword );
			$keylike_on[] = array( 'id'=> $keysword );
			$keylike_on[] = array( 'mobile'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		$this->data['keysword'] = $keysword;
		
		//返回相应的sql (classid=0 表示工人)
		$this->db->select('id,uid,name,truename,p_id,c_id,a_id,addtime');
		$this->db->from('user');	
		$this->db->where('classid',0);
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();

		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,20);
		//样式
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		
		$this->load->view_system('user_info/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['sex'] = 0;
		$this->data['name'] = '';
		$this->data['mobile'] = '';
		$this->data['email'] = '';
		$entry_age = 0;
		$this->data['qq'] = '';
		$this->data['address'] = '';
		$this->data['note'] = '';
		$this->data['truename'] = '';
		$this->data['note'] = '';
		
		$p_id = 0;
		$c_id = 0;
		$a_id = 0;
		$b_p_id = 0;
		$b_c_id = 0;
		$b_a_id = 0;

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->User_Model->info($id);
			if(!empty($rs))
			{
				$this->data['sex'] = $rs->sex;
				$this->data['name'] = $rs->name;
				$this->data['mobile'] = $rs->mobile;
				$this->data['email'] = $rs->email;
				$entry_age = $rs->entry_age;
				$this->data['qq'] = $rs->qq;
				$this->data['address'] = $rs->address;
				$this->data['truename'] = $rs->truename;
				$this->data['note'] = $rs->note;
				$p_id = $rs->p_id;
				$c_id = $rs->c_id;
				$a_id = $rs->a_id;
				$b_p_id = $rs->b_p_id;
				$b_c_id = $rs->b_c_id;
				$b_a_id = $rs->b_a_id;
			}
		}

		$this->data['select_entry_age'] = cm_form_select('entry_age',$this->User_Model->age_class(),'id','title',$entry_age);
		
		$b_ps = $this->Place_Model->provinces();
		$b_cs = $this->Place_Model->citys($p_id);
		$b_as = $this->Place_Model->areas($c_id);
		
		$b_ps_2 = $this->Place_Model->provinces();
		$b_cs_2 = $this->Place_Model->citys($b_p_id);
		$b_as_2 = $this->Place_Model->areas($b_c_id);
		
		$style = ' disabled style="width:74px;"';
		//表单select设置
		$this->data['select_b_p_id'] = cm_form_select('b_p_id',$b_ps_2,'p_id','p_name',$b_p_id,$style);
		$this->data['select_b_c_id'] = cm_form_select('b_c_id',$b_cs_2,'c_id','c_name',$b_c_id,$style);
		$this->data['select_b_a_id'] = cm_form_select('b_a_id',$b_as_2,'a_id','a_name',$b_a_id,$style);
		//表单select2设置
		$this->data['select_p_id'] = cm_form_select('p_id',$b_ps,'p_id','p_name',$p_id,$style);
		$this->data['select_c_id'] = cm_form_select('c_id',$b_cs,'c_id','c_name',$c_id,$style);
		$this->data['select_a_id'] = cm_form_select('a_id',$b_as,'a_id','a_name',$a_id,$style);
		//样式
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('user_info/edit',$this->data);
	}
	
	
	
	
	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		
		$data['name'] = noHtml($this->input->post('name'));
		$mobile = $this->input->postnum('mobile');
		$data['sex'] = $this->input->postnum('sex',0);
		$data['email'] = $this->input->post('email');
		$data['entry_age'] = $this->input->postnum('entry_age',0);
		$data['qq'] = $this->input->postnum('qq',0);
		$data['address'] = noHtml($this->input->post('address'));
		$data['note'] = noHtml($this->input->post('note'));
		$data['truename'] = noHtml($this->input->post('truename'));
		
		$data['p_id'] = $this->input->postnum('p_id',0);
		$data['c_id'] = $this->input->postnum('c_id',0);
		$data['a_id'] = $this->input->postnum('a_id',0);
		$data['b_p_id'] = $this->input->postnum('b_p_id',0);
		$data['b_c_id'] = $this->input->postnum('b_c_id',0);
		$data['b_a_id'] = $this->input->postnum('b_a_id',0);
		$data['classid'] = 0; //工人

		//验证数据
		if($data['name']=='')
		{
			json_form_no('请填写昵称!');
		}

		//写入数据
		if($id==false)
		{
			//只能添加，不能修改用户手机号
			$data['mobile'] = $mobile;
			if($mobile==false)
			{
				json_form_no('请填写正确的用户手机号!');
			}
			
			//判断该手机号是否已经被添加
			$this->db->select('id');
			$this->db->from('user');
			$this->db->where('mobile', $mobile);
			$this->db->limit(0);
			if( $this->db->count_all_resluts() > 0 )
			{
				json_form_no('操作失败，该手机号已经注册或录入！');
			}
			
			//添加,初始化密码
			$password = mb_substr($mobile,strlen($mobile)-6,strlen($mobile),'utf-8');
			if(strlen($password)!=6)
			{
				json_form_no('初始密码长度不正确!');
			}
			$data['password'] = pass_user($password);
			
			$this->db->insert('user',$data);
			json_form_yes('录入成功!');
		}
		else
		{
			//更新用户信息
			$this->db->where('id',$id);
			$this->db->update('user',$data);
			json_form_yes('更新成功!');
		}
		
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
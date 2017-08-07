<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_unions extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Unions_Model');

		$this->data['table_title'] = '淘工会';
		//获取分类
		$this->data['this_types'] = $this->Unions_Model->get_types();
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
					$this->Unions_Model->del($delID);
				}
			}
		}
		elseif( is_num($del_id) )
		{
			$this->Unions_Model->del($del_id);
		}
		
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'title'=> $keysword );
			$keylike_on[] = array( 'content'=> $keysword );
			$this->db->like_on($keylike_on);
			//(title like '%".$keysword."%' or content like '%".$keysword."%');
		}

		//获取分类
		$type_id = $this->input->getnum('type_id');
		if( $type_id )
		{
			$this->db->where('type_id',$type_id);
		}
		
		$this->data['keysword'] = $keysword;
		$this->data['type_id'] = $type_id;

		$this->db->from('unions');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();

		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		
		$this->load->view_system('page_unions/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		$this->load->library('kindeditor');

		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';
		$this->data['type_id'] = '';
		$this->data['content'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Unions_Model->view($id);
			if(!empty($rs))
			{
				$this->data['title'] = $rs->title;
				$this->data['type_id'] = $rs->type_id;
				$this->data['content'] = $rs->content;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('page_unions/edit',$this->data);
	}
	
	
	
	
	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$title = noSql($this->input->post('title'));
		//$come = noSql($this->input->post('come'));
		$content = $this->input->post('content');
		$type_id = $this->input->postnum('type_id');
		//$description = noSql($this->input->post('description'));
		//$recommen = noSql($this->input->post('recommen'));
		//$popular = noSql($this->input->post('popular'));
		
		//验证数据
		if($title=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($type_id==false)
		{
			json_form_no('请选择分类!');
		}
		elseif($content=='')
		{
			json_form_no('请填写内容!');
		}
		
		//写入数据
		$data['title'] = $title;
		$data['type_id'] = $type_id;
		$data['content'] = $content;
		
		if($id==false)
		{
			$data['time'] = dateTime();
			$this->db->insert('unions',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('unions',$data);
			json_form_yes('修改成功!');
		}
	}
	
	
	
	
	
	//分类页面
	function type()
	{
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if($del_id)
		{
			$this->Unions_Model->del_type($del_id);
			//重新获取分类
			$this->data['this_types'] = $this->Unions_Model->get_types();
		}

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$type_id = $this->input->postnum('type_id');
			
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($type_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Unions_Model->get_type($type_id);
			if(!empty($row))
			{
				//执行重新排序
				$this->load->helper('publicedit');
				$keys = array(
					  'table' => 'unions_type',
					  'key'  => 't_id',
					  'okey' => 't_order_id',
					  'id'   => $row->t_id,
					  'oid'  => $row->t_order_id,
					  'type' => $cmd
					  );
				List_Re_Order($keys);			}	
		}
		
		
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/type';
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('page_unions/type_manage',$this->data);
	}
	
	function type_edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['t_id'] = $id;
		$this->data['t_title'] = '';
		$this->data['t_order_id'] = 0;

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Unions_Model->get_type($id);
			if(!empty($rs))
			{
				$this->data['t_title'] = $rs->t_title;
				$this->data['t_order_id'] = $rs->t_order_id;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/type_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/type';
		
		$this->load->view_system('page_unions/type_edit',$this->data);
	}
	
	
	//保存分类
	function type_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('t_id');
		$t_title = noSql($this->input->post('t_title'));
		$t_order_id = $this->input->postnum('t_order_id');

		//验证数据
		if($t_title=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($t_order_id==false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		
		//写入数据
		$data['t_title'] = $t_title;
		$data['t_order_id'] = $t_order_id;
		
		if($id==false)
		{
			//添加
			$this->db->insert('unions_type',$data);
			//重洗分类排序
			$this->re_order_type();
			json_form_yes('添加成功!');
		}
		else
		{
			//修改
			$this->db->where('t_id',$id);
			$this->db->update('unions_type',$data);
			//重洗分类排序
			$this->re_order_type();
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_type()
	{
		$re_row = $this->Unions_Model->get_types();
		if(!empty($re_row))
		{
			$re_num = $this->Unions_Model->get_types_num();
			foreach($re_row as $re_rs)
			{
				$data['t_order_id'] = $re_num;
				$this->db->where('t_id',$re_rs->t_id);
				$this->db->update('unions_type',$data);
				$re_num--;
			}
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
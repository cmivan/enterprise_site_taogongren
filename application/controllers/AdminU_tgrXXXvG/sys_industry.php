<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_industry extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Industry_Model');

	}
	
	
	function index()
	{
		$this->industrys_manage();
	}
	
	
	//工种管理页面
	function industrys_manage()
	{
		$this->data['table_title'] = '项目工种';
		
		//分页模型
		$this->load->library('Paging');
		
		//管理页面操作
		$this->data['edit_tip'] = ''; //操作提示
		
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if($del_id)
		{
			$industryes_num = $this->Industry_Model->industryes_num($del_id);
			if($industryes_num<=0)
			{
				$this->Industry_Model->industrys_del($del_id);
			}
			else
			{
				$this->data['edit_tip'] = '<br />【'.$this->Industry_Model->industryes_name($del_id).'】下还有 <strong>';	
				$this->data['edit_tip'].= $industryes_num.'</strong> 个技能项目,因此不能删除!';	
			}
		}
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id))
		{
			foreach($del_id as $delID)
			{
				$industryes_num = $this->Industry_Model->industryes_num($delID);
				if($industryes_num<=0)
				{
					$this->Industry_Model->industrys_del($delID);
				}
				else
				{
					$this->data['edit_tip'] = '<br />【'.$this->Industry_Model->industryes_name($delID).'】下还有 <strong>';	
					$this->data['edit_tip'].= $industryes_num.'</strong> 个技能项目,因此不能删除!';	
				}
			}
		}
		
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'title'=> $keysword );
			$keylike_on[] = array( 'id'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		$this->data['keysword'] = $keysword;
		
		$this->db->select('id,title');
		$this->db->from('industry');
		$this->db->where('industryid',0);
		$this->db->order_by('id','asc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		
		$this->load->view_system('sys_industry/industrys_manage',$this->data);
	}
	
	
	
	
	//工种添加编辑页面
	function industrys_edit()
	{
		$this->data['table_title'] = '项目工种';
		
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Industry_Model->industryes_view($id);
			if(!empty($rs))
			{
				$this->data['title'] = $rs->title;
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/industrys_edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/industrys_manage';

		$this->load->view_system('sys_industry/industrys_edit',$this->data);
	}
	
	
	
	
	//工种提交保存
	function industrys_edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$title = $this->input->post('title');

		//验证数据
		if($title=='')
		{
			json_form_no('请填写工种名称!');
		}
		
		//写入数据
		$data['title'] = $title;
		if($id==false)
		{
			$this->db->insert('industry',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->where('industryid','0');
			$this->db->update('industry',$data);
			json_form_yes('修改成功!');
		}
	}




	//技能项目管理页面
	function industry_manage()
	{
		$this->data['table_title'] = '技能项目';
		//分页模型
		$this->load->library('Paging');
		$this->load->model('Skills_Model');

		//管理页面操作(go)
		$this->data['edit_tip'] = ''; //操作提示
		
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if($del_id)
		{
			$skills_user_num = $this->Skills_Model->skills_user_num($del_id);
			if($skills_user_num<=0)
			{
				//参数1是指删除非工种类项目
				$this->Industry_Model->industrys_del($del_id,1);
			}
			else
			{
				$this->data['edit_tip'] = '<br />技能【'.$this->Industry_Model->industryes_name($del_id).'】下还有 <strong>';	
				$this->data['edit_tip'].= $industryes_num.'</strong> 人在使用,因此不能删除!';	
			}
		}
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id))
		{
			foreach($del_id as $delID)
			{
				$skills_user_num = $this->Skills_Model->skills_user_num($delID);
				if($skills_user_num<=0)
				{
					$this->Industry_Model->industrys_del($delID,1);
				}
				else
				{
					$this->data['edit_tip'] = '<br />技能【'.$this->Industry_Model->industryes_name($delID).'】下还有 <strong>';	
					$this->data['edit_tip'].= $industryes_num.'</strong> 人在使用,因此不能删除!';	
				}
			}
		}


		//获取工种以及选中的ID
		$industryid = $this->input->getnum('industryid');
		$this->data['industryid'] = $industryid;
		$this->data["this_types"] = $this->Industry_Model->industrys();
		//获取工种分类以及选中的ID
		$classid = $this->input->getnum('classid');
		$this->data['classid'] = $classid;
		$this->data["this_class"] = $this->Industry_Model->industry_class();

		if($industryid)
		{
			$this->db->where('industryid',$industryid);
		}
		if($classid)
		{
			$this->db->where('classid',$classid);
		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'title'=> $keysword );
			$keylike_on[] = array( 'id'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		$this->data['keysword'] = $keysword;

		//返回相应的sql
		$this->db->select('id,title');
		$this->db->from('industry');
		$this->db->where('industryid !=',0);
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		
		$this->load->view_system('sys_industry/industry_manage',$this->data);
	}
	
	
	
	
	//技能项目添加编辑页面
	function industry_edit()
	{
		//加载form辅助类
		$this->load->helper('forms');
		$this->data['table_title'] = '技能项目';
		
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['classid'] = '';
		$this->data['industryid'] = '';
		$this->data['title'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			//获取非工种 项目
			$rs = $this->Industry_Model->industryes_view($id,1);
			if(!empty($rs))
			{
				$this->data['classid'] = $rs->classid;
				$this->data['industryid'] = $rs->industryid;
				$this->data['title'] = $rs->title;
			}
		}
		
		//获取工种分类
		$this_class = $this->Industry_Model->industry_class();
		//获取工种
		$this_types = $this->Industry_Model->industrys();
		
		//表单select设置
		$this->data['select_classid'] = cm_form_select('classid',$this_class,'id','title',$this->data['classid']);
		$this->data['select_industryid'] = cm_form_select('industryid',$this_types,'id','title',$this->data['industryid']);

		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/industry_edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/industry_manage';

		$this->load->view_system('sys_industry/industry_edit',$this->data);
	}
	
	
	
	
	//技能项目提交保存
	function industry_edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$classid = $this->input->postnum('classid');
		$industryid = $this->input->postnum('industryid');
		$title = $this->input->post('title');

		//验证数据
		if($classid==false)
		{
			json_form_no('请选择工种分类!');
		}
		elseif($industryid==false)
		{
			json_form_no('请选择该技能项目所属的工种!');
		}
		elseif($title=='')
		{
			json_form_no('请填写技能项目名称!');
		}
		
		//写入数据
		$data['classid'] = $classid;
		$data['industryid'] = $industryid;
		$data['title'] = $title;
				
		if($id==false)
		{
			$this->db->insert('industry',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->where('industryid !=','0');
			$this->db->update('industry',$data);
			json_form_yes('修改成功!');
		}
	}




}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
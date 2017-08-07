<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_industry extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Industry_Model');
		
		//基础数据
		$this->data  = $this->basedata();
	}
	
	
	function index()
	{
		$this->industrys_manage();
	}
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 工种管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function industrys_manage()
	{
		$this->data['table_title'] = '项目工种';
		//分页模型
		$this->load->model('Paging');
		
		//<><><>管理页面操作(go)
		
		$this->data['edit_tip'] = ''; //操作提示
		
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){
			$industryes_num = $this->Industry_Model->industryes_num($del_id);
			if($industryes_num<=0){
				$this->Industry_Model->industrys_del($del_id);
			}else{
				$this->data['edit_tip'] = '<br />【'.$this->Industry_Model->industryes_name($del_id).'】下还有 <strong>'.$industryes_num.'</strong> 个技能项目,故不能删除!';	
			}
		}
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				$industryes_num = $this->Industry_Model->industryes_num($delID);
				if($industryes_num<=0){
					$this->Industry_Model->industrys_del($delID);
				}else{
					$this->data['edit_tip'].= '<br />【'.$this->Industry_Model->industryes_name($delID).'】下还有 <strong>'.$industryes_num.'</strong> 个技能项目,故不能删除!';
				}
			}
		}

		
		//判断搜索
		$key_sql = '';
		$keysword = noSql($this->input->post('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$key_sql = " and (title like '%".$keysword."%' or id like '%".$keysword."%')";
		}else{
			$keysword = noSql($this->input->get('keysword'));
			if($keysword!=''){
				$key_sql = " and (title like '%".$keysword."%' or id like '%".$keysword."%')";
			}
		}
		//<><><>管理页面操作(end)


		//返回相应的sql
		$listsql = "select id,title from `industry` where industryid=0".$key_sql.' order by id asc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('sys_industry/industrys_manage',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 工种添加编辑页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function industrys_edit()
	{
		$this->data['table_title'] = '项目工种';
		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Industry_Model->industryes_view($id);
			if(!empty($rs)){
				$this->data['title'] = $rs->title;
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/industrys_edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/industrys_manage';

		$this->load->view_system('sys_industry/industrys_edit',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 工种提交保存 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function industrys_edit_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$title = noSql($this->input->post('title'));

		//验证数据
		if($title==''){ json_form_no('请填写工种名称!'); }
		
		//写入数据
		$data['title'] = $title;
		if($id==false){
			//添加
			$this->db->insert('industry',$data);
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->where('industryid','0');
			$this->db->update('industry',$data);
			json_form_yes('修改成功!');
		}
	}




//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@





	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 技能项目管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function industry_manage()
	{
		$this->data['table_title'] = '技能项目';
		//分页模型
		$this->load->model('Paging');
		$this->load->model('Skills_Model');
		
		
		//<><><>管理页面操作(go)
		
		$this->data['edit_tip'] = ''; //操作提示
		
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){
			$skills_user_num = $this->Skills_Model->skills_user_num($del_id);
			if($skills_user_num<=0){
				$this->Industry_Model->industrys_del($del_id,1); //参数1是指删除非工种类项目
			}else{
				$this->data['edit_tip'] = '<br />技能【'.$this->Industry_Model->industryes_name($del_id).'】下还有 <strong>'.$skills_user_num.'</strong> 人在使用,故不能删除!';	
			}
		}
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				$skills_user_num = $this->Skills_Model->skills_user_num($delID);
				if($skills_user_num<=0){
					$this->Industry_Model->industrys_del($delID,1);
				}else{
					$this->data['edit_tip'].= '<br />技能【'.$this->Industry_Model->industryes_name($delID).'】下还有 <strong>'.$skills_user_num.'</strong> 人在使用,故不能删除!';
				}
			}
		}

		//判断搜索
		$key_sql = '';
		$keysword = noSql($this->input->post('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$key_sql = " and (title like '%".$keysword."%' or id like '%".$keysword."%')";
		}else{
			$keysword = noSql($this->input->get('keysword'));
			if($keysword!=''){
				$key_sql = " and (title like '%".$keysword."%' or id like '%".$keysword."%')";
			}
		}

		//获取工种以及选中的ID
		$industryid = is_num($this->input->get('industryid'));
		$this->data['industryid'] = $industryid;
		$this->data["this_types"] = $this->Industry_Model->industrys();
		//获取工种分类以及选中的ID
		$classid = is_num($this->input->get('classid'));
		$this->data['classid'] = $classid;
		$this->data["this_class"] = $this->Industry_Model->industry_class();
		
		if($industryid){ $key_sql.= ' and industryid='.$industryid; }
		if($classid){ $key_sql.= ' and classid='.$classid; }

		//返回相应的sql
		$listsql = "select id,title from `industry` where industryid<>0".$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('sys_industry/industry_manage',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 技能项目添加编辑页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function industry_edit()
	{
		//加载form辅助类
		$this->load->helper('forms');
		$this->data['table_title'] = '技能项目';
		
		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['classid'] = '';
		$this->data['industryid'] = '';
		$this->data['title'] = '';

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Industry_Model->industryes_view($id,1); //获取非工种 项目
			if(!empty($rs)){
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
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 技能项目提交保存 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function industry_edit_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$classid = is_num($this->input->post('classid'));
		$industryid = is_num($this->input->post('industryid'));
		$title = noSql($this->input->post('title'));

		//验证数据
		if($classid==false){ json_form_no('请选择工种分类!'); }
		if($industryid==false){ json_form_no('请选择该技能项目所属的工种!'); }
		if($title==''){ json_form_no('请填写技能项目名称!'); }
		
		//写入数据
		$data['classid'] = $classid;
		$data['industryid'] = $industryid;
		$data['title'] = $title;
				
		if($id==false){
			//添加
			$this->db->insert('industry',$data);
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->where('industryid !=','0');
			$this->db->update('industry',$data);
			json_form_yes('修改成功!');
		}
	}




}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
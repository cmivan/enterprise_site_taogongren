<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_province extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->helper('forms');
		
		$this->load->model('Place_Model');

		$this->data['table_title'] = '省份';
		//获取分类
		$this->data['place_regions'] = $this->Place_Model->regions();
	}
	
	//省份管理页面
	function index()
	{
		//普通删除、数据处理
		//{暂时不写删除省份功能 by cmivan}
		
		//获取区域ID
		$r_id = $this->input->getnum('r_id');
		$this->data['r_id'] = $r_id;
		$this->data['place_provinces'] = $this->Place_Model->provinces($r_id);

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$p_id = $this->input->postnum('p_id');
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($p_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Place_Model->province($p_id);
			if(!empty($row))
			{
				//获取当前基本信息
				$at_p_id = get_num($row->p_id);
				$at_order_id = get_num($row->order_id);
				
				//执行重新排序
				$this->load->helper('publicedit');
				$keys = array(
					  'table' => 'place_province',
					  'key'  => 'p_id',
					  'okey' => 'order_id',
					  'id'   => $at_p_id,
					  'oid'  => $at_order_id,
					  'type' => $cmd
					  );
				List_Re_Order($keys);
			}	
		}
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"];
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_place/province_manage',$this->data);
	}
	
	function province_edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['r_id'] = 0;
		$this->data['p_id'] = $id;
		$this->data['p_name'] = '';
		$this->data['order_id'] = 1;

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Place_Model->province($id);
			if(!empty($rs))
			{
				$this->data['r_id'] = $rs->r_id;
				$this->data['p_name'] = $rs->p_name;
				$this->data['order_id'] = $rs->order_id;
			}
		}
		
		//获取区域
		$place_regions = $this->data['place_regions'];
		//表单select设置
		$this->data['select_r_id'] = cm_form_select('r_id',$place_regions,'r_id','r_name',$this->data['r_id']);
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/province_edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];
		
		$this->load->view_system('sys_place/province_edit',$this->data);
	}
	
	
	//保存分类
	function province_edit_save()
	{
		//接收提交来的数据
		$r_id = $this->input->postnum('r_id');
		$p_id = $this->input->postnum('p_id');
		$p_name = noSql($this->input->post('p_name'));
		$order_id = $this->input->postnum('order_id');

		//验证数据
		if($r_id==false)
		{
			json_form_no('请选择区域ID!');
		}
		elseif($p_name=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($order_id==false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		
		//写入数据
		$data['r_id'] = $r_id;
		$data['p_name'] = $p_name;
		$data['order_id'] = $order_id;
		
		if($p_id==false)
		{
			$this->db->insert('place_province',$data);
			//重洗分类排序
			$this->re_order_province();
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('p_id',$p_id);
			$this->db->update('place_province',$data);
			//重洗分类排序
			$this->re_order_province();
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_province()
	{
		$re_row = $this->Place_Model->provinces();
		if(!empty($re_row))
		{
			$re_num = $this->Place_Model->province_num();
			foreach($re_row as $re_rs)
			{
				$data['order_id'] = $re_num;
				$this->db->where('p_id',$re_rs->p_id);
				$this->db->update('place_province',$data);
				$re_num--;
			}
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
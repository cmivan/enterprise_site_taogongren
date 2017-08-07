<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_area extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->helper('forms');

		$this->data['table_title'] = '地区';
	}
	
	//省份管理页面
	function index()
	{
		//普通删除、数据处理
		//{暂时不写删除省份功能 by cmivan}

		//获取区域ID
		$c_id = $this->input->get_or_post('c_id');
		if( is_num($c_id)==false )
		{
			json_form_no('参数丢失,本次操作无效!');
		}
		
		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$a_id = $this->input->postnum('a_id');
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($a_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Place_Model->area($a_id);
			if(!empty($row))
			{
				//获取当前基本信息
				$at_a_id = get_num($row->a_id);
				$at_order_id = get_num($row->order_id,0);
				
				//执行重新排序
				$this->load->helper('publicedit');
				$keys = array(
					  'table' => 'place_area',
					  'key'  => 'a_id',
					  'okey' => 'order_id',
					  'where' => array('c_id'=>$c_id),
					  'id'   => $at_a_id,
					  'oid'  => $at_order_id,
					  'type' => $cmd
					  /*, 'order_type' => 'ASC',*/
					  );
				List_Re_Order($keys);
			}	
		}

		$this->data['c_id'] = $c_id;
		$this->data['place_area'] = $this->Place_Model->areas($c_id);
		//获取当前省份的信息
		$this->data['c_name'] = '';
		$city = $this->Place_Model->city($c_id);
		if(!empty($city))
		{
			$this->data['c_name'] = $city->c_name;
		}

		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"];
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_place/area_manage',$this->data);
	}
	
	function area_edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$p_id = $this->input->getnum('p_id',0);
		$c_id = $this->input->getnum('c_id',0);
		if($p_id==0)
		{
			$p_id = $this->Place_Model->provinceid();
			$c_id = 0;
		}
		$b_ps = $this->Place_Model->provinces();
		$b_cs = $this->Place_Model->citys($p_id);

		$this->data['a_id'] = $id;
		$this->data['a_name'] = '';
		$this->data['order_id'] = 1;

		if($id==false)
		{
			$this->data['action_name'] = "添加";
			$b_cs = $this->Place_Model->citys($p_id);
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Place_Model->area($id);
			if(!empty($rs))
			{
				$p_id = $rs->p_id;
				$c_id = $rs->c_id;
				$this->data['a_name'] = $rs->a_name;
				$this->data['order_id'] = $rs->order_id;
				$b_cs = $this->Place_Model->citys($rs->p_id);
			}
		}

		//表单select设置
		$this->data['select_p_id'] = cm_form_select('p_id',$b_ps,'p_id','p_name',$p_id);
		$this->data['select_c_id'] = cm_form_select('c_id',$b_cs,'c_id','c_name',$c_id);
		
		//样式
		$this->data['jsfiles'][] = 'js/city_select_option.js';
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/area_edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];
		
		$this->load->view_system('sys_place/area_edit',$this->data);
	}
	
	
	//保存分类
	function area_edit_save()
	{
		//接收提交来的数据
		$p_id = $this->input->postnum('p_id');
		$c_id = $this->input->postnum('c_id');
		$a_id = $this->input->postnum('a_id');
		$a_name = $this->input->post('a_name');
		$order_id = $this->input->postnum('order_id');
		
		//验证数据
		if($p_id==false)
		{
			json_form_no('请选择所属省份!');
		}
		elseif($c_id==false)
		{
			json_form_no('请选择所属城市!');
		}
		elseif($a_name=='')
		{
			json_form_no('请填写地区名称!');
		}
		elseif($order_id==false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		
		//写入数据
		$data['p_id'] = $p_id;
		$data['c_id'] = $c_id;
		$data['a_name'] = $a_name;
		$data['order_id'] = $order_id;
		
		if($a_id==false)
		{
			$this->db->insert('place_area',$data);
			//重洗分类排序
			$this->re_order_area($c_id);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('a_id',$a_id);
			$this->db->update('place_area',$data);
			//重洗分类排序
			$this->re_order_area($c_id);
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_area($c_id=0)
	{
		$re_row = $this->Place_Model->areas($c_id);
		if(!empty($re_row))
		{
			$re_num = $this->Place_Model->city2area_num($c_id); 
			foreach($re_row as $re_rs)
			{
				$data['order_id'] = $re_num;
				$this->db->where('a_id',$re_rs->a_id);
				$this->db->update('place_area',$data);
				$re_num--;
			}
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
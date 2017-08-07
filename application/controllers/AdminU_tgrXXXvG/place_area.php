<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_area extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->helper('forms');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['table_title'] = '地区';
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 省份管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{
		//普通删除、数据处理
		//{暂时不写删除省份功能 by cmivan}

		//获取区域ID
		$c_id = is_num($this->input->get('c_id'));
		if($c_id==false){ $c_id = is_num($this->input->post('c_id')); }
		if($c_id==false){ json_form_no('参数丢失,本次操作无效!'); }


		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes'){
			$cmd = $this->input->post('cmd');
			$a_id = is_num($this->input->post('a_id'));
			if($cmd==''){ json_form_no('未知操作!'); }
			if($a_id==false){ json_form_no('参数丢失,本次操作无效!'); }
			$row = $this->db->query('select * from place_area where c_id='.$c_id.' and a_id='.$a_id)->row();
			if(!empty($row)){
				//获取当前基本信息
				$at_a_id = is_num($row->a_id);
				$at_order_id = is_num($row->order_id,0);
				//执行重新排序
				if($cmd=="up"){
					$row_up = $this->db->query('select * from place_area where c_id='.$c_id.' and order_id>'.$at_order_id.' order by order_id asc')->row();
					if(!empty($row_up)){
						$up_a_id = $row_up->a_id;
						$up_order_id = $row_up->order_id;
						$this->db->query("update place_area set order_id=$at_order_id where a_id=$up_a_id");
						$this->db->query("update place_area set order_id=$up_order_id where a_id=$at_a_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到上限!');
					}
				}elseif($cmd=="down"){
					$row_down = $this->db->query('select * from place_area where c_id='.$c_id.' and order_id<'.$at_order_id.' order by order_id desc')->row();
					if(!empty($row_down)){
						$down_a_id = $row_down->a_id;
						$down_order_id = is_num($row_down->order_id,0);
						$this->db->query("update place_area set order_id=$at_order_id where a_id=$down_a_id");
						$this->db->query("update place_area set order_id=$down_order_id where a_id=$at_a_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到下限!');
					}
				}
			}	
		}
		
		
		$this->data['c_id'] = $c_id;
		$this->data['place_area'] = $this->Place->areas($c_id);
		//获取当前省份的信息
		$city = $this->Place->city($c_id);
		if(!empty($city)){
			$this->data['c_name'] = $city->c_name;
		}else{
			$this->data['c_name'] = '';
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
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$p_id = is_num($this->input->get('p_id'),0);
		$c_id = is_num($this->input->get('c_id'),0);
		if($p_id==0){
			$p_id = $this->Place->provinceid();
			$c_id = 0;
			}
		$b_ps = $this->Place->provinces();
		$b_cs = $this->Place->citys($p_id);

		$this->data['a_id'] = $id;
		$this->data['a_name'] = '';
		$this->data['order_id'] = 1;

		if($id==false){
			$this->data['action_name'] = "添加";
			$b_cs = $this->Place->citys($p_id);
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Place->area($id);
			if(!empty($rs)){
				$p_id = $rs->p_id;
				$c_id = $rs->c_id;
				$this->data['a_name'] = $rs->a_name;
				$this->data['order_id'] = $rs->order_id;
				$b_cs = $this->Place->citys($rs->p_id);
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
		$p_id = is_num($this->input->post('p_id'));
		$c_id = is_num($this->input->post('c_id'));
		$a_id = is_num($this->input->post('a_id'));
		$a_name = noSql($this->input->post('a_name'));
		$order_id = is_num($this->input->post('order_id'));
		
		//验证数据
		if($p_id==false){ json_form_no('请选择所属省份!'); }
		if($c_id==false){ json_form_no('请选择所属城市!'); }
		if($a_name==''){ json_form_no('请填写地区名称!'); }
		if($order_id==false){ json_form_no('请在排序处填写正整数!'); }
		
		//写入数据
		$data['p_id'] = $p_id;
		$data['c_id'] = $c_id;
		$data['a_name'] = $a_name;
		$data['order_id'] = $order_id;
		
		if($a_id==false){
			//添加
			$this->db->insert('place_area',$data);
			
			//重洗分类排序
			$this->re_order_area($c_id);
			json_form_yes('添加成功!');
		}else{
			//修改
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
		$re_row = $this->Place->areas($c_id);
		if(!empty($re_row))
		{
			$re_num = $this->db->query('select a_id from place_area where c_id='.$c_id)->num_rows();
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
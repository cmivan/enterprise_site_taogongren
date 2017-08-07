<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_city extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->helper('forms');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['table_title'] = '城市';
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 省份管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{
		//普通删除、数据处理
		//{暂时不写删除省份功能 by cmivan}

		//获取区域ID
		$p_id = is_num($this->input->get('p_id'));
		if($p_id==false){ $p_id = is_num($this->input->post('p_id')); }
		if($p_id==false){ json_form_no('参数丢失,本次操作无效!'); }

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes'){
			$cmd = $this->input->post('cmd');
			$c_id = is_num($this->input->post('c_id'));
			if($cmd==''){ json_form_no('未知操作!'); }
			if($c_id==''){ json_form_no('参数丢失,本次操作无效!'); }
			$row = $this->db->query('select * from place_city where p_id='.$p_id.' and c_id='.$c_id)->row();
			if(!empty($row)){
				//获取当前基本信息
				$at_c_id = is_num($row->c_id);
				$at_order_id = is_num($row->order_id);
				//执行重新排序
				if($cmd=="up"){
					$row_up = $this->db->query('select * from place_city where p_id='.$p_id.' and order_id>'.$at_order_id.' order by order_id asc')->row();
					if(!empty($row_up)){
						$up_c_id = $row_up->c_id;
						$up_order_id = $row_up->order_id;
						$this->db->query("update place_city set order_id=$at_order_id where c_id=$up_c_id");
						$this->db->query("update place_city set order_id=$up_order_id where c_id=$at_c_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到上限!');
					}
				}elseif($cmd=="down"){
					$row_down = $this->db->query('select * from place_city where p_id='.$p_id.' and order_id<'.$at_order_id.' order by order_id desc')->row();
					if(!empty($row_down)){
						$down_c_id = $row_down->c_id;
						$down_order_id = $row_down->order_id;
						$this->db->query("update place_city set order_id=$at_order_id where c_id=$down_c_id");
						$this->db->query("update place_city set order_id=$down_order_id where c_id=$at_c_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到下限!');
					}
				}
			}	
		}
		
		
		$this->data['p_id'] = $p_id;
		$this->data['place_city'] = $this->Place->citys($p_id);
		//获取当前省份的信息
		$province = $this->Place->province($p_id);
		if(!empty($province)){
			$this->data['p_name'] = $province->p_name;
		}else{
			$this->data['p_name'] = '';
		}

		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"];
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_place/city_manage',$this->data);
	}
	
	function city_edit()
	{
		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['p_id'] = 0;
		$this->data['c_id'] = $id;
		$this->data['c_name'] = '';
		$this->data['order_id'] = 1;

		if($id==false){
			$this->data['p_id'] = is_num($this->input->get('p_id'));
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Place->city($id);
			if(!empty($rs)){
				$this->data['p_id'] = $rs->p_id;
				$this->data['c_name'] = $rs->c_name;
				$this->data['order_id'] = $rs->order_id;
			}
		}
		
		//获取区域
		$place_provinces = $this->Place->provinces();
		//表单select设置
		$this->data['select_p_id'] = cm_form_select('p_id',$place_provinces,'p_id','p_name',$this->data['p_id']);
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/city_edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];
		
		$this->load->view_system('sys_place/city_edit',$this->data);
	}
	
	
	//保存分类
	function city_edit_save()
	{
		//接收提交来的数据
		$p_id = is_num($this->input->post('p_id'));
		$c_id = is_num($this->input->post('c_id'));
		$c_name = noSql($this->input->post('c_name'));
		$order_id = is_num($this->input->post('order_id'));
		
		//验证数据
		if($p_id==false){ json_form_no('请选择所属省份!'); }
		if($c_name==''){ json_form_no('请填写城市名称!'); }
		if($order_id==false){ json_form_no('请在排序处填写正整数!'); }
		
		//写入数据
		$data['p_id'] = $p_id;
		$data['c_name'] = $c_name;
		$data['order_id'] = $order_id;
		
		if($c_id==false){
			//添加
			$this->db->insert('place_city',$data);
			
			//重洗分类排序
			$this->re_order_city($p_id);
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('c_id',$c_id);
			$this->db->update('place_city',$data);
			
			//重洗分类排序
			$this->re_order_city($p_id);
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_city($p_id=0)
	{
		$re_row = $this->Place->citys($p_id);
		if(!empty($re_row))
		{
			$re_num = $this->db->query('select p_id from place_city where p_id='.$p_id)->num_rows();
			foreach($re_row as $re_rs)
			{
				$data['order_id'] = $re_num;
				$this->db->where('c_id',$re_rs->c_id);
				$this->db->update('place_city',$data);
				$re_num--;
			}
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_ads extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		//分页模型
		$this->load->model('Paging');
		$this->load->model('Ads_Model');
		$this->load->helper('forms');
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->data['table_title'] = '广告';
		
		//获取分类
		$this->data['ad_sets'] = $this->Ads_Model->ad_sets();
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{
		//<><><>管理页面操作(go)
		
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){ $this->Ads_Model->del($del_id); }
		//批量删除、数据处理
		$del_id = $this->input->post('del_id');
		if(!empty($del_id)){
			foreach($del_id as $delID){
				if(is_num($delID)){ $this->Ads_Model->del($delID); }
			}
		}
		
		//判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(note like '%".$keysword."%' or uid like '%".$keysword."%')";
			}
		
		//<><><>管理页面操作(end)
		
		
		//获取分类
		$set_id = is_num($this->input->get('set_id'));
		$this->data['set_id'] = $set_id;

		//返回相应的sql
		$key_sql = ''; //初始化该变量
		if($set_id==false){
			//无分类筛选
			if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
			$listsql = "select * from ad_list".$key_sql;
		}else{
			if(!empty($keyswordSql)){ $key_sql = " and ".$keyswordSql; }
			//筛选大类符合的
			$listsql = "select * from ad_list where set_id=$set_id".$key_sql;
		}
		$listsql.= ' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);
		
		$this->load->view_system('sys_ads/manage',$this->data);
	}
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 添加编辑页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit()
	{
		//接收Url参数
		$id = is_num($this->input->get('id'));
		$this->data['set_id'] = is_num($this->input->get('set_id'));

		//初始化数据
		$this->data['id'] = $id;
		$this->data['uid'] = 0;
		$this->data['note'] = '';
		$this->data['date_go'] = '';
		$this->data['date_end'] = '';
		$this->data['ad_file'] = '';
		$this->data['link'] = '';
		

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Ads_Model->view($id);
			if(!empty($rs)){
				$this->data['uid'] = $rs->uid;
				$this->data['note'] = $rs->note;
				$this->data['set_id'] = $rs->set_id;
				$this->data['date_go'] = $rs->date_go;
				$this->data['date_end'] = $rs->date_end;
				$this->data['ad_file'] = $rs->ad_file;
				$this->data['link'] = $rs->link;
			}
		}
		
		if($this->data['set_id']==false){ json_echo('请先选择广告要投放在哪个位置!<a href="'.site_url($this->data['s_urls'].'/ad_set').'">[选择]</a>'); }

		$this->data['ad_set_view'] = '';
		$ad_set_view = $this->Ads_Model->ad_set_view($this->data['set_id']);
		if(!empty($ad_set_view)){
			$this->data['ad_set_view'] = $ad_set_view->title.' ( 宽：'.$ad_set_view->size_w.' , 高：'.$ad_set_view->size_h.' )';
			}
		
		

		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('sys_ads/edit_ad',$this->data);
	}
	
	
	//<><><><><><><><><><><><><><><><><><
	//@@@@@@@ 返回广告预览效果 @@@@@@@
	//<><><><><><><><><><><><><><><><><><
	function ad_file_view()
	{
		$set_id = is_num($this->input->get('set_id'));
		//获取该广告的位置大小
		$ad_set_view = $this->Ads_Model->ad_set_view($set_id);
		if(!empty($ad_set_view)){
			$size_w = $ad_set_view->size_w;
			$size_h = $ad_set_view->size_h;
		}else{ exit; }

		$ad_path = img_ads($this->input->get('ad_file'));
		$ad_type = $this->fileExt(strtolower($ad_path));
		
		$data = '';
		$data.= '<div style="width:'.$size_w.'px;height:'.$size_h.'px;overflow:hidden;">';
		if(!empty($ad_type)&&$ad_type=='swf'){
			//返回swf
			$data.= '<embed src="'.$ad_path.'" width="'.$size_w.'" height="'.$size_h.'"></embed>';
		}else{
			//返回图片
			$data.= '<img src="'.$ad_path.'" width="'.$size_w.'" height="'.$size_h.'" />';
		}
		$data.= '</div>';
		
		json_echo($data);
	}
	
	
	//<><><><><><><><><><><><><><><><><><
	//@@@@@@@ 检测所选的日期是否符合 @@@@@@@
	//<><><><><><><><><><><><><><><><><><
	function edit_check()
	{
		$set_id = is_num($this->input->get('set_id'));
		if($set_id){
			//表示没排期空档,故需判断排期最后结束时间
			$rs_date = $this->db->query('select date_go,date_end from ad_list where set_id='.$set_id.' order by id desc')->row();
			if(!empty($rs_date)){
				$date_go = dateTime();
				$r_e_date = $rs_date->date_end;
				if(date_day($r_e_date,$date_go)<0){
					json_echo('投该位置的新广告：至少要从 <b class=red>'.$r_e_date.'</b> 开始!');
				}
			}
		}
	}
	
	//获取文件后缀
	function fileExt($path)
	{
		$path = strtolower($path);
		$extend = explode("." ,$path);  
		$num = count($extend)-1;
		return $extend[$num];
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 提交保存 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function edit_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$uid = $this->input->post('uid');
		$note = noSql($this->input->post('note'));
		$link = noSql($this->input->post('link'));
		$ad_file = noSql($this->input->post('ad_file'));
		$set_id = is_num($this->input->post('set_id'));
		$date_go = $this->input->post('date_go');
		$date_end = $this->input->post('date_end');


		if($note==''){ json_form_no('请填写简述!'); }
		if($ad_file==''){ json_form_no('请设置广告内容!'); }
		
		//写入数据
		$data['note'] = $note;
		$data['link'] = $link;
		$data['ad_file'] = $ad_file;
		
		//获取文件后缀
		$data['ad_type'] = $this->fileExt($ad_file);
		
		if($id==false){
			
			//验证广告用户是否存在
			if(is_num($uid)==false){ json_form_no('请填写用户ID!'); }
			$usernum = $this->db->query('select id from user where id='.$uid)->num_rows();
			if($usernum<=0){ json_form_no('未找到相应的用户!'); }
			
			if($set_id==false){ json_form_no('请选择投放位置!'); }
			$data['uid'] = $uid;
			$data['set_id'] = $set_id;
			
			//比较开始时间和结束时间
			$n_date = strtotime(date("Y-m-d",time()));
			$s_date = strtotime($date_go);
			if($n_date>=$s_date){ json_form_no('广告的开始时间已过!'); }
			//-------------------
			$date_day = date_day($date_go,$date_end);
			if($date_day<=0){ json_form_no('广告的开始时间应小于结束时间!'); }
			
			//表示没排期空档,故需判断排期最后结束时间
			$rs_date = $this->db->query('select date_go,date_end from ad_list where set_id='.$set_id.' order by id desc')->row();
			if(!empty($rs_date)){
				//存在仍未结束的广告,故需判断设定的日期是否在该范围内
				$r_s_date = $rs_date->date_go;
				$r_e_date = $rs_date->date_end;
				if(date_day($r_e_date,$date_go)<0){
					json_form_no('新广告起码需要从<b class=red>'.$r_e_date.'</b>开始!');
					}
			}

			$data['date_go']  = $date_go;
			$data['date_end'] = $date_end;
			$data['date_day'] = $date_day; //广告天数
			$data['addtime']  = dateTime();
			
			//添加
			$this->db->insert('ad_list',$data);
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->update('ad_list',$data);
			json_form_yes('修改成功!');
		}
	}
	
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 分类页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function ad_set()
	{
		//获取页面设置
		$page_id = is_num($this->input->get('page_id'));
		$this->data['page_id'] = $page_id;
		$this->data['ad_pages'] = $this->Ads_Model->ad_pages();
		
		//普通删除、数据处理
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){ $this->Ads_Model->del_type($del_id); }

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes'){
			$cmd = $this->input->post('cmd');
			$set_id = is_num($this->input->post('set_id'));
			if($cmd==''){ json_form_no('未知操作!'); }
			if($set_id==''){ json_form_no('参数丢失,本次操作无效!'); }
			$row = $this->db->query('select * from ad_set where id='.$set_id)->row();
			if(!empty($row)){
				//获取当前基本信息
				$at_id = is_num($row->id);
				$at_order_id = is_num($row->order_id);
				
				//执行重新排序
				if($cmd=="up"){
					$row_up = $this->db->query('select * from ad_set where order_id>'.$at_order_id." order by order_id asc")->row();
					if(!empty($row_up)){
						$up_id = $row_up->id;
						$up_order_id = $row_up->order_id;
						$this->db->query("update ad_set set order_id=$at_order_id where id=$up_id");
						$this->db->query("update ad_set set order_id=$up_order_id where id=$at_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到上限!');
					}
				}elseif($cmd=="down"){
					$row_down = $this->db->query('select * from ad_set where order_id<'.$at_order_id." order by order_id desc")->row();
					if(!empty($row_down)){
						$down_id = $row_down->id;
						$down_order_id = $row_down->order_id;
						$this->db->query("update ad_set set order_id=$at_order_id where id=$down_id");
						$this->db->query("update ad_set set order_id=$down_order_id where id=$at_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到下限!');
					}
				}
			}	
		}
		
		
		//返回相应的sql,判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){ $keyswordSql = "(title like '%".$keysword."%')"; }
		$key_sql = ''; //初始化该变量
		if($page_id==false){
			//无分类筛选
			if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
			$listsql = "select * from ad_set".$key_sql;
		}else{
			if(!empty($keyswordSql)){ $key_sql = " and ".$keyswordSql; }
			//筛选大类符合的
			$listsql = "select * from ad_set where page_id=$page_id".$key_sql;
		}
		$listsql.= ' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,15);

		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_set';
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_ads/ad_set_manage',$this->data);
	}
	
	function ad_set_edit()
	{
		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['page_id'] = 0;
		$this->data['title'] = '';
		$this->data['size_w'] = '';
		$this->data['size_h'] = '';
		$this->data['isshow'] = 1;
		$this->data['order_id'] = 1;

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Ads_Model->ad_set_view($id);
			if(!empty($rs)){
				$this->data['page_id'] = $rs->page_id;
				$this->data['title'] = $rs->title;
				$this->data['size_w'] = $rs->size_w;
				$this->data['size_h'] = $rs->size_h;
				$this->data['isshow'] = $rs->isshow;
				$this->data['order_id'] = $rs->order_id;
			}
		}
		
		$ad_pages = $this->Ads_Model->ad_pages();
		$this->data['select_ad_pages'] = cm_form_select('page_id',$ad_pages,'id','title',$this->data['page_id']);
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_set_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/ad_set';
		
		$this->load->view_system('sys_ads/ad_set_edit',$this->data);
	}
	
	
	//保存分类
	function ad_set_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$page_id = is_num($this->input->post('page_id'));
		$title = noSql($this->input->post('title'));
		$size_w = is_num($this->input->post('size_w'));
		$size_h = is_num($this->input->post('size_h'));
		$isshow = is_num($this->input->post('isshow'),0);
		$order_id = is_num($this->input->post('order_id'));
		//验证数据
		if($page_id==false){ json_form_no('请选择页面!'); }
		if($title==''){ json_form_no('请填写广告位置描述!'); }
		if($size_w==false){ json_form_no('请设置正确的尺寸宽度!'); }
		if($size_h==false){ json_form_no('请设置正确的尺寸高度!'); }
		if($order_id==''){ json_form_no('请在排序处填写正整数!'); }
		//写入数据
		$data['page_id'] = $page_id;
		$data['title'] = $title;
		$data['size_w'] = $size_w;
		$data['size_h'] = $size_h;
		$data['isshow'] = $isshow;
		$data['order_id'] = $order_id;
		if($id==false){
			//添加
			$this->db->insert('ad_set',$data);
			//重洗分类排序
			$this->re_order_ad_set();
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->update('ad_set',$data);
			//重洗分类排序
			$this->re_order_ad_set();
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_ad_set()
	{
		$re_row = $this->Ads_Model->ad_sets();
		if(!empty($re_row))
		{
			$re_num = $this->Ads_Model->ad_sets_num();
			foreach($re_row as $re_rs)
			{
				$data['order_id'] = $re_num;
				$this->db->where('id',$re_rs->id);
				$this->db->update('ad_set',$data);
				$re_num--;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 广告页面管理 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function ad_page()
	{
		//获取分类
		$this->data['ad_pages'] = $this->Ads_Model->ad_pages();
		
		//判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){ $keyswordSql = "(title like '%".$keysword."%')"; }
		

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes'){
			$cmd = $this->input->post('cmd');
			$page_id = is_num($this->input->post('page_id'));
			if($cmd==''){ json_form_no('未知操作!'); }
			if($page_id==''){ json_form_no('参数丢失,本次操作无效!'); }
			$row = $this->db->query('select * from ad_page where id='.$page_id)->row();
			if(!empty($row)){
				//获取当前基本信息
				$at_id = is_num($row->id);
				$at_order_id = is_num($row->order_id);
				
				//执行重新排序
				if($cmd=="up"){
					$row_up = $this->db->query('select * from ad_page where order_id>'.$at_order_id." order by order_id asc")->row();
					if(!empty($row_up)){
						$up_id = $row_up->id;
						$up_order_id = $row_up->order_id;
						$this->db->query("update ad_page set order_id=$at_order_id where id=$up_id");
						$this->db->query("update ad_page set order_id=$up_order_id where id=$at_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到上限!');
					}
				}elseif($cmd=="down"){
					$row_down = $this->db->query('select * from ad_page where order_id<'.$at_order_id." order by order_id desc")->row();
					if(!empty($row_down)){
						$down_id = $row_down->id;
						$down_order_id = $row_down->order_id;
						$this->db->query("update ad_page set order_id=$at_order_id where id=$down_id");
						$this->db->query("update ad_page set order_id=$down_order_id where id=$at_id");
						json_form_yes('更新成功!');
					}else{
						json_form_no('排序已到下限!');
					}
				}
			}	
		}

		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_page';
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_ads/ad_page_manage',$this->data);
	}
	
	
	
	function ad_page_edit()
	{
		//接收Url参数
		$id = is_num($this->input->get('id'));
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';
		$this->data['order_id'] = 1;

		if($id==false){
			$this->data['action_name'] = "添加";
		}else{
			$this->data['action_name'] = "编辑";
			$rs = $this->Ads_Model->ad_page_view($id);
			if(!empty($rs)){
				$this->data['title'] = $rs->title;
				$this->data['order_id'] = $rs->order_id;
			}
		}
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_page_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/ad_page';
		
		$this->load->view_system('sys_ads/ad_page_edit',$this->data);
	}
	
	
	//保存分类
	function ad_page_save()
	{
		//接收提交来的数据
		$id = is_num($this->input->post('id'));
		$title = noSql($this->input->post('title'));
		$order_id = is_num($this->input->post('order_id'));
		//验证数据
		if($title==''){ json_form_no('请填写广告位置描述!'); }
		if($order_id==''){ json_form_no('请在排序处填写正整数!'); }
		//写入数据
		$data['title'] = $title;
		$data['order_id'] = $order_id;
		if($id==false){
			//添加
			$this->db->insert('ad_page',$data);
			//重洗分类排序
			$this->re_order_ad_page();
			json_form_yes('添加成功!');
		}else{
			//修改
			$this->db->where('id',$id);
			$this->db->update('ad_page',$data);
			//重洗分类排序
			$this->re_order_ad_page();
			json_form_yes('修改成功!');
		}	
	}

	//重洗分类排序
	function re_order_ad_page()
	{
		$re_row = $this->Ads_Model->ad_pages();
		if(!empty($re_row))
		{
			$re_num = $this->Ads_Model->ad_pages_num();
			foreach($re_row as $re_rs)
			{
				$data['order_id'] = $re_num;
				$this->db->where('id',$re_rs->id);
				$this->db->update('ad_page',$data);
				$re_num--;
			}
		}
	}

	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
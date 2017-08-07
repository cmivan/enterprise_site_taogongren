<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_ads extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		//分页模型
		$this->load->library('Paging');
		$this->load->model('Ads_Model');
		$this->load->helper('forms');

		$this->data['table_title'] = '广告';
		
		//获取分类
		$this->data['ad_sets'] = $this->Ads_Model->ad_sets();
	}
	
	//管理页面
	function index()
	{
		$del_id = $this->input->get_or_post('del_id');
		if( is_null($del_id)==FALSE && is_array($del_id) )
		{
			//批量删除、数据处理
			foreach($del_id as $delID)
			{
				if( is_num($delID) )
				{
					$this->Ads_Model->del($delID);
				}
			}
		}
		elseif( is_num($del_id) )
		{
			//普通删除、数据处理
			$this->Ads_Model->del($del_id);
		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'note'=> $keysword );
			$keylike_on[] = array( 'uid'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		
		//获取分类
		$set_id = $this->input->getnum('set_id');
		if( $set_id )
		{
			$this->db->where('set_id',$set_id);
		}
		
		$this->data['keysword'] = $keysword;
		$this->data['set_id'] = $set_id;

		//返回相应的sql
		$this->db->from('ad_list');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		
		$this->load->view_system('sys_ads/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		$this->data['set_id'] = $this->input->getnum('set_id');

		//初始化数据
		$this->data['id'] = $id;
		$this->data['uid'] = 0;
		$this->data['note'] = '';
		$this->data['date_go'] = '';
		$this->data['date_end'] = '';
		$this->data['ad_file'] = '';
		$this->data['link'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Ads_Model->view($id);
			if(!empty($rs))
			{
				$this->data['uid'] = $rs->uid;
				$this->data['note'] = $rs->note;
				$this->data['set_id'] = $rs->set_id;
				$this->data['date_go'] = $rs->date_go;
				$this->data['date_end'] = $rs->date_end;
				$this->data['ad_file'] = $rs->ad_file;
				$this->data['link'] = $rs->link;
			}
		}
		
		$set_id = $this->data['set_id'];
		
		if( $set_id == false )
		{
			json_echo('请先选择广告要投放在哪个位置!<a href="'.site_url($this->data['s_urls'].'/ad_set').'">[选择]</a>');
		}

		$this->data['ad_set_view'] = '';
		$ad_set_view = $this->Ads_Model->ad_set_view( $set_id );
		if(!empty($ad_set_view))
		{
			$this->data['ad_set_view'] = $ad_set_view->title.' ( 宽：'.$ad_set_view->size_w.' , 高：'.$ad_set_view->size_h.' )';
		}

		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('sys_ads/edit_ad',$this->data);
	}
	
	
	//返回广告预览效果
	function ad_file_view()
	{
		$set_id = $this->input->getnum('set_id');
		//获取该广告的位置大小
		$ad_set_view = $this->Ads_Model->ad_set_view($set_id);
		if(!empty($ad_set_view))
		{
			$size_w = $ad_set_view->size_w;
			$size_h = $ad_set_view->size_h;
		}
		else
		{
			exit;
		}

		$ad_path = img_ads($this,$this->input->get('ad_file'));
		$ad_type = $this->fileExt(strtolower($ad_path));
		
		$data = '';
		$data.= '<div style="width:'.$size_w.'px;height:'.$size_h.'px;overflow:hidden;">';
		if(!empty($ad_type)&&$ad_type=='swf')
		{
			//返回swf
			$data.= '<embed src="'.$ad_path.'" width="'.$size_w.'" height="'.$size_h.'"></embed>';
		}
		else
		{
			//返回图片
			$data.= '<img src="'.$ad_path.'" width="'.$size_w.'" height="'.$size_h.'" />';
		}
		$data.= '</div>';
		json_echo($data);
	}
	
	
	//检测所选的日期是否符合
	function edit_check()
	{
		$set_id = $this->input->getnum('set_id');
		if( $set_id )
		{
			//表示没排期空档,故需判断排期最后结束时间
			$this->db->select('date_go,date_end');
			$this->db->from('ad_list');
			$this->db->where('set_id',$set_id);
			$this->db->order_by('id','desc');
			$rs_date = $this->db->get()->row();
			if(!empty($rs_date))
			{
				$date_go = dateTime();
				$r_e_date = $rs_date->date_end;
				if(date_day($r_e_date,$date_go)<0)
				{
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
	
	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$uid = $this->input->post('uid');
		$note = $this->input->post('note');
		$link = $this->input->post('link');
		$ad_file = $this->input->post('ad_file');
		$set_id = $this->input->postnum('set_id');
		$date_go = $this->input->post('date_go');
		$date_end = $this->input->post('date_end');

		if($note=='')
		{
			json_form_no('请填写简述!');
		}
		elseif($ad_file=='')
		{
			json_form_no('请设置广告内容!');
		}
		
		//写入数据
		$data['note'] = $note;
		$data['link'] = $link;
		$data['ad_file'] = $ad_file;
		
		//获取文件后缀
		$data['ad_type'] = $this->fileExt($ad_file);
		
		if($id==false)
		{
			//验证广告用户是否存在
			if(is_num($uid)==false)
			{
				json_form_no('请填写用户ID!');
			}
			
			$is_user = $this->User_Model->one_info($uid);
			if( $is_user == false )
			{
				json_form_no('未找到相应的用户!');
			}
			elseif( $set_id == false )
			{
				json_form_no('请选择投放位置!');
			}
			$data['uid'] = $uid;
			$data['set_id'] = $set_id;
			
			//比较开始时间和结束时间
			$n_date = strtotime(date("Y-m-d",time()));
			$s_date = strtotime($date_go);
			if($n_date>=$s_date)
			{
				json_form_no('广告的开始时间已过!');
			}
			$date_day = date_day($date_go,$date_end);
			if($date_day<=0)
			{
				json_form_no('广告的开始时间应小于结束时间!');
			}
			
			//表示没排期空档,故需判断排期最后结束时间
			$this->db->select('date_go,date_end');
			$this->db->from('ad_list');
			$this->db->where('set_id',$set_id);
			$this->db->order_by('id','desc');
			$rs_date = $this->db->get()->row();
			if(!empty($rs_date))
			{
				//存在仍未结束的广告,故需判断设定的日期是否在该范围内
				$r_s_date = $rs_date->date_go;
				$r_e_date = $rs_date->date_end;
				if(date_day($r_e_date,$date_go)<0)
				{
					json_form_no('新广告起码需要从<b class=red>'.$r_e_date.'</b>开始!');
				}
			}

			$data['date_go']  = $date_go;
			$data['date_end'] = $date_end;
			$data['date_day'] = $date_day; //广告天数
			$data['addtime']  = dateTime();

			$this->db->insert('ad_list',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('ad_list',$data);
			json_form_yes('修改成功!');
		}
	}
	
	
	
	
	
	//分类页面
	function ad_set()
	{
		//获取页面设置
		$this->data['ad_pages'] = $this->Ads_Model->ad_pages();
		
		//普通删除、数据处理
		$del_id = $this->input->getnum('del_id');
		if( $del_id )
		{
			$this->Ads_Model->del_type($del_id);
		}

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$set_id = $this->input->postnum('set_id');
			
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($set_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Ads_Model->ad_set_view($set_id);
			if(!empty($row))
			{
				//获取当前基本信息
				$at_id = get_num($row->id);
				$at_order_id = get_num($row->order_id);
				
				$this->load->helper('publicedit');
				$keys = array(
					  'table' => 'ad_set',
					  'key' => 'id',
					  'okey' => 'order_id',
					  'id' => $row->id,
					  'oid' => $row->order_id,
					  'type' => $cmd
					  );
				List_Re_Order($keys);
			}	
		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$this->db->like('title',$keysword);
		}

		$page_id = $this->input->getnum('page_id');
		if( $page_id )
		{
			$this->db->where('page_id',$page_id);
		}
		
		$this->data['page_id'] = $page_id;
		$this->data['keysword'] = $keysword;
		
		$this->db->from('ad_set');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();
		
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);

		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_set';
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_ads/ad_set_manage',$this->data);
	}
	
	function ad_set_edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['page_id'] = 0;
		$this->data['title'] = '';
		$this->data['size_w'] = '';
		$this->data['size_h'] = '';
		$this->data['isshow'] = 1;
		$this->data['order_id'] = 1;

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Ads_Model->ad_set_view($id);
			if(!empty($rs))
			{
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
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_set_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/ad_set';
		
		$this->load->view_system('sys_ads/ad_set_edit',$this->data);
	}
	
	
	//保存分类
	function ad_set_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$page_id = $this->input->postnum('page_id');
		$title = noSql($this->input->post('title'));
		$size_w = $this->input->postnum('size_w');
		$size_h = $this->input->postnum('size_h');
		$isshow = $this->input->postnum('isshow',0);
		$order_id = $this->input->postnum('order_id');
		//验证数据
		if($page_id==false)
		{
			json_form_no('请选择页面!');
		}
		elseif($title=='')
		{
			json_form_no('请填写广告位置描述!');
		}
		elseif($size_w==false)
		{
			json_form_no('请设置正确的尺寸宽度!');
		}
		elseif($size_h==false)
		{
			json_form_no('请设置正确的尺寸高度!');
		}
		elseif($order_id==false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		//写入数据
		$data['page_id'] = $page_id;
		$data['title'] = $title;
		$data['size_w'] = $size_w;
		$data['size_h'] = $size_h;
		$data['isshow'] = $isshow;
		$data['order_id'] = $order_id;
		if($id==false)
		{
			$this->db->insert('ad_set',$data);
			//重洗分类排序
			$this->re_order_ad_set();
			json_form_yes('添加成功!');
		}
		else
		{
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
	

	
	
	
	//广告页面管理
	function ad_page()
	{
		//获取分类
		$this->data['ad_pages'] = $this->Ads_Model->ad_pages();
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$this->db->like('title',$keysword);
		}
		$this->data['keysword'] = $keysword;

		//(post)处理大类排序问题
		$go = $this->input->post('go');
		if($go=='yes')
		{
			$cmd = $this->input->post('cmd');
			$page_id = $this->input->postnum('page_id');
			if($cmd=='')
			{
				json_form_no('未知操作!');
			}
			elseif($page_id==false)
			{
				json_form_no('参数丢失,本次操作无效!');
			}
			
			$row = $this->Ads_Model->ad_page_view($page_id);
			if(!empty($row))
			{
				//获取当前基本信息
				$at_id = get_num($row->id);
				$at_order_id = get_num($row->order_id);
				
				//执行重新排序
				$this->load->helper('publicedit');
				$keys = array(
					  'table' => 'ad_page',
					  'key'  => 'id',
					  'okey' => 'order_id',
					  'id'   => $at_id,
					  'oid'  => $at_order_id,
					  'type' => $cmd
					  );
				List_Re_Order($keys);
			}	
		}

		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_page';
		$this->data['formTO']->backurl = '';
		
		//输出界面效果
		$this->load->view_system('sys_ads/ad_page_manage',$this->data);
	}
	
	
	
	function ad_page_edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';
		$this->data['order_id'] = 1;

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Ads_Model->ad_page_view($id);
			if(!empty($rs))
			{
				$this->data['title'] = $rs->title;
				$this->data['order_id'] = $rs->order_id;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/ad_page_save';
		$this->data['formTO']->backurl = $this->data["s_urls"].'/ad_page';
		
		$this->load->view_system('sys_ads/ad_page_edit',$this->data);
	}
	
	
	//保存分类
	function ad_page_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$title = $this->input->post('title');
		$order_id = $this->input->postnum('order_id');
		//验证数据
		if($title=='')
		{
			json_form_no('请填写广告位置描述!');
		}
		elseif($order_id==false)
		{
			json_form_no('请在排序处填写正整数!');
		}
		//写入数据
		$data['title'] = $title;
		$data['order_id'] = $order_id;
		if($id==false)
		{
			$this->db->insert('ad_page',$data);
			//重洗分类排序
			$this->re_order_ad_page();
			json_form_yes('添加成功!');
		}
		else
		{
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
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_introduce extends XT_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		$this->load->model('Introduce_Model');
		
		$this->data['table_title'] = '介绍好友';
	}
	
	//管理页面
	function index()
	{
		//分页模型
		$this->load->library('Paging');
		//收支记录模型
		$this->load->model('Records_Model');

		//管理页面操作,更改状态(go)
		$id = $this->input->getnum('id');
		$cmd = $this->input->get('cmd');
		if($cmd!=''&&$id)
		{
			if($cmd=="yes")
			{
				$ok = 1; /*审核通过的信息*/
			}
			else
			{
				$ok = 2; /*审核不通过的信息*/
			}
			
			//有效，则送淘工币
			$this->db->set('ok',$ok);
			$this->db->where('ok',0);
			$this->db->where('id',$id);
			$rs = $this->db->update('sys_introduce');
			if( !empty($rs) && $ok==1 )
			{
				//获取相关信息
				$row = $this->Introduce_Model->view($id);
				if(!empty($row))
				{
					$nicename = $row->nicename;
					$this_uid = $row->uid;
					if( is_num($this_uid) )
					{
						//这里设定赠送5个淘工币
						$BC_tip = '推荐用户&nbsp;【'.$nicename.'】&nbsp;到淘工人平台,并通过审核!';
						$BC_ok  = $this->Records_Model->balance_control($this_uid,'5',$BC_tip,'T');
					}
				}
			}
		}
		
		//判断搜索
		$keysword = $this->input->get_or_post('keysword',TRUE);
		if($keysword!='')
		{
			$keylike_on[] = array( 'nicename'=> $keysword );
			$keylike_on[] = array( 'mobile'=> $keysword );
			$this->db->like_on($keylike_on);
		}
		
		$this->data['keysword'] = $keysword;
		$this->data["page"] = $this->input->getnum('page',1);

		$this->db->from('sys_introduce');
		$this->db->order_by('id','desc');
		$listsql = $this->db->getSQL();

		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,15);
		$this->load->view_system('user_introduce/manage',$this->data);
	}
	
	
	
	
	//添加编辑页面
	function edit()
	{
		//接收Url参数
		$id = $this->input->getnum('id');
		
		//初始化数据
		$this->data['id'] = $id;
		$this->data['title'] = '';
		$this->data['content'] = '';

		if($id==false)
		{
			$this->data['action_name'] = "添加";
		}
		else
		{
			$this->data['action_name'] = "编辑";
			$rs = $this->Sys_page_Model->view($id);
			if(!empty($rs))
			{
				$this->data['title'] = $rs->title;
				$this->data['content'] = $rs->content;
			}
		}
		
		//表单配置
		$this->data['formTO']->url = $this->data["s_urls"].'/edit_save';
		$this->data['formTO']->backurl = $this->data["s_urls"];

		$this->load->view_system('user_introduce/edit',$this->data);
	}
	
	
	
	
	//提交保存
	function edit_save()
	{
		//接收提交来的数据
		$id = $this->input->postnum('id');
		$title = $this->input->post('title');
		$content = $this->input->post('content');

		//验证数据
		if($title=='')
		{
			json_form_no('请填写标题!');
		}
		elseif($content=='')
		{
			json_form_no('请填写内容!');
		}
		
		//写入数据
		$data['title'] = $title;
		$data['content'] = $content;
		if($id==false)
		{
			$this->db->insert('sys_page',$data);
			json_form_yes('添加成功!');
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('sys_page',$data);
			json_form_yes('修改成功!');
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
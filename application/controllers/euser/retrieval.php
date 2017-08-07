<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retrieval extends E_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Retrieval_Model');
		$this->load->model('Industry_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '管理投标','link' => 'index'),
					array('title' => '发布投标','link' => 'add')
		            );
	}

	
	function index()
	{
		//处理删除
		$del_id = $this->input->getnum('del_id');
		if($del_id)
		{
			$this->Retrieval_Model->del($del_id,$this->logid);
		}
	
		//分页模型
		$this->load->library('Paging');
		//获取分页列表sql
		$listsql=$this->Retrieval_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql);
		//输出到视窗
		$this->load->view($this->data["c_url"].'retrieval/index',$this->data);
	}
	

	
	function add()
	{
		$this->data["team_mens"] = $this->User_Model->worker_types();
		$this->data["classids"] = $this->Industry_Model->industry_class();
		//个人信息
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		$this->data["industrys"] = $this->Industry_Model->industrys();

		//css样式-评级打分
		$this->data['cssfiles'][] = 'style/page_retrieval.css';
		//Js-下拉框选择城市
		$this->data['jsfiles'][] = 'js/city_select_option.js';

		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		//输出到视窗
		$this->load->view($this->data["c_url"].'retrieval/add',$this->data);
	}
	

	
	function edit($id='')
	{
		//安全处理
		$id = get_num($id,'404');
		$this->data["info"] = $this->Retrieval_Model->view($id);
		if(empty($this->data["info"]))
		{
			show_404('/index' ,'log_error');
		}

		$this->data["team_mens"] = $this->User_Model->worker_types();
		$this->data["classids"] = $this->Industry_Model->industry_class();
		//个人信息
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		$this->data["industrys"] = $this->Industry_Model->industrys();
		
		//获取图片信息
		$this->data["pics"] = $this->Retrieval_Model->pics($id);

		//css样式-评级打分
		$this->data['cssfiles'][] = 'style/page_retrieval.css';
		//Js-下拉框选择城市
		$this->data['jsfiles'][] = 'js/city_select_option.js';
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		//输出到视窗
		$this->load->view($this->data["c_url"].'retrieval/edit',$this->data);
	}
	
	
	
	function save($id='')
	{
		//安全处理
		$id = get_num($id);
		
		$data['uid'] = $this->logid;
		$data['title'] = noHtml($this->input->post('title'));
		$data['cost'] = noHtml($this->input->post('cost'));
		$data['team_or_men'] = $this->input->postnum('team_or_men',0);
		$data['classid'] = $this->input->postnum('classid',0);
		$data['p_id'] = $this->input->postnum('p_id',0);
		$data['c_id'] = $this->input->postnum('c_id',0);
		$data['a_id'] = $this->input->postnum('a_id',0);
		$data['industryid'] = $this->input->post('industryid');
		$data['endtime'] = $this->input->post('endtime');
		$data['job_stime'] = $this->input->post('job_stime');
		$data['job_etime'] = $this->input->post('job_etime');
		$data['note'] = noHtml($this->input->post('note'));
		$data['rid'] = $this->input->postnum('rid',0);
		$pic = $this->input->post('pic');
		
		//检测数据
		if($data['title']=='')
		{
			json_form_no('请先填写标题!');
		}
		if($data['cost']!=get_num($data['cost'])||$data['cost']<=0)
		{
			json_form_no('请填写正确的预计费用!');
		}
		if(strtotime(time())>strtotime($data['endtime']))
		{
			json_form_no('投标结束时间已经过期!');
		}
		if(strtotime($data['job_stime'])>strtotime($data['job_etime']))
		{
			json_form_no('工期结束时间不能在开始时间前!');
		}
		if($data['note']=='')
		{
			json_form_no('请填写投标描述!');
		}

		if( $id )
		{
			//编辑
			$this->db->where('id', $id);
			$this->db->update('retrieval',$data);
			
			//清空原来的图片,重新录入
			$this->Retrieval_Model->del_pic($id,$this->logid);
			if(!empty($pic))
			{
				foreach($pic as $p)
				{
					if($p!=''&&$p!='0')
					{
						$pic_data['pic'] = noSql($p);
						//$pic_data['picMD5'] = md5($p);
						$pic_data['note']= '';
						$pic_data['rid'] = $id;
						$pic_data['uid'] = $this->logid;
						$this->Retrieval_Model->add_pic($pic_data);
					}
				}
			}
			//返回提示
			json_form_yes('更新成功!');
		}
		else
		{
			//添加
			//以md5值记录任务信息，防止重复
			$thisMD5 = arr2md5($data);
			if( $this->Retrieval_Model->is_retrievaled($thisMD5) )
			{
				json_form_no('该投标信息已经发布过了!');
			}
			else
			{
				//写入数据
				$data['addtime'] = dateTime();
				$data['thisMD5'] = $thisMD5;
				$this->db->insert('retrieval',$data);
				
				//判断是否提交图片,有则处理
				$thisRid = $this->db->insert_id();
				if( is_num($thisRid) && !empty($pic) )
				{
					foreach($pic as $p)
					{
						if($p!=''&&$p!='0')
						{
							$pic_data['pic'] = noSql($p);
							//$pic_data['picMD5'] = md5($p);
							$pic_data['note']= '';
							$pic_data['rid'] = $thisRid;
							$pic_data['uid'] = $this->logid;
							$this->Retrieval_Model->add_pic($pic_data);
					    }
					}
				}
				//json_echo('{"//cmd":"y","info":"发布成功！"}');	
				//发送邮件,通知平台客服(临时)
				#*****************************
				$this->load->helper('send');
				$rvalurl=site_url('retrieval/view/'.$this->db->insert_id());
				$mailNr ='业主昵称:<a href="'.site_url('user/'.$data['uid']).'" target="_blank">'.$data['uid'].'</a><br>';
				$mailNr.='任务信息:'.$data['title'].'<br>';
				$mailNr.='任务费用:'.$data['cost'].'（元）<br>';
				$mailNr.='任务网址:<a href="'.$rvalurl.'" target="_blank">'.$rvalurl.'</a><br>';
				emailto('淘工人投标信息','cm.ivan@qq.com','淘工人投标信息',$mailNr);
				#*****************************
				//返回提示
				json_form_yes('发布成功!');
			}	
		}

	}
	
	



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
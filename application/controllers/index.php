<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends QT_Controller {

	function __construct()
	{
		parent::__construct();
		
		//对前台页面使用【缓存技术】(注意：使用后，将会导致页面刷新后不更新的情况。故慎用!)
		$this->output->cache(10);
		
		$this->load->helper('send');
	}

	function index()
	{
		//评测应用程序
		//$this->output->enable_profiler(true);
		
		/*加载模型*/
	    $this->load->model('Projacts');
		//招标信息模型
		$this->load->model('Retrieval_Model');
		$this->load->model('Case_Model');
		
	    //$this->data['zb_new'] = $this->Retrieval_Model->zb_new();   /*最新招标*/
	    $this->data['zb_ad']  = $this->Retrieval_Model->zb_ad();      /*最新招标*/
	    //$this->data['zb_tj']  = $this->Retrieval_Model->zb_tj();    /*推荐招标*/
	    $this->data['hot_team']   = $this->User_Model->hot_team();    /*热门团队*/
	    $this->data['hot_design'] = $this->User_Model->hot_design();  /*热门设计师*/
	    $this->data['hot_workers']= $this->User_Model->hot_workers(); /*热门工人*/
		$this->data['hot_company']= $this->User_Model->hot_company(); /*热门公司*/
		//$this->data['projact'] = $this->Projacts->projact(4);
		$this->data['projact'] = $this->Projacts->projact(); /*工种项目*/
		
		$this->data['index_case'] = $this->Case_Model->index_case(6); /*首页案例*/
		
		/*<><><>Js<><><>*/
		//蜂窝型技能
		$this->data['jsfiles'][] = 'js/index_skill.js';

		/*返回"我要发布信息"按钮链接*/
		$logid = get_num($this->logid);
		if($logid)
		{
			if($this->User_Model->classid($logid)!=1)
			{
				$this->data['tb_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是业主请先登录!" ';
				
				$thisurl = site_page2ajax('recruitment');
				$this->data['zp_but'] = 'href="'.$thisurl.'" class="tip" title="点击进入发布招聘信息!" ';
				
				$thisurl = site_page2ajax('recruitment/add_job');
				$this->data['qz_but'] = 'href="'.$thisurl.'" class="tip" title="点击进入发布求职信息!" ';
			}
			else
			{
				$thisurl = site_page2ajax('retrieval/add');
				$this->data['tb_but'] = 'href="'.$thisurl.'" class="tip" title="点击进入发布招标信息!" ';
				$this->data['zp_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
				$this->data['qz_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
			}
		}
		else
		{
			$this->data['tb_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是业主请先登录!" ';
			$this->data['zp_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
			$this->data['qz_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
		}

		//输出到视窗
		$this->load->view('index',$this->data);
	}

	
	
	function old()
	{
		/*加载模型*/
	    $this->load->model('Projacts');
		//招标信息模型
		$this->load->model('Retrieval_Model');

	    $this->data['zb_new'] = $this->Retrieval_Model->zb_new();    /*最新招标*/
	    $this->data['zb_ad']  = $this->Retrieval_Model->zb_ad();     /*最新招标*/
	    $this->data['zb_tj']  = $this->Retrieval_Model->zb_tj();     /*推荐招标*/

	    $this->data['hot_team']   = $this->User_Model->hot_team();	 /*热门团队*/
	    $this->data['hot_design'] = $this->User_Model->hot_design(); /*热门设计师*/
	    $this->data['hot_workers']= $this->User_Model->hot_workers();/*热门工人*/
		$this->data['projact'] = $this->Projacts->projact(4);        /*工种项目*/
		
		$this->data['cssfiles'][] = 'style/page_index_old.css';
		
		//输出到视窗
		$this->load->view('index_old',$this->data);
	}
	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
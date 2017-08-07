<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
	}
	


	function index()
	{
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
		
		$this->data['index_case']= $this->Case_Model->index_case(6); /*首页案例*/

		//$this->data['projact'] = $this->Projacts->projact(4);
		$this->data['projact'] = $this->Projacts->projact(); /*工种项目*/

		/*<><><>Js<><><>*/
		//蜂窝型技能
		$this->data['jsfiles'][] = 'js/index_skill.js';

		/*返回"我要发布信息"按钮链接*/
		$logid = is_num($this->logid);
		if($logid){
		  if($this->User_Model->classid($logid)==0){
			  $this->data['tb_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是业主请先登录!" ';
			  $this->data['zp_but'] = 'href="'.site_url($this->data['w_url']."recruitment").'" class="tip" title="点击进入发布招聘信息!" ';
			  $this->data['qz_but'] = 'href="'.site_url($this->data['w_url']."recruitment/add_job").'" class="tip" title="点击进入发布求职信息!" ';
		  }else{
			  $this->data['tb_but'] = 'href="'.site_url($this->data['e_url']."retrieval/add").'" class="tip" title="点击进入发布招标信息!" ';
			  $this->data['zp_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
			  $this->data['qz_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
		  }
		}else{
		  $this->data['tb_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是业主请先登录!" ';
		  $this->data['zp_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
		  $this->data['qz_but'] = 'href="javascript:void(0);" class="user_login tip" title="如果你是工人请先登录!" ';
		}

		/*输出到视窗*/
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
		
		/*输出到视窗*/
		$this->load->view('index_old',$this->data);
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
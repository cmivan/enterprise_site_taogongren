<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends QT_Controller {
	
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/
		
		$this->load->model('Articles_Model');
		
		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'style/mod_page.css';
		/*<><><>Js<><><>*/
		$this->data['jsfiles'][] = 'js/mod_page.js';
	}
	


/**
主页面
*/
	function index($typeid="")
	{
		//检测typeid 不符合则返回false
		$typeid = is_num($typeid);

		//同时加载相应的类库
		$this->load->model('Paging');

		//英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		//栏目分类
		$this->data["type"] = $this->Articles_Model->get_types();

		#读取列表
		$this->data["list"]=$this->Paging->show( $this->Articles_Model->get_sql($typeid) ,15);

		/*SEO设置*/
		$this->data['seo']['title']  = '装修学堂,全国装修工人大本营 淘工人网!';
		$this->data['seo']['keywords'] = '装修知识,装修必知,装修案例,装修DIY,装修贴士,装修风水,找装修工人,找室内设计师!';
		$this->data['seo']['description'] = '全国各地最新的招聘、求职、招标等信息!高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
		
		$this->load->view('articles/index',$this->data);
	}



/**
分页类页面
*/
	function type($typeid=0)
	{
		$this->index($typeid);
	}


/**
详细页面
*/
	function view($id=0)
	{
		
		//检测id 不符合则返回404页面
		$id = is_num($id,'404');
		
		//英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);
		
		//累计访问次数
		$this->Articles_Model->hit($id);
		//栏目分类
		$this->data["type"] = $this->Articles_Model->get_types();
		//获取文章详情
		$this->data["view"] = $this->Articles_Model->view($id);

		/*SEO设置*/
		$view = $this->data["view"];
		if(!empty($view)){
		   $this->data['seo']['title']  = $view->title.',全国装修工人大本营 淘工人网!';
		   $this->data['seo']['description'] = $view->title.' 概要:'.cutstr(toText($view->content),35).'...';
		}else{
		   $this->data['seo']['title']  = '装修学堂,全国装修工人大本营 淘工人网!';
		}
		$this->data['seo']['keywords'] = '装修知识,装修必知,装修案例,装修DIY,装修贴士,装修风水,找装修工人,找室内设计师!';

		$this->load->view('articles/view',$this->data);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
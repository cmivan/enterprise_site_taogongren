<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unions extends QT_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Unions_Model');

		//css样式
		$this->data['cssfiles'][] = 'style/mod_page.css';
		//Js
		$this->data['jsfiles'][]  = 'js/mod_page.js';
		
		//英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);
		//栏目分类
		$this->data["type"] = $this->Unions_Model->get_types();
		//热门文章
		$this->data["list_hot"] = $this->Unions_Model->list_hot();	
	}
	

	
/**
主页面
*/
	function index($typeid="")
	{
		//检测typeid 不符合则返回false
		$typeid = get_num($typeid);

		//用户信息模型,同时加载相应的类库
		$this->load->library('Paging');
		//读取列表
		$this->data["list"] = $this->paging->show( $this->Unions_Model->get_sql($typeid) ,20);

		/*SEO设置*/
		$this->data['seo']['title']  = '淘工会,全国装修工人大本营 淘工人网!';
		$this->data['seo']['keywords'] = '淘工会,工人保险知识,装修经验分享,工会资讯,装修,免费发布信息,找装修工人,找室内设计师!';
		$this->data['seo']['description'] = '通过淘工会可了解更多的工人保险知识,装修经验分享,工会资讯等!高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
		
		$this->load->view('unions/index',$this->data);
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
		$this->output->cache(5);
		
		//检测id 不符合则返回404页面
		$id = get_num($id,'404');
		//累计访问次数
		$this->Unions_Model->hit($id);
		//获取文章详情
		$this->data["view"] = $this->Unions_Model->view($id);

		/*SEO设置*/
		$view = $this->data["view"];
		if(!empty($view))
		{
		   $this->data['seo']['title']  = $view->title.',全国装修工人大本营 淘工人网!';
		   $this->data['seo']['description'] = $view->title.' 概要:'.cutstr(toText($view->content),35).'...';
		}
		else
		{
		   $this->data['seo']['title']  = '淘工会,全国装修工人大本营 淘工人网!';
		}
		$this->data['seo']['keywords'] = '淘工会,工人保险知识,装修经验分享,工会资讯,装修,免费发布信息,找装修工人,找室内设计师!';

		$this->load->view('unions/view',$this->data);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
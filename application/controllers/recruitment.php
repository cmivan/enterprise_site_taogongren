<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment extends QT_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Recruitment_Model');
		$this->load->model('Retrieval_Model');
		$this->load->model('Industry_Model');
	}
	


	function index()
	{
		$this->load->library('Paging');
		#参数
		//$industry  = $this->input->getnum("industry");
		$type_id = $this->input->getnum('classid');
		//$page       = $this->input->getnum("page");
		$this->data['type_ids'] = $this->Recruitment_Model->get_types();
		$this->data['type_id'] = $type_id;
		$this->data['industrys'] = $this->Industry_Model->industrys();
		$this->data['keyword'] = $this->input->gethtml("keyword");

		//获取sql语句
		$sql = $this->Recruitment_Model->page_listsql($type_id);
		//获取列表内容
		$this->data['list'] = $this->paging->show($sql,10);

		 /*SEO设置*/
		 $this->data['seo']['title']  = '招聘信息,全国装修工人大本营 淘工人网!';
		 $this->data['seo']['keywords'] = '招聘、求职信息,找工人,找装修工人,找室内设计师!';
		 $this->data['seo']['description'] = '全国各地最新的招聘、求职、招标等信息!高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
		 
		//是否需要显示搜索辅助函数
		$this->data['searchkeys'] = true;
		$this->load->view('recruitment',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
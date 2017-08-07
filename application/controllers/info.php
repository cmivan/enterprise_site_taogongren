<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info extends QT_Controller {

	function __construct()
	{
		parent::__construct();
	}
	

	function index()
	{
		$this->load->model('Recruitment_Model');
		$this->load->model('Retrieval_Model');
		
		if(is_num($this->logid))
		{
			$this->data['is_login'] = true;
		}
		else
		{
			$this->data['is_login'] = false; 
		}
		
		$this->data['job_list'] = $this->Recruitment_Model->get_list(2,10);  //get_list({分类ID},{显示数目});
		$this->data['recruitment_list'] = $this->Recruitment_Model->get_list(1,10);
		$this->data['retrieval_list'] = $this->Retrieval_Model->get_list();
		
		/*SEO设置*/
		$this->data['seo']['title']  = '淘信息! 全国装修工人大本营 淘工人网!';
		$this->data['seo']['keywords'] = '招聘信息,求职信息,招标信息,找工人,找装修工人,找室内设计师,全国装修工人大本营,淘工人帮您,找工人有淘工人网更省心!';
		$this->data['seo']['description'] = '全国各地最新的招聘、求职、招标等信息!高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
		
		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'style/page_retrieval.css';
		$this->load->view('info',$this->data);
	}

	 
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
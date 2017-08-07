<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment extends QT_Controller {
	
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
		
		$this->load->model('Recruitment_Model');
		$this->load->model('Retrieval_Model');
		$this->load->model('Industry_Model');
	}
	


	function index()
	{
		$this->load->model('Paging');

		#参数
		//$industry  = is_num($this->input->get("industry"));
		$type_id    = is_num($this->input->get("classid"));
		//$keyword    = noHtml($this->input->get("keyword"));
		//$page       = is_num($this->input->get("page"));

		$this->data["type_ids"]  = $this->Recruitment_Model->get_types();
		$this->data["industrys"] = $this->Industry_Model->industrys();
		
		$this->data['type_id'] = $type_id;
		$this->data['keyword'] = noHtml($this->input->get("keyword"));

		/*返回筛选条件*/
		$selectStr="";$selectAnd=" where";
		/*筛选任务城市*/
		//if(isnumeric($cityid)){$selectStr.=$selectAnd." cityid=$cityid";$selectAnd=" and ";}
		/*筛选任务区域*/
		//if(isnumeric($areaid)){$selectStr.=$selectAnd." areaid=$areaid";$selectAnd=" and ";}
		/*筛选任务类别*/
		if($type_id){$selectStr.=$selectAnd." type_id=".$type_id;$selectAnd=" and ";}
		/*筛选需求工种*/
//		if($industry!=""){
//		   $industryStr="";
//		   $industryArr=split(",",$industry);$Num=0;
//		   foreach($industryArr as $item){
//			   $Num++;if($Num>1){$NStr=",";}
//			   if(isnumeric($item)){$industryStr.=$NStr.$item;}
//			   }
//		   if($industryStr!=""){$selectStr.=$selectAnd." industryid ='".$industryStr."'";}
//		}
		/*返回最终筛选条件*/
//		if($keyword!=""){$selectStr.=" (title like '%".$keyword."%' or note like '%".$keyword."%') ";}

		//获取sql语句
		$sql = "select * from recruitment".$selectStr." order by id desc";
		//获取列表内容
		$this->data["list"] = $this->Paging->show($sql,10);

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
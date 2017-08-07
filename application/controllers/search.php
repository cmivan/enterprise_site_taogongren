<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->helper('cookie');
	}
	


	function index()
	{

		//评测应用程序
		//$this->output->enable_profiler(true);

		//分页模型
		$this->load->model('Paging');
		//地区模型
		$this->load->model('Projacts');
		$this->load->model('Searchs');
		$this->load->model('Industry_Model');
		$this->load->model('Approve_Model');
		$this->load->model('Favorites_Model');
		
		
		//获取列表内容
		$search_where = "";
		$search_joins = "";
		
	    /* 搜索页面所有参数 */
		$team_or_men = is_num($this->input->get("team_or_men"));
		$classid     = is_num($this->input->get("classid"));
		$age         = is_num($this->input->get("age"));
		$industryid  = $this->input->get("industryid");
		$hot_skills  = $this->input->get("hot_skills");
		$skills      = $this->input->get("skills");
		$approve     = $this->input->get("approve");
		$addr_adv    = $this->input->get("addr_adv");
		
		$keyword     = noHtml($this->input->get("keyword", TRUE));
		$page        = is_num($this->input->get("page"));
		
		$cityid = is_num($this->input->get("cityid"));
		$areaid = is_num($this->input->get("areaid"));

		//数组数据处理
		$industryid = getarray($industryid);
		$hot_skills = getarray($hot_skills);
		$skills     = getarray($skills);
		$approve    = getarray($approve);

#<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>		
############### start to get the search sql #######################
#<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

		/*城市  输入关键词搜索时cityid=no*/
		if($cityid!="no"&&$cityid!=false){ $search_where.=" and W.c_id=$cityid"; }
		/*地区 输入关键词搜索时areaid=no*/
		if($areaid!="no"&&$areaid!=false){ $search_where.=" and W.a_id=$areaid"; }
		
		/*个人或者团队*/
		if($team_or_men=="2"){
			$search_where.=" and W.classid=2";
		}elseif($team_or_men=="0"){
			//$search_where.=" and W.classid=0";
			$search_where.=" and (W.classid=0 or (W.classid=2 and W.uid=1))";
		}else{
			$search_where.=" and W.classid in (0,2)";
		}
		
		
		
		
		
		
		/*查找工人相应的技能*/
		$s_w_sql =" left join skills S on W.id=S.workerid";
		/*查找技能对应的工种*/
		$i_s_sql =" left join industry I on I.id=S.industryid";
		/*查找工种或项目对应的类型*/
		$ic_i_sql=" left join industry_class IC on IC.id=I.classid";
		
		/*擅长工种*/
		if($industryid!=""){
		   $search_joins = $s_w_sql.$i_s_sql;
		   $search_where.=" and I.industryid in ($industryid)";
		}
		/*擅长类型，安装\装修\修缮*/ 
		if($classid!=""&&is_numeric($classid)){
		   if($search_joins==""){$search_joins=$s_w_sql.$i_s_sql.$ic_i_sql;}else{$search_joins.=$ic_i_sql;}
		   $search_where.=" and IC.id=$classid";
		}

		/*擅长技能(合并普通和热门技能)*/
		$all_skills="";
		if($hot_skills!=""&&$skills!=""){
			$all_skills=$hot_skills.",".$skills;
		}elseif($hot_skills!=""){
			$all_skills=$hot_skills;
		}elseif($skills!=""){
			$all_skills=$skills;
		}
		/*擅长技能*/
		if($all_skills!=""){
		   if($search_joins==""){$search_joins = $s_w_sql;}
		   $search_where.=" and S.industryid in ($all_skills)";
		}
		
		/*工作年限范围*/
		if($age!=""&&is_numeric($age)){$search_where.=" and W.entry_age=$age";}
		/*认证*/
		if($approve!=""){$approvearr=split(",",$approve);}
		if(!empty($approvearr)&&is_array($approvearr)){
		  foreach($approvearr as $item){$search_where.=" and ".$this->Approve_Model->approve_sql($item);}
		}
		
		/*查询关键字(增强)*/
		if($keyword!=""){
		  if($search_joins==""){$search_joins=$s_w_sql.$i_s_sql;}
		  $search_where.=" and (W.name like '%".$keyword."%' or W.note like '%".$keyword."%' or I.title like '%".$keyword."%' or W.address like '%".$keyword."%' or W.addr_adv like '%".$keyword."%')";
		}
		
		/*优势位置(11-4-29)*/
		if($addr_adv=="1"){ $search_where.=" and W.addr_adv<>''";}
		
#<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>		
############### get the end for the search sql #######################
#<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

        //生成搜索sql
		$search_sql = "select W.id,W.name,W.truename,W.photoID,W.mobile,W.qq,W.entry_age,W.classid,W.approve_sj,W.approve_yx,W.approve_sm,W.uid,W.address,W.addr_adv from `user` W".$search_joins." where W.id<>'' and W.photoID<>''".$search_where." group by W.id order by W.uid desc,W.id desc,W.visited desc";
		//获取搜索内容
		$this->data["list"] = $this->Paging->show($search_sql,10);


		
		
		//用于判断技能框的显示状态 展开or收起
		$this->data['isopen'] = $this->session->userdata('isopen');

		//返回关键词
		$this->data['keyword'] = $keyword;

		//当前地区和被选中的地区id
		$this->data['areas'] = $this->data["placebox"]->areas();
		$this->data['area_id'] = $this->data["placebox"]->areaid;
		//选中个人或团队
		$this->data["team_mens"] = $this->User_Model->worker_types();
		$this->data['team_mens_id'] = $this->input->get("team_or_men", TRUE);
		//选中的工种id
		$this->data["industrys"] = $this->Projacts->industrys();
		$this->data['industry_id'] = $this->input->get("industryid", TRUE);
		//项目分类和被选中的项目分类id
		$this->data['industry_class'] = $this->Industry_Model->industry_class();
		$this->data['class_id'] = $this->input->get("classid", TRUE);
		//选中的级别id
		$this->data["levels"] = $this->Searchs->levels();
		$this->data['level_id'] = $this->input->get("level",true);
		//选中的年限id
		$this->data["ages"] = $this->Searchs->ages();
		$this->data['age_id'] = $this->input->get("age", TRUE);
		//选中的认证id
		$this->data["approves"] = $this->Searchs->approves();
		$this->data['approve_id'] = $this->input->get("approve", TRUE);
		
		
		$this->data['skills']     = $this->app_skills($this->data['class_id'],$this->data['industry_id'],0,1);
		$this->data['skills_id']  = $this->input->get("skills", TRUE);
		$this->data['skills_hot'] = $this->app_skills($this->data['class_id'],$this->data['industry_id'],1,1);
		$this->data['skills_hot_id'] = $this->input->get("hot_skills", TRUE);


		#排名-财富榜
	    //$this->data['user_cfb'] = $this->User_Model->user_cfb(0);
	    //$this->data['team_cfb'] = $this->User_Model->user_cfb(2);
		#排名-英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    //$this->data['team_yxb'] = $this->User_Model->user_yxb(2);
		#排名-人气榜
	    //$this->data['user_rqb'] = $this->User_Model->user_rqb(0);
	    //$this->data['team_rqb'] = $this->User_Model->user_rqb(2);
		
		//是否需要显示搜索辅助函数
		$this->data['searchkeys'] = true;


		/*SEO设置*/
		if(!empty($keyword)&&$keyword!=''){$keyword=$keyword.'_';}
		$this->data['seo']['title']  = $keyword.'淘工人搜索! 全国装修工人大本营!';
		$this->data['seo']['keywords'] = '找工人,找装修工人,找室内设计师,全国装修工人大本营,装修,淘工人帮您,找工人有淘工人网更省心!';
		$this->data['seo']['description'] = '淘工人搜索致力于打造一个业主直接与工人高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
		
		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'style/mod_page.css';
		#搜索页面
		$this->data['cssfiles'][] = 'style/page_search.css';
		/*<><><>Js<><><>*/
		#键盘事件
		#$this->data['jsfiles'][] = 'js/jquery_shortcut.js';
		#返回url参数
		$this->data['jsfiles'][] = 'js/mod_click_box.js';
		$this->data['jsfiles'][] = 'js/search/url.js';
		$this->data['jsfiles'][] = 'js/search/page.js';
		$this->data['jsfiles'][] = 'js/search/fitheight.js';
		
		$this->load->view('search',$this->data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	#获取技能信息(搜索页面的技能切换框) $backtype=0 直接输出,$backtype=1则返回
	function app_skills($classid=0,$industryid=0,$hot=0,$backtype=0)
	{
		//重组数组，并验证(防止非法注入)
		$show_str = "";
		$sqlArr   = "";
		$newIndustryArr="";
		
		if($industryid!=""){
		   $industryidarr=split("_",$industryid);
		   foreach($industryidarr as $item){
			  if(is_numeric($item)){
				 if($newIndustryArr==""){$newIndustryArr=$item;}else{$newIndustryArr.=",".$item;}
			  }
		   }
		}
		
		//生成相应的筛选条件
		if($classid==""){
		   $row = $this->Industry_Model->industry_class_id();
		   $classid=$row->id;
		}elseif($classid=="no"){
		   $classid="";
		}
		//
		if(is_numeric($classid)&&$newIndustryArr!=""){
		  $sqlArr=" where industryid in ($newIndustryArr) and classid = $classid";
		}elseif(is_numeric($classid)){
		  $sqlArr=" where classid = $classid";
		}elseif($newIndustryArr!=""){
		  $sqlArr=" where industryid in ($newIndustryArr)";
		} 
		//
        if($hot==1){
           if($sqlArr==""){
			   $hot_sqlArr=" where industryid<>0";}else{$hot_sqlArr=$sqlArr." and industryid<>0";
			   }
           $csql = "select * from industry".$hot_sqlArr." order by stimes desc,title asc,id desc LIMIT 4"; 
		   //$show_str.='<span style="padding-top:8px; padding-left:6px;padding-right:6px;float:left;"><img title="热门项目!" src="/public/images/ico/hot.gif" /></span>';
        }else{
	       $csql = "select * from industry".$sqlArr." order by title asc,id desc";	
		   
        }
		
		$show_str='<a href="javascript:void(0);" id="no" class="on">不限</a>';  
		//
		$row=$this->db->query($csql)->result();
		$show_skills="";
		foreach($row as $rs){
		  $show_skills.='<a href="javascript:void(0);" id="'.$rs->id.'">'.$rs->title.'</a>';
		}
		if($show_skills!=""){
		   $show_skills=$show_str.$show_skills;
		}
		$show_skills.='<div class="clear"></div>';
		
		//返回的形式不一样
		if($backtype==0){
		  json_echo($show_skills);
		}else{
		  return $row;	
		}

	}



/*记录检索条件框的状态(opend or close)*/
	function open()
	{
		$isopen = $this->input->get("isopen");
		if(!empty($isopen)&&$isopen=="1")
		{
			$cookie = array('isopen'   => '1');
		}else{
			$cookie = array('isopen'   => '0');
		}
		$this->session->set_userdata($cookie);
	}

	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
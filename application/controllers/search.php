<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends QT_Controller {
	
	public $industry_class_id;
	function __construct()
	{
		parent::__construct();

		$this->load->model('Industry_Model');
		$this->load->helper('cookie');
		
		//初始化 industry_class_id
		$this->industry_class_id = $this->Industry_Model->industry_class_id();
	}


	function index()
	{
		//评测应用程序
		//$this->output->enable_profiler(true);
		
		//分页模型
		$this->load->library('paging');
		
		//地区模型
		$this->load->model('Projacts');
		$this->load->model('Search_Model');
		$this->load->model('Approve_Model');
		$this->load->model('Favorites_Model');

	    //搜索页面所有参数
		$c_id = $this->Place_Model->c_id;
		$a_id = $this->Place_Model->a_id;
		$page = $this->input->getnum("page");
		
		$usertype = $this->input->getnum("usertype",'no');
		$classid = $this->input->getnum("classid");
		$level = $this->input->getnum("level");
		$age = $this->input->getnum("age");

		$industryid = $this->input->get("industryid");
		$hot_skills = $this->input->get("hot_skills");
		$skills = $this->input->get("skills");
		$approve = $this->input->get("approve");
		$addr_adv = $this->input->get("addr_adv");
		
		//关键词
		$keyword = $this->input->gethtml("keyword");

		//数组数据处理
		$industryid = getarray($industryid);
		$all_skills = getarray($hot_skills .'_'. $skills); //合并数组
		$hot_skills = getarray($hot_skills);
		$skills = getarray($skills);
		$approve = getarray($approve);
		
		//获取认证信息的ID
		$approves = NULL;
		if(!empty($approve) && is_array($approve))
		{
			foreach($approve as $approveID)
			{
				$approve_key = $this->Approve_Model->approve_key($approveID);
				if(!empty($approve_key))
				{
					$approves[] = $approve_key;
				}
			}
		}

		############### start to get the search sql ###################
		
		//城市-输入关键词搜索时c_id=no
		if( is_numeric($c_id) )
		{
			$this->db->where('user.c_id',(int)$c_id);
		}
		//地区-输入关键词搜索时a_id=no
		if( is_numeric($a_id) )
		{
			$this->db->where('user.a_id',(int)$a_id);
		}
		//个人或者团队
		if($usertype == '2')
		{
			$data_on[] = array( 'user.classid'=> 2, 'user.uid !='=> 1 );
			$this->db->where_on($data_on);
		}
		elseif($usertype == '0')
		{
			$data_on[] = array( 'user.classid'=> 0 );
			$this->db->where_on($data_on);
		}
		elseif($usertype == '3')
		{
			$data_on[] = array( 'user.classid'=> 2, 'user.uid'=> 1);
			$this->db->where_on($data_on);
		}
		else
		{
			//$this->db->where_in('user.classid',array(0,2));
			$this->db->where('user.classid !=',1);
		}


		//join
		if( !empty($industryid) || $classid || $keyword != '' )
		{
			$this->db->join('skills', 'user.id = skills.workerid', 'left');
			$this->db->join('industry', 'industry.id = skills.industryid', 'left');
		}
		elseif( !empty($all_skills) )
		{
			$this->db->join('skills', 'user.id = skills.workerid', 'left');
		}
		
		$this->db->join('age_class', 'age_class.id = user.entry_age', 'left');
		
		
		//擅长工种
		if(!empty($industryid))
		{
			$this->db->where_in('industry.industryid',$industryid);
		}
		//擅长类型，安装\装修\修缮
		if( $classid )
		{
			$this->db->join('industry_class', 'industry_class.id = industry.classid', 'left');
			$this->db->where('industry_class.id',$classid);
		}
		//擅长技能
		if(!empty($all_skills))
		{
			$this->db->where_in('skills.industryid',$all_skills);
		}
		//工作年限范围
		if( $age )
		{
			$this->db->where('user.entry_age',$age);
		}
		//认证
		if(!empty($approves) && is_array($approves))
		{
			foreach($approves as $approve_key)
			{
				$this->db->where('user.'.$approve_key,1);
			}
		}
		//查询关键字(增强)
		if($keyword != '')
		{
			$keylike_on[] = array( 'user.name'=> $keyword );
			$keylike_on[] = array( 'user.note'=> $keyword );
			$keylike_on[] = array( 'user.address'=> $keyword );
			$keylike_on[] = array( 'user.addr_adv'=> $keyword );
			$keylike_on[] = array( 'industry.title'=> $keyword );
			$this->db->like_on($keylike_on);
		}
		//优势位置(11-4-29)
		if($addr_adv == '1')
		{
			$this->db->where('user.addr_adv !=','');
		}
		
        //生成搜索sql
		$this->db->select('user.id,user.name,user.truename,user.photoID,user.mobile,user.qq,user.classid,age_class.title as entry_age');
		$this->db->select('user.approve_sj,user.approve_yx,user.approve_sm,user.uid,user.address,user.addr_adv');
		$this->db->from('user');
		//$this->db->where('user.id !=','');
		$this->db->where('user.photoID !=','');
		$this->db->group_by('user.id');
		$this->db->order_by('user.uid','desc');
		$this->db->order_by('user.visited','desc');
		$this->db->order_by('user.id','asc');

		//获取搜索内容
		$search_sql = $this->db->getSQL();
		//echo $search_sql;
		$this->data["list"] = $this->paging->show($search_sql,10);
		
		//用于判断技能框的显示状态 展开or收起
		$this->data['isopen'] = $this->session->userdata('isopen');
		
		//返回关键词
		$this->data['keyword'] = $keyword;
		
		//当前地区和被选中的地区id
		$this->data['areas'] = $this->Place_Model->areas();
		$this->data['area_id'] = $this->Place_Model->a_id;
		
		//选中个人或团队
		$user_types = $this->User_Model->search_worker_types();
		$this->data['items_usertype'] = SelectListItems( $user_types ,$usertype,'不限',0);
		
		//选中的工种id
		$industrys = $this->Projacts->industrys();
		$this->data['industryid'] = $industryid;
		$this->data['items_industrys'] = SelectListItems($industrys,$industryid,'不限',0);
		
		//项目分类和被选中的项目分类id
		$this->data['industry_class'] = $this->Industry_Model->industry_class();
		$this->data['class_id'] = $classid;
		
		//选中的级别id
		$levels = $this->Search_Model->levels();
		$this->data["items_levels"] = SelectListItems($levels,$level,'不限',0);
		
		//选中的年限id
		$ages = $this->Search_Model->ages();
		$this->data["items_ages"] = SelectListItems($ages,$age,'不限',0);
		
		//选中的认证id
		$approves = $this->Search_Model->approves();
		$this->data["items_approves"] = SelectListItems($approves,$approve,'不限',0);
		
		$skillsS = $this->app_skills($classid,$industryid,0,1);
		$this->data['items_skills'] = SelectListItems($skillsS,$skills,'不限',0);
		
		$skillhots = $this->app_skills($classid,$industryid,1,1);
		$this->data['items_skillhots'] = SelectListItems($skillhots,$hot_skills,'不限',0);

		//排名-英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);

		//是否需要显示搜索辅助函数
		$this->data['searchkeys'] = true;

		//SEO设置
		if(!empty($keyword) && $keyword != '')
		{
			$keyword = $keyword.'_';
		}
		
		$this->data['seo']['title']  = $keyword.'淘工人搜索! 全国装修工人大本营!';
		$this->data['seo']['keywords'] = '找工人,找装修工人,找室内设计师,全国装修工人大本营,装修,淘工人帮您,找工人有淘工人网更省心!';
		$this->data['seo']['description'] = '淘工人搜索致力于打造一个业主直接与工人高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
		
		//css样式
		$this->data['cssfiles'][] = 'style/mod_page.css';
		//搜索页面
		$this->data['cssfiles'][] = 'style/page_search.css';
		//返回url参数
		$this->data['jsfiles'][] = 'js/mod_click_box.js';
		$this->data['jsfiles'][] = 'js/search/url.js';
		$this->data['jsfiles'][] = 'js/search/page.js';

		$this->load->view('search',$this->data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	#获取技能信息(搜索页面的技能切换框) $backtype=0 直接输出,$backtype=1则返回
	function app_skills($classid=0,$industryid=0,$hot=0,$backtype=0)
	{
		//重组数组，并验证(防止非法注入)
		$show_skills = NULL;  //记录技能，并返回显示
		$industryidarr = NULL;

		//生成相应的筛选条件
		if(is_num($classid) == false)
		{
			$classid = $this->industry_class_id;
		}
		if(is_num($classid))
		{
			$this->db->where('classid',(int)$classid);
		}
		if(!empty($industryid) && is_array($industryid))
		{
			$this->db->where_in('industryid',$industryid);
		}
		$this->db->select('id,title,industrys,industryid');
		$this->db->from('industry');
		$this->db->order_by('title','desc');
		$this->db->order_by('id','desc');
        if($hot == 1)
		{
			$this->db->where('industryid !=',0);
			$this->db->order_by('stimes','desc');
			$this->db->limit(4);
        }
		
		$row = $this->db->get()->result();
		foreach( $row as $rs )
		{
			$show_skills.= '<a href="javascript:void(0);" id="'.$rs->id.'">'.$rs->title.'</a>';
		}
		if($show_skills != '')
		{
			$show_skills = '<a href="javascript:void(0);" id="no" class="on">不限</a>'.$show_skills;
		}
		$show_skills.= '<div class="clear"></div>';
		
		//返回的形式不一样
		if($backtype == 0)
		{
			json_echo($show_skills);
		}
		else
		{
			return $row;	
		}
	}
	
	/*记录检索条件框的状态(opend or close)*/
	function open()
	{
		$isopen = $this->input->getnum("isopen",'0');
		if( $isopen == '1' )
		{
			$cookie = array('isopen' => '1');
		}
		else
		{
			$cookie = array('isopen' => '0');
		}
		$this->session->set_userdata($cookie);
	}

	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
/**
 * 前台父控制器
 *
 * 前台的所有控制器都需要继承这个类，
 *
 * @author ken <394716221@qq.com>
 */
 class SITE_Controller extends CI_Controller {
	
	public $data;
	public $logid = NULL;

	function __construct(){
		parent::__construct();
		
		/*初始化登录信息*/
		$this->data = $this->ini_login();
		
		//(全局)配置，文件路径
		$this->data["css_url"] = $this->config->item("css_url");
		$this->data["img_url"] = $this->config->item("img_url");
		$this->data["fla_url"] = $this->config->item("fla_url");
		$this->data["js_url"]  = $this->config->item("js_url");
		$this->data["jq_url"]  = $this->config->item("jq_url");
		$this->data["plugins"] = $this->config->item("plugins");
    }
	
	
	//初始化登录信息
	function ini_login()
	{
		$data["logid"] = 0;  //未登录参数
		$data["c_url"] = '';
		//用户信息
		$logid = $this->session->userdata("logid");
		$classid = $this->session->userdata("classid");
		$uid = $this->session->userdata("uid");
		
		//判断是否已经登录 ($classid==2&&$uid==1):企业
		if( ( is_num($logid) != false ) && ($classid==0||$classid==1||($classid==2&&$uid==1)) )
		{
			$this->logid = $logid;
			$data["logid"] = $logid;
			$data["classid"] = $classid;
			//用户管理链接
			$data["c_url"] = $this->session->userdata("admin_url");
			//当前控制器路径(用于方便管理、编辑、删除等操作)
			$data["c_urls"] = $data["c_url"].$this->uri->segment(2);
		}
		return $data;
	}
	
 }
 
 
 //淘工人公共配置
 class TG_Controller extends SITE_Controller {

	function __construct(){
		parent::__construct();
		
		//评测应用程序
		//$this->output->enable_profiler(true);

		/*初始化SEO设置*/
		$this->data['seo'] = $this->config->item("seo");
		
		//(全局)样式文件聚合
		$this->data['cssfiles'] = $this->config->item("cssfiles");
		$this->data['jsfiles']  = $this->config->item("jsfiles");

		//用户管理中心路径
		$this->data["w_url"] = $this->config->item("w_url");
		$this->data["e_url"] = $this->config->item("e_url");
		$this->data["s_url"] = $this->config->item("s_url");
		$this->data["company_url"] = $this->config->item("company_url");

		//头像保存目录
		$this->data["face_url"] = $this->config->item("face_url");
		$this->data["uploads_url"] = $this->config->item("uploads_url");
		
		//页面顶部的城市选择框
		//$this->Place_Model->provinces() = $this->Place_Model->provinces();
		
		//搜索部分
		if($this->uri->segment(1)=="retrieval")
		{
			$this->data["search_type"]  = "retrieval";
			$this->data["search_title"] = "装修信息";
		}
		else
		{
			$this->data["search_type"]  = "search";
			$this->data["search_title"] = "装修工人";	
		}
		
		//更新
		//$this->update_scor();
		//$this->update_skills();
    }
	
	
	
	
	//更新评分
	function update_scor()
	{
		$this->load->model('Common_Model');
		$this->db->select('id,scorarr');
		$this->db->from('evaluate');
		$row = $this->db->get()->result();
		foreach($row as $rs)
		{
			$scorarr = $rs->scorarr;
			$scorarr = str_replace('_','|',$scorarr);
			$this->db->where('id',$rs->id);
			$dataup['scorarr'] = $scorarr;
			$dataup['scor_total'] = $this->Common_Model->rating_scor_total($scorarr);
			$this->db->update('evaluate',$dataup);
		}	
	}
	//更新技能
	function update_skills()
	{
		$this->load->model('Skills_Model');
		$this->load->model('Industry_Model');
		
		$this->db->select('id,industryid');
		$this->db->from('skills');
		$this->db->where('industrys',0);
		$this->db->limit(20000);
		$row = $this->db->get()->result();
		if( !empty($row) )
		{
			//print_r($row);
			foreach($row as $rs)
			{
				$ii = $this->Industry_Model->industryes_view( $rs->industryid,1);
				if(!empty($ii))
				{
					//找到相应的信息，则保留
					$this->db->where('id',$rs->id);
					$dataup['industrys'] = $ii->industryid;
					$dataup['classid'] = $ii->classid;
					$this->db->update('skills',$dataup);
				}
				else
				{
					//否则清除
					$this->db->where('id',$rs->id);
					$this->db->delete('skills');
				}
			}
			echo 'xx';exit;
		}
		echo 'end';exit;
	}
	
	
	
	
 }
 
 
 
/**
 * 网站样式配置(css & js)
 */
 class STYLE_Controller extends SITE_Controller {
	 function __construct(){
		parent::__construct();
		//$this->output->cache(10);
	 }
 }



/**
 * 网站前台基本配置
 */
 class QT_Controller extends TG_Controller {

	function __construct(){
		parent::__construct();
		
		//对前台页面使用【缓存技术】(注意：使用后，将会导致页面刷新后不更新的情况。故慎用!)
		//$this->output->cache(10);
		
		//系统管理中心路径
		$this->data["s_url"] = $this->config->item("s_url");
		//当前控制器路径(用于方便管理、编辑、删除等操作)
		$this->data["s_urls"] = $this->data["s_url"].$this->uri->segment(2);

		//右边浮动留言按钮
		$this->data['jsfiles'][] = 'js/mod_float.js';         
    }
 }

 
 
/**
 * 用户后台基本配置
 */
 class HT_Controller extends TG_Controller {
	 
	 function __construct(){
		parent::__construct();
		
		//检查登陆
		if(is_num($this->session->userdata("logid"))==false)
		{
			redirect('/index');
		}
		
		$this->load->helper('publicedit');
		
		//编辑器目录
		$this->data["edit_url"]= $this->config->item("edit_url");
		//头像上传目录
		$this->data["up_url"]  = $this->config->item("up_url");
		//基本配置信息
		$this->data['cssfiles'][] = 'style/edit_main.css';
		$this->data['jsfiles'][] = 'js/edit_item_over.js';
		
		//ajax 表单提交方式
		$this->data['formTO']->backtype = 2;
    }
	
	
	//用户后台页面跳转后对ajax加载的url加密保护
	function center_ajax_pass_url($mainpage='userinfo')
	{
		$page = $this->input->get('p');
		$key = $this->input->get('key');
		if( !empty($page) && pass_key($page) != $key )
		{
			$page = 'NULL';
		}
		//这里的 $this->data["page"] 将用于ajax页面加载
		$this->data["page"] = empty($page) ? $this->data['c_urls'].'/'.$mainpage : $page;
	}
	
 }


/**
 * 工人用户后台父控制器
 * 后台的所有控制器都需要继承这个类，主要包含验证
 */
 class W_Controller extends HT_Controller {
	 
	 public $TeamID;
	 public $UserIds; //用于记录工人和团队id
	 
	 function __construct(){
		 parent::__construct();
		 $classid = $this->session->userdata("classid");
		 //判断是否工人登录
		 if($classid!=0)
		 {
			 redirect('/index');exit;
		 }

		 if( is_num($this->logid) )
		 {
			 //记录登录用户id
			 $this->UserIds[] = $this->logid;
			 //如果已经创建团队，则同时记录团队ID
			 $this->load->model('Team_Model');
			 $this->TeamID = $this->Team_Model->user_get_team_id( $this->logid );
			 if( $this->TeamID )
			 {
				 $this->UserIds[] = $this->TeamID;
			 }
		 }
	 }
 }


/**
 * 业主用户后台父控制器
 * 后台的所有控制器都需要继承这个类，主要包含验证
 */
 class E_Controller extends HT_Controller {
	 function __construct(){
		 parent::__construct();
		 $classid = $this->session->userdata("classid");
		 //判断是否工人登录
		 if($classid!=1){ redirect('/index');exit; }
	 }
 }
 

/**
 * 企业用户后台父控制器
 * 后台的所有控制器都需要继承这个类，主要包含验证
 */
 class COMPANY_Controller extends HT_Controller {
	 function __construct(){
		 parent::__construct();
		 $classid = $this->session->userdata("classid");
		 $uid = $this->session->userdata("uid");
		 //判断是否企业登录
		 if($classid!=2||$uid!=1){ redirect('/index');exit; }
	 }
 }






/**
 * 系统后台父控制器
 *
 * 系统后台的所有控制器都需要继承这个类，主要包含验证
 *
 */
class XT_Controller extends TG_Controller {
	
	function __construct(){
		parent::__construct();
		/** 检查是否已登陆 */
		$power_system = $this->session->userdata("power_system");
		if(!empty($power_system)&&is_num($power_system['logid'])){
			$this->data["power_system"] = $power_system;
		}else{
			redirect('/index'); //登录失败则跳转到主页
		}

		//系统管理中心路径
		$this->data["s_url"] = $this->config->item("s_url");
		
		//当前控制器路径(用于方便管理、编辑、删除等操作)
		$this->data["s_urls"] = $this->data["s_url"].$this->uri->segment(2);
		
		//css样式
		$this->data['cssfiles'][] = 'style/edit_main.css';
		$this->data['cssfiles'][] = 'system_style/main.css';
		$this->data['jsfiles'][] = 'system_style/jquery_table_over.js';
		$this->data['jsfiles'][] = 'T.js';
    }
	
	//将site_url重写，指向后台目录
	function site_url($url='index')
	{
		return site_url($this->data['s_url'].$url);
	}
	
	//将page_url，指向后台某控制器
	function page_url($url='index')
	{
		return site_url($this->data['s_urls'].'/'.$url);
	}
	
	
	
}



/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */
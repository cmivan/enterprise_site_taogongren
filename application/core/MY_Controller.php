<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
/**
 * 前台父控制器
 *
 * 前台的所有控制器都需要继承这个类，
 *
 * @author ken <394716221@qq.com>
 */
 class MY_Controller extends CI_Controller {
	
	public $data;
	
	function __construct(){
		parent::__construct();
    }
 }
 
 
 //淘工人公共配置
 class TG_Controller extends CI_Controller {
	
	var $data;
	
	function __construct(){
		parent::__construct();
		
		//评测应用程序
		//$this->output->enable_profiler(true);
		
		/*初始化登录信息*/
		$this->data = $this->ini_login();
		
		/*初始化SEO设置*/
		$this->data['seo'] = $this->config->item("seo");
		
		//(全局)样式文件聚合
		$this->data['cssfiles'] = $this->config->item("cssfiles");
		$this->data['jsfiles']  = $this->config->item("jsfiles");
		
		//(全局)配置，文件路径
		$this->data["css_url"] = $this->config->item("css_url");
		$this->data["img_url"] = $this->config->item("img_url");
		$this->data["fla_url"] = $this->config->item("fla_url");
		$this->data["js_url"]  = $this->config->item("js_url");
		$this->data["jq_url"]  = $this->config->item("jq_url");
		
		//用户管理中心路径
		$this->data["w_url"] = $this->config->item("w_url");
		$this->data["e_url"] = $this->config->item("e_url");
		$this->data["s_url"] = $this->config->item("s_url");
		$this->data["company_url"] = $this->config->item("company_url");

		//头像保存目录
		$this->data["face_url"] = $this->config->item("face_url");
		$this->data["uploads_url"] = $this->config->item("uploads_url");

		//搜索部分
		if($this->uri->segment(1)=="retrieval"){
			$this->data["search_type"]  = "retrieval";
			$this->data["search_title"] = "装修信息";
		}else{
			$this->data["search_type"]  = "search";
			$this->data["search_title"] = "装修工人";	
		}

    }
	
	//初始化登录信息
	function ini_login()
	{
		$data["logid"] = 0;  //未登录参数
		$data["c_url"] = '';
		//用户信息
		$logid = is_num($this->session->userdata("logid"));
		$classid = $this->session->userdata("classid");
		$uid = $this->session->userdata("uid");
		//判断是否已经登录 ($classid==2&&$uid==1):企业
		if($logid&&($classid==0||$classid==1||($classid==2&&$uid==1))){
			
			$data["logid"]   = $logid;
			$data["classid"] = $classid;
			//用户管理链接
			$data["c_url"] = $this->session->userdata("admin_url");
			//当前控制器路径(用于方便管理、编辑、删除等操作)
			$data["c_urls"] = $data["c_url"].$this->uri->segment(2);
		}
		return $data;
	}

	//传递网站基本变量
	function basedata()
	{
		return $this->data;
	}
 }
 
 
 
/**
 * 网站样式配置(css & js)
 */
 class STYLE_Controller extends TG_Controller {
	 
	var $data;
	
	function __construct(){
		parent::__construct();
    }
 }







/**
 * 网站前台基本配置
 */
 class QT_Controller extends STYLE_Controller {
	 
	var $data;
	
	function __construct(){
		parent::__construct();
		//对前台页面使用【缓存技术】(注意：使用后，将会导致页面刷新后不更新的情况。故慎用!)
		//$this->output->cache(2);
		
		//系统管理中心路径
		$this->data["s_url"] = $this->config->item("s_url");
		//当前控制器路径(用于方便管理、编辑、删除等操作)
		$this->data["s_urls"] = $this->data["s_url"].$this->uri->segment(2);

		#右边浮动留言按钮
		$this->data['jsfiles'][] = 'js/mod_float.js';   
		
		//页面顶部的城市选择框
		$this->data["placebox"]  = $this->Place;
		$this->data["provinces"] = $this->Place->provinces(0);
		$this->data["citys"]     = $this->Place->citys(0);
		      
    }
 }

 
 
/**
 * 用户后台基本配置
 */
 class HT_Controller extends TG_Controller {

	var $data;
	
	function __construct(){
		parent::__construct();
		
		//检查登陆
		if(is_num($this->session->userdata("logid"))==false){
			redirect('/index');
			}
		
		//编辑器目录
		$this->data["edit_url"]= $this->config->item("edit_url");
		//头像上传目录
		$this->data["up_url"]  = $this->config->item("up_url");
		//基本配置信息
		$this->data['cssfiles'][] = 'style/edit_main.css';
		$this->data['jsfiles'][] = 'js/edit_item_over.js';
		
		//页面顶部的城市选择框
		$this->data["placebox"]  = $this->Place;
		$this->data["provinces"] = $this->Place->provinces(0);
		$this->data["citys"]     = $this->Place->citys(0);
		
    }
 }


/**
 * 工人用户后台父控制器
 * 后台的所有控制器都需要继承这个类，主要包含验证
 */
 class W_Controller extends HT_Controller {
	 var $data;
	 function __construct(){
		 parent::__construct();
		 $classid = $this->session->userdata("classid");
		 //判断是否工人登录
		 if($classid!=0){ redirect('/index');exit; }
	 }
 }


/**
 * 业主用户后台父控制器
 * 后台的所有控制器都需要继承这个类，主要包含验证
 */
 class E_Controller extends HT_Controller {
	 var $data;
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
	 var $data;
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
	
	var $data;
	
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
		
		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'style/edit_main.css';
		$this->data['cssfiles'][] = 'system_style/main.css';
		$this->data['jsfiles'][] = 'system_style/jquery_table_over.js';
		
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
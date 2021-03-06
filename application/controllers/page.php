<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends QT_Controller {
	
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
		
		
		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'style/mod_page.css';
		/*<><><>Js<><><>*/
		$this->data['jsfiles'][]  = 'js/mod_page.js';
		
	}

	
	function error_404()
	{
		/*加载模型*/
	    $this->load->model('Projacts');
		/*工种项目*/
		$this->data['industrys'] = $this->Projacts->industrys();
		/*输出到视窗*/
		$this->load->view('page/error_404',$this->data);
	}
	

    #关于淘工人
	function about()
	{
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/about',$this->data);
	}

    #使用协议
	function agreement()
	{
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/agreement',$this->data);
	}

    #支付方式
	function payment()
	{
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'images/payment/rcss.css';
		$this->load->view('page/payment',$this->data);
	}

    #版权声明
	function statement()
	{
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/statement',$this->data);
	}

    #帮助中心
	function help()
	{
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/help',$this->data);
	}


    #发送站内消息
	function box_sendmsg()
	{
		$uid = is_num($this->input->get("uid"));
		if($uid != false)
		{
		   $this->data["uid"]  = $uid;
		   $this->data["links"] = $this->User_Model->links($uid);
		   
		   /*表单配置*/
		   $this->data['formTO']->url = 'action/send_msg_save';
		   $this->data['formTO']->backurl = '';
		
		   $this->load->view('page/box_sendmsg',$this->data);	
		}else{
		   json_echo("很遗憾,未能正确获取用户信息!");
		}
	}

    #获取手机号码
	function box_getmobile()
	{
		$uid = is_num($this->input->get("uid"));
		$gid = is_num($this->input->get("gid"));
		if($uid != false&&$gid != false)
		{
		   $this->data["uid"]  = $uid;
		   $this->data["gid"]  = $gid;
		   $this->data["links"] = $this->User_Model->links($uid);
		   $this->load->view('page/box_getmobile',$this->data);	
		}else{
		   json_echo("很遗憾,未能正确获取用户信息!");
		}
	}

    #联系淘工人
	function contact()
	{
		$this->load->view('page/contact',$this->data);
	}

    #意见反馈
	function feedback()
	{
		/*表单配置*/
		$this->data['formTO']->url = 'action/feedback';
		$this->data['formTO']->backurl = '';
		
		$this->load->view('page/feedback',$this->data);
	}

    #收藏按钮
	function favicon()
	{
		$this->load->helper('download');
		$name = '淘工人网-全国装修工人大本营.url';
		$name = iconv("utf-8","gb2312",$name);
		$data = '[InternetShortcut]'.chr(10);
		$data.= 'URL='.siteurl().chr(10);
//		$data.= 'IconIndex=0'.chr(10);
//		$data.= 'IconFile=C:\WINDOWS\system32\url.dll'.chr(10);
//		$data.= 'Modified=F063388BF3F4CB01C9'.chr(10);
//		$data.= '[InternetShortcut.A]'.chr(10);
//		$data.= '[InternetShortcut.W]';
		$data.= 'IDList='.chr(10);
		$data.= '[{000214A0-0000-0000-C000-000000000046}]'.chr(10);
		$data.= 'Prop3=19,2';

		force_download($name, $data);
	}
	
    #登录
	function login()
	{
		$this->load->view('page/login',$this->data);
	}

    #工程项目
	function projects($industryid=0)
	{
		/*加载模型*/
	    $this->load->model('Projacts');
		
		//被选中的项目id
		$industryid = is_num($industryid);
		if($industryid){ $this->data['industryid'] = $industryid; }

		/*工种项目*/
		$this->data['projact'] = $this->Projacts->projact();
		$this->data['industrys'] = $this->Projacts->industrys();
		
		$this->load->view('page/projects',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
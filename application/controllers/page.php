<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends QT_Controller {

	function __construct()
	{
		parent::__construct();

		//css样式
		$this->data['cssfiles'][] = 'style/mod_page.css';
		//Js
		$this->data['jsfiles'][]  = 'js/mod_page.js';
	}

	
	function error_404()
	{
		//加载模型
	    $this->load->model('Projacts');
		//工种项目
		$this->data['industrys'] = $this->Projacts->industrys();
		//输出到视窗
		$this->load->view('page/error_404',$this->data);
	}
	

    #关于淘工人
	function about()
	{
		//【缓存技术】(注意：使用后，将会导致页面刷新后不更新的情况。故慎用!)
		$this->output->cache(20);
		
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/about',$this->data);
	}

    #使用协议
	function agreement()
	{
		$this->output->cache(20);
		
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/agreement',$this->data);
	}

    #支付方式
	function payment()
	{
		$this->output->cache(20);
		
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
		$this->output->cache(20);
		
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/statement',$this->data);
	}

    #帮助中心
	function help()
	{
		$this->output->cache(20);
		
		#英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);

		$this->load->view('page/help',$this->data);
	}


    #发送站内消息
	function box_sendmsg()
	{
		$uid = $this->input->getnum("uid");
		if($uid != false)
		{
		   $this->data["uid"]  = $uid;
		   $this->data["links"] = $this->User_Model->links($uid);
		   
		   /*表单配置*/
		   $this->data['formTO']->url = 'action/send_msg_save';
		   $this->data['formTO']->backurl = '';
		
		   $this->load->view('page/box_sendmsg',$this->data);	
		}
		else
		{
		   json_echo("很遗憾,未能正确获取用户信息!");
		}
	}

    #获取手机号码
	function box_getmobile()
	{
		$uid = $this->input->getnum("uid");
		$gid = $this->input->getnum("gid");
		if($uid != false&&$gid != false)
		{
		   $this->data["uid"]  = $uid;
		   $this->data["gid"]  = $gid;
		   $this->data["links"] = $this->User_Model->links($uid);
		   $this->load->view('page/box_getmobile',$this->data);	
		}
		else
		{
		   json_echo("很遗憾,未能正确获取用户信息!");
		}
	}

    #联系淘工人
	function contact()
	{
		$this->output->cache(20);
		$this->load->view('page/contact',$this->data);
	}

    #意见反馈
	function feedback()
	{
		$this->output->cache(20);
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
		$this->output->cache(20);
		$this->load->view('page/login',$this->data);
	}

    #工程项目
	function projects($industryid=0)
	{
		$this->output->cache(20);
		
		/*加载模型*/
	    $this->load->model('Projacts');
		
		//被选中的项目id
		$industryid = get_num($industryid);
		if($industryid)
		{
			$this->data['industryid'] = $industryid;
		}

		/*工种项目*/
		$this->data['projact'] = $this->Projacts->projact();

		$this->load->view('page/projects',$this->data);
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
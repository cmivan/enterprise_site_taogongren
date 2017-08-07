<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;  //登录用户id
	public $user;
	public $uid = 0; //当前用户id
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/
		
		//$this->output->enable_profiler(true);

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		//初始化加载模型

		
		/*<><><>css样式<><><>*/
		#评级打分
		$this->data['cssfiles'][] = 'style/mod_star.css';
		#排期日历
		$this->data['cssfiles'][] = 'js/fullcalendar/fullcalendar.css';

	}
	
	
	#页面基础链接
	function base_data($uid=1)
	{
		//检测id不符合则返回404页面
		$this->uid = is_num($uid,'404');
		$this->data['uid'] = $this->uid;
		
		$page_url = 'v'.$uid.'_';
		$this->data['page_url'] = 'company/'.$page_url;
		/*获取用户信息*/
		$this->user = $this->User_Model->info($this->uid);
		/*保证找到该用户信息并要求该用户为系统录入的团队用户(即企业)*/
	    if(!empty($this->user)&&$this->user->classid==2&&$this->user->uid==1){
			$this->data["id"] = $this->user->id;
			$this->data["name"] = $this->user->name;
			$this->data["truename"] = $this->user->truename;
			$this->data["note"] = $this->user->note;
			$this->data["photoID"] = $this->user->photoID;
			$this->data["addr_adv"] = $this->user->addr_adv;
			$this->data["address"] = $this->user->address;
			$this->data["cardnum"] = $this->user->cardnum;
			$this->data["cardnum2"] = $this->user->cardnum2;
			$this->data["team_ckbj"] = $this->user->team_ckbj;
			$this->data["team_fwxm"] = $this->user->team_fwxm;
			$this->data["team_fwdq"] = $this->user->team_fwdq;
			

			/*页面导航设置*/
			$nav[] = array('title'=>'首页','key'=>'index');
			$nav[] = array('title'=>'公司简介','key'=>'about');
			$nav[] = array('title'=>'服务项目','key'=>'service');
			$nav[] = array('title'=>'案例展示','key'=>'cases');
			$nav[] = array('title'=>'荣誉证书','key'=>'certificate');
			$nav[] = array('title'=>'参考价格','key'=>'price');
			
			//more链接
			$this->data['nav_more']['cases'] = site_url($this->data['page_url'].'cases');
			$this->data['nav_more']['certificate'] = site_url($this->data['page_url'].'certificate');
			
			$on = $this->uri->segment(2);
			if($on==$uid){ $on = $page_url.'index'; }
			
			$this->data['company_nav'] = '';
			foreach($nav as $nitem){
				if(!empty($nitem)){
					if(!empty($on)&&$on==($page_url.$nitem['key'])){
						
						/*SEO设置*/
						$this->data['seo']['title'] = $this->data["truename"].'-'.$nitem['title'].','.$this->data['seo']['title'];
						$this->data['seo']['keywords'] = $this->data["truename"].','.$this->data["name"].','.$this->data["address"].','.$this->data['seo']['keywords'];
						$this->data['seo']['description'] = $this->data["addr_adv"].$this->data['seo']['description'];
						
						$this->data['company_nav'].= '<li class="choose_on"><a href="javascript:void(0);">'.$nitem['title'].'</a></li>';
					}else{
						$this->data['company_nav'].= '<li><a href="'.site_url($this->data['page_url'].$nitem['key']).'">'.$nitem['title'].'</a></li>';
					}
				}
			}
	    }else{
			show_404('/index' ,'log_error');
	    }
	}
	

	/*企业主页*/
	function index($uid=0)
	{
		//加载基础数据
		$this->base_data($uid);
		//访问累计
	    $this->User_Model->visite($this->uid);
		
		$this->data["cases"] = $this->db->query("select * from cases where uid=".$uid." and type_id=1 order by id desc limit 4")->result();
		$this->data["certificates"] = $this->db->query("select * from cases where uid=".$uid." and type_id=2 order by id desc limit 4")->result();
		//输出到视窗
		$this->load->view('user/company/index',$this->data);
	}
	
	
	/*企业简介*/
	function about($uid=0)
	{
		//加载基础数据
		$this->base_data($uid);
		//输出到视窗
		$this->load->view('user/company/about',$this->data);
	}
	
	/*服务项目*/
	function service($uid=0)
	{
		//加载基础数据
		$this->base_data($uid);
		//输出到视窗
		$this->load->view('user/company/service',$this->data);
	}
	
	/*案例展示*/
	function cases($uid=0)
	{
		$this->load->model('Case_Model');
		$this->load->model('Paging');
		
		//加载基础数据
		$this->base_data($uid);
		
		//读取案例数据
		$listsql = $this->Case_Model->listsql($uid,1,0);
	    $this->data["lists"] = $this->Paging->show($listsql,8);
		
		//输出到视窗
		$this->load->view('user/company/cases',$this->data);
	}
	
	/*荣誉证书*/
	function certificate($uid=0)
	{
		$this->load->model('Case_Model');
		$this->load->model('Paging');
		
		//加载基础数据
		$this->base_data($uid);
		
		//读取证书数据
		$listsql = $this->Case_Model->listsql($uid,2,0);
		$this->data["lists"] = $this->Paging->show($listsql,8);
		
		//输出到视窗
		$this->load->view('user/company/certificate',$this->data);
	}
	
	/*参考价格*/
	function price($uid=0)
	{
		//加载基础数据
		$this->base_data($uid);
		//输出到视窗
		$this->load->view('user/company/price',$this->data);
	}




















	//用户登录
	function login()
	{
		/*表单配置*/
		$this->data['formTO']->url = 'company/do_login';
		$this->data['formTO']->backurl = $this->config->item('company_url').'center';
		$this->load->view('user/company/login',$this->data);
	}
	
	
	
	//验证登录
	function do_login()
	{
		$username = noSql($this->input->post('user'));
		$password = $this->input->post('pass');
		$code = $this->input->post('code');
		$CompanyVloginCode = $this->session->userdata('CompanyVloginCode');
		if($username==''){
			json_form_no('请输入用户名!');
		}elseif($password==''){
			json_form_no('请输入登录密码!');
		}elseif($code==''){
			json_form_no('请输入验证码!');
		}elseif($CompanyVloginCode==''){
			json_form_no('请重新获取验证码!');
		}elseif(md5($code)!=$CompanyVloginCode){
			json_form_no('输入的验证码有误!');
		}else{
			//清除验证码
			$this->session->set_userdata("CompanyVloginCode",'');
			
			//开始验证
			$user = $this->User_Model->user_company_login($username,$password);
			//返回状态
			if(!empty($user)){
			   //二重审核
			   if(($user->mobile!=$username)&&($rs->password!=$password)){
				   json_form_no("登录失败,帐号或密码有误!");
				   }
			   //login_nav 用于记录是否已经弹出登录向导(0未弹出,1已弹出)
			   $logdata = array(
					'logid' => $user->id,
					'username' => $username,
					'classid'  => $user->classid,
					'uid'  => $user->uid,
					'admin_url' => $this->config->item("company_url"),
					'tasknav' => '1'
					);
			   $this->session->set_userdata($logdata);
			   
			   //页面跳转
		   	   json_form_yes('登录成功!');
			}else{
			   json_form_no("登录失败,帐号或密码有误!");
			}

			json_form_no('登录失败,请重新获取验证码后登录!');
		}
	}
	

	
	
	//验证码
	function verifycode()
	{
		$x_size = 70;
		$y_size = 23;
		if(function_exists("imagecreate"))
		{
			$aimg = imagecreate($x_size,$y_size);
			$back = imagecolorallocate($aimg, 255, 255, 250);
			$border = imagecolorallocate($aimg, 0, 0, 0);
			imagefilledrectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $back);
			$txt = "0123456789";
			$txtlen=strlen($txt);

			$thetxt="";
			for($i=0;$i<4;$i++)
			{
				$randnum=mt_rand(0,$txtlen-1);
				$randang=mt_rand(-20,20);       //文字旋转角度
				$rndtxt=substr($txt,$randnum,1);
				$thetxt.=$rndtxt;
				$rndx=mt_rand(4,8);
				$rndy=mt_rand(0,3);
				$colornum1=($rndx*$rndx*$randnum)%255;
				$colornum2=($rndy*$rndy*$randnum)%255;
				$colornum3=($rndx*$rndy*$randnum)%255;
				$newcolor=imagecolorallocate($aimg, $colornum1, $colornum2, $colornum3);
				imageString($aimg,12,$rndx+$i*15,2+$rndy,$rndtxt,$newcolor);
			}
			unset($txt);
			$thetxt = strtolower($thetxt);
			$this->session->set_userdata("CompanyVloginCode",md5($thetxt));
			imagerectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $border);

			$newcolor="";
			$newx="";
			$newy="";
			$pxsum=50;     //干扰像素个数
			for($i=0;$i<$pxsum;$i++)
			{
				$newcolor=imagecolorallocate($aimg, mt_rand(0,254), mt_rand(0,254), mt_rand(0,254));
				imagesetpixel($aimg,mt_rand(0,$x_size-1),mt_rand(0,$y_size-1),$newcolor);
			}
			header("Pragma:no-cache");
			header("Cache-control:no-cache");
			header("Content-type: image/png");
			imagepng($aimg);
			imagedestroy($aimg);
			exit;
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
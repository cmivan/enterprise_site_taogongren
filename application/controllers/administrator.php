<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * _伪后台目录
 */

class Administrator extends QT_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('send');
	}

	function index()
	{
		$this->login();
	}
	
	function defaults()
	{
		$this->login();
	}
	
	function login()
	{
		$this->data['cssfiles'][] = 'style/edit_main.css';
		$this->data['cssfiles'][] = 'system_style/main.css';
		$this->data['formTO']->url = 'administrator/login_do';
		$this->data['formTO']->backurl = 'administrator/defaults';
		$this->load->view_system('_administrator/login',$this->data);
	}

	//验证登录
	function login_do()
	{
		$user = $this->input->post('user');
		$pass = $this->input->post('pass');
		$code = $this->input->post('code');
		$admin_code = $this->session->userdata('oadmincode');
		if($user==''){
			json_form_no('请输入用户名!');
		}elseif($pass==''){
			json_form_no('请输入登录密码!');
		}elseif($code==''){
			json_form_no('请输入验证码!');
		}elseif(md5($code)!=$admin_code){
			json_form_no('输入的验证码有误!'.$admin_code);
		}else{
			//虚假验证
			if(($user=='admin')&&($pass=='taogongren')){
				//登录成功,记录所需的信息
				hacking('尝试使用密码登录。成功登录（虚拟的）');
				json_form_yes('登录成功,但IP不在允许范围内!');
			}elseif(($user=='admin')&&($pass!='taogongren')){
				hacking('尝试使用密码登录。密码有误（虚拟的）');
				json_form_no('登录失败,密码有误!');
			}else{
				hacking('尝试使用密码登录。帐号及密码有误（虚拟的）');
				json_form_no('登录失败,帐号及密码有误!');
			}
			$this->session->set_userdata("oadmincode",'');
		}
	}
	
	
	
	//验证码
	function verifycode()
	{
		$x_size = 65;
		$y_size = 20;
		if(function_exists("imagecreate"))
		{
			$aimg = imagecreate($x_size,$y_size);
			$back = imagecolorallocate($aimg, 255, 255, 255);
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
			$this->session->set_userdata("oadmincode",md5($thetxt));
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
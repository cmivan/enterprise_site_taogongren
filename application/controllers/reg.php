<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg extends QT_Controller {

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
		$this->data['cssfiles'][] = 'style/mod_form.css';
		
		/*<><><>Js<><><>*/
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		$this->data['jsfiles'][]  = 'js/mod_page.js';
	}
	

	function index()
	{
		//评测应用程序
		//$this->output->enable_profiler(true);
		
		//英雄榜
	    $this->data['user_yxb'] = $this->User_Model->user_yxb(0);
	    $this->data['team_yxb'] = $this->User_Model->user_yxb(2);
		
		//重写 $this->data["citys"] 数据
		$p_id = $this->Place->provinceid();
		$this->data["citys"] = $this->Place->citys($p_id);
		
		//工人or团队
		$this->data["user_types"] = $this->User_Model->user_types();

		/*邀请者id*/
		$this->data['inviterUID'] = is_num($this->session->userdata('inviterUID'));

		/*表单配置*/
		$this->data['formTO']->url = 'reg/go';
		$this->data['formTO']->backurl = '';

		$this->load->view('reg',$this->data);
	}
	

/**
 * 验证手机号是否已经被注册
 */
	function is_reg_mobile($mobile=0)
	{
		$mobile = is_num($mobile);
		if($mobile!=false&&strlen($mobile)==11){
		   $is_reg_num = $this->db->query("select mobile from `user` where mobile='$mobile'")->num_rows();
		   if($is_reg_num>0){return false;}else{return true;}
		}else{return false;}
	}


/**
 * 保存用户注册信息
 */
	function go()
	{
		//获取数据
		$classid  = $this->input->post("classid");
		$name     = noHtml($this->input->post("name"));
		$mobile   = $this->input->post("mobile");
		$password = $this->input->post("password");
		$email    = noSql(toText($this->input->post("email")));
		$p_id     = is_num($this->input->post("p_id"),0);
		$c_id     = is_num($this->input->post("c_id"),0);
		$code     = $this->input->post("code");
		
		/*邀请者id*/
		$inviterUID = is_num($this->session->userdata('inviterUID'));
		
		//检测数据是否符合要求
		if($classid!=0&&$classid!=1){ json_form_alt("请选择你需要注册类型（工人/业主）!"); }
		if($this->is_reg_mobile($mobile)==false){ json_form_alt("你的手机号已被注册!"); }
			
		$regcode = is_num($this->session->userdata('reg_code'));
		if($regcode==false){ json_form_alt("请先获取验证码!"); }
		if($code==''){ json_form_alt("请先填写验证码!"); }
		
		if($code!=$regcode){ json_form_alt("验证码有误!"); }

		//生成语句数组
		$data = array(
					  'classid' => $classid,
					  'name' => $name,
					  'mobile' => $mobile,
					  'password' => pass_user($password),
					  'email' => $email,
					  'p_id' => $p_id,
					  'c_id' => $c_id,
					  'a_id' => 0,
					  'approve_sj' => 1
					  );
		
		/*存在邀请者id,则写入*/
		if($inviterUID){ $data['inviterID'] = $inviterUID; }
		
		//执行
		$this->db->insert('user',$data);
		//获取注册后的用户id
		$reg_uid = is_num($this->db->insert_id());
		if($reg_uid){
			#***** 费用模块 ******
			$this->load->model('Records_Model');
			$this->Records_Model->balance_control($reg_uid,"10","<活动赠送>恭喜你!注册成功并获得系统送出的10元!","T");
			//json_form_alt("恭喜你!注册成功并获得系统送出的10元!"); 
			json_form_yes("恭喜你!注册成功!"); 
		}else{
			json_form_alt("系统繁忙，注册可能失败!");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
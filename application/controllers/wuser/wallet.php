<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet extends W_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('Paging');
		$this->load->model('Records_Model');
		
		//初始化页面导航
		$this->data["thisnav"] = array(
		            array('title' => '收入记录','link' => 'in'),
					array('title' => '支出记录','link' => 'apply'),
					array('title' => '','link' => ''),
					array('title' => '提现','link' => 'take'),
					array('title' => '转账','link' => 'transfer'),
					array('title' => '提现/转账记录','link' => 'records')
		            );

		/*个人信息*/
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		
		$this->data["cost_T"] = $this->Records_Model->balance_cost($this->logid,'T');
		$this->data["cost_S"] = $this->Records_Model->balance_cost($this->logid,'S');
	}
	
	
	
	function index()
	{
		$this->in();
	}
	
	
	//收入
	function in()
	{
		$this->sql = $this->Records_Model->record_in($this->logid);
		$this->data["list"] = $this->paging->show($this->sql);
		//输出到视窗
		$this->load->view_wuser('wallet/index',$this->data);
	}
	
	//支出
	function apply()
	{
		$this->sql = $this->Records_Model->record_out($this->logid);
	    $this->data["list"] = $this->paging->show($this->sql);
		//输出到视窗
		$this->load->view_wuser('wallet/apply',$this->data);
	}
	
	//提现
	function take()
	{
		$listsql = $this->Records_Model->record_out($this->logid);
		$this->data["list"] = $this->paging->show($listsql);
		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = 'style/mod_page.css';
		$this->data['cssfiles'][] = 'style/mod_form.css';
		/*<><><>Js<><><>*/
		//下拉框选择城市
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/take_save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/records';
		//输出到视窗
		$this->load->view_wuser('wallet/take',$this->data);
	}
	function take_save()
	{
		//获取数据
		$username = noHtml($this->input->post("username"));
		$cardnum  = $this->input->postnum("cardnum");
		$cardat   = noHtml($this->input->post("cardat"));
		$cost     = $this->input->postnum("cost");
		$p_id     = $this->input->postnum("p_id");
		$c_id     = $this->input->postnum("c_id");
		$yzm      = $this->input->postnum("yzm");
		//检测数据
		if($username==""){ json_form_no('请填写姓名!'); }
		if($cardnum==false){ json_form_no('请填写正确的卡号!'); }
		if($cardat==""){ json_form_no('请填写开户行!'); }
		if($cost==false){ json_form_no('请填写正确的金额!'); }
		if($cost<=0){ json_form_no('填写金额不正确!'); }
		if($p_id==false){ json_form_no('请选择所在省份!'); }
		if($c_id==false){ json_form_no('请选择所在城市!'); }
		if($yzm==false){ json_form_no('请获取并输入正确的验证码!'); }
		//写入数据
		$data['uid'] = $this->logid;
		$data['username'] = $username;
		$data['cardnum']  = $cardnum;
		$data['cardat']   = $cardat;
		$data['cost'] = $cost;
		$data['p_id'] = $p_id;
		$data['c_id'] = $c_id;
		$data['note'] = '';
		$data['ip']   = '';
		$data['typeid'] = 0;
		$this->db->insert('records_transfer',$data);
		json_form_yes('提交成功，我们将在48小时内对您提交的信息进行处理!');
	}
	
	
	//转账
	function transfer()
	{
		$listsql = $this->Records_Model->record_out($this->logid);
		$this->data["list"] = $this->paging->show($listsql);
		//css样式
		$this->data['cssfiles'][] = 'style/mod_page.css';
		$this->data['cssfiles'][] = 'style/mod_form.css';
		//下拉框选择城市
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		//表单配置
		$this->data['formTO']->url = $this->data["c_urls"].'/transfer_save';
		$this->data['formTO']->backurl = $this->data["c_urls"].'/records';
		//输出到视窗
		$this->load->view_wuser('wallet/transfer',$this->data);
	}
	function transfer_save()
	{
		//获取数据
		$username = noHtml($this->input->post("username"));
		$cardnum  = $this->input->postnum("cardnum");
		$cardat   = noHtml($this->input->post("cardat"));
		$cost     = $this->input->postnum("cost");
		$p_id     = $this->input->postnum("p_id");
		$c_id     = $this->input->postnum("c_id");
		$yzm      = $this->input->postnum("yzm");
		//检测数据
		if($username==""){ json_form_no('请填写姓名!'); }
		if($cardnum==false){ json_form_no('请填写正确的卡号!'); }
		if($cardat==""){ json_form_no('请填写开户行!'); }
		if($cost==false){ json_form_no('请填写正确的金额!'); }
		if($cost<=0){ json_form_no('填写金额不正确!'); }
		if($p_id==false){ json_form_no('请选择所在省份!'); }
		if($c_id==false){ json_form_no('请选择所在城市!'); }
		if($yzm==false){ json_form_no('请获取并输入正确的验证码!'); }
		//写入数据
		$data['uid'] = $this->logid;
		$data['username'] = $username;
		$data['cardnum']  = $cardnum;
		$data['cardat']   = $cardat;
		$data['cost'] = $cost;
		$data['p_id'] = $p_id;
		$data['c_id'] = $c_id;
		$data['note'] = '';
		$data['ip']   = '';
		$data['typeid'] = 1;
		$this->db->insert('records_transfer',$data);
		json_form_yes('提交成功，我们将在48小时内对您提交的信息进行处理!');
	}
	
	
	//记录
	function records()
	{
		$this->sql = $this->Records_Model->record_transfer($this->logid);
	    $this->data["list"] = $this->paging->show($this->sql);
		
		//输出到视窗
		$this->load->view_wuser('wallet/records',$this->data);
	}
	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
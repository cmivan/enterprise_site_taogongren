<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Yeepay extends E_Controller {

	public $p1_MerId;
	public $p0_Cmd;
	public $p9_SAF;

	function __construct()
	{
		parent::__construct();

		$this->load->helper('yeepay');
		$this->p1_MerId = $this->config->item('YeePay_Id');
		$this->p0_Cmd   = $this->config->item('YeePay_Cmd');
		$this->p9_SAF   = $this->config->item('YeePay_Saf');
	}


	function req()
	{
		$this->load->model('Records_temp_Model');
		
		#	商家设置用户购买商品的支付信息.
		##易宝支付平台统一使用GBK/GB2312编码方式,参数如用到中文，请注意转码
		
		#	产品通用接口正式请求地址
		$reqURL_onLine = "https://www.yeepay.com/app-merchant-proxy/node";
		#	产品通用接口测试请求地址
		#$reqURL_onLine = "http://tech.yeepay.com:8080/robot/debug.action";

		
		#	商户订单号,选填.
		##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
		$p2_Order  = $this->input->post('p2_Order');
		#	支付金额,必填.
		##单位:元，精确到分.
		$p3_Amt	   = $this->input->post('p3_Amt');
		#	交易币种,固定值"CNY".
		$p4_Cur	   = "CNY";
		#	商品名称
		##用于支付时显示在易宝支付网关左侧的订单产品信息.
		//$p5_Pid	   = $this->input->post('p5_Pid');
		$p5_Pid	   = 'TG.Charge Online';
		//$p5_Pid	   = iconv("utf-8","gb2312",$p5_Pid);
		#	商品种类
		$p6_Pcat   = $this->input->post('p6_Pcat');
		#	商品描述
		$p7_Pdesc  = $this->input->post('p7_Pdesc');
		$p7_Pdesc	   = 'charge online!';
		#	商户接收支付成功数据的地址,支付成功后易宝支付会向该地址发送两次成功通知.
		//$p8_Url= $_REQUEST['p8_Url'];	
		$siteurl=strtolower($_SERVER['SERVER_NAME']);
		$p8_Url	   = "http://".$siteurl.site_url('ver/yeepay_callback');	
		#	商户扩展信息
		##商户可以任意填写1K 的字符串,支付成功时将原样返回.												
		$pa_MP	   = $this->input->post('pa_MP');
		#	支付通道编码
		##默认为""，到易宝支付网关.若不需显示易宝支付的页面，直接跳转到各银行、神州行支付、骏网一卡通等支付页面，该字段可依照附录:银行列表设置参数值.			
		$pd_FrpId  = $this->input->post('pd_FrpId');
		#	应答机制
		##默认为"1": 需要应答机制;
		$pr_NeedResponse	= "1";
		#调用签名函数生成签名串
		$hmac = getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);

		//add by cm.ivan ，写入到临时充值表
		if(is_num($p3_Amt)==false)
		{
		   json_echo("<script>alert('请输入整数');window.close();</script>");
		}
		elseif($p6_Pcat!="S"&&$p6_Pcat!="T")
		{
		   json_echo("<script>alert('充值的类型有误');window.close();</script>");
		}
		else
		{
			if( $this->Records_temp_Model->is_recorded( $this->logid , $p2_Order ) )
			{
				json_echo('<script>alert("该信息已提交,请不要重复提交!");window.close();</script>');
			}
			else
			{
				//写入充值临时表
				$data = array(
					  'p2_Order' => $p2_Order,
					  'p3_Amt' => $p3_Amt,
					  'p4_Cur' => $p4_Cur,
					  'cost_type' => $p6_Pcat,
					  'uid' => $this->logid,
					  'addtime' => dateTime()
					  );
			    $this->Records_temp_Model->record_temp_add($data);

				$this->data['reqURL_onLine'] = $reqURL_onLine;
				$this->data['p0_Cmd'] = $this->p0_Cmd;
				$this->data['p1_MerId'] = $this->p1_MerId;
				$this->data['p2_Order'] = $p2_Order;
				$this->data['p3_Amt'] = $p3_Amt;
				$this->data['p4_Cur'] = $p4_Cur;
				$this->data['p5_Pid'] = $p5_Pid;
				$this->data['p6_Pcat']  = $p6_Pcat;
				$this->data['p7_Pdesc'] = $p7_Pdesc;
				$this->data['p8_Url'] = $p8_Url;
				$this->data['p9_SAF'] = $this->p9_SAF;
				$this->data['pa_MP']    = $pa_MP;
				$this->data['pd_FrpId'] = $pd_FrpId;
				$this->data['pr_NeedResponse'] = $pr_NeedResponse;
				$this->data['hmac'] = $hmac;
				
				/*输出到视窗*/
				$this->load->view($this->data["c_url"].'wallet/yeepay',$this->data);
			}
		}
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
/**
 * 优化css及js
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_v1 extends STYLE_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');  //文件操作辅助函数
	}
	

	/**
	 * 目标:压缩资源并缓存该文件
	 */
	function js()
	{
		$this->output->set_header("Content-type: application/x-javascript");
		$content = '';
		$jsS=$this->input->get('p',true);
		if(!empty($jsS)){
			$jsSarr = split(",",$jsS);
			foreach($jsSarr as $jsitem){
				//获取后缀并判断是否符合
				if($jsitem!=''){
				  $pt = strrpos($jsitem,".");
				  if($pt){
					  $retval=substr($jsitem, $pt+1, strlen($jsitem)-$pt);
					  if(strtolower($retval)=='js'){$content = $content.chr(10).read_file('./public/'.$jsitem);}
				  }
				}
			}
			//$content = $this->compress_css($content);
			//$content = str_replace(';'.chr(10),'',$content);
			//$content = str_replace(chr(10),'',$content);

			//$this->output->cache(20);
			$this->data['content'] = $content;
			$this->load->view('public/global_cssjs',$this->data);
		}	
	}
	
	
	/**
	 * 目标:压缩资源并缓存该文件
	 */
	function css()
	{
		$this->output->set_header("Content-type: text/css");
		$content = '';
		$cssS=$this->input->get('p',true);
		if(!empty($cssS)){
			$cssSarr = split(",",$cssS);
			foreach($cssSarr as $cssitem){
				//获取后缀并判断是否符合
				if($cssitem!=''){
				  $pt = strrpos($cssitem,".");
				  if($pt){
					  $retval=substr($cssitem, $pt+1, strlen($cssitem)-$pt);
					  if(strtolower($retval)=='css'){$content = $content.chr(10).read_file('./public/'.$cssitem);}
				  }
				}
			}
			
			$content = $this->compress_css($content);
			$content = str_replace('../images','/public/images',$content);
			$content = str_replace('../','',$content);
			$content = str_replace('system_style/images/','/public/system_style/images/',$content);

			//$this->output->cache(20);
			$this->data['content'] = $content;
			$this->load->view('public/global_cssjs',$this->data);
		}
	}
	
	
	/**
	 * 页面右边的QQ在线
	 */
	 function qqs()
	 {
		 $this->load->view('public/qq_contact',$this->data);
	 }
	 
	/**
	 * 首页案例xml
	 */
	 function index_case_xml()
	 {
		 $this->load->model('Case_Model');
		 
		 $index_cases ='<?phpxml version="1.0" encoding="utf-8"?>';
		 $index_cases.='<bcaster autoPlayTime="3">';
		 
		 $index_case = $this->Case_Model->index_case(); /*首页案例*/
		 if(!empty($index_case))
		 {
			 foreach($index_case as $item)
			 {
				 $index_cases.='<item item_url="'.$item->pic.'" link="http://www.51xflash.com/" itemtitle="'.$item->title.'"></item>';
			 }
		 }
		 $index_cases.='</bcaster>';
		 
		 json_echo( $index_cases );
	 }

	
	/**
	 * 美化css,过滤多余的空格或换行
	 */
	function compress_css($buffer)
	{
	   /* remove comments */
	   $buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer) ;
	   /* remove tabs, spaces, newlines, etc. */
	   $arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ") ;
	   $buffer = str_replace($arr, "", $buffer) ;
	   return $buffer;
	}
	
	
	
	/**
	 * 手机验证等信息发送
	 */
	function sms_js($type="reg")
	{
		//加载
		$this->load->helper('send');
		
		//判断发送的类型是否符合
		if(sms_code_type_check($type)==false){ exit; }

		$this->data['is_send'] = false;
		$this->data['mobile']  = $this->session->userdata($type.'_mobile');
		$timeout = $this->session->userdata($type.'_timeout');
		if(is_num($timeout)&&$timeout>time()){ $this->data['is_send'] = true; }
		
		$this->data['timeout'] = $timeout;
		$this->data['type'] = $type;
		$this->load->view('public/sms_js',$this->data);
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
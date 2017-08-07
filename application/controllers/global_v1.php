<?php
/**
 * 优化css及js
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_v1 extends STYLE_Controller {
	
	public $styleData;  //用于返回页面数据
	
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
		if(!empty($jsS))
		{
			$jsSarr = preg_split('/,/',$jsS);
			foreach($jsSarr as $jsitem)
			{
				//获取后缀并判断是否符合
				if($jsitem!='')
				{
					$pt = strrpos($jsitem,".");
					if($pt)
					{
						$retval=substr($jsitem, $pt+1, strlen($jsitem)-$pt);
						if(strtolower($retval)=='js')
						{
							$content = $content.chr(10).read_file('./public/'.$jsitem);
						}
					}
				}
			}
			//$content = $this->compress_css($content);
			//$content = str_replace(';'.chr(10),'',$content);
			//$content = str_replace(chr(10),'',$content);

			//$this->output->cache(20);
			$this->styleData['content'] = $content;
			$this->load->view('public/global_cssjs',$this->styleData);
		}	
	}
	
	
	/**
	 * 目标:压缩资源并缓存该文件
	 */
	function css()
	{
		$this->output->set_header("Content-type: text/css");
		$content = '';
		$cssS = $this->input->get('p');
		if(!empty($cssS))
		{
			$cssSarr = preg_split('/,/',$cssS);
			foreach($cssSarr as $cssitem)
			{
				//获取后缀并判断是否符合
				if($cssitem!='')
				{
					$pt = strrpos($cssitem,".");
					if($pt)
					{
						$retval=substr($cssitem, $pt+1, strlen($cssitem)-$pt);
						if(strtolower($retval)=='css')
						{
							$content = $content.chr(10).read_file('./public/'.$cssitem);
						}
					}
				}
			}
			
			$content = $this->compress_css($content);
			$content = str_replace('../images','/public/images',$content);
			$content = str_replace('../','',$content);
			$content = str_replace('system_style/images/','/public/system_style/images/',$content);

			//$this->output->cache(20);
			$this->styleData['content'] = $content;
			$this->load->view('public/global_cssjs',$this->styleData);
		}
	}
	
	

	/**
	 * 网站头部的登录框
	 */
	 function top_login_box()
	 {
		 $this->load->view('public/top_login_box',$this->data);
	 }
	 


	/**
	 * 网站头部的地区选择
	 */
	 function top_places()
	 {
		 $this->load->view('public/top_places',$this->data);
	 }
	 
	
	/**
	 * 页面右边的QQ在线
	 */
	 function qqs()
	 {
		 //【缓存技术】(注意：使用后，将会导致页面刷新后不更新的情况。故慎用!)
		 $this->output->cache(20);
		 $this->load->view('public/qq_contact',$this->data);
	 }

	 
	
	/**
	 * 美化css,过滤多余的空格或换行
	 */
	function compress_css($buffer)
	{
	   /* remove comments */
	   $buffer = $buffer;
	   $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer) ;
	   /* remove tabs, spaces, newlines, etc. */
	   $arr = array('\r\n', '\r', '\n', '\t', '  ', '	', '    ', chr(10), chr(13)) ;
	   $buffer = str_replace($arr, '', $buffer) ;
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
		if(sms_code_type_check($type)==false)
		{
			exit;
		}
		$this->styleData['is_send'] = false;
		$this->styleData['mobile']  = $this->session->userdata($type.'_mobile');
		$timeout = $this->session->userdata($type.'_timeout');
		if(is_num($timeout)&&$timeout>time())
		{
			$this->styleData['is_send'] = true;
		}
		$this->styleData['timeout'] = $timeout;
		$this->styleData['type'] = $type;
		$this->load->view('public/sms_js',$this->styleData);
	}
	
	

	
	/**
	 * 返回最新消息数目和内容
	 */
	function new_msg_tip()
	{
		$this->load->model('Sendmsg_Model');
		$new_msg_num  = $this->Sendmsg_Model->new_msg_num($this->logid);
		$new_msg_info = '';
		if($new_msg_num>0)
		{
			$new_msg_info = '<p id="WB_new_msg"><b class="red">'.$new_msg_num.'</b>';
			$new_msg_info.= '条新消息，<a href="'.site_page2ajax('msg').'">查看我的新消息</a></p>';
			$new_msg_row = $this->Sendmsg_Model->user_new_msg($this->logid);
		    if(!empty($new_msg_row))
			{
				$new_msg_info.= '<p>'.$this->User_Model->links($new_msg_row->uid).'&nbsp;&nbsp;('.$new_msg_row->addtime.') ...</p>';
			}
		}
		json_echo('{"num":"'.$new_msg_num.'","msg":"'.txt2json($new_msg_info).'"}');
	}
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
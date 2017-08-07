<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Input扩展程序*/

class MY_Input extends CI_Input
{
	//GET数字
	function getnum($key,$back=false)
	{
		return get_num($this->get($key),$back);
	}
	
	//POST数字
	function postnum($key,$back=false)
	{
		return get_num($this->post($key),$back);
	}
	
	//GET HTML
	function gethtml($index = NULL, $xss_clean = FALSE)
	{
		return noHtml($this->get($index, $xss_clean));
	}

	//两种方式获取，多用于获取关键词
	function get_or_post($index = NULL, $xss_clean = FALSE)
	{
		$v = $this->get($index, $xss_clean);
		if($v=='')
		{
			$v = $this->post($index, $xss_clean);
		}
		return $v;
	}
	
	
	 
}
/* End of file Loader.php */
/* Location: ./system/core/Loader.php */

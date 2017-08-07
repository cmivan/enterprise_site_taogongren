<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Input��չ����*/

class MY_Input extends CI_Input
{
	//GET����
	function getnum($key,$back=false)
	{
		return get_num($this->get($key),$back);
	}
	
	//POST����
	function postnum($key,$back=false)
	{
		return get_num($this->post($key),$back);
	}
	
	//GET HTML
	function gethtml($index = NULL, $xss_clean = FALSE)
	{
		return noHtml($this->get($index, $xss_clean));
	}

	//���ַ�ʽ��ȡ�������ڻ�ȡ�ؼ���
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

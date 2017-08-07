<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*loader��չ����*/

class MY_Loader extends CI_Loader
{
	
	//��������û���̨view
	function view_wuser($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("w_url").$view, $vars, $return);
	}
	
	//���ҵ���û���̨view
	function view_euser($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("e_url").$view, $vars, $return);
	}
	
	
	//�����ҵ�û���̨view
	function view_company($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("company_url").$view, $vars, $return);
	}
	
	
	//���ϵͳ����Ա��̨view
	function view_system($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("s_url").$view, $vars, $return);
	}
	
	
	//�����ǰĿ¼�µ�view
	function view_on($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		echo $CI->uri->segment(2);
		return $this->view($CI->config->item("s_url").$view, $vars, $return);
	}
	
	
	//gzip���������ģ��
	function view_gzip($vars)
	{
		$CI = &get_instance();
		return $this->view('public/public_gzip', $vars, FALSE);
	}
	
	
	
	
	
	
	
	


		 
}
/* End of file Loader.php */
/* Location: ./system/core/Loader.php */

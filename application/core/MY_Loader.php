<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*loader扩展程序*/

class MY_Loader extends CI_Loader
{
	
	//输出工人用户后台view
	function view_wuser($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("w_url").$view, $vars, $return);
	}
	
	//输出业主用户后台view
	function view_euser($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("e_url").$view, $vars, $return);
	}
	
	
	//输出企业用户后台view
	function view_company($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("company_url").$view, $vars, $return);
	}
	
	
	//输出系统管理员后台view
	function view_system($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		return $this->view($CI->config->item("s_url").$view, $vars, $return);
	}
	
	
	//输出当前目录下的view
	function view_on($view, $vars = array(), $return = FALSE)
	{
		$CI = &get_instance();
		echo $CI->uri->segment(2);
		return $this->view($CI->config->item("s_url").$view, $vars, $return);
	}
	
	
	//gzip缓存输出的模板
	function view_gzip($vars)
	{
		$CI = &get_instance();
		return $this->view('public/public_gzip', $vars, FALSE);
	}
	
	
	
	
	
	
	
	


		 
}
/* End of file Loader.php */
/* Location: ./system/core/Loader.php */

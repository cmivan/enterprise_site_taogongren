<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Defaults extends QT_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		json_echo('<script>alert("请登录后操作!");window.location.href="'.site_url('administrator/login').'";</script>');
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
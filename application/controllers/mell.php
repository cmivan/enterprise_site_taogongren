<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mell extends QT_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	

	function index()
	{
		$this->load->view('mell',$this->data);
	}

	 
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
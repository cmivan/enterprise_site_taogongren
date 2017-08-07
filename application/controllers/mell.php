<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mell extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
	}
	

	function index()
	{
		$this->load->view('mell',$this->data);
	}

	 
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
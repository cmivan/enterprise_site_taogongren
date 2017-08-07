<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorites extends W_Controller {

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		$this->load->model('Favorites_Model');
	}
	


	function index()
	{
		
		//删除数据
		$del_id = $this->input->getnum("del_id");
		if($del_id!=false)
		{
			$this->Favorites_Model->del($del_id,$this->logid);
		}

		//分页模型
		$this->load->library('Paging');
		//获取分页列表sql
		$listsql=$this->Favorites_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->paging->show($listsql,10);
		/*输出到视窗*/
		$this->load->view_wuser('favorites',$this->data);
	}
	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
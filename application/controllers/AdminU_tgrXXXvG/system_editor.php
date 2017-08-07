<?php

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class System_editor extends XT_Controller{
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	public $uppath = '';  //用于创建上传文件目录
	
    public function __construct()
	{
        parent::__construct();
        $this->load->library('kindeditor');

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		if(!empty($this->data["power_system"])&&is_num($this->data["power_system"]['logid']))
		{
			$this->logid = $this->data["power_system"]['logid'];
		}
		else
		{
			exit;
		}

		//当前系统用户所上传的图片目录
		$this->uppath = cutstr(pass_user($this->logid.'TGRVVVV'),8);
		$this->uppath = str_replace('.','',$this->uppath);
		$this->uppath = '0v'.$this->uppath.'_'.$this->logid;
    }
	
	//上传文件
    public function upload()
	{
		$dir = $this->input->get('dir');
        if(!empty ($_FILES))
		{
			$this->kindeditor->upload($dir,$_FILES,$this->uppath);
        }
    }
	
	//管理文件
    public function manage()
	{
		$dir = $this->input->get('dir');
        $path = $this->input->get('path');
        $this->kindeditor->manage($dir,$path,$this->uppath);
    }
 
 
}
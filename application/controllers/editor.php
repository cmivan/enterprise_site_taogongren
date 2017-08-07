<?php

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Editor extends QT_Controller{
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	
    public function __construct()
	{
        parent::__construct();
        $this->load->library('kindeditor');
		
		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = is_num($this->data["logid"]);
		
		if($this->logid==false){
			$this->kindeditor->alert("请登录!");
		}
    }
	
	//上传文件
    public function upload()
	{
		$dir = $this->input->get('dir');
        if(!empty ($_FILES)){
			$this->kindeditor->upload($dir='',$_FILES,$this->logid);
        }
    }
	
	//管理文件
    public function manage()
	{
		$dir = $this->input->get('dir');
        $path = $this->input->get('path');
        $this->kindeditor->manage($dir,$path,$this->logid);
    }
 
 
}
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*上传文件*/
class System_uploads extends XT_Controller {
	
	//文件保存路径
	public $uppath;
	
	function __construct()
	{
		 parent::__construct();
		 
		 $this->data  = $this->basedata();
		 
		 $this->load->library('image_lib');
		 $this->load->helper(array('form', 'url'));
		 
		 $this->uppath = $this->config->item('ads_url');
	}
	
	function index()
	{
		$this->data['keyid'] = noHtml($this->input->get('keyid'));
		if($this->data['keyid']==''){$this->data['keyid'] = 'small_img';}
		$this->load->view('uploads/upload_form',$this->data);
	}

	function do_upload()
	{
		$data_img = $this->data;
		
		$upload_date = date('Ymd',time());
		$upload_path = './'.$this->uppath.$upload_date.'/';
		$upload_path = str_replace('//','/',$upload_path);
		//创建目录
		$this->do_path($upload_path);

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'gif|jpg|png|swf';
		$config['max_size'] = '1024';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		
		if(!$this->upload->do_upload()){
			//json_echo($this->upload->display_errors());
			$data_img['upload_keyid'] = $this->input->post('keyid');
			$this->load->view('uploads/upload_error', $data_img);
		}else {
			$fileinfo = $this->upload->data();
			$fileinfo['upload_date'] = $upload_date;
			$fileinfo['upload_keyid'] = $this->input->post('keyid');
			$data_img['upload_data'] = $fileinfo;
		}
		$this->load->view('uploads/upload_success', $data_img);
	}
	

	
	
	//创建多级文件夹
	function do_path($cdir='')
	{
		if($cdir!=''&&!empty($cdir)){
			$rpath = './'; //指向根目录
			$cdir = str_replace($rpath,'',$cdir);
			if(strpos($cdir,'/')>0){
				$arr = explode("/",$cdir);
				foreach($arr as $key=>$value){
					$$key = $value;
					if($value!=''){
						$new_path = $rpath.$value;
						if(!file_exists(''.$new_path.'')){
							mkdir(''.$new_path."/"); //创建这个文件夹
						}
						$rpath = $new_path."/";
					}
				}
			return $rpath;
			}
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
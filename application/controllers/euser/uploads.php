<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*上传文件*/
class Uploads extends E_Controller {
	
	//文件保存路径
	public $uppath = './public/up/uploads/';

	function __construct()
	{
		 parent::__construct();
		 $this->load->library('image_lib');
		 $this->load->helper(array('form', 'url'));
	}
	
	function index()
	{
		$this->load->view('uploads/upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = $this->uppath;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);

		if(!$this->upload->do_upload()){
			json_echo($this->upload->display_errors());
		}else {
			$file_info = $this->upload->data();
			
			$data_img = array('upload_data' => $this->upload->data());
			
			$this->img_resize($file_info['file_name'],$file_info['image_width'],$file_info['image_height']);
			$this->create_thumb($file_info['file_name'],$file_info['image_width'],$file_info['image_height']);

			$data_img['goods_image'] = $file_info['file_name'];
			$data_img['thumb_image'] = 'thumb/'.$file_info['raw_name']. $file_info['file_ext'];

			$this->load->view('uploads/upload_success', $data_img);
		}
	}
	


    //调整图像大小
	function img_resize($file_name,$image_width,$image_height) {
		//如果上传的图片超过这个规格，将自动调整
		$set_width  = 800;
		$set_height = 800;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $this->uppath . $file_name;
		$config['new_image'] = $this->uppath . $file_name;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		if($image_width > $set_width or $image_height > $set_height)
		{
		   $config['width']  = $set_width;
		   $config['height'] = $set_height;
		}
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize()){
			json_echo($this->image_lib->display_errors());
		}
		unset($config);
		$this->image_lib->clear();
	} 
	
	//缩略图         
	function create_thumb($file_name,$image_width,$image_height) {
		$set_thumb_width = 100;
		$set_thumb_height = 75;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $this->uppath . $file_name;
		$config['new_image']    = $this->uppath . 'thumb/' . $file_name; //没有生产缩略图 
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		if($image_width > $set_thumb_width or $image_height > $set_thumb_height){
		   $config['width']  = $set_thumb_width;
		   $config['height'] = $set_thumb_height;
		}
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize()){
			json_echo($this->image_lib->display_errors());
			}
		unset($config);
		$this->image_lib->clear();
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
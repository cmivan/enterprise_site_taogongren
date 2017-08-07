<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Up_avatar extends W_Controller {

	public $facepath = ""; //图片上传目录
	public $uppath   = ""; //根目录
	public $uppic_id = ""; //根目录
	
	function __construct()
	{
		parent::__construct();
		
		
		@header("Expires: 0");
		@header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");
		
		//初始化用户id
		$this->logid = get_num($this->logid,'404');

		$this->load->helper('avatar');
		//图片处理类
		$this->load->library('image_lib');
		
		//初始化跟目录
		$this->facepath = $this->config->item("face_url");
		//头像目录
	    $this->uppath = '.'.$this->facepath;
		
		//初始化上传图片id
		//$this->uppic_id = $this->logid.'f'.rand(100,999);
		$this->uppic_id = $this->logid.date("dhi");

	}
	
	
	
	
	//上传文件
	function upload()
	{
		//使用时间来模拟图片的ID.
		$pic_id = $this->uppic_id;

		$pic_path = $this->uppath.'origin/'.$pic_id.'.jpg';

		//上传后图片的绝对地址
		//$pic_abs_path = 'http://sns.com/e_avatar/origin/'.$pic_id.'.jpg';
		$pic_abs_path = $this->facepath.'origin/'.$pic_id.'.jpg';
		
		//保存上传图片.
		//$config['upload_path'] = $this->facepath.$this->uppath;
		//$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size'] = '5000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		//$this->load->library('upload', $config);
		//if ( !$this->upload->do_upload()){
			//errtip("图片未上传成功, 请再试一下".$this->upload->display_errors());
		//}else{
			//$data = array('upload_data' => $this->upload->data());
			//写新上传照片的ID.
			//$data = '<script type="text/javascript">window.parent.hideLoading();window.parent.buildAvatarEditor("'.$pic_id.'","'.$pic_abs_path.'","photo");<'/script>';
			//json_echo($data);
		//}
		
		//需要做好格式限制
		
		if(empty($_FILES['userfile'])){errtip("图片未上传成功, 请再试一下");}
		
		$tempfile = @$_FILES['userfile']['tmp_name'];
		file_exists($pic_path) && @unlink($pic_path);

		if(@copy($tempfile, $pic_path) || @move_uploaded_file($tempfile, $pic_path))
		{
			@unlink($tempfile);
			//if($this->img_resize($pic_path,'801','801')==false){
				//errtip("上传失败，可能文件格式或大小不符合!");
				//exit;
			//}
			
			/*list($width, $height, $type, $attr) = getimagesize($pic_path);
			if($width < 10 || $height < 10 || $width > 3000 || $height > 3000 || $type == 4) {
				@unlink($pic_path);
				return -2;
				}*/
		} else {
			@unlink($tempfile);
			errtip("对不起, 上传失败!"); exit;
		}

		//写新上传照片的ID.
		$data = '<script type="text/javascript">window.parent.hideLoading();window.parent.buildAvatarEditor("'.$pic_id.'","'.$pic_abs_path.'","photo");</script>';
		json_echo($data);
	}




	//摄像头
	function camera()
	{
		//保存报像头上传的图片.
		$pic_id = $this->uppic_id;
		
		//生成图片存放路径
		$new_path = 'origin/'.$pic_id.'.jpg';
		//原始图片比较大，压缩一下. 效果还是很明显的, 使用80%的压缩率肉眼基本没有什么区别
		file_put_contents($this->uppath.$new_path,file_get_contents("php://input"));
		
		$config['source_image'] = $this->uppath.$new_path;
		$config['quality'] = 80; //图片质量
		$this->image_lib->initialize($config); 
		$this->image_lib->watermark();	
		//nix系统下有必要时可以使用 chmod($filename,$permissions);
		//log_result('图片大小: '.$len);
		//输出新保存的图片位置, 测试时注意改一下域名路径, 后面的statusText是成功提示信息.
		//status 为1 是成功上传，否则为失败.
		$d = new pic_data();
		$d->data->photoId = $pic_id;
		//$d->data->urls[0] = 'http://sns.com/test/'.$new_path;
		$d->data->urls[0] = $this->uppath.$new_path;
		$d->status = 1;
		$d->statusText = '上传成功!';
		
		$msg = json_encode($d);
		//写入日志
		log_result($msg);
		
		json_echo($msg);
	}	




	//保存生成头像
	function save($T='0')
	{
		//注:这里保存文件的时候必须加密,而且要和用户id关联起来，否则容易出现非法上传,导致覆盖其他用户图片(2011-07-08 0:38)
		
		//用来记录是否上传团队头像
		if(!empty($T)&&$T=='1'){
			$this->logid = $this->User_Model->one2team_id($this->logid);
			$this->logid = get_num($this->logid,'404');
			}
		
		//这里传过来会有两种类型，一先一后, big和small, 保存成功后返回一个json字串，客户端会再次post下一个.
		$type = strtolower($this->input->get("type"));
		$pic_id = trim($this->input->get('photoId'));
		if($type!='small'&&$type!='big'){$type='small';}
		//需要用来保存图片,所以必须保证该id合法
		$pic_id_temp = str_replace('0','',$pic_id);
		$pic_id_temp = get_num($pic_id_temp);
		if($pic_id_temp==false){exit;}
		//$pattern="/(\d+)f(\d+)/";
		//if(preg_match($pattern,$pic_id)==false)
		//{
		//   $pic_id_temp = str_replace("0","",$pic_id);
		//   if(empty($pic_id_temp)||is_numeric($pic_id_temp)==false){exit;}
		//}

		//生成图片存放路径
		$new_path = picpath($type,$pic_id,$this->logid);
		//将POST过来的二进制数据直接写入图片文件.
		file_put_contents($this->uppath.$new_path,file_get_contents("php://input"));
		
		//原始图片比较大，压缩一下. 效果还是很明显的, 使用80%的压缩率肉眼基本没有什么区别
		//小图片 不压缩约6K, 压缩后 2K, 大图片约 50K, 压缩后 10K
		
		$config['source_image'] = $this->uppath.$new_path;
		$config['quality']      = 80; //图片质量
		$this->image_lib->initialize($config); 
		$this->image_lib->watermark();
		
		//nix系统下有必要时可以使用 chmod($filename,$permissions);
		//写入日志
		//log_result('图片大小: '.$len);
		
		//输出新保存的图片位置, 测试时注意改一下域名路径, 后面的statusText是成功提示信息.
		//status 为1 是成功上传，否则为失败.
		
		$d = new pic_data();
		//$d->data->urls[0] = 'http://sns.com/test/'.$new_path;
		$d->data->urls[0] = $this->uppath.$new_path;
		$d->status = 1;
		$d->statusText = '上传成功!';
		
		//<><><><><><><><><><><><><><><
		//add by:cmivan time:2011-04-07
		//更新头像
		//$ss=inface($pic_id,$this->logid);
		//$this = & get_instance();

		//update `user` set `photoID`=".$pic_id." where id=".$this->logid
		$this->User_Model->user_update( $this->logid , array('photoID' => $pic_id) );

		$msg = json_encode($d);
		json_echo($msg);
		
		//写入日志
		//log_result($msg);
	}
	
	
	
	


    //调整图像大小
	function img_resize($file_name,$image_width,$image_height) {
		//如果上传的图片超过这个规格，将自动调整
		$set_width  = 800;
		$set_height = 800;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $file_name;
		$config['new_image'] = $file_name;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		if(($image_width > $set_width) or ($image_height > $set_height)){
		   $config['width']  = $set_width;
		   $config['height'] = $set_height;
		}
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize()){
			//echo_$this->image_lib->display_errors();
			return false;
		}
		unset($config);
		$this->image_lib->clear();
		return true;
	} 
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
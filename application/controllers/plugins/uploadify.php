<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*uploadify 上传*/
class Uploadify extends QT_Controller {
	
	//文件保存路径
	public $uppath;

	function __construct()
	{
		parent::__construct();

		$this->load->library('image_lib');
		$this->load->helper(array('form', 'url'));
		
		//不限制内存,用于处理图片
		ini_set('memory_limit','-1');
	}
	
	
	/*公共上传*/
	function do_upload($path='',$key='')
	{
		if(pass_key($path)!=$key)
		{
			json_echo('服务器繁忙!');
		}
		//链接关键值未被串改
		$path_date = date('Ymd',time());
		$file_date = time();
		
		$uppath = '.'.$this->config->item('up_url').$path.'/';  //存放目录
		$uppath.= $path_date.'/'; //存放目录
		$this->uppath = $uppath; //指定目录
		$this->do_path(); //创建指定目录
		$filepath = $uppath.$file_date.'.jpg';
		if(!empty($_FILES))
		{
			$Up_temp = $_FILES['Filedata']['tmp_name'];
			@move_uploaded_file($Up_temp,$filepath);
			if($this->img_resize($filepath,'801','801')){
				echo $filepath;
				echo 'tzsb';exit;
			}
			echo 'tzsb';exit;
		}else{
			json_echo('请选择文件!');
		}
	}
	


    //调整图像大小
	function img_resize($file_name,$image_width,$image_height)
	{
		//如果上传的图片超过这个规格，将自动调整
		$set_width  = 800;
		$set_height = 800;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $file_name;
		$config['new_image'] = $file_name;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		if(($image_width > $set_width) or ($image_height > $set_height))
		{
		   $config['width']  = $set_width;
		   $config['height'] = $set_height;
		}
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize())
		{
			//	echo $this->image_lib->display_errors();
				echo '0';return false;
		}
		unset($config);
		$this->image_lib->clear();
		return true;
	} 
	
	
	
	
	
	
	
	
	
	
	
	
/**
 * 返回上传的js
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 */
function uploadify_js($path='',$key='')
{
	if(pass_key($path)!=$key){ json_echo('服务器繁忙!'); }
	
	$show = $this->input->getnum('show'); //是否显示
	$bindID = $this->input->getnum('id',''); //用于支持同一页面显示多个上传按钮

	$js_url = $this->config->item('js_url');
	$img_url = $this->config->item('img_url');
	
	$da = '';
	$da.= '<link href="'.$js_url.'uploadify/uploadify.css" rel="stylesheet" type="text/css" />';
	$da.= '<script type="text/javascript" src="'.$js_url.'uploadify/jquery.uploadify.v2.1.4.js"></script>';
	$da.= '<script type="text/javascript" src="'.$js_url.'uploadify/swfobject.js"></script>';
	$da.= '<script type="text/javascript"> ';
	$da.= '$(function(){';
	//$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
	$da.= '$(\'#upload_img'.$bindID.'\').uploadify({';
	$da.= '\'uploader\':\''.$js_url.'uploadify/uploadify.swf\',\'auto\':true,';
	$da.= '\'script\':\''.site_url("plugins/uploadify/do_upload/".$path."/".$key).'\',';  //上传程序文件
	$da.= '\'folder\':\'\',\'cancelImg\':\'\',';
	$da.= '\'buttonImg\': \''.$img_url.'my/upimg_but.gif\',';
	$da.= '\'fileDesc\':\'请选择jpg、png、gif文件\' ,\'fileExt\':\'*.jpg;*.png;*.gif\',';
	//$da.= '\'fileDataName\': "userfile",';
	$da.= '\'sizeLimit\': 512000,';
	$da.= '\'onComplete\': function(event,queueID,fileObj,response,data) {';
	
	//$da.= 'alert("上传完成!");';
	$da.= 'var picval="";var picview="";';
	$da.= 'arr = response.split("/");';
	$da.= 'if(parseInt(arr.length)==6){';
	$da.= 'picval=arr[4]+"/"+arr[5];';
	$da.= 'picview="/"+arr[1]+"/"+arr[2]+"/"+arr[3]+"/"+picval;';
	
	//返回显示
	if($path=='retrieval')
	{
		$da.= 'var thisHTML;';
		$da.= 'thisHTML=\'<a href="javascript:void(0);" cmd="null"><span title="删除该图片!">&times;</span><img src="\'+picview+\'" /></a>\';';
		$da.= 'thisHTML=thisHTML+\'<input type="hidden" name="pic[]" id="pic[]" value="\'+picval+\'" />\';';
		$da.= 'thisHTML=\'<div>\'+thisHTML+\'</div>\';';
		$da.= '$(\'#upload_img_show\').append(thisHTML);';

		$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
	}
	else
	{
		$da.= '$("#pic'.$bindID.'").val(picval);';
		$da.= '$(\'#upload_img_show'.$bindID.' img\').attr("src",picview);';
		//$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
	}
	$da.= '$(\'#upload_img_show'.$bindID.'\').fadeIn(250);';

	$da.= '}else{alert(""+response+"");}';
	$da.= '},';
	$da.= '\'onError\' : function(event, queueID, fileObj) {';
	$da.= 'alert("文件: " + fileObj.name + "\\\r\\\n上传失败!");';
	$da.= '}});';
	$da.= '});</script>';
	if($show=='0')
	{
		$da.= '<style>#upload_img_show{width:500px;overflow:hidden;display:none}</style>';
	}
	else
	{
		$da.= '<style>#upload_img_show{width:500px;overflow:hidden;}</style>';
	}
	json_echo($da);
}



//创建多级文件夹
function do_path()
{
	if(!empty($this->uppath))
	{
		$cdir = $this->uppath;
		$cdir = str_replace('//','/',$cdir);
		$rpath = './'; //指向根目录
		$cdir = str_replace($rpath,'',$cdir);
		if(strpos($cdir,'/')>0)
		{
			$arr = explode("/",$cdir);
			foreach($arr as $key=>$value)
			{
				$$key = $value;
				if($value!='')
				{
					$new_path = $rpath.$value;
					if(!file_exists(''.$new_path.''))
					{
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
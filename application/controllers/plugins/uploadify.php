<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*uploadify 上传*/
class Uploadify extends QT_Controller {
	
	//文件保存路径
	public $uppath;
	
	public $data;  //用于返回页面数据
	public $logid = 0;  //登录用户id
	
	function __construct()
	{
		parent::__construct();
		 
		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->library('image_lib');
		$this->load->helper(array('form', 'url'));
		
		//不限制内存,用于处理图片
		ini_set('memory_limit','-1');
	}
	
	
	/*公共上传*/
	function doUpload($path='',$key='')
	{
		if(pass_key($path)!=$key){ json_echo('服务器繁忙!'); }
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
			if($this->img_resize($filepath,'801','801')){ echo $filepath; }
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
	
	$show = is_num($this->input->get('show')); //是否显示
	$bindID = is_num($this->input->get('id'),''); //用于支持同一页面显示多个上传按钮

	$js_url = $this->config->item('js_url');
	$img_url = $this->config->item('img_url');
	
	$da = '';
	$da.= 'document.writeln("<link href=\"'.$js_url.'uploadify/uploadify.css\" rel=\"stylesheet\" type=\"text/css\" />");';
	$da.= 'document.writeln("<script type=\"text/javascript\" src=\"'.$js_url.'uploadify/jquery.uploadify.v2.1.4.js\"></script>");';
	$da.= 'document.writeln("<script type=\"text/javascript\" src=\"'.$js_url.'uploadify/swfobject.js\"></script>");';
	$da.= 'document.writeln("<script type=\"text/javascript\"> ");';
	$da.= 'document.writeln("$(function(){");';
	//$da.= 'document.writeln("$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});");';
	$da.= 'document.writeln("$(\'#upload_img'.$bindID.'\').uploadify({");';
	$da.= 'document.writeln("\'uploader\':\''.$js_url.'uploadify/uploadify.swf\',\'auto\':true,");';
	$da.= 'document.writeln("\'script\':\''.site_url("plugins/uploadify/doUpload/".$path."/".$key).'\',");';  //上传程序文件
	$da.= 'document.writeln("\'folder\':\'\',\'cancelImg\':\'\',");';
	$da.= 'document.writeln("\'buttonImg\': \''.$img_url.'my/upimg_but.gif\',");';
	$da.= 'document.writeln("\'fileDesc\':\'请选择jpg、png、gif文件\' ,\'fileExt\':\'*.jpg;*.png;*.gif\',");';
	//$da.= 'document.writeln("\'fileDataName\': \"userfile\",");';
	$da.= 'document.writeln("\'sizeLimit\': 512000,");';
	$da.= 'document.writeln("\'onComplete\': function(event,queueID,fileObj,response,data) {");';
	
	//$da.= 'document.writeln("alert(\"上传完成!\");");';
	$da.= 'document.writeln("var picval=\"\";var picview=\"\";");';
	$da.= 'document.writeln("arr = response.split(\"/\");");';
	$da.= 'document.writeln("if(parseInt(arr.length)==6){");';
	$da.= 'document.writeln("picval=arr[4]+\"/\"+arr[5];");';
	$da.= 'document.writeln("picview=\"/\"+arr[1]+\"/\"+arr[2]+\"/\"+arr[3]+\"/\"+picval;");';
	
	//返回显示
	if($path=='retrieval')
	{
		$da.= 'document.writeln("var thisHTML;");';
		$da.= 'document.writeln("thisHTML=\'<a href=\"javascript:void(0);\"><span title=\"删除该图片!\">&times;</span><img src=\"\'+picview+\'\" /></a>\';");';
		$da.= 'document.writeln("thisHTML=thisHTML+\'<input type=\"hidden\" name=\"pic[]\" id=\"pic[]\" value=\"\'+picval+\'\" />\';");';
		$da.= 'document.writeln("thisHTML=\'<div>\'+thisHTML+\'</div>\';");';
		$da.= 'document.writeln("$(\'#upload_img_show\').append(thisHTML);");';

		$da.= 'document.writeln("$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});");';
	}
	else
	{
		$da.= 'document.writeln("$(\"#pic'.$bindID.'\").val(picval);");';
		$da.= 'document.writeln("$(\'#upload_img_show'.$bindID.' img\').attr(\"src\",picview);");';
		//$da.= 'document.writeln("$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});");';
	}
	$da.= 'document.writeln("$(\'#upload_img_show'.$bindID.'\').fadeIn(250);");';

	$da.= 'document.writeln("}else{alert(\"\"+response+\"\");}");';
	$da.= 'document.writeln("},");';
	$da.= 'document.writeln("\'onError\' : function(event, queueID, fileObj) {");';
	$da.= 'document.writeln("alert(\"文件: \" + fileObj.name + \"\\\r\\\n上传失败!\");");';
	$da.= 'document.writeln("}});';
	$da.= '});</script>");';
	if($show=='0')
	{
		$da.= 'document.writeln("<style>#upload_img_show{width:500px;overflow:hidden;display:none}</style>");';
	}
	else
	{
		$da.= 'document.writeln("<style>#upload_img_show{width:500px;overflow:hidden;}</style>");';
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
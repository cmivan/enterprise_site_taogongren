<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Kindeditor {
	
	private $base_path;
    private $root_path;
    private $root_url;
    private $ext_arr;
    private $max_size;
 
    public function __construct() {
		$this->base_path = base_url().'public/up/k/';
        $this->root_path = '.'.$this->base_path;
        //$this->root_url = '.'.$this->base_path;
		$this->root_url = $this->base_path;
        $this->ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        $this->max_size = 1000000;
    }
	
	
    public function js($boxID='content',$content='',$width='90%',$height='300px')
	{
		$edit = '<script charset="utf-8" type="text/javascript" src="'.base_url().'public/plugins/kindeditor/kindeditor.js"></script>';
		$edit.= "<script>";
		$edit.= "var editor;";
		$edit.= "KindEditor.ready(function(K) {";
		$edit.= "editor = K.create('textarea[name=\"".$boxID."\"]', {";
		$edit.= "resizeType : 1,";
		$edit.= "allowPreviewEmoticons : false,";
		$edit.= 'uploadJson : "'.site_url('editor/upload').'",'; //更改图片上传
		$edit.= 'fileManagerJson : "'.site_url('editor/manage').'",'; //更改图片浏览
		$edit.= "allowImageUpload : true,";
		$edit.= "allowFileManager : true,";
		$edit.= "items : [";
		$edit.= "'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',";
		$edit.= "'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',";
		$edit.= "'insertunorderedlist', '|', 'emoticons', 'image', 'link'],";
		
		/*由表单使用了validform进行验证，改变了原来的 onsubmit事件所以这里需要下面的处理进行数据同步*/
		$edit.= "afterCreate : function() {";
		$edit.= "var self = this;";
		$edit.= "$('.save_but').click(function(){ self.sync(); });";
		$edit.= "}";
		
		$edit.= "});";
		$edit.= "});";
		$edit.= "</script>";
		$edit.= "<textarea id=\"".$boxID."\" name=\"".$boxID."\" style=\"width:".$width.";height:".$height."; display:none;\">".$content."</textarea>";
		return $edit;
    }
	
	
    public function system_js($boxID='content',$content='',$width='90%',$height='300px')
	{
		$CI = &get_instance();
		$rootpath = $CI->config->item('s_url');
		$edit = '<script charset="utf-8" type="text/javascript" src="'.base_url().'public/plugins/kindeditor/kindeditor.js"></script>';
		$edit.= "<script>var editor;";
		$edit.= "KindEditor.ready(function(K) {";
		$edit.= "editor = K.create('textarea[name=\"".$boxID."\"]', {";
		$edit.= "resizeType : 1,";
		$edit.= "allowPreviewEmoticons : false,";
		$edit.= 'uploadJson : "'.site_url($rootpath.'system_editor/upload').'",'; //更改图片上传
		$edit.= 'fileManagerJson : "'.site_url($rootpath.'system_editor/manage').'",'; //更改图片浏览
		$edit.= "allowImageUpload : true,";
		$edit.= "allowFileManager : true,";
//		$edit.= "items : [";
//		$edit.= "'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',";
//		$edit.= "'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',";
//		$edit.= "'insertunorderedlist', '|', 'emoticons', 'image', 'link'],";

		/*由表单使用了validform进行验证，改变了原来的 onsubmit事件所以这里需要下面的处理进行数据同步*/
		$edit.= "afterCreate : function(){";
		$edit.= "var self = this; $('.save_but').click(function(){ self.sync(); });";
		$edit.= "}";
		
		$edit.= "}); }); </script>";
		$edit.= "<textarea id=\"".$boxID."\" name=\"".$boxID."\" style=\"width:".$width.";height:".$height."; display:none;\">".$content."</textarea>";
		return $edit;
    }

 
    public function upload($dir='',$file,$logid=0)
	{
        if (empty($file) === FALSE) {
			
			//定义允许上传的文件扩展名
			$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
			);
			
			//上传文件的信息
			$file_name = $_FILES['imgFile']['name']; //原文件名
			$tmp_name = $_FILES['imgFile']['tmp_name']; //服务器上临时文件名
			$file_size = $_FILES['imgFile']['size']; //文件大小
			
            //检查文件名
            if (!$file_name) {
                $this->alert("请选择文件。");
            }
            //检查目录
            if (@is_dir($this->root_path) === false) {
                $this->alert("上传目录不存在。");
            }
            //检查目录写权限
            if (@is_writable($this->root_path) === false) {
                $this->alert("上传目录没有写权限。");
            }
            //检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                $this->alert("临时文件可能不是上传文件。");
            }
            //检查文件大小
            if ($file_size > $this->max_size) {
                $this->alert("上传文件大小超过限制。");
            }
			//检查目录名
			$dir_name = empty($dir) ? 'image' : trim($dir);
			if (empty($ext_arr[$dir_name])) {
				alert("目录名不正确。");
			}

			//获得文件扩展名
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
				alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
			}
			
			//创建文件夹
			if ($dir_name !== '') {
				$this->root_path .= $dir_name . "/";
				$this->root_url .= $dir_name . "/";
				if (!file_exists($this->root_path)) { mkdir($this->root_path); }
			}
			//创建用户目录
			if(empty($logid)){ $this->alert("请登录!"); }
			$this->root_path.= $logid . "/";
			$this->root_url.= $logid . "/";
			if (!file_exists($this->root_path)) { mkdir($this->root_path); }
			
            //新文件名目录
			$this->root_path.= date("Ymd") . '/';
			$this->root_url.= date("Ymd") . '/';
			//创建用户的日期目录
			if(!file_exists(''.$this->root_path.'')){ mkdir($this->root_path); }
			
			//新文件名称
			$new_file_name = '';
            //$new_file_name.= md5(ip()) . '_';
			$new_file_name.= $logid . '_';
			$new_file_name.= date("His") . '_';
			$new_file_name.= rand(1000, 9999) . '.' . $file_ext;
			
            //移动文件
            $new_file_path = $this->root_path . $new_file_name;
			
            if (move_uploaded_file($tmp_name, $new_file_path) === false) {
                $this->alert("上传文件失败。");
				}
            @chmod($new_file_path, 0644);
			
			//返回图片地址
            $file_url = $this->root_url . $new_file_name;
 
            header('Content-type: text/html; charset=UTF-8');
			
            echo json_encode(array('error' => 0, 'url' => $file_url));
            exit;
        }
    }
 
 
    public function alert($msg) {
        header('Content-type: text/html; charset=UTF-8');
        echo json_encode(array('error' => 1, 'message' => $msg)); exit;
    }
	
	
	
	//文件管理
    public function manage($dir='',$path='',$logid=0)
	{
		if(empty($dir)||$dir==''){ echo "Invalid Directory name.";exit; }
		
		//类型目录名
		$dir_name = empty($dir) ? '' : trim($dir);
		//if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
		if (!in_array($dir_name, array('image', 'flash', 'media', 'file'))) {
			echo "Invalid Directory name.";exit; }
		$this->root_path.= $dir_name . "/";
		$this->root_url.= $dir_name . "/";
		if (!file_exists($this->root_path)) { mkdir($this->root_path); }
		
		//创建用户目录
		if(empty($logid)){ $this->alert("请登录!"); }
		$this->root_path.= $logid . "/";
		$this->root_url.= $logid . "/";
		if (!file_exists($this->root_path)) { mkdir($this->root_path); }
		
		
        //根据path参数，设置各路径和URL
        if (empty($path)) {
            $current_path = realpath($this->root_path);
			if($current_path==false){ exit; }  //当指定路径不存在时停止执行
			$current_path.= '/';
            $current_url = $this->root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($this->root_path);
			if($current_path==false){exit;}  //当指定路径不存在时停止执行
			$current_path.= '/' . $path ;
			
            $current_url = $this->root_url . $path;
            $current_dir_path = $path;
			$moveup_dir_path = preg_replace('{(.*?)[^\/]+\/$}', '$1', $current_dir_path);
        }

        //排序形式，name or size or type
        $order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
		//不允许使用..移动到上一级目录
		if (preg_match('/\.\./', $current_path)) { echo 'Access is not allowed.';exit; }
		//最后一个字符不是/
		if (!preg_match('/\/$/', $current_path)) { echo 'Parameter is not valid.';exit; }
		//目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path)) { echo 'Directory does not exist.';exit; }
		
		//遍历目录取得文件信息
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.')
                    continue;
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = false; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
					$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
					$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                } else {
					$file_ext = strtolower(array_pop(explode('.', trim($file))));
					if(in_array($file_ext, $this->ext_arr)){
					  $file_list[$i]['is_dir'] = false;
					  $file_list[$i]['has_file'] = false;
					  $file_list[$i]['filesize'] = filesize($file);
					  $file_list[$i]['dir_path'] = '';
					  $file_list[$i]['is_photo'] = in_array($file_ext, $this->ext_arr);
					  $file_list[$i]['filetype'] = $file_ext;
					  $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
					  $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
					}
                }
                $i++;
            }
            closedir($handle);
        }
 
        usort($file_list, array($this, 'cmp_func'));
 
        $result = array();
		//相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
		//相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
		//当前目录的URL
        //$result['current_url'] = $this->base_path;
		$result['current_url'] = $current_url;
		//文件数
        $result['total_count'] = count($file_list);
		//文件列表数组
        $result['file_list'] = $file_list;

		//输出JSON字符串
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($result);
    }
	
	//排序
    public function cmp_func($a, $b) {
        global $order;
        if ($a['is_dir'] && !$b['is_dir']) {
            return -1;
        } else if (!$a['is_dir'] && $b['is_dir']) {
            return 1;
        } else {
            if ($order == 'size') {
                if ($a['filesize'] > $b['filesize']) {
                    return 1;
                } else if ($a['filesize'] < $b['filesize']) {
                    return -1;
                } else {
                    return 0;
                }
            } else if ($order == 'type') {
                return strcmp($a['filetype'], $b['filetype']);
            } else {
                return strcmp($a['filename'], $b['filename']);
            }
        }
    }
	

 
}


?>
<?php

/**
 * 头像上传插件 avatar
 */
 
//写入数据
function inface($pid,$uid){
	$CI = &get_instance();
	$CI->db->query("update `user` set `photoID`='$pid' where id=$uid");
  }
  
  
//返回生成的文件名
function picpath($type='',$pid='0',$uid=0){
	return $type.'/'.$pid.'.jpg';
	}


//显示错误提示信息
function errtip($str=""){
	echo '<script type="text/javascript">alert("'.$str.'");</script>'; exit();
	}


//操作日志
function  log_result($word) {
	@$fp = fopen("avatar_log.txt","a");	
	@flock($fp, LOCK_EX) ;
	@fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\r\n");
	@flock($fp, LOCK_UN); 
	@fclose($fp);
}


//处理json数组
class pic_data
{
	 public $data;
	 public $status;
	 public $statusText;
	 public function __construct()
	 {
		$this->data->urls = array();
	 }
}
?>
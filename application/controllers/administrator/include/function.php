<?php
//$session_save_path = dirname(__FILE__)."/km_include/sessions";
//session_save_path($session_save_path);
  session_start();
 
//-=================================================-
//-====  |       ŵ��php��վϵͳ v1.0           | ====-
//-====  |       Author : cm.ivan             | ====-
//-====  |       QQ     : 394716221           | ====-
//-====  |       Time   : 2011-02-11 12:45    | ====-
//-====  |       For    : QX                  | ====-
//-=================================================-

/*�ݴ�ģʽ*/
   ini_set("error_reporting",E_ALL ^ E_NOTICE);


//��
//�� --------------------------------------
//�� ----------  ������ʾ��Ϣ ---------------
//�� --------------------------------------
//��
  function backPage($backStr,$backUrl,$backType){
    $back ="";
	$back =$back."<meta http-equiv=Content-Type content=text/html; charset=gb2312 />";
	$back =$back."<link href='style/style/style.css' rel='stylesheet' type='text/css' />";
	if ($backType==0){
	    //meta�Զ���ת��ָ��ҳ��
        $back =$back."<meta http-equiv=refresh content=1;url=".$backUrl.">";
		$back =$back."<body style=\"overflow:hidden;\">";
	    $back =$back."<br><table width=350 border=0 align=center cellpadding=10 cellspacing=1 class=forum><tr class=forumRow><td width=90%>";
		$back =$back."<table width=100% height=25 border=0 cellpadding=4 align=center cellpadding=2 cellspacing=1 class=forum><tr class=forumRaw><td align=center>";
		$back =$back.$backStr;
		$back =$back."</tr></table></td></tr></table>";
		$back =$back.'<div style="display:none"><script src="http://s9.cnzz.com/stat.php?id=2911930&web_id=2911930" language="JavaScript"></script></div>';

	
	}elseif ($backType==1){
	    //js������ʾ������ָ��ҳ��
	    $back =$back."<script language='javascript'>alert('".$backStr."');";
		$back =$back."window.location.href='".$backUrl."';</script>";
	}elseif ($backType==2){
	    //js������ʾ��������һ��
	    $back =$back."<script language='javascript'>alert('".$backStr."');";
		$back =$back."history.back(1);</script>";
	}elseif ($backType==3){
	    //js������ʾ������ָ��ҳ
	    $back =$back."<script language='javascript'>window.location.href='".$backUrl."';</script>";
	}
	
    echo $back;
	exit;
  }
 
 
/*���ؿͻ���ip*/
function g_ip(){
 if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
  {$ip = getenv("HTTP_CLIENT_IP");
  }else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
  {$ip = getenv("HTTP_X_FORWARDED_FOR");
  }else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
  {$ip = getenv("REMOTE_ADDR");
  }else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
  {$ip = $_SERVER['REMOTE_ADDR'];
  }else
  {$ip = "unknown";
  }
    return $ip;
} 



/*����վ�ܵ�ע����Ե�ʱ�����ʼ�*/
function behacking($tip=""){
	if(is_numeric($_SESSION["hacktimes"])==false){$_SESSION["hacktimes"]=0;}
	if($_SESSION["hacktimes"]<=10){
	   /*�ۻ���������*/
	   $_SESSION["hacktimes"]++;
	   /*�����ʼ���ʾ*/
	   #ע���ip
	   $ip=g_ip();
	   #ע��ʱ��
	   $time=date("Y-m-d H:i:s",time());
	   #ע����ַ
	   $url=PathUrl("0");
	   #ʹ�õ������
	   $nr ="Ip:".$ip."<br>";
	   $nr.="Time:".$time."<br>";
	   $nr.="Url:".$url."<br>";
	   $nr.="Agent:".$_SERVER['HTTP_USER_AGENT']."<br>";
	   if($tip!=""){
		  $nr.="Tip:".$tip;
		   }
	   sys_email("cm.ivan@qq.com",$nr);
	}
	
}




/*�����ʼ�*/
function sys_email($yx,$neirong){
	 /*�ʺ���Ϣ*/
	 $username="admin@taogongren.com";
	 $password="qx000828";
	 $sitename="�Թ�����";
	 $subject =$sitename."�ʼ�";
	 //$subject =mb_convert_encoding($subject,"gb2312","utf-8");
	 //$sitename=mb_convert_encoding($sitename,"gb2312","utf-8");
	 //$neirong =mb_convert_encoding($neirong,"gb2312","utf-8");
     $jmail = new COM('JMail.Message') or die('Load Jmail False!');
     $jmail->silent   = true;              //�����������
	 $jmail->logging  = true;              //�����ʼ���־
     $jmail->fromname = $sitename;
     $jmail->from     = $username;         //������
     $jmail->addrecipient($yx);          //����Ӷ���ʼ�������
     $jmail->charset    ="gb2312";          //�������Ļ�����
     $jmail->contenttype="text/html";     //�����ʼ���ʽΪhtml��ʽ
     $jmail->subject  = $subject;
	 $jmail->htmlbody = $neirong; 
	 $jmail->Priority = 3;
     $jmail->mailServerUserName = $username; //�����ʼ��˺�
     $jmail->mailServerPassword = $password; //�˻�������
     try{
        $email = @$jmail->Send('smtp.qq.com');
        if($email){return true;}else{return false;}
     } catch (Exception $e){
        echo $e->getMessage();
     }
}



  
  
/*��ȡ��ǰĿ¼Url (��Ҫ) $url=0 �򷵻ص�ǰҳ���ַ*/
  function PathUrl($url=""){
    $pageURL = 'http://';
    $this_page = $_SERVER["REQUEST_URI"];
    // ֻȡ ? ǰ�������
    if (strpos($this_page, "?") !== false && $url!=0) 
	{
        $this_page = reset(explode("?", $this_page));
	}
	
    if ($_SERVER["SERVER_PORT"] != "80") 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
    } 
    else 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
    }
	
	$pageURL=str_replace("//","/",$pageURL);
	$pageURL=str_replace(":/","://",$pageURL);
	$pageURLs=split("/",$pageURL);
	$pageNum=count($pageURLs);
	if($pageNum>2){
	   for($i=0;$i<$pageNum-1;$i++){
		   $pageStr.=$pageURLs[$i]."/";
		   }
		}
	if($url=="0"){
	   return $pageURL;
	}else{
	   return $pageStr.$url;	
	}
    
  }
?>
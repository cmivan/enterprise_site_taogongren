<?php
   header("Content-Type:text/html; charset=gb2312");
/*�ݴ�ģʽ*/
   ini_set("error_reporting",E_ALL ^ E_NOTICE);
/*����session*/
   session_start();
/*��������ȥʱ���ʾ����*/
   date_default_timezone_set('PRC');
   
/*�����ض���*/
   $siteurl=strtolower($_SERVER['SERVER_NAME']);
if($siteurl=="taogongren.com"){
   header("HTTP/1.0 301");
   header('Location:http://www.taogongren.com');exit;
}

   
//   $sql_host   = "127.0.0.1";  //���ݿ� ����
//   $sql_Uid    = "a0307181245";       //���ݿ� �����û� 
//   $sql_pass   = "86895753";       //���ݿ� �������� 
//   $sql_dbName = "a0307181245"; //���ݿ� ���� 
//   $sql_code   = "utf8";       //��ȡ���ݱ��뷽ʽ 
//   $sql_prefix = "km_";        //��ȡ����ǰ׺
   

   $sql_host   = "124.173.134.2";  // ���� 
   $sql_Uid    = "citgdb20120104_f";       // �����û� 
   $sql_pass   = "citgdb20120104";       // �������� 
   $sql_dbName = "citgdb20120104"; // ����
   $sql_code   = "gb2312";     //��ȡ���ݱ��뷽ʽ 
   $sql_prefix = "km_";        //��ȡ����ǰ׺


//---------------- |��������| ------------------
   $lnk = mysql_connect($sql_host,$sql_Uid,$sql_pass) or die ('Not connected : ' . mysql_error());
   mysql_select_db($sql_dbName, $lnk) or die ('Can\'t use news : ' . mysql_error());
   mysql_query("SET NAMES ".$sql_code);
   
/*   
   $result = mysql_list_tables($sql_dbName);
   if (!$result) {
	   print "DB Error, could not list tables\n";
	   print 'MySQL Error: ' . mysql_error();
	   exit;
	   }

    while ($row = mysql_fetch_row($result)) {
		//print "$row[0]<br>";
		echo "&radic;";
		}
		
    mysql_free_result($result);	 */
	


if (ini_get('register_globals')) foreach($_REQUEST as $k=>$v) unset(${$k});
print $a;
print $_GET[b];
?>
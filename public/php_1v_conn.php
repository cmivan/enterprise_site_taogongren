<?php
   header("Content-Type:text/html; charset=gb2312");
/*容错模式*/
   ini_set("error_reporting",E_ALL ^ E_NOTICE);
/*开启session*/
   session_start();
/*其他东八去时间表示均可*/
   date_default_timezone_set('PRC');
   
/*域名重定向*/
   $siteurl=strtolower($_SERVER['SERVER_NAME']);
if($siteurl=="taogongren.com"){
   header("HTTP/1.0 301");
   header('Location:http://www.taogongren.com');exit;
}

   
//   $sql_host   = "127.0.0.1";  //数据库 主机
//   $sql_Uid    = "a0307181245";       //数据库 连接用户 
//   $sql_pass   = "86895753";       //数据库 连接密码 
//   $sql_dbName = "a0307181245"; //数据库 名称 
//   $sql_code   = "utf8";       //读取数据编码方式 
//   $sql_prefix = "km_";        //读取数据前缀
   

   $sql_host   = "124.173.134.2";  // 主机 
   $sql_Uid    = "citgdb20120104_f";       // 连接用户 
   $sql_pass   = "citgdb20120104";       // 连接密码 
   $sql_dbName = "citgdb20120104"; // 名称
   $sql_code   = "gb2312";     //读取数据编码方式 
   $sql_prefix = "km_";        //读取数据前缀


//---------------- |数据连接| ------------------
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
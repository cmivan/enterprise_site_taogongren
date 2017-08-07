<?php
/**
 * 返回客户端ip
 *
 * @access: public
 * @author: mk.zgc
 * @return: string
 */
function ip()
{
	$CI = & get_instance();
	return $CI->input->ip_address();
} 

function get_ip_place()
{
	$ip = file_get_contents("http://fw.qq.com/ipaddress");  
	$ip = str_replace('"',' ',$ip);  
	$ip2 = explode("(",$ip);  
	$ip3 = substr($ip2[1],0,-2);  
	$ip4 = explode(",",$ip3);  
	return $ip4;  
}




//===================================
// 纯真数据库获取ip
// 功能：IP地址获取真实地址函数
// 参数：$ip - IP地址
// 作者：[Discuz!] (C) Comsenz Inc.
//
//===================================
function convertip($ip) {
    //IP数据文件路径
    $dat_path  = 'public/QQWry.Dat';    //检查IP地址
    if(!preg_match("/^\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}$/", $ip)){ return 'IP err'; }
    //打开IP数据文件
    if(!$fd = @fopen($dat_path, 'rb')){ return 'IP数据文件无法读取，请确保是正确的纯真IP库！'; } //分解IP进行运算，得出整形数
    $ip = explode('.', $ip);
    $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];    //获取IP数据索引开始和结束位置
    $DataBegin = fread($fd, 4);
    $DataEnd = fread($fd, 4);
    $ipbegin = implode('', unpack('L', $DataBegin));
	//unpack() 函数从二进制字符串对数据进行解包。unpack(format,data) L - unsigned long (always 32 bit, machine byte order)
	#$ipbegin 值如：5386001
	if($ipbegin < 0) $ipbegin += pow(2, 32);
    $ipend = implode('', unpack('L', $DataEnd));
    if($ipend < 0) $ipend += pow(2, 32);
    $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
    
    $BeginNum = 0;
    $EndNum = $ipAllNum; //使用二分查找法从索引记录中搜索匹配的IP记录
	$ip1num = '';$ip2num = '';$ipAddr1 = '';$ipAddr2 = '';
    while($ip1num>$ipNum || $ip2num<$ipNum) {
        $Middle= intval(($EndNum + $BeginNum) / 2); //偏移指针到索引位置读取4个字节
        fseek($fd, $ipbegin + 7 * $Middle);
        $ipData1 = fread($fd, 4);
        if(strlen($ipData1) < 4) {fclose($fd);return 'System Error';}
        //提取出来的数据转换成长整形，如果数据是负数则加上2的32次幂
        $ip1num = implode('', unpack('L', $ipData1));
        if($ip1num < 0) $ip1num += pow(2, 32);
        //提取的长整型数大于我们IP地址则修改结束位置进行下一次循环
        if($ip1num > $ipNum) {$EndNum = $Middle;continue;}
        //取完上一个索引后取下一个索引
        $DataSeek = fread($fd, 3);
        if(strlen($DataSeek) < 3) {fclose($fd);return 'System Error';}
        $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
        fseek($fd, $DataSeek);
        $ipData2 = fread($fd, 4);
        if(strlen($ipData2) < 4) {fclose($fd);return 'System Error';}
        $ip2num = implode('', unpack('L', $ipData2));
        if($ip2num < 0) $ip2num += pow(2, 32);        //没找到提示未知
        if($ip2num < $ipNum) {
            if($Middle == $BeginNum) {fclose($fd);return 'Unknown';}
            $BeginNum = $Middle;
        }
    }    //下面的代码读晕了，没读明白，有兴趣的慢慢读
    $ipFlag = fread($fd, 1);
    if($ipFlag == chr(1)) {
        $ipSeek = fread($fd, 3);
        if(strlen($ipSeek) < 3) {fclose($fd);return 'System Error';}
        $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
        fseek($fd, $ipSeek);
        $ipFlag = fread($fd, 1);
    }    if($ipFlag == chr(2)) {
        $AddrSeek = fread($fd, 3);
        if(strlen($AddrSeek) < 3) {fclose($fd);return 'System Error';}
        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if(strlen($AddrSeek2) < 3) {fclose($fd);return 'System Error';}
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
		while(($char = fread($fd, 1))  != chr(0)) $ipAddr2 .= $char;
		$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
        fseek($fd, $AddrSeek);
		while(($char = fread($fd, 1))  != chr(0)) $ipAddr1 .= $char;
    } else {
        fseek($fd, -1, SEEK_CUR);
        while(($char = fread($fd, 1))  != chr(0)) $ipAddr1 .= $char;
		$ipFlag = fread($fd, 1);
        if($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if(strlen($AddrSeek2) < 3) {fclose($fd);return 'System Error';}
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
        while(($char = fread($fd, 1))  != chr(0)){$ipAddr2 .= $char;}
    }
    fclose($fd);    //最后做相应的替换操作后返回结果
    if(preg_match('/http/i', $ipAddr2)) {$ipAddr2  = '';}
    $ipaddr = "$ipAddr1 $ipAddr2";
    $ipaddr = preg_replace('/CZ88.Net/is', '', $ipaddr);
    $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
    $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
    if(preg_match('/http/i', $ipaddr) || $ipaddr == '') { $ipaddr  = 'Unknown'; }
	return mb_convert_encoding($ipaddr,"utf8","gbk");
}












/**
 * 投标信息分类处理
 *
 * @access: public
 * @author: mk.zgc
 * $l_rs 数组
 * $l_onid 被选中项的ID
 * $l_title 被选中项的标题
 * $l_input 是否有input项
 * @return: string
 */
function slistitems($l_rs,$l_onid=0,$l_title  = '',$l_input=0)
{
	if($l_title != ''){ if($l_onid=="no"||$l_onid== ''){$thison="class = 'on'";}else{$thison  = '';}
	echo "<a href = 'javascript:void(0);' id = 'no' ".$thison.">".$l_title."</a>";
	}
	
	$l_onid="__".$l_onid."_";
	if(!empty($l_rs))
	{
		foreach($l_rs as $t_rs)
		{
			$tid = "_".$t_rs->id."_"; $thison   = '';$thisboxon   = '';
			if(strpos($l_onid,$tid)>0){ $thison="class = 'on'"; $thisboxon="checked=checked"; }
			//用于工种在retrieval.php页面
			if($l_input==1){$l_inputs = '<input type="checkbox" value="'.$t_rs->id.'" '.$thisboxon.' />';}else{$l_inputs = '';}
			echo "<a href = 'javascript:void(0);' id = '".$t_rs->id."' ".$thison.">".$l_inputs.$t_rs->title."</a>";
		}
	}
}



/**
 * 后台页面，导航tab项 数组处理
 *
 * @access: public
 * @author: mk.zgc
 * @return: string
 */
function c_nav($navarr,$curl = '')
{
	$CI = & get_instance();
	//获取当前被选中的导航项
	if(empty($navarr["on"])){
		$navarr["on"] = $CI->uri->segment(3);
		if($navarr["on"]==''){ $navarr["on"] = $navarr["nav"][0]["link"]; }
		}

	//重组导航项
	$navStr  = '';
	if(!empty($navarr)){
		if(!empty($navarr["nav"])){
			foreach($navarr["nav"] as $nav){
				if(empty($nav["link"])||$nav["link"] == ''){ //分隔线
					$navStr.= '<div class="info">&nbsp;</div>';
				}else{
					$thiscss = '';
					$thison  = '';
					$thistip = '';
					if(!empty($nav['tip'])&&$nav['tip'] != ''){$thistip = 'tip';}else{$thistip = '';}
					if($navarr['on']==$nav['link']){$thison = 'on';}else{$thison = '';}
					if($thison != ''&&$thistip != ''){
					   $thiscss = ' class="tip on" title="'.$nav['tip'].'"';
					}elseif($thistip != ''){
					   $thiscss = ' class="tip" title="'.$nav['tip'].'"';
					}elseif($thison != ''){
					   $thiscss = ' class="on" ';
					}
					$navlink = $curl.'/'.$nav['link'];
					$navlink = str_replace('//','/',$navlink);
				    $navStr.= '<a href="'.site_url($navlink).'" '.$thiscss.'>'.$nav["title"].'</a>';
				}
			}
		}
	}
	return $navStr;
}



?>
<?php


/**
 * 返回日期
 * 
 * @access: public
 * @author: mk.zgc
 * @param: datetime,$val  原字符
 * @return: date 
 */
function dateYMD($val,$T=0)
{
	if($T==1){
		$Y = date('Y',strtotime($val));
		$M = date('m',strtotime($val));
		$D = date('d',strtotime($val));
		$date = $Y.'-'.$M.'-'.$D;
		return str_replace('-0','-',$date);
	}else{
		return "<span title='".$val."' class='tip'>".date("Y-m-d",strtotime($val))."</span>";
	}
}


function dateDDD($time='')
{
	if($time==''){$time=time();}else{$time=strtotime($time);}
	return date("Y.m.d",$time);
}


function dateTime($time='')
{
	if($time==''){$time=time();}else{$time=strtotime($time);}
	return date("Y-m-d H:i:s",$time);
}


function dateHi($time='')
{
	if($time==''){$time=time();}else{$time=strtotime($time);}
	return date("Y-m-d H:i",$time);
}


/**
 * 返回年龄
 * 
 * @access: public
 * @author: mk.zgc
 * @param: datetime,$val  原字符
 * @return: date 
 */
function dataAge($val)
{
	$dateY1 = date("Y",strtotime($val));
	$dateY2 = date("Y",time());
	$dateY3 = $dateY2 - $dateY1;
	if($dateY3<=0){
		return 0;
	}else{
		return $dateY3;
	}
}

/**
 * 返回日期离现在多远
 * 
 * @access: public
 * @author: mk.zgc
 * @param: datetime,$val  原字符
 * @return: date 
 */
function dataMark($val)
{
	return "<span title='".$val."' class='tip'>".date("Y-m-d",strtotime($val))."</span>";
}


/**
 * 返回当前时间减去24小时
 * 
 * @access: public
 * @author: mk.zgc
 * @param: datetime,$val  原字符
 * @return: date 
 */
function dateDay24()
{
	return time()-(3600*24);
}


/**
 * 返回步骤是否已经超过7天
 * 
 * @access: public
 * @author: mk.zgc
 * @param: datetime,$val  原字符
 * @return: date 
 */
function date7day($day,$str)
{
	//定义操作的超时时间，超过指定时间范围则 操作无效
	$d = 7;
	$limtDay = time()-(3600*24)*$d;	
	$day = strtotime($day);
	if($day>$limtDay){
	  //未超时 正常显示
	   echo $str;
	}else{
	  //已超时 显示超时
	   echo '已超过'.$d.'天!';
	}
}





/**
 * 返回两个日期的差值（相差多少天）
 * 
 * @access: public
 * @author: mk.zgc
 * @param: date_day,$val  原字符
 * @return: int 
 */
function date_day($date1,$date2)
{
	  $dateS = strtotime($date1);
	  $dateE = strtotime($date2);
	  $dateA = $dateE-$dateS;
	  return ($dateA)/(3600*24); //返回相差的天数
	  if($dateA>0){
		  return ($dateA)/(3600*24); //返回相差的天数
	  }else{
		  return 0;
	  }
} 




/**
 * 计算时间差
 * 
 * @access: public
 * @author: mk.zgc
 * format time
 * @param string $time 
 * @return string
*/

function format_time($time)
{
	if(empty($time)) {return $time;}
	if (PHP_VERSION < 5) {
		$matchs = array();
		preg_match_all('/(\S+)/', $time, $matchs);
		if ($matchs[0]) {
			$Mtom=array('Jan' => '01',
						'Feb' => '02',
						'Mar' => '03',
						'Apr' => '04',
						'May' => '05',
						'Jun' => '06',
						'Jul' => '07',
						'Aug' => '08',
						'Sep' => '09',
						'Oct' => '10',
						'Nov' => '11',
						'Dec' => '12');
			$time = $matchs[0][5].$Mtom[$matchs[0][1]].$matchs[0][2].' '.$matchs[0][3];
		}
	}
	
	$s_t = strtotime($time);
	$s_time1=time();

	if(($s_t-$s_time1)<0){
	    $t    =$s_time1;
	    $time1=$s_t;
	}else{
	    $t    =$s_t;
	    $time1=$s_time1;	
	}

	//转换
	$differ = $t-$time1;
	$year = date('Y', $time1);

	if (($year % 4) == 0 && ($year % 100) > 0) {
		//闰年
		$days = 366;
	} elseif (($year % 100) == 0 && ($year % 400) == 0) {
		//闰年
		$days = 366;
	} else {
		$days = 365;
	}

	if ($differ <= 60&&$differ>=0) {
		//小于1分钟
		$format_time = sprintf('%d秒', $differ);
//    } elseif ($differ <0) {
//		//过期
//		$format_time = "任务已过期";
	} elseif ($differ > 60 && $differ <= 60 * 60) {
		//大于1分钟小于1小时
		$min = floor($differ / 60);
		$format_time = sprintf('%d分钟', $min);
	} elseif ($differ > 60 * 60 && $differ <= 60 * 60 * 24) {
		if (date('Y-m-d', $time1) == date('Y-m-d', $t)) {
			//大于1小时小于当天
			$format_time = sprintf('%s小时', date('h', $t)-date('h', $time1)+12);
			//$format_time = (24-(int)($differ/3600)-1)."小时";
		} else {
			//大于1小时小于24小时
			$format_time = sprintf('%s小时', date('h', $t)-date('h', $time1));
		}
	} elseif ($differ > 60 * 60 * 24 && $differ <= 60 * 60 * 24 * $days) {
		if (date('Y-m', $time1) == date('Y-m', $t)) {
			//当年当月
			//$format_time = sprintf('%s天', date('d', $t)-date('d',$time1)+1);
			$format_time = sprintf('%s天', date('d', $t)-date('d',$time1)+1);
		} else {
			//当年非当月
			$format_time = date('m', $t)-date('m',$time1);
			$format_time = sprintf('%s天', date('d', $t)-date('d',$time1)+30*$format_time);
//			$format_time = date('m', $t)-date('m',$time1);
//			$format_time = $format_time."个月";
		}
	} else {
		//大于今年
		$format_time = sprintf('%s年', date('Y', $t)-date('Y', $time1));
	}
	return $format_time;
}

?>
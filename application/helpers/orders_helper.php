<?php

# 返回当前订单的状态（主要是工程单需要用到）
function order_stat($ostat='',$isevaluate=0,$id=0)
{
  $CI = &get_instance();
  $img_url = $CI->config->item('img_url');
  if($ostat){
	  $back = '';
	  if($isevaluate==1){
		  //单方评
		  $back.= '<a href="javascript:void(0);" class="order_comm tip" id="'.$id.'" title="你已经给出评分!">';
		  $back.= '<img src="'.$img_url.'ico/tick_circle.png" width="16" height="16" /><br />已评</a>';
	  }elseif($isevaluate==2){
		  //互评
		  $back.= '<a href="javascript:void(0);" class="order_comm tip" id="'.$id.'" title="双方已经对该订单进行评分!">';
		  $back.= '<img src="'.$img_url.'ico/tick_circle.png" width="16" height="16" /><br />已互评</a>';
	  }else{
		  //未评
		  $back.= '<a href="javascript:void(0);" class="order_comm tip" id="'.$id.'" title="等待评分">';
		  $back.= '<img src="'.$img_url.'ico/tick_circle_no.png" width="16" height="16" /><br />评分</a>';
	  }
	  return $back;
  }else{
	  return '<span class="tip" title="进行中..." ><img src="'.$img_url.'ico/development.png" width="16" height="16"/></span>';
  }
}



//显示诚意金
function order_deal_cy_money($OPSnum,$cy_money)
{
	if($OPSnum==1&&$cy_money>0)
	{
		return '+<span class="feed tip" title="这<b>'.$cy_money.'</b>元是诚意金">'.$cy_money.'</span>';
	}
}

//显示合同步骤状态
function order_deal_step_stat($startdate,$paydate)
{
	$back = '';
	if($startdate==''&&$paydate==''){
		$back.= '<span class="tip" title="正等待开始...">...</span>';
	}else{
		if($startdate!=''){ $back.= '开始：'.dateHi($startdate); }
		if($paydate!=''){ $back.= '<br/>验收：'.dateHi($paydate); }
	}
	return $back;
} 

//显示合同步骤状态2
function order_deal_step_stat_2($step_stat,$stepNO,$ispay)
{
	$back = '';
	if($step_stat<>2&&$stepNO>1)
	{
		$back = '<span>未开始</span>';
	}else{
		if($ispay==0){
			$back = '<span>未开始</span>';
		}elseif($ispay==1){
			$back = '<span class="red">已开始</span>';
		}else{
			$back = '<span class="green">已验收</span>';
		}
	}
	return $back;
} 

//显示合同步骤操作按钮（For 业主）
function order_deal_step_btu($step_stat,$stepNO,$ispay)
{
	$back = '';
	if($step_stat<>2&&($stepNO>1))
	{
		$back = '<div class="disabled">等待</div>';
	}else{
		if($ispay==0){
			$back = '<a href="javascript:void(0);" link="'.reUrl("action=step_start&step=".$stepNO).'" class="step_start">开始</a>';
		}elseif($ispay==1){
			$back = '<a href="javascript:void(0);" link="'.reUrl("action=step_ok&step=".$stepNO).'" class="step_yanshou">验收</a>';
		}else{ //echo '<span class="green">已验收</span>';
			$back = '<span class="green">-</span>';
		}
	}
	return $back;
} 






/*
  显示工程但的合同状态(业主)
  $u_ok:用户id
  $u_ok_2:用户id2
  $feed:反馈内容
  $dealok:合同是否生效
  $oktime:生效时间
*/
function order_deal_stat_show_yz($u_ok,$u_ok_2,$feed,$dealok,$addtime,$oktime)
{
	$back = '';
	if($u_ok==1&&$u_ok_2==0){
		$back.= '<b class="red">等待对方同意合同</b>';
	}elseif($u_ok==1&&$u_ok_2==2){
		//$back.= '<b class="red tip" title="'.$feed.'">对方不同意合同内容!</b>';
		$back.= '<b class="red">对方不同意合同内容!</b><br /><span class=red>原因：'.$feed.'</span>';
	}elseif($dealok){
		$back.= '<b class="green">合同已生效</b>';
	}else{
		$back.= '<b class="red">我还没确认</b>';
	}
	$back.= '<br>起草：'.dateHi($addtime);
	if($dealok){ $back.= '<br>生效：'.dateHi($oktime); }
	return $back;
}


/*
  显示工程但的合同状态(工人)
  $u_ok:用户id
  $u_ok_2:用户id2
  $feed:反馈内容
  $dealok:合同是否生效
  $oktime:生效时间
*/
function order_deal_stat_show_gr($u_ok,$u_ok_2,$feed,$dealok,$addtime,$oktime)
{
	$back = '';
	if($u_ok==1&&$u_ok_2==0){
		$back.= '<b class="red">我未同意合同</b>';
	}elseif($u_ok==1&&$u_ok_2==2){
		// title="'.$feed.'"
		$back.= '<b class="red">我不同意合同内容!</b><br /><span class=red>原因：'.$feed.'</span>';
	}elseif($dealok){
		$back.= '<b class="green">合同已生效</b>';
	}else{
		$back.= '<b class="red">业主未确认</b>';
	}
	$back.= '<br>起草：'.dateHi($addtime);
	if($dealok){
		$back.= '<br>生效：'.dateHi($oktime);
		}
	return $back;
}


/*返回业主对报价信息的确认状态（用于工人页面显示）*/
function order_project_price_stat($user_links,$new_quote,$feed)
{
	if($new_quote==1){
		return '<div class="text"> 业主 '.$user_links.' 同意了以上项目的报价 &radic; </div>';
	}elseif($new_quote==2){
		return '<div class="text"> 业主 '.$user_links.' 未同意以上的项目报价 &times; </div><br /><span class=red>不同意原因：'.$feed.'</span>';
	}elseif($new_quote==0){
		return '<div class="text">等待业主 '.$user_links.' 回应 ...</div>';
	}else{
		return '';
	}
}






#返回当前状态
# $ok=是否已经付款，$r=提交退款申请的状态，$m=申请收款的金额
function simple_stat_W($ok=0,$r=0,$m=0){
  $CI = &get_instance();
  $img_url = $CI->config->item('img_url');
  if($ok==0){ echo '等待确认...';return; }
  elseif($ok==1){ echo '<span class=green>订单完成&radic;</span>';return; }
  switch($r){
	  #未提交任何申请状态
	  case 0:
		echo '<span class="red">等待验收...</span>'; break;
	  #已申请退款,等待回应
	  case 1:
		echo '业主<br><span class="red">申请支付 <span class=chenghong>'.$m.'</span>元 </span><br>';
		echo '<a class="ok_yes" href="javascript:void(0);" title="确定收款">确定收款</a>&nbsp;&nbsp;';
		echo '<a class="ok_not" href="javascript:void(0);" title="不同意">不同意</a>';
		break;
	  #已同意退款，完成操作
	  case 2:
		echo '<span class=green>已收到订单费用<br><span class=chenghong>('.$m.'元)</span></span>'; break;
	  #不同意退款
	  case 3:
		echo '<span class=red>&times;不同意支付<br><span class=chenghong>'.$m.'元</span>给业主</span>'; break;
	  #对方不在追究
	  case 4:
		echo '<span class=green title=不需退款 >&radic;不需退款</span>'; break;
  }
}




#返回当前状态
# $ok=是否已经付款，$r=提交验收申请的状态，$m=申请退回的金额
function simple_stat_E($ok=0,$r=0,$m=0,$msg=''){
	if($ok==0){
	   echo '<a href="javascript:void(0);" class="ok_order tip" title="需要确认后才能进行下一步!">确认订单</a>';return;
	}elseif($ok==1){
	   echo '<span class=green>订单完成&radic;</span>';return;
	}
	switch($r){
		#未提交任何申请状态
		case 0:
		  #返回留言内容
		  if($msg!=""){
			 echo '对方不同意支付申请<br />原因：<span class=red>'.$msg.'</span><br/>'; 
			 echo '<a href="javascript:void(0);" class="ok">重新验收</a>';
		  }else{
			 echo '<a href="javascript:void(0);" class="ok">验收</a>';	  
		  }
		  break;
		#已申请验收,等待回应
		case 1:
		  echo '<span class="red">申请支付(<span class=chenghong>'.$m.'元</span>)<br>等待确认...</span>';
		  break;
		#已同意验收,完成操作
		case 2:
		  echo '<span class="green">已成功支付(<span class=chenghong>'.$m.'元</span>)</span>';
		  break;
		#不同意验收
		case 3:
	      echo '<span class="red">对方不同意</span><br>';
		  echo '<a class="feed_yes" href="javascript:void(0);" title="申诉">申诉</a>&nbsp;&nbsp;';
		  echo '<a class="feed_not" href="javascript:void(0);" title="不申诉">不申诉</a>';
		  break;
		#不再追究
		case 4:
	      echo '<span class="green">不追究验收</span>';
		  break; 
	}
}



?>
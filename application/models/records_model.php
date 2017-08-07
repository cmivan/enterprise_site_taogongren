<?php
#用户收入记录

class Records_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
/**
 * 用户收入sql(用于页面列表处理)
 */	
	function record_in($uid)
	{
		return "select * from records where uid=".$uid." and cost>0 order by id desc";
	}
/**
 * 用户消费sql(用于页面列表处理)
 */	
	function record_out($uid)
	{
		return "select * from records where uid=".$uid." and cost<0 order by id desc";
	}
/**
 * 用户提现/转账sql(用于页面列表处理)
 */	
	function record_transfer($uid)
	{
		return "select * from records_transfer where uid=".$uid." order by id desc ";
	}

	
 
	
	
/**
 * 用户信用金
 */	
	function credits($uid)
	{
		$c=$this->db->query("select sum(cost) as cost from records where uid=".$uid." and costype='S_XY'")->row();
		if(!empty($c)){ return $c->cost; }else{ return 0;}
	}
	
/**
 * 账户总记录
 */	
	function balances($uid)
	{
		$costs=0;
		if(is_num($uid))
		{
			$c = $this->db->query("select sum(cost) as costs from records where uid=".$uid)->row();
			if(!empty($c)){ $costs=$c->costs; }
		}
		return $costs;
	}
	
	
/**
 * 返回用户账户余额
 * 参数：$T="T" 淘工币 $T="S" 实币
 */
	function balance_cost($uid,$T="T")
	{
		//初始化变量
		if($T=="T"||$T=="S"||$T=="S_XY"){
			if(is_num($uid))
			{
				$c = $this->db->query("select sum(cost) as costs from records where uid=".$uid." and costype='".$T."'")->row();
				if(!empty($c)){ $cost = $c->costs; }
			}
		}
		$cost = is_num($cost,0);
		return $cost; //返回剩余金额
	}




/**
  * 操作用户户账户余额
  * $uid  被操作用户
  * $cost 被操作金额, $cost>0则充值，$cost<0则扣除
  * $tip  记录提示记录
  * $T="T" 淘工币, $T="S"实币
  */
	function balance_control($uid=0,$cost=0,$tip='',$T='')
	{
		//保证操作类型不超出操作范围
		if($T=="T"||$T=="S"||$T=="S_XY")
		{
			$tip = str_replace("'","\"",$tip); //过滤字符
			$sysnum = time();
			$ip = ip();
			if(is_num($uid)!=false&&is_num($cost)!=false&&$tip!='')
			{
				//获取总账户，金额
				$cost_count = $this->balance_cost($uid,$T);
				if(($cost_count + $cost)>=0){
				  //运行事务
				  $this->db->trans_start();
				  $this->db->query("INSERT INTO `records`(`uid` ,`cost` ,`note` ,`ip` ,`sysnum` ,`costype`) VALUES($uid, $cost, '".$tip."', '".$ip."', '$sysnum', '$T');");
				  $this->db->trans_complete();
				  return true;
				}else{
				  return false;	
				}
			}
		}
		return false;
	}


	
	
}
?>
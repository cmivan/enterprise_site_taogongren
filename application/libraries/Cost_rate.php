<?php

/*
 * 订单服务费处理类
 * * */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cost_rate
{
	//初始化费用
	var $cost=0;
	//服务费收费率
	var $costRate = 0.05;
	
	function __construct()
	{
	
	}
	
	//原费用
	public function cost_this()
	{
		//转换
		$tcose=$this->cost;
		if($tcose<0){$this->cost=-$tcose;}
		return round($this->cost,1);
	}
	
	//服务费用
	public function cost_ser()
	{
		return round(($this->costRate)*($this->cost),1);
	} 
	
	//剩余费用(原费用减服务费)
	public function cost_less()
	{
		return round(($this->cost_this())-($this->cost_ser()),1);
	}
	
	//总费用(原费用加服务费)
	public function cost_sum()
	{
		return round(($this->cost_this())+($this->cost_ser()),1);
	}
	
	//返回比率
	public function cost_rate()
	{
		return (($this->costRate)*100)."%";
	}
	
	//返回剩比率
	public function cost_rate_last()
	{
		return ((1-($this->costRate))*100)."%";
	}
	
}

?>
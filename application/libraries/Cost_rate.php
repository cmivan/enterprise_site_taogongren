<?php

/*
 * ��������Ѵ�����
 * * */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cost_rate
{
	//��ʼ������
	var $cost=0;
	//������շ���
	var $costRate = 0.05;
	
	function __construct()
	{
	
	}
	
	//ԭ����
	public function cost_this()
	{
		//ת��
		$tcose=$this->cost;
		if($tcose<0){$this->cost=-$tcose;}
		return round($this->cost,1);
	}
	
	//�������
	public function cost_ser()
	{
		return round(($this->costRate)*($this->cost),1);
	} 
	
	//ʣ�����(ԭ���ü������)
	public function cost_less()
	{
		return round(($this->cost_this())-($this->cost_ser()),1);
	}
	
	//�ܷ���(ԭ���üӷ����)
	public function cost_sum()
	{
		return round(($this->cost_this())+($this->cost_ser()),1);
	}
	
	//���ر���
	public function cost_rate()
	{
		return (($this->costRate)*100)."%";
	}
	
	//����ʣ����
	public function cost_rate_last()
	{
		return ((1-($this->costRate))*100)."%";
	}
	
}

?>
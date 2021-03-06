<?php
/**
 * 针对网站评论的
 * 
 */

class Common_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/**
 * 加载评分输入框的JS(主要用于后台订单页面)
 * @access: public
 */
	function evaluate_js($url='',$T='0')
	{
		echo '<script language="javascript">';
		echo '$(function(){';
		echo '$(".order_comm").click(function(){';
		echo 'var orderid = $(this).attr("id");';
		echo 'if(orderid==parseInt(orderid)){';
		echo 'tb_show("订单评分","'.site_url('common/add/'.$T).'?height=368&width=600&id=" + orderid,false);';
		echo '}else{';
		echo 'alert("未能获取正确的订单ID!");';
		echo '}}); });';
		echo '</script>';
	}
 
 


    

/**
 * 返回用户使用已评价(包含返回用户信息)
 * @access: public
 * @author: mk.zgc
 * @param: int，$id，内容获取的ID
 * @param: int，$uid ，用户id
 * @param: String，$T ，评论类型
 * @return: array 
 */
	function user_evaluate_one($keyid,$uid,$T='0')
	{
		return $this->db->query("select id,note,haoping,scorarr,uid,uid_2 from `evaluate` where oid=".$keyid." and uid=".$uid." and T='".$T."' LIMIT 1")->row();
	}
	
	
/**
 * 返回评分状态
 * @access: public
 * @author: mk.zgc
 * @param: int，$id，内容获取的ID
 * @param: int，$uid ，用户id
 * @param: String，$T ，评论类型
 * @return: array 
 */
	function evaluate_stat($keyid,$uid,$T='0')
	{
		$ers = $this->user_evaluate_one($keyid,$uid,$T);
		if(!empty($ers)){
			//找出被评分用户ID
			$e_uid = $ers->uid;
			if($e_uid==$uid){ $e_uid = $ers->uid_2; }
			$e_uid = is_num($e_uid,0);
			//获取对方的评分状态
			$ers2 = $this->user_evaluate_one($keyid,$e_uid,$T);
			if(!empty($ers2)){
				return 2; //双方评分
			}else{
				return 1; //单方评分
			}
		}else{
			return 0; //没获取到评论数据,即$uid用户为评分
		}
	}
	
	

/**
 * 写入订单评价及星级评分
 * @access: public
 * @author: mk.zgc
 * @param: int，$keyid，内容获取的ID
 * @param: int，$uid ，用户id
 * @param: int，$uid_2 ，用户id2
 * @param: String，$note ，评论内容
 * @param: int，$scor ，评分分数
 * @param: array，$scorarr ，星号评分分数数组
 * @param: String，$T ，评论类型
 * @return: bool 
 */
	function evaluate_add($keyid,$uid,$uid_2,$note,$haoping,$scorarr,$T='0')
	{
		$data['oid'] = $keyid;
		$data['uid'] = $uid;
		$data['uid_2'] = $uid_2;
		$data['note'] = $note;
		$data['haoping'] = $haoping;
		$data['scorarr'] = $scorarr;
		$data['ip'] = ip();
		$data['T'] = $T;
		$this->db->insert('evaluate',$data);
	  
		//$this->rating_add_arr($keyid,$uid,$uid_2,$scorarr,$T);  //添加相应的评分
	  
		return true;
	}
	
/**
 * 解析表单提交的星级评分是否符合
 * @access: public
 * @author: mk.zgc
 * @param: array，$rating_class，星级评分分类
 * @return: string
 */	
	function rating_scorarr($rating_class)
	{
		$scorarr = '';
		if(!empty($rating_class)){
			foreach($rating_class as $rs){
			   $hpscor = is_num($this->input->post('hiStar'.$rs->id));
			   if($hpscor==false||$hpscor<1||$hpscor>5){ json_form_no('请给'.$rs->title.'评分!'); }
			   $scorarr.= ','.$rs->id.'_'.$hpscor;
			}
		}else{
			json_form_no('服务器繁忙,请稍后再试!');
		}
		return $scorarr;
	}
	
/**
 * 添加星级评分（解析数组，并录入）
 * @access: public
 * @author: mk.zgc
 * @param: int，$keyid，内容获取的ID
 * @param: int，$uid ，用户id
 * @param: int，$uid_2 ，用户id2
 * @param: array，$scorarr ，星号评分分数数组
 * @param: String，$T ，评论类型
 * @return: bool 
 */
	function rating_scor2arr($scorarr)
	{
		$scorI = 0;
		$scor_item = split(",",$scorarr);
		foreach($scor_item as $sitem){
			if($sitem!=''){
				$item = split("_",$sitem);
				//限定分数范围,防止恶意提交
				if(is_num($item[0])&&is_num($item[1])&&$item[1]>=1&&$item[1]<=5)
				{
					$thisdata[$scorI]['id'] = $item[0];
					$thisdata[$scorI]['scor'] = $item[1];
					$scorI++;
				} 
			}
		}
		if(!empty($thisdata)){ return $thisdata; }
		return ;
	}
	
	
/**
 * 验证好评的提交数据是否符合要求
 * @access: public
 * @author: mk.zgc
 * @param: string，$haoping，好评分数
 * @return: string
 */	
	function rating_haoping($haoping)
	{
		if($haoping<>'1'&&$haoping<>'0'&&$haoping<>'-1')
		{
			json_form_no('参数有误!');
		}
		return $haoping;
	}



	//读取评论内容order_door <><><><><><><><><><><>
	function evaluate_order_door($keyid,$uid)
	{
		return $this->user_evaluate_one($keyid,$uid,'od');
	}
	//返回评分状态
	function isevaluate_order_door($keyid,$uid)
	{
		return $this->evaluate_stat($keyid,$uid,'od');
	}



	//读取评论内容order_simple <><><><><><><><><><><>
	function evaluate_order_simple($keyid,$uid)
	{
		return $this->user_evaluate_one($keyid,$uid,'os');
	}
	//返回评分状态
	function isevaluate_order_simple($keyid,$uid)
	{
		return $this->evaluate_stat($keyid,$uid,'os');
	}



	//读取评论内容order_project <><><><><><><><><><><>
	function evaluate_order_project($keyid,$uid)
	{
		return $this->user_evaluate_one($keyid,$uid,'op');
	}
	//返回评分状态
	function isevaluate_order_project($keyid,$uid)
	{
		return $this->evaluate_stat($keyid,$uid,'op');
	}



	//读取评论内容cases <><><><><><><><><><><>
	function evaluate_cases($keyid,$uid)
	{
		return $this->user_evaluate_one($keyid,$uid,'ca');
	}
	//返回评分状态
	function isevaluate_cases($keyid,$uid)
	{
		return $this->evaluate_stat($keyid,$uid,'ca');
	}


}
?>
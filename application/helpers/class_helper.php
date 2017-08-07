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
function SelectListItems($l_rs,$l_onid=0,$l_title = '',$l_input=0)
{
	$Items = '';
	if($l_title != '')
	{
		$thison  = '';
		if( ( empty($l_onid) && $l_onid!==0 ) || $l_onid==='no' || $l_onid==='' )
		{
			$thison="class = 'on'";
		}
		$Items.= "<a href='javascript:void(0);' cmd='null' id='no' ".$thison.">".$l_title."</a>";
	}

	if(!empty($l_rs))
	{
		foreach($l_rs as $t_rs)
		{
			$thison = '';
			$thisboxon = '';
			if( is_array($l_onid) && in_array($t_rs->id,$l_onid))
			{
				$thison = "class = 'on'";
				$thisboxon = "checked = 'checked'";
			}
			elseif( is_numeric($l_onid) && (strpos('__'.$l_onid.'_','_'.$t_rs->id.'_')>0) )
			{
				$thison = "class = 'on'";
				$thisboxon = "checked = 'checked'";
			}
			//用于工种在retrieval.php页面
			$l_inputs = '';
			if( $l_input==1 )
			{
				$l_inputs = '<input type="checkbox" value="'.$t_rs->id.'" '.$thisboxon.' />';
			}
			$Items.= "<a href='javascript:void(0);' cmd='null' id='".$t_rs->id."' ".$thison.">".$l_inputs.$t_rs->title."</a>";
		}
	}
	return $Items;
}



/*返回排序方式*/
function order_type($val='0')
{
	if($val=='1')
	{
		return 'desc';
	}
	elseif($val=='0')
	{
		return 'asc';
	}
	return false;
}


?>
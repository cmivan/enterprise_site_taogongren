<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
		
	#返回目标区域的省份及城市
	function sel_provinces()
	{
		$data = '';
		$r_id = $this->input->getnum('r_id');
		$c_id = $this->input->getnum('c_id');
		if( $r_id )
		{
			//获取旗下省份
			$provinces = $this->Place_Model->provinces($r_id);
			if( !empty($provinces) )
			{
				$p_num = 0;
				foreach( $provinces as $p_rs )
				{
					//设置样式
					if($p_num%2==1)
					{
						$style = 'class=item';
					}
					else
					{
						$style = 'class=item2';
					}
					
					$data.= '<div '.$style.'>';
					$data.= '<div class="provinces">'.$p_rs->p_name.'</div>';
					$data.= '<div class="areas">';
					
					//获取该省下的城市
					$citys = $this->Place_Model->citys($p_rs->p_id);
					if(!empty( $citys ))
					{
						foreach( $citys as $c_rs )
						{
							$data.= '<a href="javascript:void(0);" id="'.$c_rs->c_id.'">'.$c_rs->c_name.'</a>';
						}
					}
					$data.= '</div><div class="clear"></div></div>';
					$p_num++;
				}
			}
		}
		elseif( $c_id )
		{
			// $this->input->getnum('c_id') 用于重新记录地区信息
			 $this->Place_Model; exit;
		}
		json_echo($data);
	}
	
	
	#返回城市信息
	function sel_citys($id = '')
	{
		if(is_num($id))
		{
		   $thisrs = $this->Place_Model->citys($id);
		   $data = ''; //初始化
		   $dataI = 0;
		   foreach($thisrs as $rs)
		   {
			   $dataI++;
			   if($dataI==1)
			   {
				  $data.= '{"val":"'.$rs->c_id.'","title":"'.$rs->c_name.'"}';
			   }
			   else
			   {
			      $data.=',{"val":"'.$rs->c_id.'","title":"'.$rs->c_name.'"}';   
			   }
		   }
		   $data = '['.$data.']';
		   //gzip辅助输出 (使用gzip后不能在控制器使用echo等直接输出)
		   json_echo($data);
		}
	}
		
	
	#返回地区信息
	function sel_areas($id = '')
	{
		if(is_num($id))
		{
		   $thisrs = $this->Place_Model->areas($id);
		   $data = ''; //初始化
		   $dataI = 0;
		   foreach($thisrs as $rs)
		   {
			   $dataI++;
			   if($dataI==1)
			   {
				  $data.= '{"val":"'.$rs->a_id.'","title":"'.$rs->a_name.'"}';
			   }
			   else
			   {
			      $data.= ',{"val":"'.$rs->a_id.'","title":"'.$rs->a_name.'"}';   
			   }
		   }
		   $data = '['.$data.']';
		   //gzip辅助输出 (使用gzip后不能在控制器使用echo等直接输出)
		   json_echo($data);
		}
	}	
	
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
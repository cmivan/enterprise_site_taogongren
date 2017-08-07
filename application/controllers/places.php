<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller {
	
	
	#获取地区信息
	function sel_provinces()
	{
		$place=$this->Place->box();
		if(!empty($place))
		{
			 foreach($place as $rs)
			 {
				 if(!empty($rs->provinces))
				 {
					 $data = ''; //初始化
					 foreach($rs->provinces as $p_rs)
					 {
						 if($p_rs->num%2==1){$style="class=item";}else{$style="class=item2";}
						 $data.='<div '.$style.'>';
						 $data.='<div class="provinces">'.$p_rs->p_name.'</div>';
						 $data.='<div class="areas">';
						 if(!empty($p_rs->citys)){
							foreach($p_rs->citys as $c_rs){
							   $data.='<a href="javascript:void(0);" ';
							   $data.='id="'.$c_rs->c_id.'">'.$c_rs->c_name.'</a>';
							}
						 }
						 $data.='</div><div class="clear"></div></div>';
					 }
					 //gzip辅助输出 (使用gzip后不能在控制器使用echo等直接输出)
					 json_echo($data);
				 }
			 }
		}
	}
	
	
	#返回城市信息
	function sel_citys($id="")
	{
		if($id!=""&&is_numeric($id)){
		   $thisrs=$this->Place->citys($id);
		   $data = ''; //初始化
		   $dataI=0;
		   foreach($thisrs as $rs)
		   {
			   $dataI++;
			   if($dataI==1){
				  $data.= '{"val":"'.$rs->c_id.'","title":"'.$rs->c_name.'"}';
			   }else{
			      $data.=',{"val":"'.$rs->c_id.'","title":"'.$rs->c_name.'"}';   
			   }
		   }
		   $data = '['.$data.']';
		   //gzip辅助输出 (使用gzip后不能在控制器使用echo等直接输出)
		   json_echo($data);
		}
	}
		
	
	#返回地区信息
	function sel_areas($id="")
	{
		if($id!=""&&is_numeric($id)){
		   $thisrs=$this->Place->areas($id);
		   $data = ''; //初始化
		   $dataI=0;
		   foreach($thisrs as $rs)
		   {
			   $dataI++;
			   if($dataI==1){
				  $data.= '{"val":"'.$rs->a_id.'","title":"'.$rs->a_name.'"}';
			   }else{
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
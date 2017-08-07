<?php

/**
 * 后台页面，导航tab项 数组处理
 *
 * @access: public
 * @author: mk.zgc
 * @return: string
 */
function Get_User_Nav($navarr,$curl = '')
{
	$CI = & get_instance();
	//获取当前被选中的导航项
	$onnav = $CI->uri->segment(2);
	$onnav = (strpos(' '.$onnav,'orders')) ? $onnav : $CI->uri->segment(3);
	if( empty($onnav) )
	{
		$onnav = $navarr[0]["link"];
	}

	//重组导航项
	$navStr  = '';
	if(!empty($navarr))
	{
		foreach($navarr as $nav)
		{
			$link = empty($nav['link']) ? '':$nav['link'];
			$tip = empty($nav['tip']) ? '':$nav['tip'];
			if(empty($link)||$link == '')
			{
				$navStr.= '<div class="info">&nbsp;</div>'; //分隔线
			}
			else
			{
				$thiscss = '';
				if( ($onnav == $link) && (!empty($tip) && $tip != '') )
				{
					$thiscss = ' class="tip on" title="'.$tip.'"';
				}
				elseif( !empty($tip) && $tip != '' )
				{
					$thiscss = ' class="tip" title="'.$tip.'"';
				}
				elseif( $onnav == $link )
				{
					$thiscss = ' class="on" ';
				}
				
				$navlink = $curl.'/'.$link;
				$navlink = str_replace('//','/',$navlink);
				//$navStr .= '<a href="javascript:void(0);" url="'.site_url($navlink).'" '.$thiscss.'>'.$nav["title"].'</a>';
				$navStr .= '<a href="'.site_url($navlink).'" '.$thiscss.'>'.$nav["title"].'</a>';
			}
		}
	}
	return $navStr;
}






#重新排序
function List_Re_Order($keys)
{
//    $keys = array(
//		  'table' => 'place_area',
//		  'key'  => 'a_id',
//		  'okey' => 'order_id',
//		  'where' => array('c_id'=>$c_id),
//		  'id'   => $at_a_id,
//		  'oid'  => $at_order_id,
//		  'type' => $cmd,
//		  'order_type' => 'ASC'
//		  );
	
	$CI = &get_instance();
	
	if (is_array($keys) == false)
	{
		json_form_no('服务器繁忙!');
	}
	
	$table = $keys['table'];
	$key   = $keys['key'];
	$okey  = $keys['okey'];
	$id    = $keys['id'];
	$oid   = $keys['oid'];
	$type  = $keys['type'];
	
	$where = NULL;
	$order_type = NULL;
	if(!empty($keys['where']))
	{
		$where = $keys['where'];
	}
	if(!empty($keys['order_type']))
	{
		$order_type = $keys['order_type'];
	}

	
	if(is_null($table) || is_null($key) || is_null($okey) || is_null($id) || is_null($oid))
	{
		json_form_no('服务器繁忙!');
	}

	if(is_array($where))
	{
		$CI->db->where($where);
	}
	//处理排序方式
	if( is_null($order_type) )
	{
		$order_type = 0;
	}
	
	
	//执行重新排序
	if($type=="up")
	{
		$CI->db->from($table);
		if($order_type===0)
		{
			$CI->db->where($okey.' >', $oid);
			$CI->db->order_by($okey, 'asc');
		}
		else
		{
			$CI->db->where($okey.' <', $oid);
			$CI->db->order_by($okey, 'desc');
		}
		$row_up = $CI->db->get()->row();
		if(!empty($row_up))
		{
			$up_id = $row_up->$key;
			$up_order_id = $row_up->$okey;

			$CI->db->set($okey,$oid);
			$CI->db->where($key,$up_id);
			$CI->db->update($table);
			//--------------------------------
			$CI->db->set($okey,$up_order_id);
			$CI->db->where($key,$id);
			$CI->db->update($table);
			
			json_form_yes('更新成功!');
		}
		json_form_no('排序已到上限!');
	}
	elseif($type=="down")
	{
		$CI->db->from($table);
		if($order_type===0)
		{
			$CI->db->where($okey.' <', $oid);
			$CI->db->order_by($okey, 'desc');
		}
		else
		{
			$CI->db->where($okey.' >', $oid);
			$CI->db->order_by($okey, 'asc');
		}
		$row_down = $CI->db->get()->row();
		if(!empty($row_down))
		{
			$down_id = $row_down->$key;
			$down_order_id = $row_down->$okey;
			
			$CI->db->set($okey,$oid);
			$CI->db->where($key,$down_id);
			$CI->db->update($table);
			//--------------------------------
			$CI->db->set($okey,$down_order_id);
			$CI->db->where($key,$id);
			$CI->db->update($table);

			json_form_yes('更新成功!');
		}
		json_form_no('排序已到下限!');
	}
}




/**
 * 返回uploadify上传的js
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 */
function uploadify_js($path='',$show=false,$bindID='')
{
	$CI = &get_instance();
	
	$key = pass_key($path);
	
	//$show = $CI->input->getnum('show'); //是否显示
	//$bindID = $CI->input->getnum('id',''); //用于支持同一页面显示多个上传按钮

	$js_url = $CI->config->item('js_url');
	$img_url = $CI->config->item('img_url');
	
	$da = '';
	$da.= '<link href="'.$js_url.'uploadify/uploadify.css" rel="stylesheet" type="text/css" />';
	$da.= '<script type="text/javascript" src="'.$js_url.'uploadify/jquery.uploadify.v2.1.4.js"></script>';
	$da.= '<script type="text/javascript" src="'.$js_url.'uploadify/swfobject.js"></script>';
	$da.= '<script type="text/javascript">';
	$da.= '$(function(){';
	//$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
	$da.= '$(\'#upload_img'.$bindID.'\').uploadify({';
	$da.= '\'uploader\':\''.$js_url.'uploadify/uploadify.swf\',\'auto\':true,';
	$da.= '\'script\':\''.site_url("plugins/uploadify/do_upload/".$path."/".$key).'\',';  //上传程序文件
	$da.= '\'folder\':\'\',\'cancelImg\':\'\',';
	$da.= '\'buttonImg\': \''.$img_url.'my/upimg_but.gif\',';
	$da.= '\'fileDesc\':\'请选择jpg、png、gif文件\' ,\'fileExt\':\'*.jpg;*.png;*.gif\',';
	//$da.= '\'fileDataName\': "userfile",';
	$da.= '\'sizeLimit\': 512000,';
	$da.= '\'onComplete\': function(event,queueID,fileObj,response,data) {';
	
	//$da.= 'alert("上传完成!");';
	$da.= 'var picval="";var picview="";';
	$da.= 'arr = response.split("/");';
	$da.= 'if(parseInt(arr.length)==6){';
	$da.= 'picval=arr[4]+"/"+arr[5];';
	$da.= 'picview="/"+arr[1]+"/"+arr[2]+"/"+arr[3]+"/"+picval;';
	
	//返回显示
	if($path=='retrieval')
	{
		$da.= 'var thisHTML;';
		$da.= 'thisHTML=\'<a href="javascript:void(0);" cmd="null"><span title="删除该图片!">&times;</span><img src="\'+picview+\'" /></a>\';';
		$da.= 'thisHTML=thisHTML+\'<input type="hidden" name="pic[]" id="pic[]" value="\'+picval+\'" />\';';
		$da.= 'thisHTML=\'<div>\'+thisHTML+\'</div>\';';
		$da.= '$(\'#upload_img_show\').append(thisHTML);';
		$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
		$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
		$da.= '$(\'#upload_img_show'.$bindID.' a span\').unbind("click");';  //必须先取消原来的绑定事件，否则，增加后会出现重复执行的情况
		$da.= '$(\'#upload_img_show'.$bindID.' a span\').click(function(){ if(confirm(\'确定删除该图片？\')){ $(this).parent().parent().remove(); } });';
	}
	else
	{
		$da.= '$("#pic'.$bindID.'").val(picval);';
		$da.= '$(\'#upload_img_show'.$bindID.' img\').attr("src",picview);';
		//$da.= '$(\'#upload_img_show'.$bindID.' img\').css({\'height\':\'100px\'});';
	}
	$da.= '$(\'#upload_img_show'.$bindID.'\').fadeIn(250);';

	$da.= '}else{alert(""+response+"");}';
	$da.= '},';
	$da.= '\'onError\' : function(event, queueID, fileObj) {';
	$da.= 'alert("文件: " + fileObj.name + "\\\r\\\n上传失败!");';
	$da.= '}});';
	$da.= '});</script>';
	if($show=='0')
	{
		$da.= '<style>#upload_img_show{width:500px;overflow:hidden;display:none}</style>';
	}
	else
	{
		$da.= '<style>#upload_img_show{width:500px;overflow:hidden;}</style>';
	}
	echo($da);
}

?>
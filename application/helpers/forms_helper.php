<?php
/**
 * 创建表单样式
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 * @return: string
 * @eq    : json_form_no("要提示消息"); 
 */
function cm_form_select($formID,$itemarr,$valuekey,$titlekey,$selectedkey,$style='')
{
	if(empty($formID)||$formID==''){return '未设置select框的ID!';}
	//if(empty($itemarr)||$itemarr==''){return 'select框未找到所需创建的项!';}
	if(empty($valuekey)||$valuekey==''){return '请给select框的value绑定值!';}
	if(empty($titlekey)||$titlekey==''){return '请给select框的title绑定值!';}
	$selectbox = '';
	$selectbox.= '<select id="'.$formID.'" name="'.$formID.'" '.$style.' >';
	foreach($itemarr as $item){
		if($item->$valuekey==$selectedkey){
			$selectbox.= '<option value="'.$item->$valuekey.'" selected style="background-color:#F60; color:#FFF">'.$item->$titlekey.'</option>';
		}else{
			$selectbox.= '<option value="'.$item->$valuekey.'">'.$item->$titlekey.'</option>';
		}	
	}
	$selectbox.= '</select>';
	return $selectbox;
}
 

?>
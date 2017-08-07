<?php


/**
 * 手机发信息语模板
 *
 * @access: public
 * @author: mk.zgc
 */
    function sms_simple_ok($mobile=0,$to_mobile=0,$to_uid=0,$cost)
    {
		$note = "手机".$mobile."的用户".$to_uid." 已同意了你的验收申请，验收费用为".$cost."元。详情请登陆淘工人网！";
		return smsto($to_mobile,$note);
    }
	
	
    function sms_simple_no($mobile=0,$to_mobile=0,$to_uid=0,$msg)
    {
		$note = "手机".$mobile."的用户".$to_uid." 不同意你的验收申请，原因：".$msg."。详情请登陆淘工人网！";
		return smsto($to_mobile,$note);
    }
	
	
	
    function sms_simple_notice($mobile=0,$to_mobile=0,$to_uid=0,$msg)
    {
		//$mobile_2=g_user($uid,"mobile");
		$note='';
		if($r_place!=""){$note =",地点：".$r_place;}
		$note ="手机".$mobile_2."的工人".g_user($uid,"name")."补充了订单".$note;
		$note.=",描述：".$r_note.",费用：".$r_cost."元";
		$note.="【淘工人网】";
		return smsto($to_mobile,$note);
    }

	

?>
<?php

/**
 * 提交表单返回信息提示
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 * @return: string
 * 由于使用了gzip功能后，控制器就无法使用 echo 直接输出，所以需要改函数辅助
 */
function json_echo($str)
{
	echo $str;exit;
}

/**
 * 提交表单返回的错误信息提示
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 * @return: string
 * @eq    : json_form_no("要提示消息"); 
 */
function json_form_no($str)
{
	echo '{"cmd":"n","info":"'.$str.'"}';exit;
}

/**
 * 提交表单返回的正确信息提示
 *
 * @access: public
 * @author: mk.zgc
 * @param : string，$str，提示消息
 * @return: string
 * @eq    : json_form_yes("要提示消息ok"); 
 */
function json_form_yes($str)
{
	echo '{"cmd":"y","info":"'.$str.'"}';exit;
}


/*
弹出消息窗口*/
function json_form_alt($str)
{
	echo '{"cmd":"alt","info":"'.$str.'"}';exit;
}

/*
弹出Div窗口*/
function json_form_box($title,$url)
{
	echo '{"cmd":"box","title":"'.$title.'","url":"'.$url.'"}';exit;
}

/*
弹出登录窗口*/
function json_form_box_login($title='用户登录')
{
	json_form_box($title,site_url('page/login').'?height=180&width=360');
}

/*
手机短信倒计时*/
function json_form_dj($info,$sec=0)
{
	echo '{"cmd":"dj","sec":"'.$sec.'","info":"'.$info.'"}';exit;
}


?>
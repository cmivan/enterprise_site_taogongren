<?php
/*密码加密处理函数*/

//普通用户密码加密处理
function pass_user($password)
{
	$password = md5(md5($password));
	return $password;
}

//企业用户密码加密处理
function pass_company($password)
{
	$password = md5($password.'TaoGongRen@cm.ivan@company');
	$password = md5($password.'Xv@^~*');
	$password = md5($password);
	return $password;
}

//系统用户密码加密处理
function pass_system($password)
{
	$password = md5('TaoGongRen@cm.ivan@system'.$password);
	$password = md5('#%Vadev@G^R~$.com'.$password);
	$password = md5($password);
	return $password;
}

//关键内容加密,防止串改(当天有效)
function pass_key($key)
{
	$key = md5($key.date('Ymd')); //当天有效
	$key = md5('Pass@cm.ivan@key'.$key);
	$key = md5('#%2011ev12@31G^R~$.tgr'.$key);
	$key = md5($key);
	return $key;
}


//关键内容加密,防止串改(当月有效)
function pass_token($key)
{
	$key = md5($key.date('Ym')); //当天月有效
	$key = md5('Onekey@cm.ivan@key'.$key);
	$key = md5('#%2ev12%31G^V~$.tgr'.$key);
	$key = md5($key);
	return $key;
}

?>
<?php

//重写css Url
function site_url_css($url)
{
	return site_url_fix($url,'css');
}

function site_url_js($url)
{
	return site_url_fix($url,'js');
}

function site_url_htm($url)
{
	return site_url_fix($url,'htm');
}

function ajax_url($title='',$url='',$backtype=0)
{
	$back = '<a href="'.site_url($url).'">' . $title . '</a>';
	if($backtype==0)
	{
		echo $back;
	}
	else
	{
		return $back;
	}
	return;
}

/*
 用于用户后台删除内容
 */
function ajax_delurl($tip='',$keys='',$ico='')
{
	$keys = (is_num($keys)) ? 'del_id='.$keys : $keys;
	$del = '<a href="'.reUrl($keys,1).'" title="'.$tip.'" tip="确定要'.$tip.'吗？">';
	if($ico==''){
		$del.= '删除';
	}else{
		$del.= '<img src="'.$ico.'" width="10" height="10" />';
	}
	$del.= '</a>';
	echo $del;
}

function ajax_history($title='')
{
	echo '<a class="ajax" href="javascript:void(0);" url="'.site_url($url).'">' . $title . '</a>';
}

/*
 * 用于加密URL地址，在ajax的调用过程中防止xss
 */
function site_page2ajax($url='')
{
	$CI = &get_instance();
	$center = empty($CI->data['c_url']) ? false : $CI->data['c_url'].'center';
	$url = (empty($url) || $url=='') ? false : $CI->data['c_url'].$url;
	if( $center !=false && $url!=false )
	{
		$url = site_url($url);
		return site_url($center).'?p=' . $url . '&key=' . pass_key($url) . '#T';
	}
}



/**
 * 重写url后缀
 * 
 * @access: public
 * @author: mk.zgc
 * @param: string,$url，要替换的网址
 * @param: string,$fix，要替换成的后缀
 * @return: string 
 */
function site_url_fix($url,$fix)
{
	$CI = &get_instance();
	$urlfix = $CI->config->item('url_suffix');
	$url = site_url($url);
	$url = str_replace($urlfix,'.'.$fix,$url);
	return $url;
}


/*重组JS、CSS,的数组文件*/
function site_arrfile($arrfile)
{
	$items = 'cm';
	if(!empty($arrfile))
	{
		foreach($arrfile as $item){$items = $items.','.$item;}
	}
	return $items;
}











/*
 * 返回各上传文件的目录路径(便于调用)
 */
function img_face($CI,$img='')
{
	return $CI->config->item('face_url').$img;
}

function img_ads($CI,$img='')
{
	return $CI->config->item('ads_url').$img;
}

function img_cases($CI,$img='')
{
	return $CI->config->item('cases_url').$img;
}

function img_certificate($CI,$img='')
{
	return $CI->config->item('certificate_url').$img;
}

function img_approve($CI,$img='')
{
	return $CI->config->item('approve_url').$img;
}

function img_retrieval($CI,$img='')
{
	return $CI->config->item('retrieval_url').$img;
}

function img_uploads($img='')
{
	$CI = &get_instance();
	return $CI->config->item('uploads_url').$img;
}



?>
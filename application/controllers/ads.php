<?php
/*
 * 广告部分
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends QT_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Ads_Model');
	}
	
	
	function index()
	{
		$id = $this->input->getnum('id');
		$ad_sets = $this->Ads_Model->ad_page_sets($id);
		if(!empty($ad_sets))
		{
			$data = '$(function(){';
			foreach($ad_sets as $item)
			{
				$data.= 'load_ad("'.$item->id.'");';
			}
			$data.= 'function load_ad(id){';
			$data.= 'var thisHtml=$("#ad_box_"+id).html();';
			$data.= '$("#ad_box_"+id).load("'.site_url('ads/view').'?id="+id,function(da){';
			$data.= 'if(da!=""){$(this).append(thisHtml);$(this).fadeOut(0).delay(200).fadeIn(200);} });';
			$data.= '}});';
			json_echo($data);
		}
	}
	
	
	function view()
	{
		//【缓存技术】(注意：使用后，将会导致页面刷新后不更新的情况。故慎用!)
		$this->output->cache(10);
		
		$set_id = $this->input->getnum('id');
		if($set_id==false)
		{
			exit;
		}
		$set_view = $this->Ads_Model->ad_set_view($set_id,1);
		if(!empty($set_view))
		{
			//获取广告位尺寸
			$size_w = $set_view->size_w;
			$size_h = $set_view->size_h;
			//获取当前进行中的广告
			$ad_view = $this->Ads_Model->ad_ing($set_id);
			if(!empty($ad_view))
			{
				$uid = $ad_view->uid;
				$ad_file = img_ads($this,$ad_view->ad_file);
				$ad_type = $ad_view->ad_type;
				
				$data = '<div style="width:'.$size_w.'px;height:'.$size_h.'px;overflow:hidden;">';
				if(!empty($ad_type)&&$ad_type=='swf')
				{
					//返回swf
					$data.= '<embed src="'.$ad_file.'" width="'.$size_w.'" height="'.$size_h.'" wmode="transparent"></embed>';
				}
				else
				{
					//返回图片
					if($ad_view->link!='')
					{
						$data.= '<a href="'.$ad_view->link.'" target="_blank">';
						$data.= '<img src="'.$ad_file.'" width="'.$size_w.'" height="'.$size_h.'" />';
						$data.= '</a>';
					}
					else
					{
						$data.= '<a href="'.site_url('user/'.$ad_view->uid).'" target="_blank">';
						$data.= '<img src="'.$ad_file.'" width="'.$size_w.'" height="'.$size_h.'" />';
						$data.= '</a>';
					}
				}
				$data.= '</div>';
				
				json_echo($data);
			}
			exit;
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
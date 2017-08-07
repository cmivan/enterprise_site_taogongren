<?php
/*
 * 广告部分
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		$this->load->model('Ads_Model');
	}
	
	
	function index()
	{
		$id = is_num($this->input->get('id'));
		$ad_sets = $this->db->query('select id from ad_set where page_id='.$id)->result();
		if(!empty($ad_sets))
		{
			$data = '$(function(){';
			foreach($ad_sets as $item){ $data.= 'load_ad("'.$item->id.'");'; }
			$data.= 'function load_ad(id){';
			$data.= 'var thisHtml=$("#ad_box_"+id).html();';
			$data.= '$("#ad_box_"+id).load("'.site_url('ads/view').'?id="+id,function(da){';
			$data.= 'if(da!=""){$(this).append(thisHtml);$(this).fadeIn(200);} });';
			$data.= '}});';
			json_echo($data);
		}
	}
	
	
	function view()
	{
		$this->load->model('Ads_Model');
		
		$set_id = is_num($this->input->get('id'));
		if($set_id==false){ exit; }
		$set_view = $this->db->query('select * from ad_set where id='.$set_id.' and isshow=1')->row();
		if(!empty($set_view)){
			//获取广告位尺寸
			$size_w = $set_view->size_w;
			$size_h = $set_view->size_h;
			//获取当前进行中的广告
			$ad_view = $this->db->query('select uid,ad_file,ad_type,link from ad_list
										where set_id='.$set_id.' and UNIX_TIMESTAMP(date_go)<'.time().' and UNIX_TIMESTAMP(date_end)>'.time())->row();

			if(!empty($ad_view)){
				$uid = $ad_view->uid;
				$ad_file = img_ads($ad_view->ad_file);
				$ad_type = $ad_view->ad_type;
				
				$data = '<div style="width:'.$size_w.'px;height:'.$size_h.'px;overflow:hidden;">';
				if(!empty($ad_type)&&$ad_type=='swf'){
					//返回swf
					$data.= '<embed src="'.$ad_file.'" width="'.$size_w.'" height="'.$size_h.'" wmode="transparent"></embed>';
				}else{
					//返回图片
					if($ad_view->link!=''){
						$data.= '<a href="'.$ad_view->link.'" target="_blank">';
						$data.= '<img src="'.$ad_file.'" width="'.$size_w.'" height="'.$size_h.'" />';
						$data.= '</a>';
					}else{
						$data.= '<a href="'.site_url('user/'.$ad_view->uid).'" target="_blank">';
						$data.= '<img src="'.$ad_file.'" width="'.$size_w.'" height="'.$size_h.'" />';
						$data.= '</a>';
					}
				}
				$data.= '</div>';
				
				json_echo($data);
			}else{ exit; }
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
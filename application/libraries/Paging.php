<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Paging {
	
	private $CI;

    public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->library('pagination');
    }
	
	
/**
 * 显示列表
 * @access: public
 * @author: mk.zgc
 * @param: string，$sql，要查询的sql语句
 * @param: int，$per_page ，每一页显示行数
 * @return: array 
 */
    public function show($sql,$per_page=15)
    {
		// 加载分页类
    	$count = $this->listnum($sql);
    	// helper('textval')->reUrl
		$page_url = site_url( uri_string() ).reUrl('page=null');
    	$page_config = $this->page_config($page_url,$per_page,$count); 
    	// 重写分页配置
    	$this->CI->pagination->initialize($page_config);
		$page = $this->CI->input->getnum('page',0);
		return $this->showlist($sql,$per_page,$page);
    }
	
	
/**
 * 返回列表查询结果行数
 * @access: public
 * @author: mk.zgc
 * @param: string，$sql，要查询的sql语句
 * @return: int  
 */
    public function listnum($sql='')
	{
		return $this->CI->db->query($sql)->num_rows();
	}
	
    
/**
 * 返回列表信息
 * 
 * @access: public
 * @author: mk.zgc
 * @param: string，$sql，要查询的sql语句
 * @param: int，$per_page ，每一页显示行数
 * @param: int，$page ，当前页数
 */
	public function showlist($sql="",$per_page=15,$page=0)
	{
		if(!empty($sql))
		{
			//重写sql语句,用于读取分页数据
			$sql = $sql." limit ".($page*1).','.($per_page);
			return $this->CI->db->query($sql)->result();
		}
		return false;
	}
	
	
/**
 * 分页的方法，
 * 
 * @access: public
 * @author: mk.zgc
 * @param: string，$link_url，分页链接地址
 * @param: int，$per_page ，分页的每一页显示行数
 * @param: int，$total_rows ，分页的总行数
 * @return: void  
 */
	public function page_config($link_url='',$per_page,$total_rows)
	{
		//上一页'下一页的链接地址
		$config["base_url"] = $link_url;
		//每页显示行数
		$config['per_page'] = $per_page;
		//总的页数
		$config['total_rows'] = $total_rows;
		//首页面效果
		$config['first_link'] = '第一页';
		//尾页效果
		$config['last_link'] = '最后一页';
		//当前页显示效果
		$config['cur_tag_open'] = '<div class="on">';
		$config['cur_tag_close'] = '</div>';
		//自定义上一页\下一页
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';  
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['query_string_segment'] = 'page';
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		//$config['anchor_class'] = "style='font-size:14px;' ";
		return $config;
	}
	
	
/**
 * 输出分页链接，
 * 
 * @access: public
 * @author: mk.zgc
 * @return: void  
 */
	public function links()
	{
		echo '<div class="paging"><a>共有'.$this->CI->pagination->total_rows;
		echo '条记录 / 每页显示'.$this->CI->pagination->per_page.'条信息</a>';
		echo $this->CI->pagination->create_links().'</div>';
	}


 
}


?>
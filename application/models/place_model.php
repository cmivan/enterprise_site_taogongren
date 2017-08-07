<?php
class Place_Model extends CI_Model {
	
	public $r_id;
	public $p_id;
	public $c_id;
	public $a_id;
	
	public $default_place = array(
						  'r_id' => 3 ,
						  'p_id' => 20 ,
						  'c_id' => 258 ,
						  'a_id' => 1
						  );

    function __construct()
    {
        parent::__construct();

		//(记录)城市地区变量
		$this->r_id = $this->session->userdata('r_id');
		$this->p_id = $this->session->userdata('p_id');
		$this->c_id = $this->session->userdata('c_id');
		$this->a_id = $this->session->userdata('a_id');

		//如果记录为空，则初始化记录
		if( is_num($this->r_id) == false && is_num($this->c_id) == false && is_num($this->a_id) == false )
		{
			$place = $this->iptocity();
			$this->re_session( $place );
		}
		
		//初始化城市地区变量
		$g_r_id = $this->input->getnum("r_id");
		$g_c_id = $this->input->getnum("c_id");
		$g_a_id = $this->input->getnum("a_id");
		
		//GET参数和记录参数不一致，则重新记录
		if((is_numeric($g_r_id)&&($this->r_id!=$g_r_id)) ||
		   (is_numeric($g_c_id)&&($this->c_id!=$g_c_id)) || (is_numeric($g_a_id)&&($this->a_id!=$g_a_id)))
		{
			//重组地区
			$place = array('r_id' => $g_r_id , 'p_id' => 0 , 'c_id' => $g_c_id , 'a_id' => $g_a_id );
			$place = $this->real_place($place);
			$this->re_session( $place );
		}

		//特殊处理
		if($g_a_id==false) $this->a_id = 'no';
		
		//数据查询缓存
		$this->db->cache_on();
    }

	/*根据配置信息，记录地区信息的session*/
	public function re_session($config='')
	{
		if(!empty($config))
		{
			//重新记录
			$this->r_id = $config->r_id;
			$this->p_id = $config->p_id;
			$this->c_id = $config->c_id;
			$this->a_id = $config->a_id;
			$this->session->set_userdata('r_id', $this->r_id);
			$this->session->set_userdata('p_id', $this->p_id);
			$this->session->set_userdata('c_id', $this->c_id);
			$this->session->set_userdata('a_id', $this->a_id);
		}
	}

	/*根据访问IP返回所在城市*/
	public function iptocity()
	{
		$ip = list($ip1,$ip2,$ip3,$ip4) = explode(".",ip()); 
		$ip = $ip1*pow(256,3) + $ip2*pow(256,2) + $ip3*256 + $ip4;
		$this->db->select('p_id,c_id');
		$this->db->from('place_ips');
		$this->db->where('IP_Start <=',$ip);
		$this->db->order_by('IP_Start','desc');
		$this->db->limit(1);
		$row = $this->db->get()->row();
		$p_id = 0;
		$c_id = 0;
		if( !empty($row) )
		{
			$p_id = $row->p_id;
			$c_id = $row->c_id;
		}
		//重组地区
		$place = array(
			   'r_id' => 0 ,
			   'p_id' => $p_id ,
			   'c_id' => $c_id ,
			   'a_id' => 0
			   );
		return $this->real_place($place);
	}
	
	/*返回完整的城市地点*/
	public function real_place($config='')
	{
		//初始化配置信息
		if( empty($config) || is_array($config)==false )
		{
			$config = $this->default_place;
		}
		$a_id = $config['a_id'];
		$c_id = $config['c_id'];
		$p_id = $config['p_id'];
		$r_id = $config['r_id'];
		
		$this->db->select('place_region.r_id,place_province.p_id,place_city.c_id,place_area.a_id');
		$this->db->from('place_city');
		$this->db->join('place_area','place_area.c_id = place_city.c_id','left');
		$this->db->join('place_province','place_province.p_id = place_city.p_id','left');
		$this->db->join('place_region','place_region.r_id = place_province.r_id','left');
		if( !empty($a_id) && is_numeric($a_id) && $a_id > 0 )
		{
			$this->db->where('place_area.a_id',$a_id);
		}
		elseif( !empty($c_id) && is_numeric($c_id) && $c_id > 0 )
		{
			$this->db->where('place_city.c_id',$c_id);
		}
		elseif( !empty($p_id) && is_numeric($p_id) && $p_id > 0 )
		{
			$this->db->where('place_province.p_id',$p_id);
		}
		elseif( !empty($r_id) && is_numeric($r_id) && $r_id > 0 )
		{
			$this->db->where('place_region.r_id',$r_id);
		}
		$this->db->group_by('place_city.c_id');
		$this->db->limit(1);
		$row = $this->db->get()->row();
		if( empty($row) )
		{
			return $this->real_place();
		}
		return $row;
	}


    /**
     * 返回区域
     */
	 public function regions()
	 {
	    $this->db->select('*');
    	$this->db->from('place_region');
    	$this->db->order_by('r_id','asc');
    	return $this->db->get()->result();
	 }
	
	
	/**
	 * 获取区域(单项)
	 * */
    public function regionid()
    {
	   if(is_num($this->r_id)==false)
	   {
		   $this->db->select('r_id');
		   $this->db->from('place_region');
		   $this->db->order_by('r_id','asc');
		   $this->db->limit(1);
		   $row = $this->db->get()->row();
		   if(!empty($row))
		   {
			   return $row->r_id;
		   }
	   }
	   return $this->r_id;
    }
    


    /*根据区域ID返回省份*/
    public function provinces($r_id='')
    {
		$this->db->select('p_id,p_name,r_id');
		$this->db->from('place_province');
		$this->db->order_by('order_id','desc');
		$this->db->order_by('p_id','asc');
    	if(is_num($r_id))
		{
			$this->db->where('r_id',$r_id);
    	}
		return $this->db->get()->result();
    }

	
    /*根据省份ID返回省份信息*/
    public function province($p_id='')
    {
		$this->db->select('p_id,p_name,r_id');
		$this->db->from('place_province');
		$this->db->where('p_id',$p_id);
		$this->db->limit(1);
		return $this->db->get()->row();
    }
    public function province_name($p_id='')
    {
		$province = $this->province($p_id);
		if(!empty($province))
		{
			return $province->p_name;
		}
		return '';
    }
	
    /*根据省份ID返回省份数*/
    public function province_num($r_id=false)
    {
		$this->db->select('p_id');
		$this->db->from('place_province');
		if( $r_id!=false )
		{
			$this->db->where('r_id',$r_id);
		}
		return $this->db->count_all_results();
    }
	

    /*返回第个省份ID*/
    public function provinceid()
    {
		$this->db->select('*');
		$this->db->from('place_province');
		$this->db->order_by('order_id','desc');
		$this->db->order_by('p_id','asc');
		$this->db->limit(1);
		$row = $this->db->get()->row();
		if(!empty($row))
		{
			return $row->p_id;
		}
		return '';
    }

    /*当前省份下的城市*/
    public function citys($p_id='')
    {
		$this->db->select('c_id,c_name');
		$this->db->from('place_city');
		$this->db->order_by('order_id','desc');
		$this->db->order_by('c_id','asc');
        if(is_num($p_id))
		{
			$this->db->where('p_id',$p_id);
    	}
		return $this->db->get()->result();
	}
	
    /*当前省份下的城市数目*/
    public function province2city_num($p_id='')
    {
		$this->db->select('c_id');
		$this->db->from('place_city');
		$this->db->where('p_id',$p_id);
		return $this->db->count_all_results();
    }
	
    /*当前省份下的地区数目*/
    public function province2area_num($p_id='')
    {
		$this->db->select('a_id');
		$this->db->from('place_area');
		$this->db->where('p_id',$p_id);
		return $this->db->count_all_results();
    }
	
    /*当前城市下的地区数目*/
    public function city2area_num($c_id='')
    {
		$this->db->select('a_id');
		$this->db->from('place_area');
		$this->db->where('c_id',$c_id);
		return $this->db->count_all_results();
    }
	
    
    /*当前城市*/
    public function city($c_id='')
    {
		$c_id = get_num($c_id,$this->c_id);
		$this->db->select('*');
		$this->db->from('place_city');
		$this->db->where('c_id',$c_id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
    public function city_name($c_id='')
    {
		$city = $this->city($c_id);
		if(!empty($city))
		{
			return $city->c_name;
		}
    }
	

    /*当前城市下的地区*/
    public function areas($c_id='')
    {
		$c_id = get_num($c_id,$this->c_id);
		$this->db->select('a_id,a_name,c_id,p_id');
		$this->db->from('place_area');
		$this->db->where('c_id',$c_id);
		$this->db->order_by('order_id','desc');
		$this->db->order_by('a_id','asc');
		return $this->db->get()->result();
	}

	
    /*当前城市和相应的地区(返回数组)*/
    public function area($a_id='')
    {
		$a_id = get_num($a_id,$this->a_id);
		$this->db->select('*');
		$this->db->from('place_area');
		$this->db->where('a_id',$a_id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
    public function area_name($a_id='')
    {
		$area = $this->area($a_id);
		if(!empty($area))
		{
			return $area->a_name;
		}
    }

    /*当前城市和相应的地区(字符串)*/
    public function place($c_id='')
    {
		$this->db->select('c_id,c_name');
		$this->db->from('place_city');
		$this->db->where('c_id',$c_id);
		$this->db->limit(1);
		$city["city"] = $this->db->get();
		
		$this->db->select('a_id,a_name');
		$this->db->from('place_area');
		$this->db->where('c_id',$c_id);
		$this->db->order_by('a_id','desc');
		$city["area"] = $this->db->get();
		
		return $city;
    }

}
?>
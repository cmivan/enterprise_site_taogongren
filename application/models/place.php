<?php
class Place extends CI_Model {
	
	public $regionid  = 1;
	public $provinceid = 1;
	public $cityid = 258;
	public $areaid = 1;

    function __construct()
    {
        parent::__construct();

		#初始化城市地区变量
		$g_regionid=$this->input->get("regionid", TRUE);
		$g_cityid  =$this->input->get("cityid", TRUE);
		$g_areaid  =$this->input->get("areaid", TRUE);
		
		#记录区域信息
		if(!empty($g_regionid)&&is_numeric($g_regionid)){
			$this->regionid=$g_regionid;
			$this->session->set_userdata('regionid',$g_regionid);
			}
	
		#记录地区信息
		if((!empty($g_areaid)&&is_numeric($g_areaid))&&$g_cityid==$this->session->userdata('cityid')){
			$this->areaid=$g_areaid;
			$this->session->set_userdata('areaid',$g_areaid);
		}elseif(!empty($g_areaid)&&is_numeric($g_areaid)==false){
			$this->areaid='';
			$this->session->set_userdata('areaid','');
		}
	
		#记录城市信息
		if(!empty($g_cityid)&&is_numeric($g_cityid)){
			$this->cityid = $g_cityid;
			$this->session->set_userdata('cityid',$g_cityid);
			}

		#使用session值来记录城市信息
		$s_regionid=$this->session->userdata('regionid');
		$s_cityid  =$this->session->userdata('cityid');
		$s_areaid  =$this->session->userdata('areaid');
		if(!empty($s_regionid)){$this->regionid=$s_regionid;}
		if(!empty($s_cityid)){$this->cityid=$s_cityid;}
		if(!empty($s_cityid)){$this->areaid=$s_areaid;}

    }
	
	
	
	/*整个地区下拉选择框的模型*/
	public function box()
	{
		/*获取区域*/
		$p_regions=$this->regions();
		if(!empty($p_regions))
		{
			/*获取相应的省份*/
			$r_id=$this->regionid();
			$p_provinces=$this->provinces($r_id);
			if(!empty($p_provinces)){
			   $p_regions[0]->provinces=$p_provinces;
			   $t = 0;  //初始化变量
			   foreach($p_provinces as $p_item){
			      /*获取相应的城市*/
				  $p_regions[0]->provinces[$t]->num=$t;
			      $p_citys=$this->citys($p_item->p_id);
			      if(!empty($p_citys)){$p_regions[0]->provinces[$t]->citys=$p_citys;}
			      $t++;
			   }
			}
		}

		return $p_regions;
	}
	



    /**
     * 返回区域
     */
    public function regions()
    {
       return $this->db->query("select * from place_region order by r_id asc")->result();
    }
	
	
	/**
	 * 获取区域(单项)
	 * */
    public function regionid()
    {
	   if(is_numeric($this->regionid)==false){
          return $this->db->query("select r_id from place_region order by r_id asc limit 1")->row()->r_id;
	   }else{
          return $this->regionid;
	   }
    }
    


    /*根据区域ID返回省份*/
    public function provinces($r_id='')
    {
    	if(is_num($r_id)){
    		return $this->db->query("select * from place_province where r_id=".$r_id." order by order_id desc,p_id asc")->result();
    	}else{
    		return $this->db->query("select * from place_province order by order_id desc,p_id asc")->result();
    	}
    }

	
    /*根据省份ID返回省份信息*/
    public function province($p_id=0)
    {
		return $this->db->query("select * from place_province where p_id=".$p_id." order by p_id asc")->row();
    }
    public function province_name($p_id=0)
    {
		$province = $this->province($p_id);
		if(!empty($province)){ return $province->p_name; }
    }
	

    /*返回第个省份ID*/
    public function provinceid()
    {
    	return $this->db->query("select * from place_province order by order_id desc,p_id asc")->row()->p_id;
    }

    /*当前省份下的城市*/
    public function citys($p_id='')
    {
        if(is_num($p_id)){
    		return $this->db->query("select c_id,c_name from place_city where p_id=".$p_id." order by order_id desc,c_id asc")->result();
    	}else{
    		return $this->db->query("select c_id,c_name from place_city order by order_id desc,c_id asc")->result();
    	}
    }
	
    /*当前省份下的城市数目*/
    public function province2city_num($p_id='')
    {
        return $this->db->query("select c_id from place_city where p_id=".$p_id)->num_rows();
    }
	
    /*当前省份下的地区数目*/
    public function province2area_num($p_id='')
    {
        return $this->db->query("select a_id from place_area where p_id=".$p_id)->num_rows();
    }
	
    /*当前城市下的地区数目*/
    public function city2area_num($c_id='')
    {
        return $this->db->query("select a_id from place_area where c_id=".$c_id)->num_rows();
    }
	
    
    /*当前城市*/
    public function city($c_id=0)
    {
		if(is_num($c_id)==false){ $c_id = $this->cityid; }
		return $this->db->query("select * from place_city where c_id=".$c_id." limit 1")->row();
    }
    public function city_name($c_id=0)
    {
		$city = $this->city($c_id);
		if(!empty($city)){ return $city->c_name; }
    }
	

    /*当前城市下的地区*/
    public function areas($c_id='')
    {
		if(is_num($c_id)==false){ $c_id = $this->cityid; }
		return $this->db->query("select * from place_area where c_id=".$c_id." order by order_id desc,a_id asc")->result();
    }

	
    /*当前城市和相应的地区(返回数组)*/
    public function area($a_id=0)
    {
		if(is_num($a_id)==false){ $a_id = $this->areaid; }
		return $this->db->query("select * from place_area where a_id=".$a_id." limit 1")->row();
    }
    public function area_name($a_id=0)
    {
		if(empty($a_id)||$a_id==0){
			return '-';
		}else{
			$area = $this->area($a_id);
			if(!empty($area)){ return $area->a_name; }		
		}
    }

    /*当前城市和相应的地区(字符串)*/
    public function place($c_id='')
    {
		$city["city"]=$this->db->query("select c_id,c_name from place_city where c_id=".$c_id." limit 1");
		$city["area"]=$this->db->query("select a_id,a_name from place_area where c_id=".$c_id." order by a_id desc");
		return $city;
    }

}
?>
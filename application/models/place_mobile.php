<?php
class Place_Model extends CI_Model {
	
	
	//初始化变量
	public $r_id = 1;
	public $p_id = 1;
	public $c_id = 258;
	public $a_id = 1;
	
	public $r_on;
	public $p_on;
	public $c_on;
	public $a_on;

    function __construct()
    {
		$this->r_on = $this->r_id;
		$this->p_on = $this->p_id;
		$this->c_on = $this->c_id;
		$this->a_on = $this->a_id;

    }
	
	//有区域r_id，获取旗下省、旗下第一省下的市、旗下第一市的区
	
	//有省份p_id，所属区域、旗下市、旗下第一市的区
	
	//有城市c_id，获取所属区域、所属省、旗下区
	
	//有区a_id，获取所属区域、所属省、所属市
	
	
	
	
	
	//获取区域信息(列表信息，及被选中项)
    public function regions_select($r_id)
    {
		$r_id = is_num($r_id);
		$r_on = is_num($this->r_on);
		if($r_id&&$r_on==false){
			$this->r_on = $r_id;
		}elseif($r_on==false){
			$this->r_on = $this->r_id; //初始化
		}
		
		//获取
		
		$data['on'] = $this->db->query("select r_id from place_region order by r_id asc limit 1")->row()->r_id;
		$data['items'] = $this->db->query("select * from place_region order by r_id asc")->result();
		return $data;
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
	

}
?>
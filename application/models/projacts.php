<?php
class Projacts extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


    
    
/**
 * 工种项目(重组读取到的内容，主页调用)
 */
    function projact($num=0)
    {
		$projact = $this->industrys();
		foreach($projact as $projactRs){
			$Pid=$projactRs->id;
			$projact_items[$Pid]["p_id"] = $projactRs->id;
			$projact_items[$Pid]["p_title"] = $projactRs->title;
			$projact_items[$Pid]["p_pic"] = base_url().$projactRs->pic;
			
			//读取分类
			$class_row=$this->industrys_class($Pid);
			$projact_items[$Pid]["p_class"]=$class_row;
			$cnum=0;
			
			foreach($class_row as $class_rs){
			  //判断该类型的工种是否已经录入具体项目
			 $cid=$class_rs->id;
			 $pquery=$this->industrys_class_skill($Pid,$cid,$num);
			 if(!empty($pquery)){
				$cnum++;
				if($cnum%2==0){
				   $projact_items[$Pid]["typeitem"][$cid]="0"; 
				}else{
				   $projact_items[$Pid]["typeitem"][$cid]="1"; 
				}
				$projact_items[$Pid]["pquery"][$cid]=$pquery;
			   }
			  }
			}

		return $projact_items;
    }



    
/**
 * 工种
 */ 
    function industrys()
    {
    	return $this->db->query("select id,title,pic from industry where industryid=0 order by orderid asc")->result();
    }

    
/**
 * 工种项目下的分类
 */
    function industrys_class($pid=0)
    {
    	return $this->db->query("select IC.id,IC.title from industry_class IC left join industry I on I.classid=IC.id where I.industryid=$pid GROUP by I.classid")->result();
    }
    
    
/**
 * 该类型的工种是否已经录入具体项目
 */
    function industrys_class_skill($pid=0,$cid=0,$num=0)
    {
    	if($num==0){
			return $this->db->query("select id,title from industry where industryid=$pid and classid=$cid order by title asc")->result();
		}else{
			return $this->db->query("select id,title from industry where industryid=$pid and classid=$cid order by title asc LIMIT ".$num)->result();
		}
    }
    
    
}
?>
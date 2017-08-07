<?php
class Projacts extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*工种项目(重组读取到的内容，主页调用)*/
    function projact($num=0)
    {
    	$projact_items = '';
		$projact = $this->industrys();
		foreach($projact as $projactRs)
		{
			$Pid=$projactRs->id;
			$projact_items[$Pid]["p_id"] = $projactRs->id;
			$projact_items[$Pid]["p_title"] = $projactRs->title;
			$projact_items[$Pid]["p_pic"] = base_url().$projactRs->pic;
			
			//读取分类
			$class_row = $this->industrys_class($Pid);
			$projact_items[$Pid]["p_class"] = $class_row;
			$cnum = 0;
			
			foreach($class_row as $class_rs)
			{
				//判断该类型的工种是否已经录入具体项目
				$cid = $class_rs->id;
				$pquery = $this->industrys_class_skill($Pid,$cid,$num);
				if(!empty($pquery))
				{
					$cnum++;
					if($cnum%2==0)
					{
						$projact_items[$Pid]["typeitem"][$cid]="0"; 
					}
					else
					{
						$projact_items[$Pid]["typeitem"][$cid]="1"; 
					}
					$projact_items[$Pid]["pquery"][$cid]=$pquery;
				}
			}
		}
		return $projact_items;
    }


    /*工种*/ 
    function industrys()
    {
	    $this->db->select('id,title,pic');
    	$this->db->from('industry');
    	$this->db->where('industryid',0);
    	$this->db->order_by('orderid','asc');
    	return $this->db->get()->result();
    }
    
    
    /*工种项目下的分类*/
    function industrys_class($pid=0)
    {
	    $this->db->select('industry_class.id,industry_class.title');
    	$this->db->from('industry_class');
    	$this->db->join('industry','industry.classid = industry_class.id','left');
    	$this->db->where('industry.industryid',$pid);
    	$this->db->group_by('industry.classid');
    	return $this->db->get()->result();
    }
    
    /*该类型的工种是否已经录入具体项目*/
    function industrys_class_skill($pid=0,$cid=0,$num=0)
    {
	    $this->db->select('id,title');
    	$this->db->from('industry');
    	$this->db->where('industryid',$pid);
    	$this->db->where('classid',$cid);
    	$this->db->order_by('title','asc');
    	if($num!=0)
    	{
			$this->db->limit($num);
		}
		return $this->db->get()->result();
    }
    
    
}
?>
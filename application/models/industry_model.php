<?php
#单用户信息

class Industry_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


/**
 * 返回工种
 * $Iarr = '$id1_$id2_$id3_$id4_$id5'; 工种项目的数组形式
 */
    function industrys($arrs='')
    {
		$arr = getarray($arrs);
		$this->db->select('id,title');
		$this->db->from('industry');
		$this->db->where('industryid',0);
		$this->db->order_by('orderid','asc');
		$this->db->order_by('id','asc');
		if(!empty($arr))
		{
			$this->db->where_in('id',$arr);
		}
		return $this->db->get()->result();
    }
    function industrys_helper($industrysObj='',$keyword='')
    {
		$industrys = '';
		if(!empty($industrysObj))
		{
			$num = 0;
			foreach($industrysObj as $item)
			{
				$num++;
				if( $num > 1 ){ $industrys.= '、'; }
				$industrys.= '<span>' .$item->title. '</span>';
			}
		}
		if(!empty($keyword)){ $industrys = keycolor( $industrys , $keyword); }
		return $industrys;
    }



/**
 * 返回某工种下已添加项目数目
 */
    function industryes_num($industryid=0)
    {
    	$this->db->from('industry');
    	$this->db->where('industryid',$industryid);
    	return $this->db->count_all_results();
    }
	

	
/**
 * 返回某工种的名称
 */
    function industryes_view($id=0,$T=0)
    {
		$this->db->select('id,title');
    	$this->db->from('industry');
		$this->db->where('id',$id);
		if($T==0)
		{
			$this->db->where('industryid',0);
		}
		else
		{
			$this->db->select('classid,industryid');
			$this->db->where('industryid !=',0);
		}
		return $this->db->get()->row();
    }
	
	
/**
 * 返回某工种的名称
 */
    function industryes_name($id=0)
    {
    	$this->db->select('title');
    	$this->db->from('industry');
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	$row = $this->db->get()->row();
		if(!empty($row))
		{
			return $row->title;
		}
		return '';
    }
	
	

/**
 * 删除工种 或 技能项目
 */
    function industrys_del($id=0,$T=0)
    {
		$this->db->where('id',$id);
		if($T==0)
		{
			$this->db->where('industryid =',0);
		}
		else
		{
			$this->db->where('industryid !=',0);
		}
		return $this->db->delete('industry'); 
    }
	
/**
 * 按ID排序返回前面的技能分类ID
 */
    function industry_class_id()
	{
    	$this->db->select('id');
    	$this->db->from('industry_class');
    	$this->db->order_by('id','asc');
    	$this->db->limit(1);
    	$row = $this->db->get()->row();
		if(!empty($row))
		{
			return $row->id;
		}
	}	
  

/**
 * 返回技能分类
 */
    function industry_class()
    {
    	$this->db->select('id,title');
    	$this->db->from('industry_class');
    	$this->db->order_by('id','asc');
    	return $this->db->get()->result();
    }


  
/**
 * 返回某种类某分类下的技能
 */
    function class_industrys($classid,$industryid)
	{
    	$this->db->select('id,title');
    	$this->db->from('industry');
    	$this->db->where('classid',$classid);
    	$this->db->where('industryid',$industryid);
    	return $this->db->get()->result();
    }	
  
	
/**
 * 返回用户添加技能数
 */
    function skills_count($uid=0)
    {
		$this->db->from('skills');
    	$this->db->where('workerid',$uid);
    	return $this->db->count_all_results();
    }	

  
/**
 * 返回用户擅长工种
 */
    function goodat_industrys($uid=0)
    {
/*	    $this->db->select('I.id,I.title');
    	$this->db->from('industry as I');
    	$this->db->join('industry as IT','I.id = IT.industryid','left');
		$this->db->join('skills as S','IT.id = S.industryid','left');
    	$this->db->where('S.workerid',$uid);
    	$this->db->group_by('I.id');*/
	    $this->db->select('industry.id,industry.title');
    	$this->db->from('industry');
		$this->db->join('skills','skills.industrys = industry.id','left');
    	$this->db->where('skills.workerid',$uid);
    	$this->db->group_by('industry.id');
		return $this->db->get()->result();
		
	}	


/**
 * 返回用户擅长项目种类(安装装修维修)
 */
    function goodat_classes($uid=0)
    {
	    $this->db->select('industry.classid');
    	$this->db->from('skills');
    	$this->db->join('industry','industry.id = skills.industryid','left');
    	$this->db->where('skills.workerid',$uid);
    	$this->db->group_by('industry.classid');
		$sql_1 = $this->db->getSQL();
		$sql_1 = 'SELECT classid FROM ('.$sql_1.')tbt';
		$this->db->select('*');
    	$this->db->from('industry_class');
		$this->db->where('id IN ('.$sql_1.')');
		//$sql_2 = $this->db->getSQL();
		//return $this->db->query($sql_2)->result();
		return $this->db->get()->result();
	}	


/**
 * 返回用户某种类下擅长的技能
 */
     function goodat_skills($uid,$num=10)
     {
		 $this->db->select('industry.title,skills.industryid');
    	 $this->db->from('industry');
    	 $this->db->join('skills','industry.id = skills.industryid','left');
    	 $this->db->where('skills.workerid',$uid);
    	 $this->db->order_by('industry.id','asc');
    	 $this->db->limit($num);
    	 return $this->db->get()->result();
     }	
  

/**
 * 返回用户某种类下擅长的工种
 */
     function goodat_class_industrys($classid,$uid)
     {
		 $this->db->select('industry.industryid');
    	 $this->db->from('skills');
    	 $this->db->join('industry','industry.id = skills.industryid','left');
    	 $this->db->where('industry.classid',$classid);
    	 $this->db->where('skills.workerid',$uid);
    	 $this->db->group_by('industry.id');
		 $sql_1 = $this->db->getSQL();
		 $sql_1 = 'SELECT industryid FROM ('.$sql_1.')tbt';
		 $this->db->select('*');
    	 $this->db->from('industry');
		 $this->db->where('id IN ('.$sql_1.') AND industryid=0');
		 //$sql_2 = $this->db->getSQL();
		 //return $this->db->query($sql_2)->result();
		 return $this->db->get()->result();
     }	


/**
 * 返回用户某种类下的某工种下的擅长技能
 */
     function goodat_class_industry_skills($classid,$industryid,$uid)
     {
		 $this->db->select('skills.id,skills.price,skills.note,industry.title');
    	 $this->db->from('skills');
    	 $this->db->join('industry','skills.industryid=industry.id','left');
    	 $this->db->where('skills.workerid',$uid);
    	 $this->db->where('industry.industryid',$industryid);
    	 $this->db->where('industry.classid',$classid);
    	 $this->db->order_by('skills.id','asc');
    	 return $this->db->get()->result();
     }	

}
?>
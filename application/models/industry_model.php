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
		if(empty($arr)){
			return $this->db->query("select id,title from `industry` where industryid=0 order by id asc")->result();
		}else{
			return $this->db->query("select id,title from `industry` where (industryid=0 and id in (".$arr.")) order by id asc")->result();
		}
    }	


/**
 * 返回某工种下已添加项目数目
 */
    function industryes_num($industryid=0)
    {
		return $this->db->query("select id from `industry` where industryid=".$industryid)->num_rows();
    }
	

	
/**
 * 返回某工种的名称
 */
    function industryes_view($id=0,$T=0)
    {
		if($T==0){
			return $this->db->query("select title from `industry` where industryid=0 and id=".$id)->row();
		}else{
			return $this->db->query("select title,classid,industryid from `industry` where industryid<>0 and id=".$id)->row();
		}
    }
	
	
/**
 * 返回某工种的名称
 */
    function industryes_name($id=0)
    {
		$Irs = $this->db->query("select title from `industry` where id=".$id)->row();
		if(!empty($Irs)){
			return $Irs->title;
		}else{
			return '';
		}
    }
	
	
/**
 * 删除工种 或 技能项目
 */
    function industrys_del($id=0,$T=0)
    {
		if($T==0){
			return $this->db->query("delete from `industry` where industryid=0 and id=".$id);
		}else{
			return $this->db->query("delete from `industry` where industryid!=0 and id=".$id);
		}
    }
	
/**
 * 按ID排序返回前面的技能分类ID
 */
    function industry_class_id()
	{
		return $this->db->query("select * from industry_class order by id asc LIMIT 1")->row();
	}	
  

/**
 * 返回技能分类
 */
    function industry_class()
    {
		return $this->db->query("select * from industry_class order by id asc")->result();
    }


  
/**
 * 返回某种类某分类下的技能
 */
    function class_industrys($classid,$industryid)
	{
		return $this->db->query("select id FROM `industry` WHERE `classid` = ".$classid." and `industryid` = ".$industryid)->result();
    }	
  
	
/**
 * 返回用户添加技能数
 */
    function skills_count($uid)
    {
		return $this->db->query("select industryid from skills where workerid=".$uid." order by id asc")->num_rows();
    }	
  
  
/**
 * 返回用户擅长工种
 */
  function goodat_industrys($uid)
  {
	 return $this->db->query("select * from industry where id in (select industryid from (select I.industryid from skills as S INNER JOIN industry as I where I.id=S.industryid and S.workerid=".$uid." GROUP by I.industryid)tbt)")->result();
  }	


/**
 * 返回用户擅长项目种类(安装装修维修)
 */
  function goodat_classes($uid)
  {
	 return $this->db->query("select * from industry_class where id in (select classid from (select I.classid from skills as S INNER JOIN industry as I where I.id=S.industryid and S.workerid=".$uid." GROUP by I.classid)tbt)")->result();
  }	


/**
 * 返回用户某种类下擅长的工种
 */
  function goodat_skills($uid)
  {
	 return $this->db->query("select I.title from industry I left join skills S on I.id=S.industryid where S.workerid=".$uid." order by I.id asc LIMIT 10")->result();
  }	
  

/**
 * 返回用户某种类下擅长的工种
 */
  function goodat_class_industrys($classid,$uid)
  {
	 return $this->db->query("select * from industry where id in (select industryid from (select I.industryid from skills as S INNER JOIN industry as I where I.id=S.industryid and I.classid=".$classid." and S.workerid=".$uid." GROUP by I.industryid)tbt)")->result();
  }	


/**
 * 返回用户某种类下的某工种下的擅长技能
 */
  function goodat_class_industry_skills($classid,$industryid,$uid)
  {
	 return $this->db->query("select S.id,S.price,S.note,I.title from skills S left join industry I on S.industryid=I.id where S.workerid=".$uid." and I.industryid=".$industryid." and I.classid=".$classid." order by id asc")->result();
  }	

}
?>
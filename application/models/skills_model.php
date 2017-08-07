<?php
#单用户信息

class Skills_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function User_Prices($uid=0)
  {
	  return $this->db->query("select S.id,S.price,S.note,I.title from skills S left join industry I on S.industryid=I.id where S.workerid=".$uid." and S.price<>'' and S.price<>0 and S.note<>''")->result();
  }
  
  
/**
 * 删除用户擅长技能
 */
  function skills_del($uid=0,$id=0)
  {
	  return $this->db->query("DELETE FROM `skills` WHERE `workerid` = ".$uid." and `industryid` = ".$id);
  }


/**
 * 返回某技能项目的使用人数
 */
    function skills_user_num($industryid=0)
    {
		return $this->db->query("select id from `skills` where industryid=".$industryid.' group by workerid')->num_rows();
    }

}
?>
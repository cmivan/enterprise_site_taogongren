<?php
#单用户信息

class Recommend_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid)
  {
	 return "select * from recommend where uid=".$logid." order by id desc";
  }		
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function User_Recommend($logid)
  {
	 return $this->db->query("select W.id,W.name,W.photoID,W.note,W.addtime from recommend R left join `user` W on W.id=R.fuid where R.uid=".$logid." LIMIT 16")->result();
  }		
	
	
/**
 * 返回用户是否已经被推荐
 */
  function is_Recommend($logid,$uid_2)
  {
	 return $this->db->query("select id from `recommend` where fuid=$uid_2 and uid=$logid LIMIT 1")->num_rows();
  }		
	


  
/**
 * 删除数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `recommend` where uid=".$logid." and id=".$id);
  }


}
?>
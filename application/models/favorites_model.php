<?php
#单用户信息

class Favorites_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid)
  {
	 return "select * from favorites where uid=".$logid." order by id desc";
  }		
	

  
/**
 * 删除数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `favorites` where uid=".$logid." and id=".$id);
  }


  
/**
 * 判断是否已经收藏
 */
  function is_favorites($uid=0,$uid2=0)
  {
	  return $this->db->query("select id from `favorites` where uid=".$uid." and fuid=".$uid2)->num_rows();
  }


}
?>
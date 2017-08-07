<?php
#单用户信息

class Friends_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回好友列表Sql
 */
  function listsql_friends($logid)
  {
	 return "select * from friends where uid=".$logid." and isok=1 and isblack=0 order by id desc";
  }		

/**
 * 返回好友请求
 */
  function listsql_request($logid)
  {
	 return "select * from friends where uid=".$logid." and isok=0 and isblack=0 order by id desc";
  }	
  
/**
 * 返回黑名单列表
 */
  function listsql_black($logid)
  {
	 return "select * from friends where uid=".$logid." and isblack=1 order by id desc";
  }	


  
/**
 * 用户页面(我的好友)
 */
  function User_Friends1($logid)
  {
	 return $this->db->query("select F.fuid,W.name,W.photoID,W.addtime from friends F left join `user` W on F.fuid=W.id where (F.uid=".$logid." and F.u_del=0) LIMIT 5")->result();
  }	
  function User_Friends2($logid)
  {
	 return $this->db->query("select F.uid,W.name,W.photoID,W.addtime from friends F left join `user` W on F.uid=W.id where (F.fuid=".$logid." and F.su_del=0) LIMIT 5")->result();
  }


  
/**
 * 删除数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `friends` where uid=".$logid." and isok=1 and id=".$id);
  }

  
/**
 * 删除数据
 */
  function del_black($id=0,$logid=0)
  {
	  $this->db->query("delete from `friends` where uid=".$logid." and isblack=1 and id=".$id);
  }

}
?>
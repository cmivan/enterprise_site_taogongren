<?php
#站内消息

class Sendmsg_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql_send($uid)
  {
	  return "select * from sendmsg where (uid= ".$uid." and u_del=0) or (uid=0 and suid=".$uid." and su_del=0) order by id desc";
  }
  
  function listsql_receiver($uid)
  {
	  return "select * from sendmsg where suid= ".$uid." and su_del=0 order by id desc";
  }
  
  function listsql_sys($uid)
  {
	  return "select * from sendmsg where uid=0 and suid=".$uid." and su_del=0 order by id desc";
  }

  
/**
 * 删除发送的消息
 */
  function del_send($id=0,$logid=0)
  {
	  $this->db->query("update `sendmsg` set u_del=1 where uid=".$logid." and id=".$id);
  }

/**
 * 删除收到的消息
 */
  function del_receiver($id=0,$logid=0)
  {
	  $this->db->query("update `sendmsg` set su_del=1 where suid=".$logid." and id=".$id);
  }
  
/**
 * 更新收到的消息状态
 */
  function update_receiver($logid=0)
  {
	  $this->db->query("update `sendmsg` set checked=1 where checked=0 and su_del=0 and suid=".$logid);
  }
  
  
  

}
?>
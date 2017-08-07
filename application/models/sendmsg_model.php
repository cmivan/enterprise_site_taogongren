<?php
#站内消息

class Sendmsg_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    #返回列表sql语句,用于分页
    //发出消息
    function listsql_send($uid)
    {
    	$this->db->select('*');
    	$this->db->from('sendmsg');
		//$where = "(`uid`=".$uid." and `u_del`=0) or (`uid`=0 and `suid`=".$uid." and `su_del`=0)";
		$where = "(`uid`=".$uid." and `u_del`=0)";
		$this->db->where($where);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
    //收到消息
    function listsql_receiver($uid)
    {
    	$this->db->select('*');
    	$this->db->from('sendmsg');
    	$this->db->where('suid',$uid);
    	$this->db->where('su_del',0);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
    //系统消息
    function listsql_sys($uid='')
    {
    	$this->db->select('*');
    	$this->db->from('sendmsg');
    	$this->db->where('uid',0);
    	$this->db->where('suid',$uid);
    	$this->db->where('su_del',0);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
    
    
    /*删除发送的消息*/
    function del_send($id=0,$logid=0)
    {
    	$date['u_del'] = 1;
    	$this->db->where('uid', $logid);
    	$this->db->where('id', $id);
    	return $this->db->update('sendmsg',$date);
    }
    
    /*删除收到的消息*/
    function del_receiver($id=0,$logid=0)
    {
    	$date['su_del'] = 1;
    	$this->db->where('suid', $logid);
    	$this->db->where('id', $id);
    	return $this->db->update('sendmsg',$date);
    }
    
    
    /*更新收到的消息状态*/
    function update_receiver($logid=0)
    {
    	$date['checked'] = 1;
    	$this->db->where('checked', 0);
    	$this->db->where('su_del', 0);
    	$this->db->where('suid', $logid);
    	return $this->db->update('sendmsg',$date);
    }
    
    
    /*获取某用户收到的最新消息*/
    function user_new_msg($uid=0)
    {
		$this->db->from('sendmsg');
    	$this->db->where('suid', $uid);
    	$this->db->where('su_del', 0);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
    	return $this->db->get()->row();
    }

	
    /*站内最新短消息数目*/
    function new_msg_num($uid=0)
    {
		$this->db->select('id');
		$this->db->from('sendmsg');
		$this->db->where('suid',$uid);
		$this->db->where('checked',0);
		$this->db->where('su_del',0);
		return $this->db->count_all_results();
	}
  
  
  
  

}
?>
<?php
#信息评论

class Recommend_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    /*返回列表sql语句,用于分页*/
    function listsql($logid)
    {
	    $this->db->select('*');
    	$this->db->from('recommend');
    	$this->db->where('uid',$logid);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
    
    /*返回列表sql语句,用于分页*/
    function User_Recommend($logid)
    {
	    $this->db->select('user.id,user.name,user.photoID,user.note,user.addtime');
    	$this->db->from('recommend');
    	$this->db->join('user','user.id = recommend.fuid','left');
    	$this->db->where('recommend.uid',$logid);
    	$this->db->limit(16);
    	return $this->db->get()->result();
    }
    
    /*返回用户是否已经被推荐*/
    function is_Recommend($fuid=0,$uid=0)
    {
		$this->db->from('recommend');
    	$this->db->where('fuid', $fuid);
    	$this->db->where('uid', $uid);
    	$this->db->limit(1);
    	if( $this->db->count_all_results()>0 )
		{
			return true;
		}
		return false;
    }
    
    /*返回用户是否已经被推荐*/
    function recommend_view($fuid=0,$uid=0)
    {
		$this->db->from('recommend');
    	$this->db->where('fuid', $fuid);
    	$this->db->where('uid', $uid);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }
    
    
    /*删除数据*/
    function del($id=0,$logid=0)
    {
    	$this->db->where('uid', $logid);
    	$this->db->where('id', $id);
    	return $this->db->delete('recommend'); 
    }


}
?>
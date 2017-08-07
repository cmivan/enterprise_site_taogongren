<?php
#团队广告

class Team_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
    /*返回团队成员列表sql语句,用于分页*/
    function member_listsql($tid=0)
    {
	    $this->db->select('user.id,user.name,user.addtime');
    	$this->db->from('user');
		$this->db->join('team_user','user.id = team_user.uid','left');
    	$this->db->where('team_user.tid',$tid);
    	$this->db->order_by('user.id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
	
	
    /*返回我加入的团队列表sql语句,用于分页*/
    function myjoin_listsql($uid=0)
    {
	    $this->db->select('user.id,user.name,user.addtime');
    	$this->db->from('user');
		$this->db->join('team_user','user.id = team_user.tid','left');
		$this->db->where('user.classid',2);
    	$this->db->where('team_user.uid',$uid);
		$this->db->where('team_user.checked',1);
    	$this->db->order_by('user.id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
	
	
    /*判断是否已经创建该团队*/
    function user_get_team_id($uid=0)
    {
		$this->db->select('id');
    	$this->db->from('user');
		$this->db->where('uid',$uid);
    	$this->db->where('classid',2);
		$row = $this->db->get()->row();
		if( !empty($row) )
		{
			return $row->id;
		}
		return false;
    }
	

    /*判断是否已经创建该团队*/
    function is_create_team($uid=0,$classid=0)
    {
    	$this->db->from('user');
		$this->db->where('uid',$uid);
    	$this->db->where('classid',$classid);
		if( $this->db->count_all_results()>0 )
		{
			return true;
		}
		return false;
    }

}
?>
<?php
#单用户信息

class Skills_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    /*返回列表sql语句,用于分页*/
    function user_skill_prices_sql($uid=0)
    {
	    $this->db->select('skills.id,skills.price,skills.note,industry.title');
    	$this->db->from('skills');
    	$this->db->join('industry','skills.industryid = industry.id','left');
    	$this->db->where('skills.workerid', $uid);
    	$this->db->where('skills.price !=','');
    	$this->db->where('skills.price !=',0);
    	$this->db->where('skills.note !=','');
    	return $this->db->getSQL();
    }
	
    /*返回列表,用于用户页面显示参考报价*/
    function user_skill_prices($uid=0)
    {
	    $this->db->select('skills.id,skills.price,skills.note,industry.title');
    	$this->db->from('skills');
    	$this->db->join('industry','skills.industryid = industry.id','left');
    	$this->db->where('skills.workerid', $uid);
    	$this->db->where('skills.price !=','');
    	$this->db->where('skills.price !=',0);
    	$this->db->where('skills.note !=','');
    	return $this->db->get()->result();
    }
    
    /*用户擅长项目详细信息*/
    function user_skill_view($uid=0,$pid=0)
    {
	    $this->db->select('industry.title,skills.id,skills.price,skills.note');
    	$this->db->from('skills');
    	$this->db->join('industry','skills.industryid = industry.id','left');
    	$this->db->where('skills.workerid', $uid);
    	$this->db->where('skills.id =', $pid);
		$this->db->limit(1);
    	return $this->db->get()->row();
    }

    /*添加某技能*/
    function user_skill_add($uid=0,$id=0)
    {
		$this->load->model('Industry_Model');
		$Industry = $this->Industry_Model->industryes_view($id,1);
		if(!empty($Industry))
		{
			$data['workerid'] = $uid;
			$data['industrys'] = $Industry->industryid;
			$data['classid'] = $Industry->classid;
			$data['industryid'] = $id;
			$data['addtime'] = dateTime();
			$data['price'] = '0';
			$data['note'] = '';
			return $this->db->insert('skills',$data);
		}
    }
    
    /*判断用户是否已经添加某技能*/
    function user_skill_added($uid=0,$id=0)
    {
    	$this->db->where('workerid', $uid);
    	$this->db->where('industryid', $id);
		$this->db->from('skills');
		$this->db->limit(1);
		if( $this->db->count_all_results()>0 )
		{
			return true;
		}
		return false;
    }
	
    
    /*删除用户擅长技能*/
    function skills_del($uid=0,$id=0)
    {
    	$this->db->where('workerid', $uid);
    	$this->db->where('industryid', $id);
    	return $this->db->delete('skills'); 
    }
    
    /*返回某技能项目的使用人数*/
    function skills_user_num($industryid=0)
    {
		$this->db->from('skills');
    	$this->db->where('industryid', $industryid);
    	$this->db->group_by("workerid"); 
    	return $this->db->count_all_results();
    }

}
?>
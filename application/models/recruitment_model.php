<?php
#人才招聘

class Recruitment_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
    /*返回所以招聘信息列表sql语句,用于分页*/
    function page_listsql($type_id=1)
    {
        $this->db->select('*');
        $this->db->from('recruitment');
		if($type_id)
		{
			$this->db->where('type_id',$type_id);
		}
        $this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
    }
    
    /*返回列表sql语句,用于分页*/
    function listsql($logid=0)
    {
        $this->db->select('*');
        $this->db->from('recruitment');
        $this->db->where('uid', $logid);
        $this->db->order_by('id','desc');
        $t = $this->input->get('t');
    	if(is_num($t))
    	{
    		$this->db->where('type_id', $t);
    	}
		//返回SQL
		return $this->db->getSQL();
    }
    
    /*返回最新的N条记录*/
    function get_list($type_id=1,$num=10)
    {
        $this->db->select('recruitment.id,recruitment.title,recruitment.c_id,place_city.c_name');
        $this->db->from('recruitment');
        $this->db->join('place_city','recruitment.c_id = place_city.c_id','left');
        $this->db->where('recruitment.type_id', $type_id);
        $this->db->order_by('recruitment.id','desc');
        $this->db->limit($num);
        return $this->db->get()->result();
    }
    
    /*招聘求职的类型*/
    function get_types()
    {
  	    $this->db->select('id,title');
    	$this->db->from('recruitment_type');
    	$this->db->order_by('id','asc');
    	return $this->db->get()->result();
    }
    
    /*返回返回招聘或者是求职*/
    function view($id=0,$logid=0)
    {
  	    $this->db->select('*');
    	$this->db->from('recruitment');
    	$this->db->where('uid',$logid);
    	$this->db->where('id',$id);
    	return $this->db->get()->row();
    }
    
    /*返回返回招聘或者是求职*/
    function recruitment_uid($id=0)
    {
  	    $this->db->select('uid');
    	$this->db->from('recruitment');
    	$this->db->where('id',$id);
    	$rs = $this->db->get()->row();
		if(!empty($rs))
		{
			return $rs->uid;
		}
		return false;
    }
    
    /*累积访问次数*/
    function visite($id=0)
    {
    	$this->db->set('visited', 'visited+1', FALSE);
    	$this->db->where('id', $id);
    	return $this->db->update('recruitment',array());
    }
    
    /*返回返回招聘或者是求职*/
    function save($id=0,$logid=0)
    {
		$thisdata = array(
				  "type_id" => $this->input->postnum("type_id"),
				  "title" => noHtml($this->input->post("title")),
				  "content" => $this->input->post("content"),
				  "addtime" => dateTime(),
				  "num" => $this->input->postnum("num"),
				  "fuli" => noHtml($this->input->post("fuli")),
				  "cost" => noHtml($this->input->post("cost")),
				  "p_id" => $this->input->postnum("p_id"),
				  "c_id" => $this->input->postnum("c_id"),
				  "a_id" => $this->input->postnum("a_id"),
				  "c_addr" => noHtml($this->input->post("c_addr")),
				  "industryid" => $this->input->post("industryid"),
				  "uid" => $logid
		);

		//检测数据
		if($thisdata["title"]=='')
		{
			json_form_no('请先填写标题！');
		}
		elseif($thisdata["content"]=='')
		{
			json_form_no('请先填写内容！');
		}
		
		//录入数据
		if($id!=false)
		{
			$this->db->where('id', $id);
			$this->db->update('recruitment', $thisdata); 
			json_form_yes('更新成功！');
		}
		else
		{
			$this->db->insert('recruitment', $thisdata);
			json_form_yes('发布成功！');
		}
    }
    
    /*删除数据*/
    function del($id=0,$logid=0)
    {
    	$this->db->where('uid', $logid);
    	$this->db->where('id', $id);
    	return $this->db->delete('recruitment'); 
    }
    
    
    /*返回返回所有类型*/
    function types()
    {
	    $this->db->select('*');
    	$this->db->from('recruitment_type');
    	return $this->db->get()->result();
    }
    
    /*返回返回招聘或者是求职*/
    function type($id=0)
    {
    	if(is_num($id))
    	{
    		$this->db->select('title');
    		$this->db->from('recruitment_type');
    		$this->db->where('id',$id);
    		$rs = $this->db->get()->row();
    		if(!empty($rs))
    		{
    			return $rs->title;
    		}
    	}
    }
    
    /*返回返回招聘或者是求职*/
    function type_id($id=0)
    {
        $this->db->select('type_id');
        $this->db->from('recruitment');
        $this->db->where('id',$id);
        $rs = $this->db->get()->row();
    	if(!empty($rs))
    	{
    		return $rs->type_id;
    	}
    	else
    	{
    		return 1;  
    	}
    }
  

}
?>
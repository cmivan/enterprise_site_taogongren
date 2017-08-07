<?php
#单用户信息

class Recruitment_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid)
  {
	  $t=$this->input->get("t",true);
	  
	  if($t!=""&&is_numeric($t))
	  {
		 return "select * from recruitment where uid=".$logid." and type_id=".$t." order by id desc"; 
	  }else{
		 return "select * from recruitment where uid=".$logid." order by id desc";
	  }
  }		
	
	
/**
 * 返回最新的N条记录
 */
  function get_list($type=1,$num=10)
  {
	  return $this->db->query("select R.id,R.title,R.c_id,C.c_name from recruitment R left join place_city C on R.c_id=C.c_id where R.type_id=".$type." order by R.id desc limit ".$num)->result();
  }	
  
  
	
/**
 * 招聘求职的类型
 */
  function get_types()
  {
	  return $this->db->query("select id,title from `recruitment_type` order by id asc")->result();
  }		
 
	
/**
 * 返回返回招聘或者是求职
 */
  function view($id=0,$logid=0)
  {
		return $this->db->query("select * from `recruitment` where uid=".$logid." and id=".$id)->row();
  }	

  
/**
 * 返回返回招聘或者是求职
 */
  function recruitment_uid($id=0)
  {
		$crs = $this->db->query("select uid from `recruitment` where id=".$id)->row();
		if(!empty($crs)){
			return $crs->uid;
		}else{
			return false;
		}
  }

/**
 * 累积访问次数
 */
    function visite($id=0)
    {
    	$this->db->query("update `recruitment` set visited=visited+1 where id=$id LIMIT 1");
    }

	
/**
 * 返回返回招聘或者是求职
 */
  function save($id=0,$logid=0)
  {
	  
		$thisdata=array(
		"type_id" => $this->input->post("type_id"),
		"title" => noHtml($this->input->post("title")),
		"content" => $this->input->post("content"),
		"addtime" => date("Y-m-d H:i:s",time()),
		"num" => $this->input->post("num"),
		"fuli" => noHtml($this->input->post("fuli")),
		"cost" => noHtml($this->input->post("cost")),
		"p_id" => $this->input->post("p_id"),
		"c_id" => $this->input->post("c_id"),
		"a_id" => $this->input->post("a_id"),
		"c_addr" => noHtml($this->input->post("c_addr")),
		"industryid" => $this->input->post("industryid"),
		"uid" => $logid
		);

		//检测数据
		if($thisdata["title"]==""){echo '{"cmd":"n","info":"请先填写标题！"}';exit;}
		if($thisdata["content"]==""){echo '{"cmd":"n","info":"请先填写内容！"}';exit;}
		

		if($id!=false)
		{
			$this->db->where('id', $id);
			$this->db->update('recruitment', $thisdata); 
			echo '{"cmd":"y","info":"更新成功！"}';exit;
		}else{
			$this->db->insert('recruitment', $thisdata); 
			echo '{"cmd":"y","info":"发布成功！"}';exit;
		}
		
		
  }
  
  
/**
 * 删除数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `recruitment` where uid=".$logid." and id=".$id);
  }

	
/**
 * 返回返回所有类型
 */
  function types()
  {
	  return $this->db->query("select * from `recruitment_type`")->result();
  }	
  
  
/**
 * 返回返回招聘或者是求职
 */
  function type($id=0)
  {
	  if($id!=""&&is_numeric($id))
	  {
		  $rs = $this->db->query("select title from `recruitment_type` where id=".$id)->row();
		  if(!empty($rs)){ return $rs->title; }
	  }
  }
  
/**
 * 返回返回招聘或者是求职
 */
  function type_id($id=0)
  {
	  $trs = $this->db->query("select type_id from `recruitment` where id=".$id)->row();
	  if(!empty($trs)){
		  return $trs->type_id;
	  }else{
		  return 1;  
	  }
  }
  

}
?>
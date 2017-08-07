<?php
#单用户信息

class Listing_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid)
  {
	  return "select * from listing where uid=".$logid." order by id desc"; 
  }	
  
/**
 * 返回工人页面列表sql语句
 */
  function User_Listing($logid)
  {
	  return $this->db->query("select * from listing where uid=".$logid." order by id desc limit 10")->result();
  }	
	
	
/**
 * 返回返回招聘或者是求职
 */
  function view($id=0,$logid=0)
  {
	  return $this->db->query("select * from `listing` where uid=".$logid." and id=".$id)->row();
  }	

	
/**
 * 返回返回招聘或者是求职
 */
  function save($id=0,$logid=0)
  {
	  
		$thisdata=array(
		"note" => noHtml($this->input->post("note",true)),
		"diqu" => noHtml($this->input->post("diqu",true)),
		"mytime" => $this->input->post("mytime",true),
		"addtime" => date("Y-m-d H:i:s",time()),
		"uid" => $logid
		);

		//检测数据
		if($thisdata["mytime"]==""){echo '{"cmd":"n","info":"请先填写日期！"}';exit;}
		if($thisdata["diqu"]==""){echo '{"cmd":"n","info":"请先填写地区！"}';exit;}
		if($thisdata["note"]==""){echo '{"cmd":"n","info":"请先填写内容！"}';exit;}
		

		if($id!=""&&is_numeric($id))
		{
			$this->db->where('id', $id);
			$this->db->update('listing', $thisdata); 
		}else{
			$this->db->insert('listing', $thisdata); 
		}
		
		echo '{"cmd":"y","info":"保存成功！"}';exit;
  }
  
  
  
/**
 * 删除数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `listing` where uid=".$logid." and id=".$id);
  }


}
?>
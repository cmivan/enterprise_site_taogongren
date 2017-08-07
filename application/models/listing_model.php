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
  function listsql($uid)
  {
	  $this->db->select('*');
	  $this->db->from('listing');
	  $this->db->where('uid',$uid);
	  $this->db->order_by('id','desc');
	  //返回SQL
	  return $this->db->getSQL();
  }	
  
/**
 * 返回工人页面列表sql语句
 */
  function User_Listing($uid)
  {
	  $this->db->select('*');
	  $this->db->from('listing');
	  $this->db->where('uid',$uid);
	  $this->db->order_by('id','desc');
	  $this->db->limit(10);
	  return $this->db->get()->result();
  }	
	
	
/**
 * 返回返回招聘或者是求职
 */
  function view($id=0,$uid=0)
  {
	  $this->db->select('*');
	  $this->db->from('listing');
	  $this->db->where('uid',$uid);
	  $this->db->where('id',$id);
	  $this->db->limit(1);
	  return $this->db->get()->row();
  }	

	
/**
 * 返回返回招聘或者是求职
 */
  function save($id=0,$uid=0)
  {
	  $thisdata=array(
	  "note" => noHtml($this->input->post("note",true)),
	  "diqu" => noHtml($this->input->post("diqu",true)),
	  "mytime" => $this->input->post("mytime",true),
	  "addtime" => dateTime(),
	  "uid" => $uid
	  );

	  //检测数据
	  if($thisdata["mytime"]=='')
	  {
		  json_form_no('请先填写日期!');
	  }
	  if($thisdata["diqu"]=='')
	  {
		  json_form_no('请先填写地区!');
	  }
	  if($thisdata["note"]=='')
	  {
		  json_form_no('请先填写内容!');
	  }

	  if(is_num($id))
	  {
		  $this->db->where('id', $id);
		  $this->db->update('listing', $thisdata); 
	  }
	  else
	  {
		  $this->db->insert('listing', $thisdata); 
	  }
	  json_form_yes('保存成功!');
  }
  
  
  
/**
 * 删除数据
 */
  function del($id=0,$uid=0)
  {
	  $this->db->where('uid', $uid);
	  $this->db->where('id', $id);
	  return $this->db->delete('listing'); 
  }


}
?>
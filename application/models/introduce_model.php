<?php
#单用户信息

class Introduce_Model extends CI_Model {

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
    	$this->db->from('sys_introduce');
    	$this->db->where('uid',$uid);
		$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}		
	
	
/**
 * 返回返回详细信息
 */
	function view($id=0,$uid=false)
	{
	    $this->db->select('*');
    	$this->db->from('sys_introduce');
		if( $uid != false )
		{
			$this->db->where('uid',$uid);
		}
		$this->db->where('id',$id);
		$this->db->limit(1);
    	return $this->db->get()->row();
	}

	
/**
 * 保存数据
 */
  function save($id=0,$logid=0)
  {
	  //检测数据
	  $mobile = $this->input->post("mobile");
	  $nicename = noHtml($this->input->post("nicename"));
	  if($nicename=='')
	  {
		  json_form_no('请先填写称呼!');
	  }
	  elseif( is_num($mobile)==false )
	  {
		  json_form_no('请填写正确的手机号码!');
	  }
	  
	  $thisdata = array(
					  "nicename" => $nicename,
					  "sex" => noHtml($this->input->post("sex")),
					  "mobile" => $mobile,
					  "qq" => $this->input->postnum("qq",0),
					  "email" => noHtml($this->input->post("email")),
					  "other" => noHtml($this->input->post("other")),
					  "addtime" => dateTime(),
					  "uid" => $logid
					  );
	  if(is_num($id))
	  {
		  //$this->db->where('id', $id);
		  //$this->db->update('sys_introduce', $thisdata); 
	  }
	  else
	  {
		  $this->db->insert('sys_introduce', $thisdata); 
		  json_form_yes('保存成功!');
	  }
	  json_form_no('保存可能失败!');
  }
  
  
  
/**
 * 用于显示当前状态
 */
  function stats($ok=0)
  {
	  if($ok==0)
	  {
		  echo '<span class="red">未审核</span>？';
	  }
	  elseif($ok==1)
	  {
		  echo '<span class="green">&radic;已通过</span>';
	  }
	  elseif($ok==2)
	  {
		  echo '<span class="red">&times;没通过</span>';
	  }
  }
  
  
/**
 * 删除未被审核的数据
 */
    function del($id=0,$uid=0)
	{
		$this->db->where('uid', $uid);
		$this->db->where('id', $id);
		$this->db->where('ok', 0);
		$this->db->limit(1);
    	return $this->db->delete('sys_introduce'); 
    }


}
?>
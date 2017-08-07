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
  function listsql($logid)
  {
	 return "select * from sys_introduce where uid=".$logid." order by id desc";
  }		
	
	
/**
 * 返回返回详细信息
 */
  function view($id=0,$logid=0)
  {
		return $this->db->query("select * from `sys_introduce` where uid=".$logid." and id=".$id)->row();
  }	

	
/**
 * 保存数据
 */
  function save($id=0,$logid=0)
  {
	  //检测数据
	  $mobile = is_num($this->input->post("mobile"));
	  $nicename = noHtml($this->input->post("nicename"));
	  if($nicename==''){ json_form_no('请先填写称呼!'); }
	  if($mobile==false){ json_form_no('请填写正确的手机号码!'); }
	  
	  $thisdata = array(
					  "nicename" => $nicename,
					  "sex" => noHtml($this->input->post("sex")),
					  "mobile" => $mobile,
					  "qq" => is_num($this->input->post("qq"),''),
					  "email" => noHtml($this->input->post("email")),
					  "other" => noHtml($this->input->post("other")),
					  "addtime" => dateTime(),
					  "uid" => $logid
					  );
	  if($id!=""&&is_numeric($id)){
		  //$this->db->where('id', $id);
		  //$this->db->update('sys_introduce', $thisdata); 
	  }else{
		  $this->db->insert('sys_introduce', $thisdata); 
	  }
	  json_form_yes('保存成功!');
  }
  
  
  
/**
 * 用于显示当前状态
 */
  function stats($ok=0)
  {
	  if($ok==0){
		  echo '<span class="red">未审核</span>？';
	  }elseif($ok==1){
		  echo '<span class="green">&radic;已通过</span>';
	  }elseif($ok==2){
		  echo '<span class="red">&times;没通过</span>';
	  }
  }
  
  
/**
 * 删除未被审核的数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `sys_introduce` where uid=".$logid." and id=".$id." and ok=0");
  }


}
?>
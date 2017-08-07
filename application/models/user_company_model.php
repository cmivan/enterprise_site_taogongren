<?php
#单用户信息

class User_company_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
    /*返回列表sql语句,用于分页*/
    function listsql($logid)
    {
	    $this->db->select('*');
    	$this->db->from('user_company');
    	$this->db->where('uid',$logid);
    	$this->db->where('ok',0);
    	$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
    }		
	
    
    /*返回返回详细信息*/
    function view($id=0,$logid=0)
    {
	    $this->db->select('*');
    	$this->db->from('user_company');
    	$this->db->where('uid',$logid);
    	$this->db->where('id',$id);
    	$this->db->limit(1);
    	return $this->db->get()->row();
    }	

    
    /*保存数据*/
    function save($id=0,$logid=0)
    {
    	//检测数据
    	$mobile = $this->input->post("mobile");
    	$nicename = noHtml($this->input->post("nicename"));
    	if($nicename=='')
		{
			json_form_no('请先填写称呼!');
		}
    	if(is_num($mobile)==false)
		{
			json_form_no('请填写正确的手机号码!');
		}
    	
    	$updata = array(
				"nicename" => $nicename,
				"sex" => noHtml($this->input->post("sex")),
				"mobile" => $mobile,
				"qq" => $this->input->postnum("qq",''),
				"email" => noHtml($this->input->post("email")),
				"other" => noHtml($this->input->post("other")),
				"addtime" => dateTime(),
				"uid" => $logid
					  );
    	if(is_num($id))
    	{
    		$this->db->select('addtime');
    		$this->db->from('user_company');
    		$this->db->where('mobile',$mobile);
    		$this->db->where('uid',$logid);
    		$this->db->where('id !=',$id);
    		$this->db->limit(1);
    		$rs = $this->db->get()->row();
    		if(!empty($rs))
    		{
    			json_form_no('该手机号的成员已于：<br><b class=red>'.$rs->addtime.'</b> 录入!');
    		}
    		else
    		{
    			$this->db->where('id', $id);
    			$this->db->update('user_company', $updata); 
    			json_form_yes('修改成功!'); 
    		}
    	}
    	else
    	{
    		$this->db->select('addtime');
    		$this->db->from('user_company');
    		$this->db->where('mobile',$mobile);
    		$this->db->where('uid',$logid);
    		$this->db->limit(1);
    		$rs = $this->db->get()->row();
    		if(!empty($rs))
    		{
    			json_form_no('该手机号的成员已于：<br><b class=red>'.$rs->addtime.'</b> 录入!');
    		}
    		else
    		{
    			$this->db->insert('user_company', $updata); 
    			json_form_yes('添加成功!');
    		}
    	}
    }
  
  
    /*用于显示当前状态*/
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
  
  
    /*删除未被审核的数据*/
    function del($id=0,$logid=0)
    {
    	$data['ok'] = 1;
    	$this->db->where('id',$id);
    	$this->db->where('uid',$logid);
    	$this->db->update('user_company',$data);
    }


}
?>
<?php
#案例数据

class Case_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
    function listsql($uid,$type_id=0,$is_team=0)
	{
	    $this->db->select('*');
    	$this->db->from('cases');
    	$this->db->where('uid',$uid);
		$this->db->where('is_team',$is_team);
		$this->db->where('type_id',$type_id);
		$this->db->order_by('id','desc');
		//返回SQL
		return $this->db->getSQL();
	}		
	
	
/**
 * 返回工人页面案例
 */
	function User_Case($uid=0,$type_id=0)
	{
	    $this->db->select('id,title,pic,content,addtime');
    	$this->db->from('cases');
    	$this->db->where('uid',$uid);
		$this->db->where('type_id',$type_id);
		$this->db->order_by('id','desc');
		$this->db->limit(10);
		return $this->db->get()->result();
	}
	
  
/**
 * 返回案例用于首页显示
 */
	function index_case($num=4)
	{
	    $this->db->select('id,title,pic,uid');
    	$this->db->from('cases');
		$this->db->where('type_id',1);
		$this->db->where('pic !=','');
		$this->db->order_by('id','desc');
		$this->db->limit($num);
		return $this->db->get()->result();
	}
  
	

/**
 * 返回企业用户页面案例
 */
	function Company_Case($uid=0)
	{
	    $this->db->select('*');
    	$this->db->from('cases');
    	$this->db->where('uid',$uid);
		$this->db->where('type_id',1);
		$this->db->order_by('id','desc');
		$this->db->limit(4);
		return $this->db->get()->result();
	}
/**
 * 返回企业用户页面证书
 */
	function Company_Certificates($uid=0)
	{
	    $this->db->select('*');
    	$this->db->from('cases');
    	$this->db->where('uid',$uid);
		$this->db->where('type_id',2);
		$this->db->order_by('id','desc');
		$this->db->limit(4);
		return $this->db->get()->result();
	}
  
  

/*上传文件后的案例图片url*/
//  function imgurl($img='')
//  {
//	  $path = $this->config->item('uploads_url');
//	  return $path.$img;
//  }
	
	
/**
 * 返回详细信息用于用户管理页面
 */
	function case_id($id=0)
	{
	    $this->db->select('id');
    	$this->db->from('cases');
    	$this->db->where('id',$id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
	
/**
 * 返回详细信息用于用户管理页面
 */
	function view($id=0,$uids=0,$is_team=0)
	{
	    $this->db->select('*');
    	$this->db->from('cases');
		
		if(is_array($uids))
		{
			$this->db->where_in('uid',$uids);
		}
		elseif(is_numeric($uids))
		{
			$this->db->where('uid',$uids);
			$this->db->where('is_team',$is_team);
		}
	
		$this->db->where('id',$id);
		$this->db->limit(1);
		return $this->db->get()->row();
	}
  
  
/**
 * 根据案例返回用户id
 */
	function case_uid($id=0)
	{
	    $this->db->select('uid');
    	$this->db->from('cases');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$row = $this->db->get()->row();
		if(!empty($row))
		{
			return $row->uid;
		}
		return false;
	}
  

	
/**
 * 保存案例或者资质证书
 */
	function save($id=0,$type_id=1,$uid=0)
	{
		$title = noHtml($this->input->post("title"));
		$content = $this->input->post("content");
		$pic = noHtml($this->input->post("pic"));
		
		//是否属于团队
		$is_team = $this->input->postnum("is_team",0);
		if($this->User_Model->one2team_id($this->logid)<=0||($is_team!=0&&$is_team!=2))
		{
			$is_team = 0;
		}

		//检测数据
		if($title=='')
		{
			json_form_no('请先填写标题!');
		}
		if($content=='')
		{
			json_form_no('请先填写内容!');
		}
		if($pic=='')
		{
			json_form_no('请上传图片!');
		}

		if($id==false)
		{
			//创建数组
			$data=array(
						"type_id" => $type_id,
						"title" => $title,
						"content" => $content,
						"pic" => $pic,
						"addtime" => dateTime(),
						"uid" => $uid,
						"is_team" => $is_team
						);
			$this->db->insert('cases', $data); 
			json_form_yes('添加成功!');
		}
		else
		{
			//创建数组
			$data=array(
						"type_id" => $type_id,
						"title" => $title,
						"content" => $content,
						"pic" => $pic,
						"addtime" => dateTime(),
						"uid" => $uid,
						"is_team" => $is_team
						);
			$this->db->where('id', $id);
			$this->db->update('cases', $data); 
			json_form_yes('更新成功!');
		}
	}
  
  
  
  
/**
 * 删除数据
 */
	function del($id=0,$type_id=0,$uid=0)
	{
    	$this->db->where('uid', $uid);
		$this->db->where('type_id', $type_id);
		$this->db->where('id', $id);
    	return $this->db->delete('cases'); 
	}


}
?>
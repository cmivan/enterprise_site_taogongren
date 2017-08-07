<?php
#单用户信息

class Case_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid,$type_id=0,$is_team=0)
  {
	  return "select * from cases where uid=".$logid." and is_team=".$is_team." and type_id=".$type_id." order by id desc";
  }		
	
	
/**
 * 返回返回工人页面案例
 */
  function User_Case($logid=0,$type_id=0)
  {
	  return $this->db->query("select id,title,pic,content,addtime from cases where type_id=".$type_id." and uid=".$logid." order by id desc limit 10")->result();
  }
  
  
/**
 * 返回详细信息用于用户管理页面
 */
  function index_case($num=4)
  {
		return $this->db->query("select id,title,pic,uid from `cases` where type_id=1 and pic!='' order by id desc limit ".$num)->result();
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
		return $this->db->query("select id from `cases` where id=".$id)->row();
  }
	
	
/**
 * 返回详细信息用于用户管理页面
 */
  function view($id=0,$uid=0,$is_team=0)
  {
		return $this->db->query("select * from `cases` where uid=".$uid." and is_team=".$is_team." and id=".$id)->row();
  }
  
  
/**
 * 根据案例返回用户id
 */
  function case_uid($id=0)
  {
		$crs = $this->db->query("select uid from `cases` where id=".$id)->row();
		if(!empty($crs)){
			return $crs->uid;
		}else{
			return false;
		}
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
		$is_team = is_num($this->input->post("is_team"),0);
		if($this->User_Model->one2team_id($this->logid)<=0||($is_team!=0&&$is_team!=2))
		{
			$is_team = 0;
		}

		//检测数据
		if($title==""){ json_form_no('请先填写标题!'); }
		if($content==""){ json_form_no('请先填写内容!'); }
		if($pic==''){ json_form_no('请上传图片!'); }

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
		}else{
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
  function del($id=0,$type_id=0,$logid=0)
  {
	  $this->db->query("delete from `cases` where uid=".$logid." and type_id=".$type_id." and id=".$id);
  }


}
?>
<?php
#单用户信息

class TeamAd_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid)
  {
	 return "select * from `team_ad` where uid=".$logid." order by id desc";
  }		
	
	
/**
 * 返回返回详细信息
 */
  function view($id=0,$logid=0)
  {
	  return $this->db->query("select * from `team_ad` where uid=".$logid." and id=".$id)->row();
  }	

	
/**
 * 保存数据
 */
  function save($id=0,$logid=0)
  {
	  if($id!=''&&is_numeric($id)){
		  //获取数据
		  $data=array(
			"title" => noHtml($this->input->post("adtitle")),
			"ad" => noHtml($this->input->post("adnote")),
		  );
		  
		  //检测数据
		  if($data["title"]==""){echo '{"cmd":"n","info":"请先填写广告标题!"}';exit;}
		  if($data["ad"]==""){echo '{"cmd":"n","info":"请先填写广告语!"}';exit;}
		  //写入
		  $this->db->where('uid', $logid);
		  $this->db->where('id', $id);
		  $this->db->update('team_ad', $data); 
		  
		  echo '{"cmd":"y","info":"更新成功!"}';exit;
	  }else{
		  //获取数据
		  $data=array(
			"title" => noHtml($this->input->post("adtitle")),
			"ad" => noHtml($this->input->post("adnote")),
			"s_date" => $this->input->post("s_date"),
			"e_date" => $this->input->post("e_date"),
			"tid" => $this->User_Model->one2team_id($logid),
			"uid" => $logid
		  );
		  //检测数据
		  if($data["title"]==""){echo '{"cmd":"n","info":"请先填写广告标题!"}';exit;}
		  if($data["ad"]==""){echo '{"cmd":"n","info":"请先填写广告语!"}';exit;}
		  
		  //比较开始时间和结束时间
		  $n_date = strtotime(date("Y-m-d",time()));
		  $s_date = strtotime($data["s_date"]);
		  $e_date = strtotime($data["e_date"]);
		  if($n_date>=$s_date){echo '{"cmd":"n","info":"广告的开始时间已过期!"}';exit;}
		  if($s_date>=$e_date){echo '{"cmd":"n","info":"广告的开始时间应小于结束时间!"}';exit;}
		  
		  //获取订单费用
		  $data['cost'] = $this->ads_cost($data["s_date"],$data["e_date"]);
		  
		  //执行扣费
		  $tip = '<b>投放广告业务!</b>&nbsp;&nbsp;投放日期：'.$data['s_date'].' ～ '.$data['e_date'];
		  
		  $cost = $data['cost'];
		  #<><><>初始化金额,转换成负值，保证扣除费用
		  if($cost>0){$cost = -$cost;}else{$cost = $cost;}

		  $this->load->model('Records_Model');
		  $this->Records_Model->balance_control($logid,$cost,$tip,'S');
		  
//		  $CI = &get_instance();
//		  $CI->load->model('Records_Model');
//		  $CI->Records_Model->balance_control($logid,$cost,$tip,'S');
		  
		  //写入数据
		  $this->db->insert('team_ad', $data);
		  
		  
		  echo '{"cmd":"y","info":"发布成功!"}';exit;
	  }

  }
  
  
/**
 * 删除数据
 */
  function del($id=0,$logid=0)
  {
	  $this->db->query("delete from `team_ad` where uid=".$logid." and id=".$id);
  }





/**
 * 计算团队广告发布时间是否有效
 */
  function ads_isok($dateS='',$dateE='')
  {
	  $dateS = strtotime($dateS);
	  $dateE = strtotime($dateE);
	  if(($dateE-$dateS)>0){
		  return true;
	  }else{
		  return false;
	  }
  }


/**
 * 计算团队广告投放时间
 */
  function ads_day($dateS='',$dateE='')
  {
	  $dateS = strtotime($dateS);
	  $dateE = strtotime($dateE);
	  return ($dateE-$dateS)/(3600*24); //返回时间差值
  }


/**
 * 计算团队广告费用
 */
  function ads_cost($dateS='',$dateE='')
  {
	  $dateS = strtotime($dateS);
	  $dateE = strtotime($dateE);
	  $dateA = $dateE-$dateS;
	  if($dateA>0){
		  return ($dateA)/(3600*24)*1; //返回广告费用
	  }else{
		  return 0;
	  }
  }



}
?>
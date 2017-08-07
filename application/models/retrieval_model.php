<?php
#单用户信息

class Retrieval_Model extends CI_Model {
	
	public $g24time;
	
    function __construct()
    {
        parent::__construct();
		
		$this->g24time = dateDay24();
    }

	
/**
 * 返回最新的N条记录
 */
  function get_list($num=10)
  {
	  return $this->db->query("select R.id,R.title,R.c_id,C.c_name from retrieval R left join place_city C on R.c_id=C.c_id order by id desc limit ".$num)->result(); 
  }	
 

 
/**
 * 累积访问次数
 */
    function visite($id=0)
    {
    	$this->db->query("update `retrieval` set visited=visited+1 where id=$id LIMIT 1");
    }
 

/**
 * 判断用户是否已经加入某投标
 */
    function R_election($uid=0,$rid=0)
    {
    	return $this->db->query("select uid,retrievalid,skills,note from retrieval_election where uid=".$uid." and retrievalid=".$rid." LIMIT 1");
    }
	
 
/**
 * 最新招标的id
 */
    function zb_new_id($uid)
    {
        return $this->db->query("select id from retrieval where uid=".$uid." order by id desc")->row();
    }
 
    
/**
 * 最新招标
 */
    function zb_new()
    {
        return $this->db->query("select R.title,R.id,P.pic from retrieval_pic as P inner join retrieval as R on P.rid=R.rid group by R.id desc LIMIT 1,3")->result();
    }
	
/**
 * 最新招标
 */
    function zb_ad()
    {
        return $this->db->query("select id,title,cost from retrieval where UNIX_TIMESTAMP(endtime)>".date(time())." and isshow=0 order by id desc limit 0,10")->result();
        //return $this->db->query("select id,title,cost from retrieval where isshow=0 order by id desc limit 0,10")->result();
    }
	
	
/**
 * 推荐招标
 */
    function zb_tj()
    {
        return $this->db->query("select R.title,R.id,P.pic from retrieval_pic as P inner join retrieval as R on P.rid=R.rid group by R.id desc LIMIT 0,1")->result();
    }


	
	
/**
 * 用户投标信息
 */
    function election_sql($id=0)
    {
        return "select * from retrieval_election where retrievalid=".$id;
    }
	
	



	

//用于任务投标
function retrieval_type($id=0)
{
	$rs=$this->db->query("select team_or_men from retrieval where id=$id LIMIT 1")->row();
	if(!empty($rs)){
		$team_or_men=$rs->team_or_men;
		if($team_or_men==0){
		   return 0;#个人任务
		}elseif($team_or_men==2){
		   return 2;#团队任务
		}else{
		   return 1;#全部任务
		}
	}else{
		return 0;#个人任务
	}
}
	

	
	
  
/**
 * 任务详细信息
 */
    function view($id=0)
    {
    	return $this->db->query("select * from `retrieval` where id=$id and isshow=0 LIMIT 1")->row();
    }  

/**
 * 任务进行中
 */
    function view_ing($id=0)
    {
    	return $this->db->query("select * from retrieval where uid=".$id." and UNIX_TIMESTAMP(endtime)>=".$this->g24time." and isshow=0 order by id desc limit 3")->result();
    }  

/**
 * 任务结束的
 */
    function view_end($id=0)
    {
		
    	return $this->db->query("select * from retrieval where uid=".$id." and UNIX_TIMESTAMP(endtime)<".$this->g24time." and isshow=0 order by id desc limit 3")->result();
    } 

/**
 * 任务最新的
 */
    function view_new($id=0)
    {
    	return $this->db->query("select * from retrieval where uid=".$id." and UNIX_TIMESTAMP(endtime)>=".$this->g24time." and isshow=0 order by id desc limit 8")->result();
    } 

/**
 * 任务高价的
 */
    function view_max($id=0)
    {
    	return $this->db->query("select * from retrieval where uid=".$id." and UNIX_TIMESTAMP(endtime)>=".$this->g24time." and isshow=0 order by cost desc,id desc limit 8")->result();
    } 
	
	

/**
 * 附近的任务
 */
    function view_near($c_id)
    {
    	return $this->db->query("select * from retrieval where c_id=".$c_id." and UNIX_TIMESTAMP(endtime)>=".$this->g24time." and isshow=0 order by cost desc,id desc limit 8")->result();
    } 
	
	

/**
 * 相似的任务
 */
    function view_like($classid)
    {
    	return $this->db->query("select * from retrieval where classid=".$classid." and UNIX_TIMESTAMP(endtime)>=".$this->g24time." and isshow=0 order by cost desc,id desc limit 8")->result();
    } 	
	

/**
 * 图片任务信息
 */
    function view_img($id=0)
    {
    	return $this->db->query("select R.id,P.pic from `retrieval_pic` as P inner join retrieval as R on P.rid=R.rid group by R.id desc LIMIT 4")->result();
    } 
  
  
    function pics($id=0)
    {
    	return $this->db->query("select * from retrieval_pic where rid=".$id." order by id desc limit 15")->result();
    } 

    function pic_num($id=0)
    {
    	return $this->db->query("select id from retrieval_pic where rid=".$id)->num_rows();
    } 


/*返回任务状态及中标用户id*/
	function ok_uid($id=0)
	{
		$u = $this->db->query("select uid from `retrieval_election` where retrievalid=".$id." and ok=1 LIMIT 1")->row();
		if(!empty($u))
		{
			return $u->uid;
		}else{
			return false;
		}
	} 
	
	
/*任务投标人数*/
	function election_num($id=0)
	{
		return $this->db->query("select id from retrieval_election where retrievalid=".$id)->num_rows();
	}
	
	
	
/*判断是否已经参加投标(工人或团队已参加投标则返回true)
$uid=用户id , $tid=团队id ,$id=任务id*/
	function retrieval_uid($uid,$tid,$id)
	{
		#保证为数字
		if(is_numeric($uid)==false){$uid=0;}
		if(is_numeric($tid)==false){$tid=0;}
		if(is_numeric($id)==false){$id=0;}
		$rs=$this->db->query("select uid from retrieval_election where (uid=$uid or uid=$tid) and retrievalid=$id")->row();
		if(!empty($rs)){
			return $rs->uid;  //已经参加了
		}else{
			return false;   //未参加
		}
	}
	
   

/**
 * 返回任务类别
 */
	function g_class($id=0)
	{
      if(is_numeric($id)){
         $row = mysql_fetch_array(mysql_query("select title from industry_class where id=$id"));
         if($row){return $row["title"];}
	  }
	}
	
	
/**
 * 返回单个工种名称industry
 */
	function g_industry($id=0)
	{
		if(is_numeric($id)){
			$query = $this->db->query("select `title` from `industry` where `id`=$id LIMIT 1");
			$gnum  = $query->num_rows();
			if($gnum>0){
				return $query->row()->title;
			}
		}
	}  
	

/**
 * 返回返回返回工种industryid
 */
	function g_industrys($ids)
	{
	   $industryid=split(",",$ids);
	   if(is_array($industryid)){
	      $i=0;
	      foreach($industryid as $item){
		    $i++;
		    if(is_numeric($item)){
			   if($i>1){echo "、";}
			   echo $this->g_industry($item);
			   }
	      }
	   }
	}
	

	
/**
 * 返回列表sql语句,用于分页
 */
  function listsql($logid)
  {
	 //return "select R.id,R.title,R.title,R.addtime,R.endtime from `retrieval` as R left join `retrieval_election` as E on E.retrievalid=R.id left join `user` as W on W.`uid`=E.`uid` where (E.`uid`=".$logid." or E.`uid`=W.id) group by R.id order by E.id desc";
	  return "select R.id,R.title,R.addtime,R.endtime,R.visited from `retrieval` as R left join `user` as W on R.`uid`=W.`id` where (R.`uid`=".$logid.") order by R.id desc";
  }		

	
/**
 * 返回列表sql语句,用于用户页面
 */
  function User_Retrieval($logid)
  {
	 return $this->db->query("select R.id,R.title,R.addtime from `retrieval` as R left join `retrieval_election` as E on E.retrievalid=R.id where E.uid=".$logid." group by R.id order by E.id desc LIMIT 10")->result();
  }	

  
/**
 * 删除投标任务数据
 */
  function del($id=0,$uid=0,$T=false)
  {
	  if($T==true){
		  //无需用户登录权限
		  return $this->db->query("delete from `retrieval` where id=".$id);
	  }else{
		  //需要用户登录权限
		  return $this->db->query("delete from `retrieval` where uid=".$uid." and id=".$id);
	  }
  }

  
/**
 * 取消参加投标任务
 */
  function join_off($id=0,$uid=0)
  {
	  $this->db->query("delete from retrieval_election where uid=".$uid." and retrievalid=".$id);
  }

  
  #返回投标页面查询的sql
  function sql_retrieval()
  {
	  #*****接收参数，并进行xss过滤*****
	  $cityid = is_num($this->input->get("cityid"));
	  $areaid = is_num($this->input->get("areaid"));
	  
	  $team_or_men=is_num($this->input->get("team_or_men"));
	  $industry   =$this->input->get("industry", TRUE);
	  $classid    =is_num($this->input->get("classid"));
	  $keyword    =noHtml($this->input->get("keyword", TRUE));
	  #排序参数
	  $o_visited  =is_num($this->input->get("o_visited"));
	  $o_cost     =is_num($this->input->get("o_cost"));
	  $o_endtime  =is_num($this->input->get("o_endtime"));

	  #*****初始化排序*****
	  $order_keys="";
	  $orderAnd  ="";
	  #点击次数排序
	  if($o_visited=="1"){$order_keys.=$orderAnd."visited desc";}elseif($o_visited=="0"){$order_keys.=$orderAnd."visited asc";}
	  if($order_keys!=""){$orderAnd=",";}
	  #任务预费排序
	  if($o_cost=="1"){$order_keys.=$orderAnd."cost desc";}elseif($o_cost=="0"){$order_keys.=$orderAnd."cost asc";}
	  if($order_keys!=""){$orderAnd=",";}
	  #结束时间排序
	  if($o_endtime=="1"){$order_keys.=$orderAnd."endtime desc";	}elseif($o_endtime=="0"){$order_keys.=$orderAnd."endtime asc";}
	  if($order_keys!=""){$orderAnd=",";}
	  #基础排序排序
	  $order_keys.=$orderAnd."id desc";

	  #*****返回筛选条件*****
	  $selectStr="";
	  $selectAnd="";
	  #筛选任务城市
	  if($cityid){$selectStr.=$selectAnd." c_id=$cityid";$selectAnd=" and ";}
	  #筛选任务区域
	  if($areaid){$selectStr.=$selectAnd." a_id=$areaid";$selectAnd=" and ";}
	  #筛选任务类型
	  if($team_or_men){$selectStr.=$selectAnd." team_or_men=$team_or_men";$selectAnd=" and ";}
	  #筛选任务类别
	  if($classid){$selectStr.=$selectAnd." classid=$classid";$selectAnd=" and ";}
	  #筛选需求工种
	  if($industry!=""){
		  $industryStr="";
		  $industryArr=split(",",$industry);$Num=0;
		  $NStr="";
		  foreach($industryArr as $item){
			  $Num++;if($Num>1){$NStr=",";}
			  if(is_numeric($item)){$industryStr.=$NStr.$item;}
			  }
		  if($industryStr!=""){$selectStr.=$selectAnd." industryid ='".$industryStr."'";}
	  }
	  #返回最终筛选条件
	  if($selectStr!=""){$selectStr=$selectStr." and ";}
	  if($keyword!=""){$selectStr.=" (title like '%".$keyword."%' or note like '%".$keyword."%') and ";}
  
	  $sql = "select * from retrieval where".$selectStr." isshow=0 order by ".$order_keys;
	  
	  return $sql;
  }



}
?>
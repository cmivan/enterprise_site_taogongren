<?php
#单用户信息

class Evaluate_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
/**
 * 返回10条用户评价(包含返回用户信息)
 */
	function User_Evaluate($logid)
	{
		return $this->db->query("select E.uid,E.note,E.addtime,W.name from evaluate E left join `user` W on E.uid=W.id where E.uid_2=".$logid." order by E.id desc limit 10")->result();
	}
  
  
  
/**
 * 返回 指定用户 被评 某一类的 平均分数
 */
	function rating_sroc($uid,$classid)
	{
		$backScor = 0; //初始化
		$allScor  = 0; //初始化
		if(is_numeric($uid)&&is_numeric($classid)){
			//总评论数
			$row = $this->db->query("select scorarr from evaluate where uid_2=$uid and scorarr like '%".$classid."_%'");
			$rownum = $row->num_rows();
			$rowrs = $row->result();
			if(!empty($rowrs))
			{
				//通过数组解析并计数所获取的星级评分结果
				foreach($rowrs as $rs){
					$scorarr = $rs->scorarr;
					preg_match_all("/".$classid."_(\d+)/",$scorarr,$scorall,PREG_SET_ORDER);
					if(!empty($scorall))
					{
						$scor = is_num($scorall[0][1]);
						if($scor){ $allScor = $allScor + $scor; }
					}
				}
				if(is_numeric($rownum)&&is_numeric($allScor)){ $backScor=$allScor/$rownum; }
			}
        }
	    return ceil($backScor);
	}



}
?>
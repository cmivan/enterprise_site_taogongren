<?php
#多用户信息

class Rating_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
/**
 * 返回好评分类
 */	
	function rating_class($classid=0)
	{
		return $this->db->query("select id,title from rating_class where classid=".$classid." order by id asc")->result();
	}
	
/**
 * 返回用户的好评率
 */
	function haoping_sroc($uid)
	{
		//初始化
		$backScor = 0;
		//总评论数
		$rownum = $this->db->query("select id from evaluate where uid_2=".$uid)->num_rows();
		//好评数
		$haonum = $this->db->query("select id from evaluate where uid_2=".$uid." and haoping=1")->num_rows();
		if(is_numeric($haonum)&&is_numeric($rownum)&&$haonum!=0){
			$backScor = ($haonum/$rownum)*100;
			$backScor = round($backScor,2);
			}
		return "<span>".$backScor."</span> %";
	}


	

}
?>
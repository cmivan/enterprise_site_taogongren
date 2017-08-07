<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*升级记录*/
class Update extends QT_Controller {

	function __construct()
	{
		parent::__construct();
		exit;
	}

	function index()
	{
		//$this->update_face();
		//$this->update_sql();
		//$this->re_projects_pic();
		//$this->update_retrieval();
		//$this->update_cases(2);
		//$this->update_articles();
		//$this->update_unions();
	}
	
	
	function send_email($email='')
	{
		$this->load->helper('send');
		emailto('taogongren.com','cm.vian@qq.com','For Test!','Testing!');
	}
	
	function send_mobile($mobile='')
	{
		$this->load->helper('send');
		smsto($mobile,'Testing!');
	}

	
	//更新头像目录
	function update_face()
	{
		$row=$this->db->query("select id,photo from `user` where photo<>''")->result();
		if(!empty($row)){ $num=0;
			#####数据处理######
			$rootPath = dirname(__FILE__).'/../..';
			/*
			  图片目录包括：
			  e_avatar 
			  views
			  */
			foreach($row as $rs){
				$thispicid = $rs->id;
				$data[$num]["photoID"] = $thispicid;
				$data[$num]["oldpic"]  = $rootPath.'/'.$rs->photo;
				$data[$num]["newpic"]  = $rootPath.$this->config->item("face_url")."origin/".$thispicid.".jpg";
				$data[$num]["newpicB"] = $rootPath.$this->config->item("face_url")."big/".$thispicid.".jpg";
				$data[$num]["newpicS"] = $rootPath.$this->config->item("face_url")."small/".$thispicid.".jpg";
				if($rs->photo!='views/images/none.jpg'){
					//复制文件到指定目录
					@copy($data[$num]["oldpic"],$data[$num]["newpic"]);
					@copy($data[$num]["oldpic"],$data[$num]["newpicB"]);
					@copy($data[$num]["oldpic"],$data[$num]["newpicS"]);
					$updata["photoID"] = $thispicid;
					
					$file = $data[$num]["oldpic"];
					@unlink ($file);
				}else{
					$updata["photoID"] = '';
				}
				//更新数据
				$this->db->where('id',$thispicid);
				$this->db->update('user',$updata);
				$num++;
			}
		}
		json_echo("<pre>");
		print_r($data);
		json_echo("</pre>");
	}	
	
	
	
	
	
	
	
	
	
	//更新投标
	function update_retrieval()
	{
		$row=$this->db->query("select id,uid,pic from `retrieval_pic` where pic<>''")->result();
		if(!empty($row)){
			$num=0;
			#####数据处理######
			$rootPath = dirname(__FILE__).'/../..';
			foreach($row as $rs){
				$thispicid = $rs->id;
				$data[$num]["oldpic"]  = $rootPath.'/'.$rs->pic;
				$newpic = "20111230/".pass_key($rs->uid.$thispicid).".jpg";
				$data[$num]["newpic"]  = $rootPath.$this->config->item("retrieval_url").$newpic;
				//print_r($data);
				//exit;
				//复制文件到指定目录
				@copy($data[$num]["oldpic"],$data[$num]["newpic"]);
				$file = $data[$num]["oldpic"];
				@unlink($file);
				
				$updata["pic"] = $newpic;
				//更新数据
				$this->db->where('id',$thispicid);
				$this->db->update('retrieval_pic',$updata);
				$num++;
			}
		}

		json_echo("<pre>");
		print_r($data);
		json_echo("</pre>");
	}
	
	
	
	
	
	
	
	
	
	
	//更新投标
	function update_cases($T=1)
	{
		//$row=$this->db->query("select id,uid,pic,content from `cases` where pic<>''")->result();
		$row=$this->db->query("select id,uid,pic,content from `cases`")->result();
		if(!empty($row)){
			$num=0;
			#####数据处理######
			$rootPath = dirname(__FILE__).'/../..';
			foreach($row as $rs){
				$thispicid = $rs->id;
				
				if($T==1){
					$data[$num]["oldpic"]  = $rootPath.'/'.$rs->pic;
					$newpic = "20111230/".pass_key($rs->uid.$thispicid).".jpg";
					$data[$num]["newpic"]  = $rootPath.$this->config->item("cases_url").$newpic;
					//print_r($data);
					//exit;
					//复制文件到指定目录
					@copy($data[$num]["oldpic"],$data[$num]["newpic"]);
					$file = $data[$num]["oldpic"];
					@unlink($file);
					//print_r($data);
					$updata["pic"] = $newpic;
				}else{
					$data[$num]["id"]  = $thispicid;
					
					$content = $rs->content;
					preg_match_all("/<img(.*)(src=\"[^\"]+\")[^>]+>/isU", $content, $arr); 
					for($i=0,$j=count($arr[0]);$i<$j;$i++){
						$content = str_replace("views/tg_pic_edit/","/public/up/cases/20111230/e/",$content); 
					}
					
					$updata["content"] = $content;
					json_echo($content.'<hr>');
				}
				
				//更新数据
				$this->db->where('id',$thispicid);
				$this->db->update('cases',$updata);
				$num++;
			}
		}

		json_echo("<pre>");
		//print_r($data);
		json_echo("</pre>");
	}
	
	
	
	
	
	//更新投标
	function update_articles()
	{
		//$row=$this->db->query("select id,uid,pic,content from `cases` where pic<>''")->result();
		$row=$this->db->query("select id,content from `articles`")->result();
		if(!empty($row)){
			$num=0;
			#####数据处理######
			$rootPath = dirname(__FILE__).'/../..';
			
			foreach($row as $rs){
				$thispicid = $rs->id;
				$data[$num]["id"]  = $thispicid;
				$content = $rs->content;
				
				//创建文章目录
				$rootPath = dirname(__FILE__).'/../..';
				$thispath = "/public/up/k/image/0vf962a1be_7103/20121230/";
				$new_path = $thispath.'a'.$thispicid.'/';
				if (!file_exists('.'.$new_path)) { mkdir('.'.$new_path); }

				preg_match_all("/<img(.*)(src=\"[^\"]+\")[^>]+>/isU", $content, $arr); 
				for($i=0,$j=count($arr[0]);$i<$j;$i++){
					
					//创建相应的目录
					$num = 0;
					$itemdata = '';
					foreach($arr[2] as $item){
						$thisitem = $item;
						$thisitem = str_replace('src=','',$thisitem);
						$thisitem = str_replace('"','',$thisitem);
						
						$itemarr = split('/',$thisitem);
						if(in_array('http:',$itemarr)||in_array('0vf962a1be',$itemarr)){
							
						}else{
							$old_path = $thisitem;
							$new_file = $new_path.$abc.'.jpg';
							
							//复制文件到指定目录
							//$root_old_path = realpath($rootPath.$old_path);
							$root_old_path = realpath($rootPath.$old_path);
							$root_new_file = realpath($rootPath).$new_file;
							$ok = @copy(''.$root_old_path.'',''.$root_new_file.'');
							if($ok){
								@unlink($root_old_path);
								$content = str_replace($old_path,$new_file,$content); 
							}
							
							//生成数组
							$itemdata[$abc]['old_path'] = $old_path;
							$itemdata[$abc]['new_path'] = $new_file;
							
							//更新数据
							//$content = str_replace($old_path,$new_file,$content); 
							//$content = str_replace('/public/user/','/public/xxxx/',$content); 
						}
						$num++;
					}
					//json_echo($content);
					print_r($itemdata);
				}
				
				//更新数据
				$updata["content"] = $content;
				$this->db->where('id',$thispicid);
				$this->db->update('articles',$updata);
				$num++;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	//更新投标
	function update_unions()
	{
		$dbtable = 'unions';
		$rootPath = dirname(__FILE__).'/../..';

		$row=$this->db->query("select id,content from `".$dbtable."`")->result();
		if(!empty($row)){
			$num=0;
			foreach($row as $rs){
				$thispicid = $rs->id;
				$content = strtolower($rs->content);

				preg_match_all("/<img(.*)(src=\"[^\"]+\")[^>]+>/isU", $content, $arr); 
				
				if(count($arr[0])>0){
					//创建文章目录
					$new_path = "/public/up/k/image/0ve0d0f1f8_2/20121230/".$dbtable.$thispicid."/";
					if (!file_exists('.'.$new_path)) { mkdir('.'.$new_path); }
					}
					
				$content = str_replace('../../../','/',$content); 	
				$content = str_replace('.jpg">','.jpg" />',$content); 
				for($i=0,$j=count($arr[0]);$i<$j;$i++){
					//创建相应的目录
					$abc = 0;
					$itemdata = '';
					foreach($arr[2] as $item){
						//获取文章内的所有图片链接
						$thisitem = $item;
						$thisitem = str_replace('src=','',$thisitem);
						$thisitem = str_replace('"','',$thisitem);
						//将路径转换成数组,用于检测路径是否符合所需
						json_echo($thisitem);
						$itemarr = split('/',$thisitem);
						
						if(in_array('www.taogongren.com',$itemarr)){
							$content = str_replace('http://www.taogongren.com','',$content); 
						}elseif(in_array('www.hengannet.com',$itemarr)){
							$content = str_replace('http://www.hengannet.com','',$content); 
						}elseif(in_array('http:',$itemarr)||in_array('0ve0d0f1f8_2',$itemarr)){
							$content = str_replace('http://www.taogongren.com','',$content); 
							//json_echo('<br>@@'.$thispicid.'<hr>'.$content);
						}else{
							//原路径
							$old_path = $thisitem;
							//新路径
							$new_file = $new_path.$abc.'.jpg';
							
							//将原路径处理中文支持
/*							$oldpath = split('/',$old_path);
							if(count($oldpath)>0){
								$oldpathname = $oldpath[count($oldpath)-1];
							}
							if($oldpathname!=''){
								$oldpatharr = split('\.',$oldpathname);
								if(count($oldpatharr)>0){
									$oldname = $oldpatharr[0];
									$newOldname = urlencode($oldname);
									if($newOldname!=''){
										$newOldname.= '.'.$oldpatharr[1];
										$newOldpath = str_replace($oldpathname,$newOldname,$old_path);
									}
								}
							}
							
							if($newOldname!=$oldpathname){
								$old_path = $newOldpath;
								json_echo($newOldname.'<br>');
								json_echo($oldpathname.'<br>');
								$root_old_path = $old_path;
								json_echo($root_old_path.'<br>');
							}*/
							
							if($old_path!=$new_file){
								//生成完整路径
								$root_old_path = realpath($rootPath.$old_path);
								$root_new_file = realpath($rootPath).$new_file;
								//复制文件到指定目录
								$ok = @copy(''.$root_old_path.'',''.$root_new_file.'');
								if($ok){
									//更新数据
									$content = str_replace($old_path,$new_file,$content); 
									//$content = str_replace('0vf962a1be','0vaa45fc3e',$content); 
								}else{
									json_echo($root_old_path);
									json_echo('&nbsp;&nbsp;&nbsp;');
									json_echo($root_new_file);
								}

								//生成数组
								$itemdata[$abc]['old_path'] = $old_path;
								$itemdata[$abc]['new_path'] = $new_file;
							}
						}
						$abc++;
						
						
					}
				}
				json_echo('<br>@@'.$thispicid.'<hr>'.$content);
				//json_echo('<br>@@'.$thispicid.'<hr>');
				//print_r($itemdata);
				
				//更新数据
				$updata["content"] = $content;
				if(!empty($updata["content"])){
					$this->db->where('id',$thispicid);
					$this->db->update($dbtable,$updata);
				}
				$num++;
			}
		}
	}
	
	
	
	
	
	
	
//function replace($str) 
//{
//	preg_match_all("/<img(.*)(src=\"[^\"]+\")[^>]+>/isU", $str, $arr); 
//	for($i=0,$j=count($arr[0]);$i<$j;$i++){
//		//$newpic = str_replace("views/tg_pic_edit/","/public/up/cases/20111230/e/",$arr[2][$i]);
//		//$str = str_replace($arr[0][$i],"<img ".$newpic." />",$str); 
//		$str = str_replace("views/tg_pic_edit/","/public/up/cases/20111230/e/",$str); 
//	}
//	return $str; 
//} 

	
	
	
	
	
	
	
	
	
	//整理数据库
	function update_sql()
	{
		$this->load->dbutil();
		$this->load->dbforge();
		//删除多余的表
		$dbs = $this->dbutil->list_databases();
		foreach($dbs as $db){ json_echo($db); }
		//工人的
//		$this->dbforge->drop_column('user', 'photo');
//		$this->dbforge->drop_column('user', 'photo2');
//		$this->dbforge->drop_column('user', 'serial_id');
//		$this->dbforge->drop_column('user', 'entry_date');
		//招聘
		json_echo("ok");
	}
	
	

/**
 * 工种图片
 */
    function re_projects_pic()
    {
    	$row=$this->db->query("select * from industry where industryid=0")->result();
		if(!empty($row)){
    	foreach($row as $Rs){
    		$id =$Rs->id;
    		$pic=$Rs->pic;
    		$pic=str_replace("views/index_typeimg/","public/images/index_typeimg/",$pic);
			$pic=str_replace(".jpg",".png",$pic);
    		json_echo($pic.'<br>');
    		$this->db->query("update industry set pic='".$pic."' where id=".$id);
    	}
		}
    }
		
	

/**
 * 替换头像图片1
 */
    function re_pic1()
    {
    	$row=$this->db->query("select * from retrieval_pic");
    	foreach($row->result() as $Rs){
    		$id =$Rs->id;
    		$pic=$Rs->pic;
    		//$pic=str_replace("views/tg_pic_up/","/public/images/tg_pic_up/",$pic);
    		//$pic=str_replace("/public/images/up/tg_pic_up/","/public/up/tg_pic_up/",$pic);
    		$pic=str_replace("public/images/","public/up/",$pic);
    		
    		json_echo($pic);
    		$this->db->query("update retrieval_pic set pic='".$pic."' where id=".$id);
    	}	
    }

/**
 * 替换头像图片2
 */
    function re_pic2()
    {
    	$row=$this->db->query("select id,photo from `user`");
    	foreach($row->result() as $Rs){
    		$id =$Rs->id;
    		$pic=$Rs->photo;
    		//$pic=str_replace("views/face_images/","/public/images/face_images/",$pic);
    		//$pic=str_replace("/public/images/up/face_images/","/public/up/face_images/",$pic);
    		//$pic=str_replace("/public/images/tg_pic_up/","/public/up/tg_pic_up/",$pic);
    		$pic=str_replace("public/up/public/up/e_avatar/","public/up/e_avatar/",$pic);
    		//$pic=str_replace("views/images/none","public/images/none",$pic);
    		
    		json_echo($pic);
    		$this->db->query("update `user` set photo='".$pic."' where id=".$id);
    	}	
    }
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
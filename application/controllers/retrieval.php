<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retrieval extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Retrieval_Model');
		$this->load->model('Industry_Model');	
	}
	


	function index()
	{
		$this->load->model('Paging');

		$this->data['keyword'] = noHtml($this->input->get("keyword", TRUE));

		$this->data["team_mens"] = $this->User_Model->worker_types();
		$this->data["classids"]  = $this->Industry_Model->industry_class();
		$this->data["industrys"] = $this->Industry_Model->industrys();

		//获取sql语句
		$sql = $this->Retrieval_Model->sql_retrieval();
		//获取列表内容
		$this->data["list"] = $this->Paging->show($sql,10);

		#排序参数
		$o_visited = $this->input->get("o_visited", TRUE);
		$o_cost = $this->input->get("o_cost", TRUE);
		$o_endtime = $this->input->get("o_endtime", TRUE);
		
		if($o_visited==0){$this->data["o_visited"]=1;}else{$this->data["o_visited"]=0;}
		if($o_cost==0){$this->data["o_cost"]=1;}else{$this->data["o_cost"]=0;}
		if($o_endtime==0){$this->data["o_endtime"]=1;}else{$this->data["o_endtime"]=0;}

		//是否需要显示搜索辅助函数
		$this->data['searchkeys'] = true;
		$this->load->view('retrieval/index',$this->data);
	}




	function view($id=0)
	{
		//检测id 不符合则返回404页面
		$id = is_num($id,'404');
		
		$this->load->model('Rating_Model');
		$this->load->model('Evaluate_Model');
		$this->load->model('GetMobile_Model');
		$this->load->model('Paging');
		
		//累积访问次数
		$this->Retrieval_Model->visite($id);

		//任务详细信息
	    $this->data['view'] = $this->Retrieval_Model->view($id);

		//获取用户信息
		$view = $this->data['view'];
		if(!empty($view)){ $uid = $view->uid; }else{ $uid = ''; }
		$uid = is_num($uid,'404');
		
		$this->data["user"] = $this->User_Model->info($uid);
		$this->user = $this->data["user"];

	    $this->data['view_ing'] = $this->Retrieval_Model->view_ing($uid);  //任务进行中
	    $this->data['view_end'] = $this->Retrieval_Model->view_end($uid);  //任务结束的
	    $this->data['view_new'] = $this->Retrieval_Model->view_new($uid);  //任务最新的
	    $this->data['view_max'] = $this->Retrieval_Model->view_max($uid);  //任务高价的
	    $this->data['view_near'] = $this->Retrieval_Model->view_near($uid);//附近任务
	    $this->data['view_like'] = $this->Retrieval_Model->view_like($uid);//相似任务
	    $this->data['view_img'] = $this->Retrieval_Model->view_img($id);   //图片任务信息

		//任务id
		//$rid = $view->rid;
		//if($rid==''&&is_numeric($rid)==false){ $rid=0; }

		$this->data['pics'] = $this->Retrieval_Model->pics($id);
		$this->data['pic_num'] = $this->Retrieval_Model->pic_num($id);
		//任务是否已到期
		$this->data['timeover'] = strtotime($view->endtime)>dateDay24();
		//中标人id
		$this->data['ok_uid'] = $this->Retrieval_Model->ok_uid($id);
		/*用户手机遮罩*/
		$ispay = $this->GetMobile_Model->is_getok($this->logid,$uid);
		$this->data["mobile_mark"] = mobile_mark($this->user->mobile,$uid,$this->logid,$ispay);
		$this->data["mobile_mark2"] = mobile_mark($this->user->mobile,$uid,$this->logid,$ispay,1);
		
		/*当前任务的城市或地区*/
		$c_id = is_num($view->c_id);
		$a_id = is_num($view->a_id);
		
		if($a_id){
			$rs = $this->Place->area($a_id);
			if(!empty($rs)){ $this->data["where"] = $rs->a_name; }
		}elseif($c_id){
			$rs = $this->Place->city($c_id);
			if(!empty($rs)){ $this->data["where"] = $rs->c_name; }
		}
		
		if(empty($this->data["where"])) { $this->data["where"] = "未知";	}

		/*参与投标人数*/
		$this->data["election_num"] = $this->Retrieval_Model->election_num($id);
		/*用户投标信息*/
		$election_sql = $this->Retrieval_Model->election_sql($id);
		$this->data["election_list"] = $this->Paging->show($election_sql,15);
		/*评分类型*/
		$this->data["rating_class"] = $this->Rating_Model->rating_class(1);
		/*评分率*/
		$this->data["haoping_sroc"] = $this->Rating_Model->haoping_sroc($uid);
		
		
		/*<><><>css样式<><><>*/
		#评级打分
		$this->data['cssfiles'][] = 'style/mod_star.css';
		#投标详细
		$this->data['cssfiles'][] = 'style/page_retrieval_view.css';
		#LightBox v2.0
		$this->data['cssfiles'][] = 'style/mod_lightbox.css';
		
		/*<><><>Js<><><>*/
		#评级打分
		//$this->data['jsfiles'][]  = 'js/mod_common_star.js';
		#手机动画绑定
		$this->data['jsfiles'][]  = 'js/mobile_movement.js';

		$this->load->view('retrieval/view',$this->data);
	}
	
	
	
	/*参加投标*/
	function joins()
	{
		/*获取用户信息*/
		$logid = is_num($this->logid);
		
		$id = is_num($this->input->get("id"));
		$ok = is_num($this->input->get("ok"),0);
		
		if($id==false){
			json_form_alt("err:id=null");
		}elseif($logid==false){
			json_form_box_login();
		}else{
			$classid = $this->User_Model->classid($logid);
			if(!empty($classid)&&$classid<>0){
				json_form_box_login();
			}else{
			   if($ok==0){
				   //返回窗口
				   json_form_box('参加任务投标',site_url('retrieval/joins').'?height=355&width=680&ok=1&id='.$id);
			   }else{
				   //获取用户设置
				   $type = $this->input->get("type");
				   if($type=="U"||$type=="T"){ $this->session->set_userdata("utype",$type);  /*获取设置,重新绑定*/ }
				   
				   //返回当前用户状态
				   $utype = $this->session->userdata("utype");
				   if($utype!="U"&&$utype!="T"){ $utype = false; }
				   //用于页面操作，与当前状态相反
				   if($utype=="U"){ $this->data["utype"] = "T"; }else{ $this->data["utype"] = "U"; }

				   #显示视窗
				   $this->data["id"] = $id;
				   $this->data["retrieval_type"] = $this->Retrieval_Model->retrieval_type($id);
				   $retrieval_type = $this->data["retrieval_type"];
				   
				   #参加投标的用户id
				   //个人id
				   $uid = $logid;
				   $this->data["uid"] = $uid;
				   //团队id
				   $tid = $this->User_Model->get_user_id($logid,1);
				   $this->data["tid"] = $tid;
				   
				   #获取成功参加投标的用户id
				   $ok_uid = $this->Retrieval_Model->retrieval_uid($uid,$tid,$id);
				   
				   $this->data["isshow_but"] = false;
				   
				   #未参加该任务
				   if($ok_uid==false){
					  //判断任务类型
					  switch($retrieval_type)
					  {
						  //个人
						  case 0:
							 //取消团队身份,直接以个人身份操作
							 $utype = 'U';
							 $RUid  = $uid;
							 break;
						  //团队
						  case 2: //如果是个人身份，则不允许登录
							 if($tid==0){ json_echo("该任务只允许团队创建者参加!"); }
							 $utype = 'T';
							 $RUid = $tid;
							 break;
						  //全部
						  case 1:
						     //显示切换按钮
							 $this->data["isshow_but"] = true;
							 if($tid==0){
								$RUid = $uid;
								//json_echo("个人,直接参加!");
							 }elseif($utype==false){
								//$utype==false表示未能识别身份
								//团队创建者，则选择相应的身份
								$this->data["Uuser"] = $this->User_Model->info($uid);
								$this->data["Tuser"] = $this->User_Model->info($tid);
								$this->load->view('retrieval/join_select',$this->data);
							 }else{
								/*当上面的选择操作判断完成后
								则可以返回一个最终参加投标的userid值*/
								if($utype=="U"){
								   #返回个人id
								   $RUid = $uid;
								}elseif($utype=="T"){
								   #返回团队id
								   $RUid = $tid;
								} 
							 }
							 break; 
					  }

				  }else{
					  #是否要显示身份[切换按钮](任务已完成不需显示)
					  $this->data["isshow_but"] = false;
					  #已参加该任务
					  $utype = 'U';
					  $RUid = $ok_uid;  
				  }
				  
				  //在未能识别用户使用的身份前，不输出主界面
				  if($utype!=false){
					  //返回用户id
					  $this->data["RUid"] = $RUid;
					  
					  //判读是否已经读参加，如果已经参加则
					  $rs = $this->Retrieval_Model->R_election($RUid,$id)->row();
					  if(!empty($rs)){
						  //存在
						  $this->data["is_join"] = true;
						  $this->data["skills"]  = $rs->skills;
						  $this->data["note"]    = $rs->note;
					  }else{
						  //不存在
						  $this->data["is_join"] = false;
						  $this->data["skills"]  = '';
						  $this->data["note"]    = '';
					  }
					  
					  /*表单配置*/
					  $this->data['formTO']->url = 'retrieval/join_save';
					  $this->data['formTO']->backurl = '';
					  
					  $this->load->view('retrieval/join',$this->data);
				  }  
			   }
			}
		}
	}
	
	
	
	
	
	/*保存投标*/
	function join_save()
	{
		//过滤数字,不符合则返回0
		$logid = is_num($this->logid,0);
		$rid   = is_num($this->input->post("rid"),0);
		$skills= noHtml($this->input->post("skills"));
		$note  = noHtml($this->input->post("note"));
		$show  = is_num($this->input->post("show"),0);
		if($show!=1){$show=0;}

		//取消投标
		$cancel= $this->input->post("cancel");

	    //判断是否已经参与投标
		$rsnum = $this->Retrieval_Model->R_election($logid,$rid)->num_rows();

		if($logid==false){ json_form_no('请先登录!'); }
		elseif($rid==false){ json_form_no('Id err!'); }
		elseif($cancel=="yes"){
			$this->Retrieval_Model->join_off($rid,$logid);
			json_form_yes('已成功取消参与该投标!');
			}
		elseif($rsnum>0){ json_form_yes('不能重复参与投标!'); }
		elseif($skills==''){ json_form_no('请填写报价!'); }
		elseif($note==''){ json_form_no('请填写留言!'); }
		else{
		   $data["uid"] = $logid;
		   $data["retrievalid"] = $rid;
		   $data["skills"] = $skills;
		   $data["note"] = $note;
		   $data["addtime"] = dateTime();
		   $data["show"] = $show;
		   $this->db->insert("retrieval_election",$data);
		   json_form_yes('成功参加投标!');
		}
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retrieval extends E_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data  = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		$this->load->model('Retrieval_Model');

		//初始化页面导航
		$this->data["thisnav"]["nav"][0]["title"] = "管理投标";
		$this->data["thisnav"]["nav"][0]["link"]  = "index";
		$this->data["thisnav"]["nav"][1]["title"] = "发布投标";
		$this->data["thisnav"]["nav"][1]["link"]  = "add";
	}

	
	function index()
	{
		//处理删除
		$del_id = is_num($this->input->get('del_id'));
		if($del_id){
			$this->Retrieval_Model->del($del_id,$this->logid);
			//删除图片
			$this->db->query('delete from retrieval_pic where uid='.$this->logid.' and rid='.$del_id);
			}
	
		//分页模型
		$this->load->model('Paging');
		//获取分页列表sql
		$listsql=$this->Retrieval_Model->listsql($this->logid);
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql);
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'retrieval/index',$this->data);
	}
	

	
	function add()
	{
		$this->data["team_mens"] = $this->db->query("select id,title from `user_type` where type_id=0")->result();
		$this->data["classids"]  = $this->db->query("select id,title from `industry_class` order by id asc")->result();
		/*个人信息*/
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		$this->data["industrys"] = $this->db->query("select id,title from `industry` where industryid=0 order by id asc")->result();


		/*<><><>css样式<><><>*/
		#评级打分
		$this->data['cssfiles'][] = 'style/page_retrieval.css';
		/*<><><>Js<><><>*/
		#下拉框选择城市
		$this->data['jsfiles'][]  = 'js/city_select_option.js';

		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save';
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'retrieval/add',$this->data);
	}
	

	
	function edit($id=0)
	{
		//安全处理
		$id = is_num($id);
		$this->data["info"]=$this->Retrieval_Model->view($id);
		if(empty($this->data["info"])){ show_404('/index' ,'log_error'); }

		$this->data["team_mens"] = $this->db->query("select id,title from `user_type` where type_id=0")->result();
		$this->data["classids"]  = $this->db->query("select id,title from `industry_class` order by id asc")->result();
		/*个人信息*/
	    $this->data["u_place"] = $this->User_Model->info($this->logid);
		$this->data["industrys"] = $this->db->query("select id,title from `industry` where industryid=0 order by id asc")->result();
		
		/*获取图片信息*/
		$this->data["pics"] = $this->db->query("select id,pic from `retrieval_pic` where rid=".$id." order by id asc")->result();

		/*<><><>css样式<><><>*/
		#评级打分
		$this->data['cssfiles'][] = 'style/page_retrieval.css';
		/*<><><>Js<><><>*/
		#下拉框选择城市
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/save/'.$id;
		$this->data['formTO']->backurl = $this->data["c_urls"];
		
		/*输出到视窗*/
		$this->load->view($this->data["c_url"].'retrieval/edit',$this->data);
	}
	
	
	
	function save($id=0)
	{
		//安全处理
		$id = is_num($id);
		
		$data['uid'] = $this->logid;
		$data['title'] = noHtml($this->input->post("title"));
		$data['cost']  = noHtml($this->input->post("cost"));
		$data['team_or_men'] = is_num($this->input->post("team_or_men"),0);
		$data['classid']  = is_num($this->input->post("classid"),0);
		$data['p_id'] = is_num($this->input->post("p_id"),0);
		$data['c_id'] = is_num($this->input->post("c_id"),0);
		$data['a_id'] = is_num($this->input->post("a_id"),0);
		$data['industryid'] = $this->input->post("industryid");
		$data['endtime']    = $this->input->post("endtime");
		$data['job_stime']  = $this->input->post("job_stime");
		$data['job_etime']  = $this->input->post("job_etime");
		$data['note'] = noHtml($this->input->post("note"));
		$data['rid']  = is_num($this->input->post("rid"),0);
		$pic = $this->input->post("pic");
		
		//检测数据
		if($data['title']==""){ json_form_no('请先填写标题!'); }
		if($data['cost']!=is_num($data['cost'])||$data['cost']<=0){ json_form_no('请填写正确的预计费用!'); }
		if(strtotime(time())>strtotime($data['endtime'])){ json_form_no('投标结束时间已经过期!'); }
		if(strtotime($data['job_stime'])>strtotime($data['job_etime'])){ json_form_no('工期结束时间不能在开始时间前!'); }
		if($data['note']==""){ json_form_no('请填写投标描述!'); }

		if($id){
			//<><><>编辑
			$this->db->where('id', $id);
			$this->db->update('retrieval',$data);
			//清空原来的,重新录入
			$this->db->query("delete from `retrieval_pic` where `rid`=".$id);
			if(!empty($pic)){
			  foreach($pic as $p){
				 if($p!=""&&$p!="0"){
					$pdata['pic'] = noSql($p);
					//$pdata['picMD5'] = md5($p);
					$pdata['note']= '';
					$pdata['rid'] = $id;
					$pdata['uid'] = $this->logid;
					$this->db->insert('retrieval_pic',$pdata);
				 }}}
			//返回提示
			json_form_yes('更新成功!');
		}else{
			
			//<><><>添加
			//以md5值记录任务信息，防止重复
			$thisMD5 = arr2md5($data);
			$num = $this->db->query("select `id` from `retrieval` where `thisMD5`='".$thisMD5."'")->num_rows();
			if($num>0){
				json_form_no('该投标信息已经发布过了!');
			}else{
				//写入数据
				$data['addtime'] = dateTime();
				$data['thisMD5'] = $thisMD5;
				$this->db->insert('retrieval',$data);
				
				//判断是否提交图片,有则处理
				$thisRid = $this->db->insert_id();
				if(is_num($thisRid)&&!empty($pic)){
				  foreach($pic as $p){
					 if($p!=''&&$p!='0'){
						 $pdata['pic'] = noSql($p);
						 //$pdata['picMD5'] = md5($p);
						 $pdata['note']= '';
						 $pdata['rid'] = $thisRid;
						 $pdata['uid'] = $this->logid;
						 $this->db->insert('retrieval_pic',$pdata);
					 }}}
				//json_echo('{"//cmd":"y","info":"发布成功！"}');	
				//发送邮件,通知平台客服(临时)
				#*****************************
				$this->load->helper('send');
				$rvalurl=site_url('retrieval/view/'.$this->db->insert_id());
				$mailNr ='业主昵称:<a href="'.site_url('user/'.$data['uid']).'" target="_blank">'.$data['uid'].'</a><br>';
				$mailNr.='任务信息:'.$data['title'].'<br>';
				$mailNr.='任务费用:'.$data['cost'].'（元）<br>';
				$mailNr.='任务网址:<a href="'.$rvalurl.'" target="_blank">'.$rvalurl.'</a><br>';
				emailto('淘工人投标信息','cm.ivan@qq.com','淘工人投标信息',$mailNr);
				#*****************************
				//返回提示
				json_form_yes('发布成功!');
			}	
		}

	}
	
	



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
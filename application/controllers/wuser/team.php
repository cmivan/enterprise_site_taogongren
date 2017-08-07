<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team extends W_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	public $tid = 0;

	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		//分页模型
		$this->load->model('Paging');
		
		/*初始化团队id*/
		$this->tid = is_num($this->User_Model->one2team_id($this->logid),0);
		
		//初始化页面导航
		if($this->tid){
			//已创建团队
			$this->data["thisnav"]["nav"][0]["title"] = "我的团队";
			$this->data["thisnav"]["nav"][0]["link"]  = "index";
			$this->data["thisnav"]["nav"][1]["title"] = "团队头像";
			$this->data["thisnav"]["nav"][1]["link"]  = "face";
//			$this->data["thisnav"]["nav"][2]["title"] = "团队案例";
//			$this->data["thisnav"]["nav"][2]["link"]  = "cases";
//			$this->data["thisnav"]["nav"][2]["tip"]   = "点击进入“案例展示”管理页面";
//			$this->data["thisnav"]["nav"][3]["title"] = "团队证书";
//			$this->data["thisnav"]["nav"][3]["link"]  = "certificate";
//			$this->data["thisnav"]["nav"][3]["tip"]   = "点击进入“资质证书”管理页面";
			$this->data["thisnav"]["nav"][4]["title"] = "团队成员";
			$this->data["thisnav"]["nav"][4]["link"]  = "member";
			$this->data["thisnav"]["nav"][5]["title"] = "";
			$this->data["thisnav"]["nav"][5]["link"]  = "";
			$this->data["thisnav"]["nav"][6]["title"] = "我加入的团队";
			$this->data["thisnav"]["nav"][6]["link"]  = "my_join";
		}else{
			//没创建团队
			$this->data["thisnav"]["nav"][0]["title"] = "我要创建团队";
			$this->data["thisnav"]["nav"][0]["link"]  = "index";
			$this->data["thisnav"]["nav"][1]["title"] = "我加入的团队";
			$this->data["thisnav"]["nav"][1]["link"]  = "my_join";
		}
	}
	
	
	
	function index()
	{
		/*当前登录用户是否是在活动期间被邀请的用户，是则开放创建团队权限*/
		$this->data['is_sys_inviter'] = activity_sys_inviter($this->logid);
		/*是否创建团队而赠送工币*/
		$this->data['create_2gift'] = activity_create2gift($this->tid);

		/*<><><>css样式<><><>*/
		$this->data['cssfiles'][] = '';
		/*<><><>Js<><><>*/
		$this->data['jsfiles'][]  = 'js/city_select_option.js';
		
		/*表单配置*/
		$this->data['formTO']->url = $this->data["c_urls"].'/go_save_team';
		$this->data['formTO']->backurl = 'null';
		
		/*初始化数据*/
		$this->data['name'] = '';
		$this->data['photoID'] = '';
		$this->data['addtime'] = '';
		$this->data['address'] = '';
		$this->data['note'] = '';
		$this->data['team_fwxm'] = '';
		$this->data['team_fwdq'] = '';
		$this->data['team_ckbj'] = '';
		$this->data['p_id'] = $this->User_Model->p_id($this->logid);
		$this->data['c_id'] = $this->User_Model->c_id($this->logid);
		$this->data['a_id'] = $this->User_Model->a_id($this->logid);
		$this->data['ps'] = $this->Place->provinces(0);
		$this->data['cs'] = $this->Place->citys($this->data['p_id']);
		$this->data['as'] = $this->Place->citys($this->data['c_id']);

		/*分析内容是否为空*/
		$info = $this->User_Model->team_info($this->logid);
		if(!empty($info)){
			$this->data['name'] = $info->name;
			$this->data['photoID'] = $info->photoID;
			$this->data['addtime'] = $info->addtime;
			$this->data['address'] = $info->address;
			$this->data['note']    = $info->note;
			$this->data['team_fwxm'] = $info->team_fwxm;
			$this->data['team_fwdq'] = $info->team_fwdq;
			$this->data['team_ckbj'] = $info->team_ckbj;
			$this->data['p_id'] = $info->p_id;
			$this->data['c_id'] = $info->c_id;
			$this->data['a_id'] = $info->a_id;
			$this->data['cs'] = $this->Place->citys($info->p_id);
			$this->data['as'] = $this->Place->areas($info->c_id);
		}
		
		/*邀请链接*/
		$this->data['inviter_url'] = activity_inviter_url($this->logid);
		
		$this->load->view($this->data["c_urls"].'/index',$this->data);
	}
	

	//管理头像
	function face()
	{
		$tid = is_num($this->tid,'404');
		$photoID = $this->User_Model->photoID($tid);
		$this->data["photoID"] = $photoID;
		$this->data["face"] = $this->User_Model->face($photoID);
		/*输出到视窗*/
		$this->load->view_wuser('team/face',$this->data);
	}
	

	function cases($is_team=0)
	{
		redirect($this->data['c_url'].'cases/index/2', 'location', 301);
	}
	function certificate()
	{
		redirect($this->data['c_url'].'certificate/index/2', 'location', 301);
	}	
	
	
	function member()
	{
		$tid = is_num($this->tid,'404');
		$sql = "select id,name,addtime from `user` where id in (select uid from `team_user` where tid=".$tid.")";
		$this->data["list"] = $this->Paging->show($sql,10);
		/*输出到视窗*/
		$this->load->view($this->data["c_urls"].'/member',$this->data);
	}
	
	
	function my_join()
	{
		$sql = "(select tid from `team_user` where uid=".$this->logid." and checked=1)";
		$sql = "select id,name,addtime from `user` where id in ".$sql." and classid=2";
		$this->data["list"] = $this->Paging->show($sql,10);
		/*输出到视窗*/
		$this->load->view($this->data["c_urls"].'/my_join',$this->data);
	}
	
	
	
	
	/** 
	 * 操作
	 * <><><><><><><><><><><><><>
	 */
	 
	 /*保存文件*/
	 function go_save_team()
	 {
		 $uid = $this->logid;  //记录操作团队的用户id
		 $classid = 2;  //0工人，1雇主，2为团队
		 //接收参数
		 $data['name'] = noHtml($this->input->post('name'));
		 $data['mobile'] = is_num($this->User_Model->mobile($uid));
		 $data['password'] = pass_user('******'.$data['mobile']);
		 //$data['photoID'] = is_num($this->input->post('photoID'));
		 $data['p_id'] = is_num($this->input->post('p_id'));
		 $data['c_id'] = is_num($this->input->post('c_id'));
		 $data['a_id'] = is_num($this->input->post('a_id'));
		 $data['address'] = noHtml($this->input->post('address'));
		 $data['note']    = noHtml($this->input->post('note'));
		 $data['team_ckbj'] = noHtml($this->input->post('team_ckbj'));
		 $data['team_fwxm'] = noHtml($this->input->post('team_fwxm'));
		 $data['team_fwdq'] = noHtml($this->input->post('team_fwdq'));
		  
		 //分析数据
		 if($data['name']==''){ json_form_no('团队名称不能为空!'); }
		 if($data['p_id']==false||$data['c_id']==false){ json_form_no('请选择所在省市!'); }
		 if($data['address']==''){ json_form_no('请填写详细地址!'); }
		 if($data['note']==''){ json_form_no('请填写团队简介!'); }
		 if($data['team_fwxm']==''){ json_form_no('请填写服务项目!'); }
		 if($data['team_fwdq']==''){ json_form_no('请填写服务地区!'); }
		 if($data['team_ckbj']==''){ json_form_no('请填写参考报价!'); }

		 $TD_ok=false; //判读赠送团队创建者的条件是否满足
		 if($data['name']!=""&&$data['p_id']&&$data['c_id']&&$data['address']!=""&&$data['note']!=""&&$data['team_ckbj']!=""&&$data['team_fwxm']!=""&&$data['team_fwdq']!=""){ $TD_ok=true; }
		  
		 //判断是否已经创建该团队
		 $rsnum = $this->db->query("select id from `user` where uid=$uid and classid=$classid")->num_rows();
		 if($rsnum>0){
			 //更新数据
			 $this->db->where('uid', $uid);
			 if($this->db->update('user',$data)){
				 json_form_yes('更新成功!'); /*.is_presented($TD_ok)*/
			 }else{
				 json_form_no('更新失败!');
			 }
		 }else{
			  //写入数据
			  $data['qq']  = '0';
			  $data['sex'] = '0';
			  $data['email'] = '0';
			  $data['identity'] = '0';
			  $data['visited']  = '0';
			  //$data['serial_id'] = 'tg_team';
			  $data['addtime'] = dateTime();
			  $data['classid'] = 2;
			  $data['uid'] = $uid;
			  if($this->db->insert('user',$data)){ json_form_yes('创建成功!'); }else{ json_form_no('创建失败!'); }
		 }
	 }
	 
	 
	/*活动期间,完成团队信息后可以获取赠送金币*/
	function teamok2gift()
	{
		$uid = is_num($this->tid);
		if($uid){ activity_teamok_2gift($uid); }
	}	 
	


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
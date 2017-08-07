<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_approve extends XT_Controller {
	
	public $data;  //用于返回页面数据
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $data 数据前加载*/
		
		//基础数据
		$this->data  = $this->basedata();
		
		$this->load->model('Approve_Model');
		$this->load->model('Introduce_Model');
		
		$this->data['table_title'] = '身份认证';
	}
	
	//<><><><><><><><><><><><><><><><><><>
	//@@@@@@@@@@@ 管理页面 @@@@@@@@@@@@@@@@
	//<><><><><><><><><><><><><><><><><><>
	function index()
	{
		//分页模型
		$this->load->model('Paging');
		//收支记录模型
		$this->load->model('Records_Model');
		
		
		//<><><>管理页面操作,更改状态(go)
		$id = is_num($this->input->get('id'));
		$cmd = $this->input->get('cmd');
		if($cmd!=''&&$id){
			$ok = '';
			$errtip = '';
			//-----------------------------------
			if($cmd=="yes"){
				$ok = 1; /*审核通过的信息*/
			}elseif($cmd=="no"){
				$ok = 2; /*审核不通过的信息*/
				$errtip = noHtml($this->input->get('errtip'));
			}
			//-----------------------------------
			if(is_num($ok)){
				
				if($ok==2&&$errtip==''){
					json_echo('');  //操作无效
				}else{
					$data['ok'] = $ok;
					$data['errtip'] = $errtip;
					$this->db->where("ok",0);
					$this->db->where("id",$id);
					$this->db->update('yz_sm',$data);
					$this->user_ok($id,$ok);	
				}
			}
		}
		

		//判断搜索
		$keysword = noSql($this->input->get('keysword'));
		$this->data['keysword'] = $keysword;
		if($keysword!=''){
			$keyswordSql = "(truename like '%".$keysword."%' or sfz like '%".$keysword."%')";
		}
	 
		//<><><>管理页面操作(end)


		//返回相应的sql
		$key_sql = ''; //初始化该变量
		//无分类筛选
		if(!empty($keyswordSql)){ $key_sql = " where ".$keyswordSql; }
		$listsql = "select * from yz_sm".$key_sql.' order by id desc';
		
		//获取列表数据
		$this->data["list"] = $this->Paging->show($listsql,10);
		$this->data["page"] = $this->input->get('page');
		
		$this->load->view_system('user_approve/manage',$this->data);
	}
	
	
	
	//修改用户信息，设置为已通过状态
	function user_ok($id=0,$t=0){
		$id = is_num($id);
		$t = is_num($t);
		if($id&&$t){
			$rs = $this->db->query("select uid from yz_sm where id=$id limit 1")->row();
			if(!empty($rs)){
				$thisuid = is_num($rs->uid);
				if($thisuid)
				{
					$this->db->query("update user set approve_sm=".$t." where id=$thisuid");
				}
			}
		}
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
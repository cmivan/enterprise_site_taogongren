<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends QT_Controller {
	
	public $data;  //用于返回页面数据
	public $logid = 0;
	public $rating_class;
	
	function __construct()
	{
		parent::__construct();

		/*初始化加载application\core\MY_Controller.php
		这里的加载必须要在产生其他 $this->data 数据前加载*/

		//基础数据
		$this->data = $this->basedata();
		//初始化用户id
		$this->logid = $this->data["logid"];
		
		$this->load->model('Rating_Model');
		$this->load->model('Orders_Model');
		$this->load->model('Common_Model');
		
		//rating_class,不用身份则显示不用的评价信息
		$user_classid = $this->data['classid'];
		if($user_classid==0)
		{
			$this->rating_class = $this->Rating_Model->rating_class(1);
		}elseif($user_classid==1){
			$this->rating_class = $this->Rating_Model->rating_class(0);
		}
	}
	
	
	//限定提交的标识范围
	function checkkeys($T='')
	{
		switch($T){
			case 'od':
			case 'os':
			case 'op':
			case 'ca':
			  return true;
			break;
		}
		echo '服务器繁忙,请稍后再试!'; exit;
	}
	
	
	//添加评分
	function add($T='0')
	{
		//检测提交的标识是否符合范围
		$this->checkkeys($T);

		$id  = $this->input->get('id');
		$keyid = is_num($id,'404');
		
		//当前操作用ID
		$uid = $this->logid;

		$this->data['e_id'] = '';
		$this->data['e_note'] = '';
		$this->data['e_haoping'] = '';
		
		$this->data['keyid'] = $keyid;
		$this->data['r_content'] = '';
		$this->data['r_uid'] = '';
		
		$this->data['key'] = '';
		$this->data['show_tab'] = false; //是否显示tab按钮

		switch($T)
		{
			case 'od': //上门单评价
			   $this->data['show_tab'] = true; //显示tab按钮
			   $this->order_door($keyid);
			   break;
			   
			case 'os': //简化单评价
			   $this->data['show_tab'] = true; //显示tab按钮
			   $this->order_simple($keyid);
			   break;
			   
			case 'op': //工程单评价
			   $this->data['show_tab'] = true; //显示tab按钮
			   $this->order_project($keyid);
			   break;
			   
			case 'ca': //案例评价
			
			   //用于防止非法提交案例评分
			   $this->data['key'] = $this->input->get('key');
			   $uid = $keyid;
			   $this->rating_class = $this->Rating_Model->rating_class(0);
			   break;
		}
		
		//对方用户ID
		$uid_2 = is_num($this->data['r_uid'],0);
		
		//判断当前用户身份,获取对方用户的信息并显示
		if($uid_2&&$uid_2==$uid){ $uid_2 = $this->data['r_uid_2']; }
		
		//返回用户连接按钮
		$this->data['r_user_links'] = $this->User_Model->links($uid);
		
		//用于判断是否查看对方给出的评论
		$this->data['cmd'] = $this->input->get('cmd');
		if($this->data['cmd']=='tab'){
			
			#@获取并返回该订单是否被评分(已被评分，则显示)
			$row = $this->Common_Model->user_evaluate_one($keyid,$uid_2,$T);
			if($row){
				$this->data['e_id'] = $row->id;
				$this->data['e_note'] = $row->note;
				$this->data['e_haoping'] = $row->haoping;
				$scorarr = $row->scorarr;
				$this->data['e_scorarr'] = $this->Common_Model->rating_scor2arr($scorarr);
				}
			
			//登录用户查看对方给出的评分时，应该显示
			$this->data['r_user_links'] = $this->User_Model->links($uid_2);
			
			//tab切换按钮
			$this->data['common_tab'][0] = '';
			$this->data['common_tab'][1] = ' on';
			
			//需要切换星号类型才可以正常显示对方的星号评分
			$user_classid = $this->data['classid'];
			if($user_classid==0){
				$this->rating_class = $this->Rating_Model->rating_class(0);
			}elseif($user_classid==1){
				$this->rating_class = $this->Rating_Model->rating_class(1);
			}
			
		}else{
			
			#@查看是否已经对该订单进行评分(已评分，则显示)
			$row = $this->Common_Model->user_evaluate_one($keyid,$uid,$T);
			if($row){
				$this->data['e_id'] = $row->id;
				$this->data['e_note'] = $row->note;
				$this->data['e_haoping'] = $row->haoping;
				$scorarr = $row->scorarr;
				$this->data['e_scorarr'] = $this->Common_Model->rating_scor2arr($scorarr);
				}
			//tab切换按钮
			$this->data['common_tab'][0] = ' on';
			$this->data['common_tab'][1] = '';	
		}
		
		//输出星号评分类型
		$this->data['rating_class'] = $this->rating_class;
		
		//表单配置
		$this->data['formTO']->url = 'common/save/'.$T;
		$this->data['formTO']->backurl = '';
		
		$this->load->view('common/index',$this->data);
		
	}
	

	//获取上门单信息
	function order_door($id=0)
	{
		$this->logid = is_num($this->logid,'404');
		$id = is_num($id,'404');
		$row = $this->Orders_Model->order_doors($id,$this->logid);
		if($row){
			//$this->data['keyid'] = $id;
			$this->data['r_uid'] = $row->uid;
			$this->data['r_uid_2'] = $row->uid_2;
			$this->data['r_content'] = cutstr($row->note,35)."..."; 
		}
	}
	
	
	//获取简化单信息
	function order_simple($id=0)
	{
		$this->logid = is_num($this->logid,'404');
		$id = is_num($id,'404');
		$row = $this->Orders_Model->order_simples($id,$this->logid);
		if($row){
			//$this->data['keyid'] = $id;
			$this->data['r_uid'] = $row->uid;
			$this->data['r_uid_2'] = $row->uid_2;
			$this->data['r_content'] = cutstr($row->note,35)."..."; 
		}
	}

	//获取工程单信息
	function order_project($id=0)
	{
		$this->logid = is_num($this->logid,'404');
		$id = is_num($id,'404');
		$row = $this->Orders_Model->order_projects($id,$this->logid);
		if($row){
			$this->data['r_uid'] = $row->uid;
			$this->data['r_uid_2'] = $row->uid_2;
			$this->data['r_content'] = cutstr($row->note,35)."...";
		}
	}
	
	

	
	
	
	
	
	
	//保存评分信息
	function save($T='0')
	{
		//检测提交的标识是否符合范围
		$this->checkkeys($T);
		
		//获取参数
		$keyid = is_num($this->input->post('keyid'));
		$haoping = $this->input->post('hp_scor');
		$note = noHtml($this->input->post('note'));

		switch($T)
		{
			case 'od': //上门单评价
			   //{ 上门单的步骤有点特殊，这部分程序延后再写 }
			
			   //防止未完成订单的非法提交评分
			   if( $this->Orders_Model->order_door_stat($keyid)==false )
			   {
				    json_form_no('服务器繁忙,请稍后再试!'); 
			   }
			   
			   //获取订单的基本信息
			   $this->order_door($keyid);
			   //获取对方用户ID
			   $uid_2 = $this->data['r_uid_2'];
			   if($uid_2==$this->logid){ $uid_2 = $this->data['r_uid']; }
			   
			   break;
			   
			case 'os': //简化单评价
			
			   //防止未完成订单的非法提交评分
			   if( $this->Orders_Model->order_simple_stat($keyid)==false )
			   {
				    json_form_no('服务器繁忙,请稍后再试!'); 
			   }
			   
			   //获取订单的基本信息
			   $this->order_simple($keyid);
			   //获取对方用户ID
			   $uid_2 = $this->data['r_uid_2'];
			   if($uid_2==$this->logid){ $uid_2 = $this->data['r_uid']; }

			   break;
			   
			case 'op': //工程单评价
			
			   //防止未完成订单的非法提交评分
			   if( $this->Orders_Model->order_project_stat($keyid)==false )
			   {
				    json_form_no('服务器繁忙,请稍后再试!'); 
			   }
			   
			   //获取订单的基本信息
			   $this->order_project($keyid);
			   //获取对方用户ID
			   $uid_2 = $this->data['r_uid_2'];
			   if($uid_2==$this->logid){ $uid_2 = $this->data['r_uid']; }
			   
			   break;
			   
			case 'ca': //案例评价
			
			   //防止非法提交案例评分
			   $key = $this->input->post('key');
			   if($key!=case_hash($keyid)){ json_form_no('服务器繁忙,请稍后再试!'); }
			   //在这里是代表案例ID
			   $this->logid = $keyid;  
			   //在这里是代表业主ID(虚拟的)
			   $uid_2 = $keyid;
			   $this->rating_class = $this->Rating_Model->rating_class(0);
			   break;
		}
		
		//验证是否正确获取对方用于ID
		if(is_num($uid_2)==false){ json_form_no('未找到相应的订单信息!'); }
		
		
		
		//查看是否已经对该订单进行评分
		$row = $this->Common_Model->user_evaluate_one($keyid,$this->logid,$T);
		if(!empty($row)){ json_form_no('你已经对该订单评分,请不要重复提交!'); }
		
		//数据处理
		if($keyid==false){ json_form_no($this->lang->line('system_tip_busy')); }
		//限定评分范围
		$haoping = $this->Common_Model->rating_haoping($haoping);
		//返回星级评分数组
		$scorarr = $this->Common_Model->rating_scorarr($this->rating_class);
		if($note==''){ json_form_no('请填写评分内容!'); }

		//写入评分及星级评分
		$this->Common_Model->evaluate_add($keyid,$this->logid,$uid_2,$note,$haoping,$scorarr,$T);
		//发送通知
		
		//返回提示
		json_form_yes('提交成功!');
	}
	 
	 
	 


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends QT_Controller {

	public $user;
	public $uid = 0; //当前用户id
	public $Tid = 0; //当前团队id

	function __construct()
	{
		parent::__construct();

		//初始化加载模型
		$this->load->model('Industry_Model');
		$this->load->model('Records_Model');
		$this->load->model('Listing_Model');
		$this->load->model('Orders_Model');
		$this->load->model('Case_Model');
		$this->load->model('Retrieval_Model');
		$this->load->model('Recommend_Model');
		$this->load->model('Recruitment_Model');
		$this->load->model('Skills_Model');
		$this->load->model('Friends_Model');
		$this->load->model('Evaluate_Model');
		$this->load->model('Common_Model');
		$this->load->model('GetMobile_Model');
		
		
		/*<><><>css样式<><><>*/
		#评级打分
		$this->data['cssfiles'][] = 'style/mod_star.css';
		#排期日历
		$this->data['cssfiles'][] = 'js/fullcalendar/fullcalendar.css';
		#LightBox v2.0
		#$this->data['cssfiles'][] = 'style/screen.css';
		$this->data['cssfiles'][] = 'style/mod_lightbox.css';

		/*<><><>Js<><><>*/
		#团队按钮
		$this->data['jsfiles'][]  = 'js/team_buttom.js';
		#手机动画绑定
		$this->data['jsfiles'][]  = 'js/mobile_movement.js';
	}


	function info($uid=0)
	{
		//检测id不符合则返回404页面
		$this->uid = get_num($uid,'404');
		$this->data['uid'] = $this->uid;

		#访问累计
	    $this->User_Model->visite($this->uid);
		/*获取用户信息*/
		$this->user = $this->User_Model->info($this->uid);

		/*获取用户创建的团队*/
	    if( !empty($this->user) )
		{
			$this->data["user"] = $this->user;
			/*判断用户类型*/
			switch($this->user->classid)
			{
				case 0: #工人
				$this->user_worker(); break;
				case 1: #业主
				$this->user_employer(); break;
				case 2: #团队/企业
				if( $this->User_Model->is_company_user($uid) == false )
				{
					//团队
					$this->user_team($uid); break;
				}
				else
				{
					//跳转到企业页面
					redirect('/company/'.$uid, 'location', 301);
					break;
				}
			}
	    }
		else
		{
			show_404('/index' ,'log_error');
	    }
	}
	
	
	
	
	/*判断用户是否已经加入团队，团队成员人数*/
	function user_get_team()
	{
		$is_login = get_num($this->logid);
		if($is_login)
		{
			if($this->uid==$this->logid)
			{
				$this->data['is_teamer'] = true;
			}
			if( $this->data['is_teamer'] == false )
			{
				//判断是否已加入群
				if( $this->User_Model->is_team_user($this->Tid,$this->logid) )
				{
					$this->data['is_teamer'] = true;
					$this->data['team_num'] = $this->User_Model->team_num($this->Tid);
				}
			}
		}	
	}
	
	
	/*工人个人页面*/
	function user_worker()
	{
		//获取该用户创建的团队id
		$this->uid = get_num($this->uid,'404');
		$this->Tid = $this->User_Model->one2team_id($this->uid);
		$this->data["Tid"] = $this->Tid;	

		//判断是否为团队成员
		$this->data['team_num'] = 0;
		$this->data['is_teamer'] = false;
		
		//用户级别
		$this->data['level'] = $this->Evaluate_Model->level_sroc( $this->uid );

		//判断用户是否有加入团队或创建团队
		$this->user_get_team();

		//SEO设置
		$this->data['seo']['title']  = '淘工人信息,全国装修工人大本营 淘工人网!';
		$this->data['seo']['keywords'] = '招聘,求职,找装修工人,找室内设计师!';
		$this->data['seo']['description'] = '全国各地最新的招聘、求职、招标等信息!高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';

		//左边模块
		$this->user_worker_left();
		//右边模块
		$this->user_worker_right();
		//输出到视窗
		$this->load->view('user/worker',$this->data);
	}
	
	
	
	/*团队页面*/
	function user_team($Tid=0)
	{
		//获取该用户创建的团队id
		$this->uid = get_num($this->uid,'404');

		$this->Tid = get_num($Tid,'404');
		$this->data["Tid"] = $this->Tid;	

		//判断是否为团队成员
		$this->data['is_teamer'] = false;
		$this->data['team_num'] = 0;
		
		//用户级别
		$this->data['level'] = $this->Evaluate_Model->level_sroc( $this->uid );

		//判断用户是否有加入团队或创建团队
		$this->user_get_team();

		//左边模块
		$this->user_worker_left();
		//右边模块
		$this->user_worker_right();
		//输出到视窗
		$this->load->view('user/team',$this->data);
	}
	
	
	
	/*企业页面*/
	function user_company($Tid=0)
	{
		//获取该用户创建的团队id
		$this->uid = get_num($this->uid,'404');

		$this->Tid = get_num($Tid,'404');
		$this->data["Tid"] = $this->Tid;	

		//判断是否为团队成员
		$this->data['is_teamer'] = false;
		$this->data['team_num'] = 0;
		
		$this->data['base_page_url'] = 'user/'.$Tid.'/';

		//输出到视窗
		$this->load->view('user/company',$this->data);
	}


	
	
	/*工人案例页面*/
	function cases($id=0)
	{
		$this->load->model('Common_Model');
		
		//检测id 不符合则返回404页面
		$id = get_num($id,'404');
		$this->data["id"] = $id;

		//id有效则根据案例id 返回相应的用户id
		$uid = $this->Case_Model->case_uid($id);
		$this->uid = get_num($uid,'404');
		
		//获取该用户创建的团队id
		$this->Tid = $this->User_Model->one2team_id($this->uid);
		$this->data["Tid"] = $this->Tid;

		//判断是否为团队成员
		$this->data['is_teamer'] = false;
		$this->data['team_num'] = 0;
		
		//用户级别
		$this->data['level'] = $this->Evaluate_Model->level_sroc( $this->uid );

		//判断用户是否有加入团队或创建团队
		$this->user_get_team();

		/*获取用户信息*/
		$this->user=$this->User_Model->info($this->uid);
	    if(!empty($this->user))
		{
		   $this->data["user"] = $this->user;
	    }
		else
		{
		   show_404('/index' ,'log_error');
	    }

		//加载左边模块信息
		$this->user_worker_left();
		//获取右边案例信息
		$view = $this->Case_Model->view($id,$this->uid,0);
		if(empty($view))
		{
			$view = $this->Case_Model->view($id,$this->uid,2);
		}
		if(empty($view))
		{
			show_404('/index' ,'log_error');
		}
		$this->data["view"] = $view;
		

		//是否显示评论框或者显示评论内容
		$allow_id = get_num($this->session->userdata('allow_comm_id'));
		if($allow_id&&$allow_id==$id)
		{
			$this->data["allow_comm"] = true;
		}
		else
		{
			$this->data["allow_comm"] = false;
		}
		
		//案例评论的提交按钮
		$this->data['cssfiles'][] = 'style/edit_main.css';

		//输出到视窗
		$this->load->view('user/worker_case_view',$this->data);
	}
	
	
	
	
	/*求职/求职详细页面*/
	function recruitment($id=0)
	{
		//检测id 不符合则返回404页面
		$id = get_num($id,'404');
		//id有效则根据案例id 返回相应的用户id
		$uid = $this->Recruitment_Model->recruitment_uid($id);
		$this->uid = get_num($uid,'404');
		
		//获取该用户创建的团队id
		$this->Tid = $this->User_Model->one2team_id($this->uid);
		$this->data["Tid"] = $this->Tid;

		//判断是否为团队成员
		$this->data['is_teamer'] = false;
		$this->data['team_num'] = 0;
		
		//用户级别
		$this->data['level'] = $this->Evaluate_Model->level_sroc( $this->uid );

		//判断用户是否有加入团队或创建团队
		$this->user_get_team();

		/*获取用户信息*/
		$this->user=$this->User_Model->info($this->uid);
	    if(!empty($this->user))
		{
		   $this->data["user"] = $this->user;
	    }
		else
		{
		   show_404('/index' ,'log_error');
	    }

		//加载左边模块信息
		$this->user_worker_left();
		//点击文章
		$this->Recruitment_Model->visite($id);
		//获取详情
		$this->data["view"] = $this->Recruitment_Model->view($id,$this->uid);
		$view = $this->data["view"];
		if(!empty($view))
		{
			//SEO设置
			$this->data['seo']['title']  = $view->title.' 全国装修工人大本营 淘工人网!';
			$this->data['seo']['keywords'] = '招聘、求职信息,找工人,找装修工人,找室内设计师!';
			$this->data['seo']['description'] = cutstr($view->content,35).',全国各地最新的招聘、求职、招标等信息!高效对接的平台,通过海量的在线工人与即时的装修信息,帮业主省钱,帮工人赚钱,让天下没有难找的工人!';
			
			if($view->type_id==1)
			{
				$this->load->view('user/worker_recruitment_zp_view',$this->data);
			}
			elseif($view->type_id==2)
			{
				$this->load->view('user/worker_recruitment_qz_view',$this->data);	
			}	
		}
	}
	
	
	
	/*工人页面-左边模块信息*/
	function user_worker_left()
	{
		$this->data["approves"] = $this->User_Model->approves($this->uid); /*用户认证图标*/
		$this->data["credits"]  = $this->Records_Model->credits($this->uid); /*累积信用金*/
		$this->data["balances"] = $this->Records_Model->balances($this->uid); /*总计收入*/
		$this->data["jobtimes"] = $this->Orders_Model->order_oks($this->uid); /*揽活次数*/

		if(!empty($this->logid)&&($this->logid==$this->uid))
		{
		   //显示创建按钮
		   $this->data["nicetitle"] = "我";
		   $this->data["team_but"]  = 2; 
		}
		else
		{
		   //未创建
		   $this->data["nicetitle"] = "他";
		   $this->data["team_but"]  = 0;
		}
		/*获取团队id*/
		$Tid = $this->Tid;
		//已创建
		if(is_num($Tid))
		{
			$this->data["team_but"] = 1;
		}		
		/*评分类型*/
		$this->data["rating_class"] = $this->Evaluate_Model->rating_class(0);
		/*评分率*/
		$this->data["haoping_sroc"] = $this->Evaluate_Model->haoping_sroc( $this->uid );
		/*好友信息*/
		$this->data["friend1"] = $this->Friends_Model->User_Friends1($this->uid);
		$this->data["friend2"] = $this->Friends_Model->User_Friends2($this->uid);


	}
	
	
	
	/*工人页面-右边模块信息*/
	function user_worker_right()
	{
		/*用户技能总数*/
		$this->data["skills_count"] = $this->Industry_Model->skills_count($this->uid);
		
		/*用户擅长工种*/
		$goodat_industrys = $this->Industry_Model->goodat_industrys($this->uid);
		$this->data["goodat_industrys"] = $this->Industry_Model->industrys_helper( $goodat_industrys );
		
		/*用户擅长项目种类*/
		$this->data["goodat_classes"]   = $this->Industry_Model->goodat_classes($this->uid);
		/*用户手机遮罩*/
		$ispay = $this->GetMobile_Model->is_getok($this->logid,$this->uid);
		$this->data["mobile_mark"] = mobile_mark($this->user->mobile,$this->uid,$this->logid,$ispay);

		$this->data["evaluate"]  = $this->Evaluate_Model->User_Evaluate($this->uid);    /*雇主评价*/
		$this->data["skills"]    = $this->Skills_Model->user_skill_prices($this->uid);        /*参考报价*/
		$this->data["cases"]     = $this->Case_Model->User_Case($this->uid,1);          /*案例展示*/
		$this->data["zhengshu"]  = $this->Case_Model->User_Case($this->uid,2);          /*资质证书*/
		$this->data["listing"]   = $this->Listing_Model->User_Listing($this->uid);      /*最近排期*/
		$this->data["recommend"] = $this->Recommend_Model->User_Recommend($this->uid);  /*他的推荐*/
		$this->data["retrieval"] = $this->Retrieval_Model->User_Retrieval($this->uid);  /*他的投标*/

	}
	

	
	
	/*业主页面*/
	function user_employer()
	{
		//获取业主发布最新的信息ID,然后跳转
		$zb_new = $this->Retrieval_Model->zb_new_id($this->uid);
		if(!empty($zb_new))
		{
		   redirect('/retrieval/view/'.$zb_new->id, 'location', 301);
		}
		else
		{
		   show_404('/index' ,'log_error');
		}
	}
	
	
	
	

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
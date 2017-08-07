<?php $this->load->view('public/header'); ?><script language="javascript" type="text/javascript">
$(function(){
    <?php /*?>初始化、绑定右边工人tab事<?php */?>
	$(".recommendbox .tab_top").find("a").eq(0).attr("class","on");
	$(".recommendbox").find(".tab").eq(1).css({display:"block"});
	$(".box table").css({"display":"none"});
	$(".box table").eq(0).css({"display":""});
	$("#help_but a").eq(0).css({"color":"#f90"});
	<?php /*?>帮助页面<?php */?>
	$("#help_but a").click(function(){
		var thisid=$(this).attr("id");
		$(".box table").fadeOut(100);
		$("#page_"+thisid).fadeIn(100);
		$("#help_but a").css({"color":""});
		$(this).css({"color":"#f90"});
		$(".box table").css({"display":"none"});
		$("#page_"+thisid).css({"display":""});
		});
   $("#ok").click(function(){
      var ok=$("#ok").attr("checked");
      if(ok){$("#go").attr("disabled",false);}else{$("#go").attr("disabled",true);}
	  });
   $("#go").click(function(){window.location.href="<?php echo site_url('reg');?>";});
 });</script>
</head>
<body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><div class="index_left"> <div class="box"><table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_1_1"><tr><td valign="top" class="page_main_title"><div>管理</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">

    <b>如何查找装修任务？</b><br />
    点击页面右上角&ldquo;淘信息&rdquo;图标，进入信息列表页，选择城市、区域，通过任务类型，任务描述，项目类别，需求工种，预计费用，剩余时间等条件来筛选你感兴趣的信息。</p>
    <p><b>如何参与任务投标？</b><br />
      在筛选的任务信息列表，点击任务标题进入雇主发布的当前任务查看详细，点击&ldquo;参与投标&rdquo;，勾选任务相关信息，提交即可参与任务。</p>
    <p><b>如何修改个人信息？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;个人信息&rdquo;，即可对个人的基本信息进行修改。</p>
    <p><b>如何添加擅长工种、技能？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;擅长工种&rdquo;，点击右侧&ldquo;修改&rdquo;，在不同工种下即可选择添加项目技能。</p>
    <p><b>如何查看我的订单信息？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;订单信息&rdquo;，即可以查看雇主下的订单详情。</p>
    <p><b>如何添加参考报价？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;擅长工种&rdquo;，点击某个项目，即可添加相应的参考报价。</p>
    <p><b>如何添加案例展示？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;案例展示&rdquo;，即可添加或者管理您以往的成功案例，好的案例会为您赢得雇主的认可，增加中标几率。</p>
    <p><b>如何添加最近排期？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;最近排期&rdquo;，点击添加，选择日期，可以添加您最近一段时间的事项安排，让清楚了解你的雇主空闲时间。</p>
    <p><b>如何添加资质证书？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;资质证书&rdquo;，即可上传添加个人的资质证书和说明，为自己加分哦。</p>
    <p><b>什么是我的推荐？如何管理？</b><br />
      你可以在自己的个人主页对好友或团队进行推荐展示。<br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;我的推荐&rdquo;，可以修改推荐备注信息，或者取消推荐。</p>
    <p><b>如何添加好友？如何推荐好友？</b><br />
      登录网站后，在会员个人页面，点击添加图标可以将该会员加为好友。<br />
      进入管理中心&shy;，切换到&ldquo;我的好友&rdquo;，即可对未推荐好友进行推荐操作。</p></td></tr>
  </table>
  
<table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_1_2"><tr><td valign="top" class="page_main_title"><div>评价</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>如何对雇主进行评价？</b><br />
      在任务完成后，工人可以对雇主进行评价。包括信用，态度，工期安排，付款速度，对外协调，开工准备以及好评打分。</p>
    <p><b>什么是开工准备评级？</b><br />
      开工准备是雇主为保障工程顺利按期开始，将作业区域、相关手续、施工所需水电等准备好。评级为1-5。</p>
    <p><b>什么是对外协调评级？</b><br />
      对外协调是雇主为保障工程顺利按期开始，负责协调邻里及管理机构之间的关系。评级为1-5。</p>
    <p><b>什么是工期安排评级？</b><br />
      工期安排评级是雇主对工期安排的合理程度的评价，评级为1-5。</p>
    <p><b>什么是付款速度评级？</b><br />
      付款速度是雇主按照约定，在工人完成某一阶段任务时，给予确认并将约定的任务金额打入工人帐户的时间长短。评级为1-5。</p>
    <p><b>什么是雇主信用评级？</b><br />
      雇主信用是指工人对雇主在下单给工人之后到工人完成全部约定任务的时间段内，所形成的信任度的评价，评级为1-5。</p>
    <p><b>什么是雇主态度评级？</b><br />
      雇主态度评级是工人对雇主在施工过程中所表现出来的合作态度的评价，评级为1-5。</p></td></tr>
  </table>
  
<table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_1_3"><tr><td valign="top" class="page_main_title"><div>收入</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>信用金是什么？如何累积？</b><br />
      信用金是工人为了提高自己的信任级别而暂时缴纳的一部分收入所得，不同工种有不同的额度，信用金从每笔订单所得收入中由系统按5%扣缴，缴满定额之后，系统不再扣除。</p>
    <p><b>信用金保存在哪里？如何查看？</b><br />
      信用金作为工人收入的一部分，保存在工人的个人帐户下，可以登录管理中心，我的钱包查看，也可以在工人主页查看。</p>
    <p><b>信用金可以提现么？如何提现？</b><br />
      信用金作为工人收入的一部分，同样可以提现的。提现需要联系我们的客服，由客服帮您办理，同时会注销在淘工人网的帐号。只有在你承接的所有订单服务的保修期到期以后，才可以办理信用金提现。</p>
    <p><b>如何查看我的收入？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;我的钱包&rdquo;，即可查看我的收入明细。</p>
    <p><b>收入可以提现么？</b><br />
      工人在本网站上完成雇主订单所获得的收入归工人所有，淘工人网站收取工程费用的10%作为平台服务费，其余部分打入工人帐户，收入可以提现。</p>
    <p><b>我的收入如何提现？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;我的钱包&rdquo;，点击&ldquo;提现&rdquo;，填写金额，提交后等待淘工人网站打款即可。收款人姓名需要与你在淘工人网注册填写的姓名一致。</p>
    <p><b>什么是亲情帐户？有什么用？</b><br />
      淘工人网站允许会员（仅工人）绑定一个银行帐号作为一个亲情帐户，通过验证后，工人可以将自己的收入通过淘工人网站，免费汇款给自己家人。</p>
    <p><b>亲情帐户如何申请汇款？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;我的钱包&rdquo;，点击&ldquo;转账&rdquo;，填写金额，汇款帐号已经受款人姓名，提交后等待淘工人网站打款即可。受款人姓名需要与你在提交的银行帐号的户主姓名一致。</p></td></tr>
  </table>

<!--雇主--><table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_2_1"><tr><td valign="top" class="page_main_title"><div>管理</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
    <b>如何修改个人信息？</b><br />
    登录网站后，进入管理中心&shy;，切换到&ldquo;个人信息&rdquo;，即可对个人的基本信息进行修改。</p>
    <p><b>如何发布装修任务？</b><br />
      登录网站后，进入&ldquo;管理中心&rdquo;，切换到&ldquo;发布任务&rdquo;菜单下，选择地点，任务类型、装修类别、需求工种，以及标题、费用、时间、描述等，然后提交即可。</p>
    <p><b>如何为任务项目付款？</b><br />
      你可以通过淘工人指定的帐号汇款给我们，在工程任务进行期间，款项由淘工人代为保管，并按照雇主与工人双方设定好的付款方式，在雇主分段确认之后，打入工人帐户。</p>
    <p><b>如何找到合适的工人？</b><br />
      在&ldquo;找工人&rdquo;页面，你可以按地区，按类型，按工种，按项目，按等级，按年限等等多种条件来检索出符合条件的工人列表，然后可以点击查看工人主页详细了解。</p>
    <p><b>&ldquo;收藏&rdquo;按钮有什么用？</b><br />
      在工人列表页面下的&ldquo;收藏&rdquo;按钮可以将工人放入你的收藏夹，进入管理中心，&ldquo;我的收藏&rdquo;即可以查看。</p>
    <p><b>&ldquo;雇佣&rdquo;按钮有什么用？</b><br />
      在工人列表页面下的&ldquo;雇佣&rdquo;按钮可以使你直接下单给工人，你还可以在管理中心，&ldquo;我的收藏&rdquo;中点击&ldquo;雇佣&rdquo;，下单给工人。</p></td></tr></table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_2_2"><tr><td valign="top" class="page_main_title"><div>评价</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>如何对工人进行评价？</b><br />
      在任务完成后，雇主可以对工人进行评价。包括信用，态度，质量，技能，工期，售后以及好评打分。</p>
    <p><b>什么是信用评级？</b><br />
      信用评级是雇主对工人在接受并完成任务订单的过程中所形成的信任度的评价，评级为1-5。</p>
    <p><b>什么是态度评级？</b><br />
      态度评级是雇主对工人在施工过程中所表现出来的服务态度的评价，评级为1-5。</p>
    <p><b>什么是质量评级？</b><br />
      质量评级是雇主对工人完成任务订单的整体评价，评级为1-5。</p>
    <p><b>什么是技能评级？</b><br />
      技能评级是雇主对工人施工过程中表现出来的技术水平的评价，评级为1-5。</p>
    <p><b>什么是工期评级？</b><br />
      工期评级是雇主对工人工期进展速度的评价，评级为1-5。</p>
    <p><b>什么是售后评级？</b><br />
工人完成任务后，在保质期内负有保证维护的义务，售后评级是雇主对此服务的评价，评级为1-5。</p></td></tr></table>
  
  <!--团队--><table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_3_1"><tr><td valign="top" class="page_main_title"><div>管理</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
    <b>什么是团队？</b><br />
    团队是网站会员（仅工人）自发创建组织的联合体，或者线下实体工程队。由不同工种、不同技能的工人组成，可以参与雇主发布的团队类型的任务投标。</p>
    <p><b>如何创建团队？ </b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;团队管理&rdquo;，点击创建团队，填写相应信息，即可完成创建。每位会员（仅工人）可以创建一个团队。 </p>
    <p><b>为什么我不能创建团队？ </b><br />
      不能创建团队，有可能是因为您已经创建了团队，目前每位会员（仅工人）可以创建一个团队。或者是您的等级不够（稍后推出）。 </p>
    <p><b>如何加入团队？</b><br />
      登录网站后，在团队页面&shy;，找到&ldquo;团队信息&rdquo;，点击申请加入，等待团队创建者批准，你就可以加入这个团队了。</p>
    <p><b>加入团队可以做什么？</b><br />
      加入团队后，可以与其他成员一起完成团队接到的订单投标，获得任务分成（分成由创建者与成员协商，淘工人网站不参与）。</p>
    <p><b>我最多可以加入几个团队？</b><br />
      工人加入团队目前没有限制，但需要经过团队创建者的批准。创建者有权取消团队成员资格。</p>
    <p><b>如何修改团队信息？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;团队管理&rdquo;， 在&ldquo;管理团队信息&rdquo;菜单下即可以对团队名称、图片、所在地区、介绍等进行修改。</p>
    <p><b>如果管理团队成员？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;团队管理&rdquo;， 在&ldquo;团队成员&rdquo;菜单下，可以进行通过成员加入申请，取消成员资格操作。</p></td></tr></table>
<table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_3_2"><tr><td valign="top" class="page_main_title"><div>自助广告</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>什么是团队自助广告？</b><br />
      团队自助广告是淘工人网站提供给团队的一种低价高效、操作简便的推广方式。团队只需编辑18字以内的推广信息，支付相应费用，便可以出现在淘工人网站首页显眼位置，接下来就是等待雇主下单啦。</p>
    <p><b>如何发布团队自助广告？</b><br />
      登录网站后，进入管理中心&shy;，切换到&ldquo;团队管理&rdquo;， 在&ldquo;发布广告&rdquo;菜单下，编辑好广告语，设置投放时间段，支付相应费用，即可完成自助广告发布。</p>
    <p><b>只有团队才可以发布自助广告吗？由谁来发布？</b><br />
      自助广告是专门为团队所设计，并且只能由团队的创建者来发布，团队成员不可以发布。</p>
  </td></tr></table>
  
  <!--帐号--><table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_4_1"><tr><td valign="top" class="page_main_title"><div>注册</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content"><b>用户注册时应了解哪些问题？</b><br />
1.雇主注册成功后，完成新手任务（发布一条装修信息），将获得系统10元赠送，可以用来查看工人的联系信息。<br />
2.查看工人联系方式每条按照1元计算。<br />
3.雇主选择好工人，成功下单，需要先把预计的工程任务款打到淘工人网站，同时加收5元服务费，没有完成下单则不收取任何费用。<br />
4.工人注册成功后，在管理中心完善个人资料，会获得系统赠送的5元奖励。<br />
5.工人在接受雇主订单，按期保质完成任务后所得收入，淘工人网站收取10%的平台费用。没有订单，则不收取任何费用。</p>
    <p><b>淘工人网站能做什么？为什么要注册成为淘工人网站会员？</b><br />
      淘工人网站（<a href="http://www.taogongren.com/">www.taogongren.com</a>）是为了方便雇主与工人之间信息流通而搭建的装修类服务平台。我们的目标是更省，更方便。<br />
      对于雇主，在淘工人网站上可以省时，省力，省钱地找到适合的工人来完成装修项目，不需要东奔西跑，在家里就可以方便地选择、比较想要找的工人，真正省心。<br />
      对于工人，在淘工人网站需要做的，仅仅是将你的资料、技能、参考报价、资质证书、以往案例等填写好，然后等待雇主下单给你，淘工人网站会自动下发短信通知你收到的订单。<br />
      工人还可以主动对雇主发布的工程信息进行投标，然后等待雇主下单，提高订单机会，自己做自己的老板，赚钱很容易。</p>
    <p><b>如何免费注册成为淘工人网站会员？</b><br />
      在淘工人网站（<a href="http://www.taogongren.com/">www.taogongren.com</a>）点击免费注册，填写相应资料，并选择验证方式通过验证，即可注册成为淘工人网站会员，享有会员权利，使用淘工人网站提供的全部服务。</p>
    <p><b>可以注销帐号吗？</b><br />
      为了保障会员账户的安全性，不能注销账号。如果您忘记该账号密码，可以通过手机或者邮箱取回。前提是您的账号必须通过手机认证或者邮箱认证。</p></td></tr></table>
 
<table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_4_2"><tr><td valign="top" class="page_main_title"><div>登录</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>登录淘工人网站的帐号是什么？</b><br />
      会员可以使用注册时填写的手机号或者邮箱登录淘工人网站。登录时请填写完整的email地址，如：&nbsp;<a href="mailto:xxxxx@gmail.com">xxxxx@gmail.com</a>&nbsp;。</p>
    <p><b>登录时为什么提示帐号或密码错误？</b><br />
      1．请确认你是否已经更换了手机号码或者邮箱。<br />
      2．请确认输入的手机号码或者邮箱是否正确，密码是否正确。<br />
      3．请确认是否打开了大写&ldquo;Caps Lock&rdquo;键。<br />
      4．如果不记得登录帐号，请参考对应帮助内容进行找回。</p>
    <p><b>忘记登录密码怎么办？</b><br />
      方式一：在淘工人网站点击忘记密码，填写已验证的手机号码，系统会下发包含验证码的短信到会员手机，按提示操作修改密码。<br />
      方式二：在淘工人网站点击忘记密码，填写已验证的邮箱，系统会下发包含修改链接的邮件到会员邮箱，按提示操作修改密码。</p>
    <p><b>忘记登录帐号怎么办？</b><br />
      忘记手机号的情况，可以通过注册邮箱登录网站，然后进入管理中心查找或者更新。<br />
      忘记邮箱的情况，可以通过注册手机号登录网站，然后进入管理中心查找或者更新。<br />
      手机号和邮箱都不记得了，请联系客服，并尽可能的提供您当时注册时留下的信息，包括注册邮箱、真实姓名、身份证号、银行卡号。如果有以上信息有注册记录，客服会帮您找回用户名。</p></td></tr></table>
  
<table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_4_3"><tr><td valign="top" class="page_main_title"><div>修改</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>注册资料可以修改吗？</b><br />
      注册成功后，会员资料可以在管理中心进行修改。<br />
      修改已经验证的手机号码和邮箱，需要重新进行验证操作。<br />
      会员姓名、性别和身份证号码经审核后，不可以再进行修改。 </p>
    <p><b>如何修改登录密码？</b><br />
      登录网站后，进入管理中心，切换到&ldquo;个人信息&rdquo;菜单下，帐号安全&mdash;修改密码即可。</p>
    <p><b>什么情况下需要修改手机号码？如何修改？</b><br />
      为了网站其他会员能够及时联系到你，如果你的手机号码已经更换，请登录淘工人网站，进入管理中心，修改绑定手机，重新验证。</p>
    <p><b>可以修改认证邮箱吗？如何修改？</b><br />
      会员可以在管理中心修改登录用的邮箱，修改后，淘工人网会给您的邮箱发送验证邮件，验证成功后，才能使用新的邮箱地址登录。</p></td></tr></table>
  
<table border="0" align="center" cellpadding="0" cellspacing="10" id="page_h_4_4"><tr><td valign="top" class="page_main_title"><div>认证</div><p class="page_main_line">&nbsp;</p></td></tr><tr><td height="400" valign="top" class="page_main_content">
      <b>什么是手机认证？没有收到验证短信怎么办？</b><br />
      验证码是用户注册时，淘工人网站发送到用户填写的手机号码的一组数字，用来确定手机号码与用户的关联性，用户在网站上填写收到的验证码并提交，即可完成验证。<br />
      如果没有收到验证短信，可能是由于网络原因或手机号码不正确，请稍等或者检查填写的手机号码。如果仍然收不到，可以选择再次发送或者切换到邮箱验证。</p>
    <p><b>什么是邮件认证？没有收到验证邮件怎么办？</b><br />
      邮件验证是淘工人网发送到用户注册邮箱的一封用来确定邮箱与用户关联性的邮件，用户登录邮箱点击邮件里的验证链接，即可完成验证。<br />
      如果没有收到验证邮件，有可能是被列为了垃圾邮件，请检查一下&ldquo;垃圾箱&rdquo;或者稍等几分钟再检查下邮箱。若10分钟后没收到确认信，可以在管理中心重发一封验证邮件。&nbsp;<br />
      <b>邮件中的认证链接提示链接地址已经失效，为什么？</b><br />
      确认邮箱认证的邮件在系统发出7天后，如果您还未点击邮件内的验证链接，此链接将会失效；所以当您提交了邮箱认证的申请后，请尽快完成邮箱验证。如果您的链接地址失效，请登录淘工人网站，在管理中心再次提交邮箱认证申请。</p>
    <p><b>什么是实名认证？如何认证？</b><br />
      实名认证就是对会员资料的真实性进行验证审核，建立完善可靠的互联网信用基础。实名认证能证明会员的真实身份，能保障所有会员的合法权益，同时也会提高自己的被信任度<br />
      登录网站后，进入管理中心，在&ldquo;个人信息&rdquo;---帐号安全下，填写身份证号码，并上传你的身份证图片，然后提交审核，审核通过即完成实名认证，点亮实名认证图标，可以增加雇主对你的信任度，提高赢单机会啊。</p></td></tr></table>
  </div>



</div>
  
  <div class="index_right"><div class="right_box">

<div class="recommendbox"><div class="tab_title">网站帮助</div><div class="clear"></div><div class="tab_box" id="help_but"><div class="tab" style="display:block; background-image:url(<?php echo $img_url;?>/ico/num2.gif);"><li><dd style="color:#999;font-weight:bold;">工人</dd></li><li><dd style="width:155px;"><a href="javascript:void(0);" id="h_1_1">管理</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_1_2">评价</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_1_3">收入</a></dd></li>
<li><dd style="color:#999;font-weight:bold;">雇主</dd></li><li>
  <dd style="width:155px;"><a href="javascript:void(0);" id="h_2_1">管理</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_2_2">评价</a></dd></li>
<li><dd style="color:#999;font-weight:bold;">团队</dd></li><li>
  <dd style="width:155px;"><a href="javascript:void(0);" id="h_3_1">管理</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_3_2">自助广告</a></dd></li>
<li><dd style="color:#999;font-weight:bold;">帐号</dd></li><li>
  <dd style="width:155px;"><a href="javascript:void(0);" id="h_4_1">注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_4_2">登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_4_3">修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" id="h_4_4">认证</a></dd></li><div class="clear"></div></div>

              </div><div class="clear"></div>
            </div>


<?php $this->load->view('public/mod_yxb');?>
       <div class="right_ad"><a href="javascript:void(0);"><img src="<?php echo $img_url;?>ads/index_ad.jpg" /></a></div> </div></div>
  
  
  <!--清除浮动--><div class="clear"></div>
  </div>
</div>

<?php $this->load->view('public/footer');?>
<?php $this->load->view('public/header'); ?>
<?php /*?>倒计时<?php */?>
<script language="javascript" src="<?php echo $js_url;?>sms_timeout.js"></script>
<script language="javascript" src="<?php echo site_url('global_v1/sms_js/reg')?>"></script>
</head><body>
<?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><div class="index_left"> <div class="box"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="10"><tr><td valign="top" class="page_main_title"><div style="float:left;">免费注册,只需10秒!</div><div style="float:right; background:none;">或者请 <a href="javascript:void(0);" class="user_login">登录</a></div></td></tr><tr><td valign="top"><div class="tipbox">请输入您的手机,以便验证注册。&nbsp;所有项都必填!&nbsp;&nbsp;</div></td></tr><tr><td height="400" valign="top" class="page_main_content"><div class="diy_form"><form class="validform">
<table border="0" cellpadding="0" cellspacing="3">

<?php if(!empty($inviterUID)&&$inviterUID){?>
<style>.iUser { font-size:14px;} .iUser img{align:top;}</style>
<tr><td colspan="3" class="iUser">您正接受用户 <?php echo $this->User_Model->links($inviterUID)?> 的注册邀请！</td></tr>
<tr><td height="1" colspan="5" class="yzpage_line"></td></tr>
<?php }?>

<tr><td><div class="val_left"></div></td><td><div class="val_center"></div></td><td><div class="val_right"></div></td></tr>
<tr><td>身份：</td><td>
<select name="classid" id="classid" datatype="select" errormsg="请选择身份！" style="width:100%;">
<?php foreach($user_types as $rs){?><option value="<?php echo $rs->id?>"> 我是<?php echo $rs->title2?> </option><?php }?>
</select></td><td><div class="validform_checktip"></div></td></tr>
<tr><td>昵称：</td><td><input type="text" name="name" class="inputxt" datatype="s2-6" nullmsg="请输入用户名！" errormsg="昵称至少2个字符,最多6个字符！" /></td><td><div class="validform_checktip">昵称至少2个字符,最多6个字符</div></td></tr><tr>
<td>手机：</td>
<td><input type="text" name="mobile" id="mobile" class="inputxt" datatype="m" ajaxurl="<?php echo site_url('action/check_mobile')?>" nullmsg="请输入手机号！" errormsg="请输入您的手机号码！" /></td><td><div class="validform_checktip">请填写您的手机号码</div></td></tr>

<tr><td>密码：</td>
<td><input type="password" name="password" class="inputxt" datatype="*6-18" plugin="passwordStrength" nullmsg="请设置密码！" errormsg="密码范围在6~18位之间,不能使用空格！" id="password" />
<?php /*?><div class="passwordStrength">密码强度： <span>弱</span><span>中</span><span class="last">强</span></div><?php */?>
</td>
<td><div class="validform_checktip">密码范围在6~18位之间,不能使用空格</div></td></tr><tr>
<td>确认密码：</td>
<td><input type="password" name="password2" class="inputxt" datatype="*" recheck="password" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！" id="password2" /></td>
<td><div class="validform_checktip">两次输入密码需一致</div></td></tr><tr>
<td>邮箱：</td>
<td><input type="text" name="email" class="inputxt" datatype="e" nullmsg="请输入您常用的邮箱！" errormsg="请输入正确的邮箱！" />
</td><td><div class="validform_checktip">请输入您常用的邮箱</div></td></tr><tr><td>现在住处：</td><td class="val_place">
  <select name="p_id" id="p_id" datatype="select" errormsg="请选择省份！" disabled>
  <?php if(!empty($provinces)){
	  foreach ($provinces as $rs){?>
  <option value="<?php echo $rs->p_id?>" ><?php echo $rs->p_name?></option>
  <?php }}?>
  </select>
  <select name="c_id" id="c_id" datatype="select" errormsg="请选择城市！" disabled >
  <?php if(!empty($citys)){
	  foreach ($citys as $rs){?>
  <option value="<?php echo $rs->c_id?>" ><?php echo $rs->c_name?></option>
  <?php }}?></select></td><td><div class="validform_checktip"></div></td></tr><tr><td>验证码：</td><td class="td30"><input name="code" type="text" class="inputxt" id="code" maxlength="4" datatype="p" nullmsg="请输入验证码！" errormsg="验证码有误！" /><label id="send_sms"><a href="javascript:void(0);">获取验证码</a></label></td><td><div class="validform_checktip">请输入验证码</div></td></tr><tr><td></td><td colspan="2"><button type="submit" class="cm_but btu_reg">&nbsp;</button></td></tr></table></form><div class="clear"></div><div style="padding-left:10px; padding-top:12px; padding-bottom:5px;"><span href="javascript:void(0);" id="reg_xieyi_title">《淘工人网服务协议》</span></div><div class="reg_xieyi">
  <h2>注册协议 </h2>
  <p><strong>淘工人网服务协议（试行）</strong> <br />
    <br />
    淘工人网（以下简称&ldquo;本网站&rdquo;）依据《淘工人网服务协议》（以下简称&ldquo;本协议&rdquo;）的规定提供服务，本协议具有合同效力。注册会员时，请您认真阅读本协议，审阅并接受或不接受本协议（未成年人应在法定监护人陪同下审阅）。 <br />
  <strong>若您已经注册为本网站会员，即表示您已充分阅读、理解并同意自己与本网站订立本协议，且您自愿受本协议的条款约束。本网站有权随时变更本协议并在本网站上予以公告。经修订的条款一经在本网站的公布后，立即自动生效。如您不同意相关变更，必须停止使用本网站。本协议内容包括协议正文及所有淘工人网已经发布的各类规则。所有规则为本协议不可分割的一部分，与本协议正文具有同等法律效力。一旦您继续使用本网站，则表示您已接受并自愿遵守经修订后的条款。</strong><br />
  <br />
  <br />
  <strong>第一条 会员资格</strong><br />
    一、 只有符合下列条件之一的自然人或法人才能申请成为本网站会员，可以使用本网站的服务。<br />
    （一）、年满十八岁，并具有民事权利能力和民事行为能力的自然人；<br />
    （二）、无民事行为能力人或限制民事行为能力人应经过其监护人的同意；<br />
    （三）、根据中国法律、法规、行政规章成立并合法存在的机关、企事业单位、社团组织和其他组织。无法人资格的单位或组织不当注册为本网站会员的，其与本网站之间的协议自始无效，本网站一经发现，有权立即注销该会员，并追究其使用本网站服务的一切法律责任。　　&nbsp;<br />
    二、 会员需要提供明确的联系地址和联系电话，并提供真实姓名或名称。 <br />
  <br />
  <br />
  <strong>第二条 会员的权利和义务</strong>&nbsp;　　<br />
    一、会员有权根据本协议及本网站发布的相关规则，利用本网站发布任务信息、查询会员信息、参加任务，在本网站社区及相关产品发布信息，参加本网站的有关活动及有权享受本网站提供的其他有关资讯及信息服务。<br />
    二、会员须自行负责自己的会员账号和密码，且须对在会员账号密码下发生的所有活动（包括但不限于发布任务信息、网上点击同意各类协议、规则、参加竞标等）承担责任。会员有权根据需要更改登录和账户提现密码。　<br />
    三、会员应当向本网站提供真实准确的注册信息，包括但不限于真实姓名、身份证号、联系电话、地址、邮政编码等。保证本网站可以通过上述联系方式与自己进行联系。同时，会员也应当在相关资料实际变更时及时更新有关注册资料。　　<br />
    四、会员不得以任何形式擅自转让或授权他人使用自己在本网站的会员帐号。<br />
    五、会员有义务确保在本网站上发布的任务信息真实、准确，无误导性。<br />
    六、会员在本网站网上发布平台，不得发布国家法律、法规、行政规章规定禁止的信息、侵犯他人知识产权或其他合法权益的信息、违背社会公共利益或公共道德的信息。<br />
    七、会员在本网站交易中应当遵守诚实信用原则，不得以干预或操纵发布任务等不正当竞争方式扰乱网上交易秩序，不得从事与网上交易无关的不当行为，不得在交易平台上发布任何违法信息。<br />
    八、会员不应采取不正当手段（包括但不限于虚假任务、互换好评等方式）提高自身或他人信用度，或采用不正当手段恶意评价其他会员，降低其他会员信用度。<br />
    九、会员承诺自己在使用本网站实施的所有行为遵守法律、法规、行政规章和本网站的相关规定以及各种社会公共利益或公共道德。如有违反导致任何法律后果的发生，会员将以自己的名义独立承担相应的法律责任。<br />
    十、会员在本网站网上交易过程中如与其他会员因交易产生纠纷，可以请求本网站从中予以协调处理。会员如发现其他会员有违法或违反本协议的行为，可以向本网站举报。<br />
    十一、会员应当自行承担因交易产生或取得的相关费用，并依法纳税。<br />
    十二、未经本网站书面允许，会员不得将本网站的任何资料以及在交易平台上所展示的任何信息作商业性利用（包括但不限于以复制、修改、翻译等形式制作衍生作品、分发或公开展示）。<br />
    十三、会员不得使用以下方式登录网站或破坏网站所提供的服务：<br />
  &nbsp;&nbsp; （一）、以任何机器人软件、蜘蛛软件、爬虫软件、刷屏软件或其它自动方式访问或登录本网站；<br />
  &nbsp;&nbsp; （二）、通过任何方式对本公司内部结构造成或可能造成不合理或不合比例的重大负荷的行为；&nbsp;<br />
  &nbsp;&nbsp; （三）、通过任何方式干扰或试图干扰网站的正常工作或网站上进行的任何活动；<br />
    十四、会员有权在同意本网站相关规则的前提下享受交易保障服务（包括但不限于保证原创、保证完成、免费修改等）。<br />
    十五、会员同意接收来自本网站的信息，包括但不限于活动信息、交易信息、促销信息等。 <br />
  <br />
  <br />
  <strong>第三条  淘工人网的权利和义务</strong>　<br />
    一、本网站仅为会员提供一个信息交流平台，是雇主发布任务需求和工人提供解决方案的一个交易市场，本网站对交易双方均不加以监视或控制，亦不介入交易的过程。<br />
    二、本网站有义务在现有技术水平的基础上努力确保整个网上交流平台的正常运行，尽力避免服务中断或将中断时间限制在最短时间内，保证会员网上交流活动的顺利进行。<br />
    三、本网站有义务对会员在注册使用本网站信息平台中所遇到的与交易或注册有关的问题及反映的情况及时作出回复。<br />
    四、本网站有权对会员的注册资料进行审查，对存在任何问题或怀疑的注册资料，本网站有权发出通知询问会员并要求会员做出解释、改正。<br />
    五、会员因在本网站网上交易与其他会员产生纠纷的，会员将纠纷告知本网站，或本网站知悉纠纷情况的，经审核后，本网站有权通过电子邮件及电话联系向纠纷双方了解纠纷情况，并将所了解的情况通过电子邮件互相通知对方；会员通过司法机关依照法定程序要求本网站提供相关资料，本网站将积极配合并提供有关资料。<br />
    六、因网上信息平台的特殊性，本网站没有义务对所有会员的交易行为以及与交易有关的其他事项进行事先审查，但如发生以下情形，<strong>本网站有权无需征得会员的同意限制会员的活动、向会员核实有关资料、发出警告通知、暂时中止、无限期中止及拒绝向该会员提供服务：</strong><br />
  &nbsp;&nbsp; （一）、会员违反本协议或因被提及而纳入本协议的相关规则；<br />
  &nbsp;&nbsp; （二）、存在会员或其他第三方通知本网站，认为某个会员或具体交易事项存在违法或不当行为，并提供相关证据，而本网站无法联系到该会员核证或验证该会员向本网站提供的任何资料；<br />
  &nbsp;&nbsp; （三）、存在会员或其他第三方通知本网站，认为某个会员或具体交易事项存在违法或不当行为，并提供相关证据。本网站以普通非专业交易者的知识水平标准对相关内容进行判别，可以明显认为这些内容或行为可能对本网站会员或本网站造成财务损失或法律责任。<br />
    七、根据国家法律、法规、行政规章规定、本协议的内容和本网站所掌握的事实依据，可以认定该会员存在违法或违反本协议行为以及在本网站交易平台上的其他不当行为，本网站有权无需征得会员的同意在本网站交易平台及所在网站上以网络发布形式公布该会员的违法行为，并有权随时作出删除相关信息、终止服务提供等处理。<br />
  <strong>八、本网站依据本协议及相关规则，可以冻结、使用、先行赔付、退款、处置会员缴存并冻结在本网站账户内的资金。</strong><br />
  <strong>九、本网站有权在不通知会员的前提下，删除或采取其他限制性措施处理下列信息：</strong>包括但不限于以规避费用为目的；以炒作信用为目的；存在欺诈等恶意或虚假内容；与网上交易无关或不是以交易为目的；存在恶意竞价或其他试图扰乱正常交易秩序因素；该信息违反公共利益或可能严重损害本网站和其他会员合法利益的。<br />
  <br />
  <strong>第四条 服务的中断和终止</strong><br />
  <strong>一、本网站可自行全权决定以任何理由 (包括但不限于本网站认为会员已违反本协议及相关规则的字面意义和精神，或会员在超过180日内未登录本网站等) 终止对会员的服务，并有权在两年内保存会员在本网站的全部资料（包括但不限于会员信息、产品信息、交易信息等）。同时本网站可自行全权决定，在发出通知或不发出通知的情况下，随时停止提供全部或部分服务。服务终止后，本网站没有义务为会员保留原账户中或与之相关的任何信息，或转发任何未曾阅读或发送的信息给会员或第三方。</strong><br />
    二、若会员向本网站提出注销本网站注册会员身份，需经本网站审核同意，由本网站注销该注册会员，会员即解除与本网站的协议关系，但本网站仍保留下列权利：<br />
  &nbsp;&nbsp; （一）、会员注销后，本网站有权在法律、法规、行政规章规定的时间内保留该会员的资料,包括但不限于以前的会员资料、交易记录等。<br />
  &nbsp;&nbsp; （二）、会员注销后，若会员注销前在本网站交易平台上存在违法行为或违反本协议的行为，本网站仍可行使本协议所规定的权利。<br />
    三、会员存在下列情况，本网站可以通过注销会员的方式终止服务：<br />
  &nbsp;&nbsp; （一）、在会员违反本协议及相关规则规定时，本网站有权终止向该会员提供服务。本网站将在中断服务时通知会员。但该会员在被本网站终止提供服务后，再一次直接或间接或以他人名义注册为本网站会员的，本网站有权再次单方面终止为该会员提供服务；<br />
  &nbsp;&nbsp; （二）、本网站发现会员注册资料中主要内容是虚假的，本网站有权随时终止为该会员提供服务；<br />
  &nbsp;&nbsp; （三）、本协议终止或更新时，会员未确认新的协议的。<br />
  &nbsp;&nbsp; （四）、其它本网站认为需终止服务的情况。<br />
  <strong>第五条 本网站的责任范围</strong>　　<br />
  <strong>当会员接受该协议时，会员应当明确了解并同意∶</strong><strong><br />
  </strong><strong>一、本网站不能随时预见到任何技术上的问题或其他困难。该等困难可能会导致数据损失或其他服务中断。本网站是在现有技术基础上提供的服务。本网站不保证以下事项∶</strong><strong><br />
  </strong><strong>&nbsp;&nbsp; </strong><strong>（一）、本网站将符合所有会员的要求。</strong><strong><br />
  </strong><strong>&nbsp;&nbsp; </strong><strong>（二）、本网站不受干扰、能够及时提供、安全可靠或免于出错。</strong><strong><br />
  </strong><strong>&nbsp;&nbsp; </strong><strong>（三）、本服务使用权的取得结果是正确或可靠的。</strong><strong><br />
  </strong><strong>二、是否经由本网站下载或取得任何资料，由会员自行考虑、衡量并且自负风险，因下载任何资料而导致会员电脑系统的任何损坏或资料流失，会员应负完全责任。希望会员在使用本网站时，小心谨慎并运用常识。</strong><strong><br />
  </strong><strong>三、会员经由本网站取得的建议和资讯，无论其形式或表现，绝不构成本协议未明示规定的任何保证。</strong><strong><br />
  </strong><strong>四、基于以下原因而造成的利润、商誉、使用、资料损失或其它无形损失，本网站不承担任何直接、间接、附带、特别、衍生性或惩罚性赔偿（即使本网站已被告知前款赔偿的可能性）：</strong><strong><br />
  </strong><strong>&nbsp;&nbsp; </strong><strong>（一）、本网站的使用或无法使用。</strong><strong><br />
  </strong><strong>（一）、本网站的使用或无法使用。</strong><strong><br />
  </strong><strong>（二）、会员的传输或资料遭到未获授权的存取或变更。</strong><strong><br />
  </strong><strong>　　 （三）、本网站中任何第三方之声明或行为。</strong><strong><br />
  </strong><strong>（四）、本网站其它相关事宜。</strong><strong><br />
  </strong><strong>五、本网站只是为会员提供一个服务交易的平台，对于会员所发布的任务的合法性、真实性及其品质，以及会员履行交易的能力等，本网站一律不负任何担保责任。</strong><strong><br />
  </strong><strong>六、本网站提供与其它互联网上的网站或资源的链接，会员可能会因此连结至其它运营商经营的网站，但不表示本网站与这些运营商有任何关系。其它运营商经营的网站均由各经营者自行负责，不属于本网站控制及负责范围之内。对于存在或来源于此类网站或资源的任何内容、广告、物品或其它资料，本网站亦不予保证或负责。因使用或依赖任何此类网站或资源发布的或经由此类网站或资源获得的任何内容、物品或服务所产生的任何损害或损失，本网站不负任何直接或间接的责任。&nbsp;</strong><strong><br />
  </strong><br />
  <strong>第六条 知识产权</strong><br />
    一、本网站及本网站所使用的任何相关软件、程序、内容，包括但不限于作品、图片、档案、资料、网站构架、网站版面的安排、网页设计、经由本网站或广告商向会员呈现的广告或资讯，均由本网站或其它权利人依法享有相应的知识产权，包括但不限于著作权、商标权、专利权或其它专属权利等，受到相关法律的保护。未经本网站或权利人明示授权，会员保证不修改、出租、出借、出售、散布本网站及本网站所使用的上述任何资料和资源，或根据上述资料和资源制作成任何种类产品。<br />
    二、本网站授予会员不可转移及非专属的使用权，使会员可以通过单机计算机使用本网站的目标代码（以下简称&quot;软件&quot;），但会员不得且不得允许任何第三方复制、修改、创作衍生作品、进行还原工程、反向组译，或以其它方式破译或试图破译源代码，或出售、转让&quot;软件&quot;或对&quot;软件 &quot;进行再授权，或以其它方式移转&quot;软件&quot;之任何权利。会员同意不以任何方式修改&quot;软件&quot;，或使用修改后的&quot;软件&quot;。<br />
    三、会员不得经由非本网站所提供的界面使用本网站。&nbsp;<br />
  <strong>第七条 隐私权</strong><br />
    一、信息使用：<br />
    （一）、本网站不会向任何人出售或出借会员的个人或法人信息，除非事先得到会员得许可。<br />
    （二）、本网站亦不允许任何第三方以任何手段收集、编辑、出售或者无偿传播会员的个人或法人信息。任何会员如从事上述活动，一经发现，本网站有权立即终止与该会员的服务协议，查封其账号。<br />
    二、信息披露：会员的个人或法人信息将在下述情况下部分或全部被披露：<br />
    （一）、经会员同意，向第三方披露；<br />
    （二）、若会员是合法的知识产权使用权人并提起投诉，应被投诉人要求，向被投诉人披露，以便双方处理可能的权利纠纷；<br />
    （三）、根据法律的有关规定，或者行政、司法机关的要求，向第三方或者行政、司法机关披露；<br />
    （四）、若会员出现违反中国有关法律或者网站规定的情况，需要向第三方披露；<br />
    （五）、为提供你所要求的产品和服务，而必须和第三方分享会员的个人或法人信息<br />
    （六）、其它本网站根据法律或者网站规定认为合适的披露；<br />
    三、信息安全：<br />
    （一）、在使用本网站服务进行网上交易时，请会员妥善保护自己的个人或法人信息，仅在必要的情形下向他人提供；<br />
    （二）、如果会员发现自己的个人或法人信息泄密，尤其是账户或诚付宝账户及密码发生泄露，请会员立即联络本网站客服，以便我们采取相应措施。<br />
  <strong>第八条 不可抗力</strong><br />
    因不可抗力或者其他意外事件，使得本协议的履行不可能、不必要或者无意义的，双方均不承担责任。本合同所称之不可抗力意指不能预见、不能避免并不能克服的客观情况，包括但不限于战争、台风、水灾、火灾、雷击或地震、罢工、暴动、法定疾病、黑客攻击、网络病毒、电信部门技术管制、政府行为或任何其它自然或人为造成的灾难等客观情况。<br />
  <strong>第九条 保密</strong><br />
    双方保证在对讨论、签订、执行本协议中所获悉的属于对方的且无法自公开渠道获得的文件及资料（包括但不限于商业秘密、公司计划、运营活动、财务信息、技术信息、经营信息及其他商业秘密）予以保密。未经该资料和文件的原提供方同意，另一方不得向第三方泄露该商业秘密的全部或者部分内容。但法律、法规、行政规章另有规定或者双方另有约定的除外。<br />
  <strong>第十条 争议解决方式</strong><br />
  <strong>一、本协议及其规则的有效性、履行和与本协议及其规则效力有关的所有事宜，将受中华人民共和国法律管辖，任何争议仅适用中华人民共和国法律。　　</strong><strong><br />
  </strong><strong>二、本网站有权受理并调处您与其他会员因交易服务产生的争议，同时有权单方面独立判断其他会员对您的投诉及索偿是否成立，若本网站判断索偿成立，则本网站有权使用您已被托管的任务赏金或交纳的保证金进行相应偿付。本网站没有使用自用资金进行偿付的义务，但若进行了该等支付，您应及时赔偿本网站的全部损失，否则本网站有权通过前述方式抵减相应资金或权益，如仍无法弥补损失，则本网站保留继续追偿的权利。因本网站非司法机关，您完全理解并承认，本网站对证据的鉴别能力及对纠纷的处理能力有限，受理交易争议完全是基于您之委托，不保证争议处理结果符合您的期望，本网站有权决定是否参与争议的调处。</strong><strong><br />
  </strong><strong>三、凡因本协议及其规则发生的所有争议，争议双方可协商解决，若协商不成的，争议双方同意提交广州仲裁委员会按其仲裁规则进行仲裁。</strong><strong><br />
  </strong><strong>第十一条  淘工人网对本服务协议包括基于本服务协议制定的各项规则拥有最终解释权。</strong><br />
  <strong>第十二条 附则</strong><br />
    在本协议中所使用的下列词语，除非另有定义，应具有以下含义：<br />
  &quot;本网站&quot;在无特别说明的情况下，均指&quot;淘工人网&quot;（<a href="http://www.zhubajie.com%29./">www.taogongren.com）。</a>　<br />
    &ldquo;用户&rdquo;： 指具有完全民事行为能力的淘工人网各项服务的使用者。<br />
    &ldquo;会员&rdquo;： 指与淘工人网签订《淘工人网服务协议》并完成注册流程的用户。<br />
    &ldquo;雇主&rdquo;：是指在本网站上进行发布任务或雇佣工人线下服务等&ldquo;买&rdquo;操作的会员。<br />
    &ldquo;工人&rdquo;：是指在本网站上参加竞标、销售服务、出售技能等&ldquo;卖&rdquo;操作的会员。<br />
    &ldquo;任务赏金&rdquo;:雇主在淘工人网上发起交易，确认工人身份和交易信息后，所要支付的任务费用。 </p><p>&nbsp;</p></div></div>
</td></tr></table></div>
</div><div class="index_right"><div class="right_box"><?php $this->load->view('public/mod_yxb');?><div class="right_ad"><a href="http://www.pft06.com/" target="_blank"><img src="<?php echo $img_url;?>ads/index_ad.jpg" /></a></div> 
 </div></div><!--清除浮动--><div class="clear"></div>
  </div></div><?php $this->load->view('public/footer');?>
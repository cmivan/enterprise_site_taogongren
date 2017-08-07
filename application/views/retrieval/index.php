<?php $this->load->view('public/header'); ?><?php /*?>搜索页面<?php */?>

<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>page_retrieval.css" /><?php /*?>用于控制投标信息页面的地区宽度<?php */?><style>
.retrieval_left .box li dt .city_select{width:925px;}
.city_select .citys #areas{float:right;width:812px;line-height:23px;height:auto;/*height:23px;*/}</style><script language="javascript" type="text/javascript" src="<?php echo $js_url;?>retrieval/url.js"></script><script language="javascript" type="text/javascript" src="<?php echo $js_url;?>retrieval/page.js"></script></head><body><?php $this->load->view('public/top'); ?>
<div class="main_width"><div class="body_main"><div class="retrieval_left"><div class="box" style="border:0; background:none; padding-bottom:0px; margin-bottom:3px;"><li><dt> <?php /*?>城市选择<?php */?><div class="city_select"><div class="citys"><div id="areas" class="click_box" isfor="1" style="width:920px;"><a href="javascript:void(0);" id="no" <?php if(is_numeric($placebox->areaid)==false){?>class="on"<?php }?>>不限</a><?php $areas=$placebox->areas();?><?php if(!empty($areas)):?><?php foreach($areas as $rs){?><a href="javascript:void(0);" id="<?php echo $rs->a_id?>" <?php if($placebox->areaid==$rs->a_id){?>class="on"<?php }?>><?php echo $rs->a_name?></a><?php }?><?php endif?></div><div class="clear"></div></div></div></dt></li><!--清除浮动--><div class="clear"></div> </div>
   <div class="box"><table width="932" border="0" cellpadding="3" cellspacing="1" style="background-color:#FFE4C4" id="retrieval_box"><tr class="retrieval_title"><td width="70" class="selectbox"><div class="retrieval_select"><div class="click_box thiswidth1" id="search_team_or_men" isfor="1"><?php $l_onid=$this->input->get("team_or_men",true);?><?php slistitems($team_mens,$l_onid,"全部",0)?></div></div>
      <div class="title_main">投标类型<font face=Webdings>&#54;</font></div></td><td style="text-align:left;">&nbsp;标题</td><td width="45" class="selectbox"><div class="retrieval_select"><div class="click_box thiswidth2" id="classid" isfor="1"><?php $l_onid=$this->input->get("classid",true);?><?php slistitems($classids,$l_onid,"全部",0)?></div></div><div class="title_main">类别<font face=Webdings>&#54;</font></div></td><td width="145" class="selectbox" style="width:145px;"><div class="retrieval_select"><div class="click_box thiswidth3" id="search_industry" isfor="0"><?php $l_onid=$this->input->get("industry",true);?><?php slistitems($industrys,$l_onid,"",1)?>
<input id="SelectIDS" value="0" type="hidden" /></div></div>
<div class="title_main">需求工种<font face=Webdings>&#54;</font></div></td><td width="90" ><a href="<?php echo reUrl("o_visited=".$o_visited."&o_cost=0&o_endtime=0")?>">浏览/投标人数<font face=Wingdings><?php if($o_visited==1){echo "&#241;";}else{echo "&#242";}?></font></a></td><td width="82" ><a href="<?php echo reUrl("o_visited=0&o_cost=".$o_cost."&o_endtime=0")?>">预计费用(元)<font face=Wingdings><?php if($o_cost==1){echo "&#241;";}else{echo "&#242";}?></font></a></td><td width="70" ><a href="<?php echo reUrl("o_visited=0&o_cost=0&o_endtime=".$o_endtime)?>">剩余时间<font face=Wingdings><?php if($o_endtime==1){echo "&#241;";}else{echo "&#242";}?></font></a></td><td width="75">业主</td></tr>
<?php if(!empty($list)){?>  <?php foreach($list as $rs){?>
  <tr class="out">
    <td height="22" align="center"><?php echo $this->User_Model->g_team_men($rs->team_or_men)?></td>
    <td align="left" class="title">&nbsp;<a href="<?php echo site_url("retrieval/view/".$rs->id)?>" target="_blank"><?php echo $rs->title?></a></td>
    <td align="center"><?php echo $this->Retrieval_Model->g_class($rs->classid)?></td>
    <td align="center" style="width:145px;"><?php echo $this->Retrieval_Model->g_industrys($rs->industryid)?></td>
    <td align="center">12 / 0</td>
    <td align="center"><?php echo $rs->cost?></td>
    <td align="center">51天</td>
    <td align="center"><a target="_blank" href="<?php echo site_url("user/".$rs->uid)?>"><?php echo $this->User_Model->links($rs->uid)?></a></td>
  </tr><?php }?><?php }else{?><tr class="out"><td height="160" colspan="8" align="center">暂无相关信息</td></tr><?php }?>
  
 <tr><td colspan="8" align="center" bgcolor="#FFFFFF"><?php $this->Paging->links(); ?></td></tr></table></div></div><!--清除浮动--><div class="clear"></div></div></div>
 <?php $this->load->view('public/footer');?>
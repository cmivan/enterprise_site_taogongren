<?php $this->load->view('public/header'); ?><?php /*?>搜索页面<?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>page_retrieval.css" />
<?php /*?>用于控制任务信息页面的地区宽度<?php */?>
<style>
.retrieval_left .box li dt .city_select{width:925px;}
.city_select .citys #areas{float:right;width:812px;line-height:23px;height:auto;/*height:23px;*/}</style>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>retrieval/url.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $js_url;?>retrieval/page.js"></script>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><div class="retrieval_left">

<div class="box"><table width="932" border="0" cellpadding="3" cellspacing="1" style="background-color:#FFE4C4" id="retrieval_box">
<tr class="retrieval_title">
<td width="45" class="selectbox">
<div class="retrieval_select">
<div class="click_box thiswidth2" id="classid" isfor="1">
<?php echo SelectListItems($type_ids,$type_id,"全部",0)?>
</div></div>
<div class="title_main">类别<font face=Webdings>&#54;</font></div>
</td>
<td style="text-align:left;">&nbsp;标题</td>
<td width="90" >查看人数</td>
<td width="100">发布时间</td>
<td width="90">发布人</td>
</tr>
<?php if(!empty($list)){?>  <?php foreach($list as $rs){?>
<tr class="out">
<td height="26" align="center"><?php echo $this->Recruitment_Model->type($rs->type_id)?></td>
<td align="left" class="title">&nbsp;<a href="<?php echo site_url("user/recruitment/".$rs->id)?>" target="_blank"><?php echo $rs->title?></a></td>
<td align="center"><?php echo $rs->visited?></td>
<td align="center"><?php echo dateYMD($rs->addtime)?></td>
<td align="center"><?php echo $this->User_Model->links($rs->uid)?></td>
</tr><?php }}else{?> <tr class="out"><td height="100" colspan="8" align="center">未找到符合的信息!</td></tr><?php }?> 
<tr><td colspan="8" align="center" bgcolor="#FFFFFF"><?php $this->paging->links(); ?></td></tr></table></div></div>

<!--清除浮动--><div class="clear"></div>
</div></div>
<?php $this->load->view('public/footer');?>
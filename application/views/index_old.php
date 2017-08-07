<?php $this->load->view('public/header'); ?>
<!--首页页面-->
<link rel="stylesheet" type="text/css" href="<?php echo  $css_url;?>page-index.css" /><!--flash--><script language="javascript" type="text/javascript" src="<?php echo  $fla_url;?>swfobject_modified.js"></script>
</head><body><?php $this->load->view('public/top'); ?>
<div class="main_width">
<div class="top_ad" style="display:none1"><a href="javascript:void(0);"><img src="<?php echo $img_url;?>ads/index_01.jpg" width="974" height="39" alt="" /></a></div>
<div class="body_main"><div class="index_left"><div class="index_top_title">最新招标信息</div><!--清除浮动--><div class="box"><!--最新招标信息--><div class="index_new_info"><table border="0" cellpadding="0" cellspacing="0"><tr>
<?php foreach($zb_new as $rs){?><td><div class="item"><div class="face"><a href="<?php echo site_url("retrieval/view/".$rs->id)?>" title="<?php echo $rs->title?>"><img src="<?php echo img_retrieval($rs->pic);?>" /></a></div></div></td><?php }?>
</tr></table></div>
      <div class="clear"></div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="index_ad_line">
  <tr>
    <td><div class="index_ad_text"><?php foreach($zb_ad as $rs){?>
   <li><a href="<?php echo site_url("retrieval/view/".$rs->id)?>" title="<?php echo $rs->title?>"><?php echo cutstr($rs->title,20)?></a><span>预算<?php echo $rs->cost?>元</span></li><?php };?></div>
    </td>
    </tr>
  <tr><td height="18">&nbsp;</td></tr>
  </table>
 </div>
    
 <!--清除浮动--><div class="clear"></div>   
 <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px">
  <tr>
    <td height="196" id="index_flash">&nbsp;</td>
    </tr></table>
 
 <!--清除浮动--><div class="clear"></div>   

<!--工种工项选择框-->
 <div class="industry_box">
 <?php foreach($projact as $rs){?><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="type_img"><a href="<?php echo site_url("search/")?>?industryid=<?php echo $rs["p_id"];?>" target="_blank"><img src="<?php echo $rs["p_pic"];?>" /></a></td>
    <td valign="bottom" class="type_right_title"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr><td width="50" rowspan="2" class="type_title"><?php echo $rs["p_title"];?></td>
        <td>
        <?php foreach($rs["p_class"] as $prs){?>
        &nbsp;<span><?php echo $prs->title?></span>
        <?php }?>
        &nbsp;部分项目
        </td></tr>
      <tr><td class="type_line">&nbsp;</td></tr>
      </table></td>
  </tr>
  </table><table width="100%" border="0" cellpadding="0" cellspacing="1" class="type_item_box"><?php foreach($rs["p_class"] as $crs){?><tr class="type_item_<?php echo $rs["typeitem"][$crs->id]?>">
  <?php foreach($rs["pquery"][$crs->id] as $prs){?>
    <td><div><a href="<?php echo site_url("search/")?>?industryid=<?php echo $rs["p_id"];?>&classid=<?php echo $crs->id?>&skills=<?php echo $prs->id?>"><?php echo $prs->title?></a></div></td>
  <?php }?></tr><?php }?></table><div class="clear" style="height:10px;"></div> <?php };?>
 <div class="clear"></div></div></div>
<div class="index_right"><div class="index_top_title">&nbsp;</div><?php foreach($zb_tj as $rs){?>
  <div class="right_box"><a href="<?php echo site_url("retrieval/view/".$rs->id)?>" title="<?php echo $rs->title?>"><img src="<?php echo img_retrieval($rs->pic);?>" width="277" height="210" style="border:solid 1px #ccc;" /></a></div>
  <div class="right_comm_title right_box"><a href="<?php echo site_url("retrieval/view/".$rs->id)?>"><?php echo $rs->title?></a></div><?php };?>
<div class="right_box">
  <div class="right_box_title">热门团队</div>
  <div class="right_box_ad_text">
  
  <?php foreach($hot_team as $rs){?>
    <div class="box_ad_text"><a href="<?php echo site_url("user/".$rs->tid)?>" title="<?php echo $rs->title?>"><?php echo cutstr($rs->title,16)?></a></div>
    <div class="box_ad_note"><?php echo $rs->ad?></div>
  <?php }?>
      
  </div></div>
 <div class="right_box"><a href="http://www.pft06.com/" target="_blank"><img alt="朴风堂" title="朴风堂" src="<?php echo  $img_url;?>ads/index_ad.jpg" width="279" height="103" /></a></div>
 <div class="right_box"><div class="right_box_title">热门设计师</div><div class="right_box_user"><?php foreach($hot_design as $rs){?><li><a href="<?php echo site_url("user/".$rs->id)?>"><span><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" /></span><br /><?php echo $rs->name?></a></li><?php }?></div></div>
<div class="right_box"><div class="right_box_title">热门工人</div><div class="right_box_user"><?php foreach($hot_workers as $rs){?><li><a href="<?php echo site_url("user/".$rs->id)?>"><span><img src="<?php echo $this->User_Model->faceS($rs->photoID)?>" /></span><br /><?php echo $rs->name?></a></li><?php }?></div></div>
</div>
  <!--清除浮动--><div class="clear"></div>
  </div>
 </div>
 
<!--Flash模块--><div id="index_flash_box" style="display:none"><object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="653" height="206">
        <param name="movie" value="<?php echo  $fla_url;?>flash.swf" />
        <param name="quality" value="high" />
        <param name="wmode" value="opaque" />
        <param name="swfversion" value="8.0.35.0" />
        <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
        <param name="expressinstall" value="<?php echo  $fla_url;?>expressInstall.swf" />
        <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
        <!--[if !IE]>-->
        <object type="application/x-shockwave-flash" data="<?php echo  $fla_url;?>flash.swf" width="653" height="206">
          <!--<![endif]-->
          <param name="quality" value="high" />
          <param name="wmode" value="opaque" />
          <param name="swfversion" value="8.0.35.0" />
          <param name="expressinstall" value="<?php echo  $fla_url;?>expressInstall.swf" />
          <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
          <div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
          <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p></div>
          <!--[if !IE]>-->
        </object>
        <!--<![endif]-->
      </object></div>
      <script type="text/javascript"> <!--
$(function(){$("#index_flash").html($("#index_flash_box").html());});
 swfobject.registerObject("FlashID");
//--></script>

<?php $this->load->view('public/footer');?>
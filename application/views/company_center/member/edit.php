<?php $this->load->view('public/header'); ?>
</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box"><form class="validform" method="post"><br><table width="650" border="0" align="center" cellpadding="0" cellspacing="3">
<tr>
  <td width="79" align="right">性别：</td>
  <td width="168">
    <select name="sex" id="sex">
      <option value="男" <?php if($info->sex=="男"){echo " selected";}?> >男</option>
      <option value="女" <?php if($info->sex=="女"){echo " selected";}?> >女</option>
      </select>
    </td>
  <td width="391"><div class="validform_checktip"></div></td></tr><tr>
  <td align="right"><span class="red">*</span> 称呼：</td>
  <td><input type="text" name="nicename" class="inputxt" id="nicename" datatype="s2-6" value="<?php echo $info->nicename?>" nullmsg="请输入用户名！" />
  </td>
  <td><div class="validform_checktip">称呼至少2个字符,最多6个字符</div></td></tr>


<tr>
  <td align="right"><span class="red">*</span> 手机：</td>
            <td><input name="mobile" type="text" class="inputxt" id="mobile" value="<?php echo $info->mobile?>" datatype="m" nullmsg="请输入手机号！" errormsg="请输入正确的手机号码！" /></td>
            <td><div class="validform_checktip">不可以修改</div></td>
        </tr>

        
        <tr>
            <td align="right">QQ：</td>
            <td><input name="qq" type="text" class="inputxt" id="qq" value="<?php echo $info->qq?>" /></td>
            <td><div class="validform_checktip">这里输入他的QQ，如果没有，可以留空</div></td>
        </tr>
        <tr>
          <td align="right">邮箱：</td>
          <td>
            <input name="email" type="text" class="inputxt" value="<?php echo $info->email?>" />
            </td>
          <td><div class="validform_checktip">这里输入他常用的邮箱</div></td>
        </tr>
<tr><td align="right">其他描述：</td><td colspan="2" class="val_place"><textarea name="other" class="inputxt" id="other" style="width:350px;"><?php echo $info->other?></textarea></td></tr>
        
<tr><td>&nbsp;</td><td colspan="2"><input type="submit" class="save_but" value="" /></td></tr>
</table></form>
</div></div>
</div>

<div class="clear"></div></div></div><?php $this->load->view('public/footer');?>
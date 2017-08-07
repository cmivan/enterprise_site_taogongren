<?php $this->load->view('public/validform'); ?>
<div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo Get_User_Nav($thisnav,$c_urls); ?> </div>

<div class="mainbox_box">

<?php /*?><div class="tipbox" style="line-height:22px;">
1、将工人信息记录下来，有助于企业对工人成员的管理！<br />
2、可以将订单合理制定分配给每位工人！<br />
3、业主可以对工人进行评分，有助于及时了解每个工人成员的工作质量等！<br />
4、注：带红色星号<span class="red">*</span>的 为必填项。</div><?php */?>

<form class="validform" method="post"><br><table width="650" border="0" align="center" cellpadding="0" cellspacing="3">
<tr>
  <td width="79" align="right">性别：</td>
  <td width="168">
    <select name="sex" id="sex">
      <option value="男">男</option>
      <option value="女">女</option>
      </select>
    </td>
  <td width="391"><div class="validform_checktip"></div></td></tr><tr>
  <td align="right"><span class="red">*</span> 称呼：</td>
  <td><input type="text" name="nicename" class="inputxt" nullmsg="请输入用户名！" id="nicename" datatype="s2-6" /></td>
  <td><div class="validform_checktip">称呼至少2个字符,最多6个字符</div></td></tr>


<tr>
            <td align="right"><span class="red">*</span> 手机：</td>
            <td><input type="text" name="mobile" id="mobile" class="inputxt" datatype="m" nullmsg="请输入手机号！" errormsg="请输入正确的手机号码！" /></td>
            <td><div class="validform_checktip">这里输入他的手机号码</div></td>
        </tr>

        
        <tr>
            <td align="right">QQ：</td>
            <td><input type="text" name="qq" class="inputxt" id="qq" /></td>
            <td><div class="validform_checktip">这里输入他的QQ，如果没有，可以留空</div></td>
        </tr>
        <tr>
          <td align="right">邮箱：</td>
          <td>
            <input type="text" name="email" class="inputxt" />
            </td>
          <td><div class="validform_checktip">这里输入他常用的邮箱</div></td>
        </tr>
<tr><td align="right">其他描述：</td><td colspan="2" class="val_place"><textarea name="other" class="inputxt" id="other" style="width:350px;"></textarea></td></tr>
        <tr><td align="right">&nbsp;</td><td colspan="2"><input type="submit" class="save_but" value="" /></td></tr>
        
    </table></form><br><br><br>
</div></div>
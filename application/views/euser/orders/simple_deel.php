<?php $this->load->view('public/header'); ?>

</head><body><?php $this->load->view('public/top'); ?><div class="main_width"><div class="body_main"><?php /*?>管理页面的框架分布<?php */?><div class="my_left"><div class="my_left_nav"><?php $this->load->view($c_url.'leftnav'); ?><div class="clear"></div></div></div><div class="my_right"><div class="mainbox" box="content_box"><?php /*?>订单页面操作导航<?php */?><div class="mainbox_nav"> <?php echo c_nav($thisnav,$c_url); ?> </div><div class="mainbox_box"><?php $this->load->view($c_url.'orders/ordertip'); ?>
<div class="content">
<table width="100%" border="0" cellpadding="0" cellspacing="0" ><form action="" method="post"><tr><td align="left" style="border:#CCC 1px solid;padding:25px; padding-right:12px;background-color:#f6f6f6;background-image:url(<?php echo $img_url?>ico/bgs.gif); background-repeat:repeat-x; background-position:0 -180px;"><div style="height:680px; overflow:auto;">
  <p><strong>一、工艺流程： </strong><br />
    &nbsp;&nbsp;&nbsp;  咨询一设计一签订合同一清理施工现场--水电进场施工一木工进场施工一油漆进场施工一扇灰进场施工一工程验收一竣工并填写保修单，交付使用。 <br />
    <strong>二、施工工艺要求：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
    &nbsp;&nbsp;&nbsp;  要求各施工项目在客户现场制作，尺寸、式样按图纸设计放样，技术要求及施工制作要求应严格按本公司所定的施工规范执行，工艺流程中指定的验收工序，必须经客户验收签字。 <br />
    <strong>三、施工工艺制作规范及要求： </strong><br />
    公司工程部负责人、项目经理、工班组长会同客户现场开工，工班组长须将施工许可证，公司施工牌及公司其他规定张贴、悬挂在指定醒目处。客户向工程监理交施工工地钥匙。 <br />
    <strong>四、施工验收标准： </strong><br />
    <strong>（一）文明施工 </strong></p>
  <ol>
    <ol>
      <li>施工现场必须张贴文明施工、安全施工条例及防水防潮施工工艺与工程进度计划表。 </li>
      <li>凡公司员工必须在工地挂牌上岗。 </li>
      <li>墙壁批荡时超过40mm厚必须挂4号钢网后方可批荡。 </li>
      <li>施工现场灭火器必须放在明显且取用方便的位置。 </li>
      <li>施工现场不得打赤膊穿拖鞋。 </li>
      <li>施工现场不得带小孩进出，并做到无闲杂人员。 </li>
      <li>施工现场材料应分类堆放整齐。 </li>
      <li>当天应清扫施工场地，保持清洁卫生。 </li>
      <li>易燃材料必须放在安全位置。 </li>
    </ol>
  </ol>
  <p>10）严禁在施工用电时裸线直插，严禁在施工场地吸烟及煮饭。 <br />
    11）严禁在施工现场随意大小便。 <br />
    12）不准在业主的床上及家具上睡觉。 <br />
    13）不准站在家具或洁具上施工。 <br />
    14）不准站在天那水及油漆桶上施工。 <br />
    15）打墙、拆瓷片应采取安全保护措施。 <br />
    16）不得在施工场地吵嘴、打架或与业主争执、辱骂。 <br />
    17）不得在施工场地聚众赌博。 <br />
    18）所有完工成品必须严格保护好（不能有划痕、碰伤，柜内不能堆放杂物并保持洁净。） <br />
    <strong>（二）电工施工验收标准： </strong><br />
    1) 按施工设计图及客户现场确定开关、插座位置、电视、电话插座位置及照明位置。 <br />
    2) 切割机按所定位置进行垂直、水平线切割和插座、开关暗盒切割，禁止斜线切割。 <br />
    3) 电路制作： <br />
    a. 电线埋设必须用PVC套管，埋入墙体内的PVC套管不得破裂，不准高出墙面，90度弯曲，不得皱瘪，PVC管壁厚应不小于1.5mm。剪力墙、梁等无法开槽的应用黄蜡管做绝缘保护。 <br />
    b．各路空调插座、浴霸、热水器及其他大功率的电器设备均为专线，不得与其他线路同时配置接地线。 <br />
    c．总配电箱总开关应为63A或63A以上漏电保护器，空调插座为16A以上，其他插座照明为1OA以上，插座开关面板应为统一高度(插座离地应不低于200mm，照明开关距地高度宜为1.4m，开关不宜在门后)。 <br />
    C1＞高度距离地面1.5m为宜，并要安装平整、牢固、可靠安全。 <br />
    C2＞配电箱进、出路线都应有PVC线管或其它绝缘管插入进行保护。 <br />
    C3＞配电箱的漏电开关，空气开关排列要整齐，并要标明详细；配电箱内应分别设置零线和保护线(PE线)汇流排，零线和保护应在汇流排上连接不得绞接，应有编号。 <br />
    C4＞隐蔽的电气线路必须在质检员验收合格后方可进行封槽。 <br />
    C5＞各种灯具安装要位置正确、端正平稳、美观、牢固可靠。各种面板要平直、牢固、美观，面板贴墙面或板面，各个开关开启灵活，控制灵敏。各种插座通电良好。空气开关、漏电开关开启灵活，控制灵敏。 <br />
    a．电话线为多芯，电视和电话与电源线要分穿PVC管，不和电源线并列同穿。 <br />
    b．电线禁用旧电线。 <br />
    c．电线PVC管的铺设，二楼以下一般情况，禁止着地铺设，无法入墙铺设的，作特殊处理。 <br />
    d．严禁电线有接头回路借线。 <br />
    e．线管、线盒不准高出成品墙面。 <br />
    f．每个插座、应放接地线。 <br />
    <strong>(</strong><strong>三)水路验收标准：&nbsp; </strong><br />
    1）管材、管件的质量必须符合标准，采用PPR管，禁止使用镀锌管。 <br />
    2）地漏位置的安排要合理。 <br />
    3）布管要整齐、美观、规范，而排水管杜绝二合一连接地漏。 <br />
    4）排水管应采用硬质PVC排水管件，全部下水道取消软连接。 <br />
    5）全部地漏用防臭地漏施工。 <br />
    6）水管铺设不得靠近电源，水管与燃气管的间距应不小于400mm。 <br />
    7）管道安装应固定牢固、无松动，龙头、阀门安装平整，开启灵活，水表运作正常，管道无渗漏。制作完毕，应与客户一起试压，经客户认可签字后方能封墙。 <br />
    8）水管试水压必须严格按相关标准执行(详见隐蔽工程验收标准)。 </p>
  <table border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
      <td width="254"><br />
        蹲厕安装标准 </td>
      <td width="396" valign="top"><p>1．安装是应向后带有0.002的坡度，以利排泄； <br />
        2．水箱高度自蹲台面30mm以上； <br />
        3．蹲厕排污口每个水管连接处要密封，不准出现渗漏； </p></td>
    </tr>
    <tr>
      <td width="254"><p>排水管的排水坡度 </p></td>
      <td width="396" valign="top"><p>2-3％为宜 </p></td>
    </tr>
    <tr>
      <td width="254"><p>水龙头、花洒(标准高度为1200mm)</p></td>
      <td width="396" valign="top"><p>龙头安装要正、要稳、牢固、龙头带盖的盖要平整、 <br />
        挂件，花洒龙头等安装要平整牢固。 </p></td>
    </tr>
    <tr>
      <td width="254"><p>前期水压检测 </p></td>
      <td width="396" valign="top"><p>前期给排水安装完毕，必须经质检人质检、试压达到 <br />
        10公斤合格后，方可封槽。 </p></td>
    </tr>
    <tr>
      <td width="254"><p>检验的基本标准 </p></td>
      <td width="396" valign="top"><p>定位准确、布置平稳、给水不漏、排水不渗、流水畅 <br />
        通、洗手盆平、洗菜盆稳、挂件牢固。 </p></td>
    </tr>
  </table>
  <div class="clear"></div>
  <p><strong>（四）泥工验收标准： </strong><br />
    <strong>1</strong><strong>、抹灰的基本要求和验收方法： </strong></p>
  <ol>
    <ol>
      <li>表面应洁净，接搓平顺，线角顺直，粘接牢固，无脱层，无爆灰和裂缝等缺陷。采用目测的方法验收。 </li>
      <li>用小锤轻轻敲击检查有无空鼓声，空鼓而不裂，每处的面积不大于200cm2为合格，全数检查（单块砖空壳小于10%）。 </li>
    </ol>
  </ol>
  <p><strong>2</strong><strong>、面镶贴的基本要求和验收方法： </strong><br />
    1）镶贴应牢固，表面平整干净，无漏贴错贴，缝隙均匀，周边顺直，砖面无裂纹、摔角、缺棱等现象。采用自然光线下目测的方法验收。 </p>
  <ol>
    <li>锤在墙面上全数轻轻敲击，空鼓面积应小于4cm2。 </li>
    <li>卫生间、厨房内墙面防水涂膜做到0.9m高，内墙隔壁有柜的防水涂膜做到1.2m以上，待36小时干固后再贴墙面砖。 </li>
  </ol>
  <p><strong>3</strong><strong>、面镶贴的基本要求和验收方法</strong><strong>： </strong><br />
    1）镶贴应牢固，表面平整干净，缝隙均匀周边平直，表面无裂纹、摔角、缺棱等现象。 <br />
    2）用小锤在地面上全数轻轻敲击，不得有空鼓声。 <br />
    3）有排水要求的地砖镶贴应满足排水坡度要求2&mdash;3%坡向地漏等出水口，与地漏及出水口应严密牢固。 </p>
  <ol>
    <li>卫生间、厨房地面必须做防水涂膜层，与墙面处理应严密，待36小时干固后再贴地砖。 </li>
  </ol>
  <p><strong>（五）木制作验收标准： </strong><br />
    <strong>1</strong><strong>、门及门套基本要求和验收方法： </strong></p>
  <ol>
    <li>门及门套的品种规格，开启方向及安装位置应符合设计规定。安装必须牢固，横平竖直，高低一致。门框与门页之间空隙在4&mdash;6mm 之内。门扇应开启灵活，无阻滞及反弹现象，关闭后不翘角，不露缝。厚度均匀，外观洁净，大面无划痕、碰伤、缺棱等现象。拼块严密，镶贴幻彩线粘结牢固平顺，烙缝平直弧线顺畅。安装平开门合面两边开槽。采用目测和手感方法验收。 </li>
  </ol>
  <p><strong>2</strong><strong>、推拉门、折叠门的基本要求和验收方法： </strong></p>
  <ol>
    <li>安装必须牢固，推拉灵活流畅，门页高低一致，横平竖直，大小一样，拉拢后不得出现顺v字型。门页与门页之间在横向留缝5mm左右，以免推拉时碰撞。折叠门应折叠灵活方便，其余制作方法大体相似。采用目测和手感方法验收。 </li>
  </ol>
  <p><strong>3</strong><strong>、衣柜的基本要求和验收方法： </strong></p>
  <ol>
    <li>造型、结构的安装位置应符合设计要求，框架应垂直、水平。柜内应洁净，表面应砂磨光滑，不应有毛刺和锤印。大面无划痕、碰伤、缺棱等现象。贴面板及线条，应粘贴平整牢固，不脱胶，边角不起翘。柜门安装牢固，开关灵活，上下缝一致，横平竖直。并块应平整严密，镶贴幻彩线粘结平顺。采用目测和手感的方法验收。 </li>
    <li>夹板与墙之间应做防潮处理，墙面涂防潮剂或防水材料，板刷光油，双面做防潮处理。 </li>
    <li>也可适用矮柜、储物柜、地柜、吊柜、壁柜、鞋柜、书柜等的验收评定。 </li>
  </ol>
  <p><strong>4</strong><strong>、写字台的基本要求和验收方法： </strong></p>
  <ol>
    <li>制作造型、结构和安装位置应符合设计要求。面板、线条、幻彩线等粘贴平整牢固，不脱胶，不起鼓，边角不起翘。表面应砂磨光滑，不得有毛刺和锤印。大面无伤痕、缺棱等现象。抽屉轨道间隙应严密，推拉灵活，无阻滞、脱轨现象。采用目测和手感的方法验收。 </li>
    <li>也可适用梳妆台、电脑写字台、床头柜、电视柜等的验收评定。如电视柜台面为大理石的应安放平整牢固。 </li>
  </ol>
  <p><strong>5</strong><strong>、木地台的基本要求和验收方法： </strong></p>
  <ol>
    <li>铺设应牢固，不松动、涡陷和起翘，行走时无响声。台面板应留伸缩缝，应做防潮处理。用目测和脚踏行走的方法验收。 </li>
  </ol>
  <p>6<strong>、木地板的基本要求和验收方法</strong>： </p>
  <ol>
    <li>木地板表面应洁净无沾污，刨平磨光，无刨痕和毛刺、磨迹等现象。垫层应牢固，间距应符合要求，并做防潮处理。木地板铺设牢固，不松动，行走时无响声。地板与墙面之间应留8&mdash;10mm的伸缩缝，用目测和手感的方法验收。 </li>
  </ol>
  <p><strong>7</strong><strong>、天花的基本要求和验收方法： </strong></p>
  <ol>
    <li>造型、结构和安装位置应符合设计要求。安装牢固，表面平整、无污染、折裂、缺棱、掉角、锤伤等缺陷。粘贴面板的不应有脱层、起鼓、翘角，钉夹板的不应有漏缝、透光，钉桑拿板的应严密。假梁面板应碰角整齐，超过2.4m面板颜色要一致。主龙骨无明显弯曲，次龙骨连接处无明显错位，在嵌装灯具、排气扇等物体的位置应加固处理。采用目测的方法验收。 </li>
    <li>夹板天花、面板天花、桑拿板天花、假梁天花、扣板天花、玻璃天花、格子天花等均参照验收评定。 </li>
  </ol>
  <p><strong>8</strong><strong>、细木工的基本要求和验收方法： </strong></p>
  <ol>
    <li>表面光滑，线条顺直，棱角方正，不露钉帽，无刨痕、毛刺、锤印等缺陷。安装位置正确，割角、碰角整齐，接缝严密，与墙面紧 </li>
    <li>贴。采用目测和手感的方法验收。 </li>
    <li>粘贴天花石膏线应平直牢固，接头要严密，对花平整，弧形线要流畅。 </li>
  </ol>
  <p><strong>9</strong><strong>、墙面造型的基本要求和验收方法： </strong></p>
  <ol>
    <li>造型、结构和安装位置应符合设计要求。表面应光洁，表面光滑，无毛刺等。缝口紧密，板面间缝隙宽度均匀，直木纹朝向一致，斜木纹图案清晰。安装牢固，粘贴面板不脱胶，边角不起翘，拼块严密。采用目测及手感方法验收。 </li>
    <li>也可适用护墙板、木墙裙、床头造型等验收评定。 </li>
  </ol>
  <p><strong>（六）油漆工制作验收标准:</strong><br />
    1、饰面板刚进工地时，表面必须用底漆(聚脂清漆)涂刷一遍，以保护面板在以后的施工过程中长期保持清洁，如发现色差大及质次的夹板应及时退回配货中心。 <br />
    2、修补钉眼时如发现气钉露出饰面板应把气钉钉入饰面板内，修补钉眼的颜色。 <br />
    3、做调色漆前应先做好三块以上色板由客户选定一种，方可按客户认可的色板进行油漆。 <br />
    4、油漆前如发现木工在饰面板上划过的铅笔或其他记号须及时擦干净。 <br />
    5、要求 <br />
    a.刷清漆要求木纹清晰，平整光滑，颜色基本一致，无刷纹。大面上和小面上明显处无裹楞、流坠、皱皮。不允许有漏刷、脱皮及斑纹。 <br />
    b．混色漆涂刷要求平整、光滑、均匀一致，刷纹通顺。不允许有脱皮、漏刷及泛锈。 <br />
    c．油漆完工时，应作亮光处理。 <br />
    <strong>（七）扇灰及糊裱制作验收标准： </strong><br />
    1、扇灰前应将洞眼、线槽、门边缝填补平，墙面、顶面平整，阴阳角平直，无掉粉、起波、漏刷涂料等现象。无明显色差、返色、刷纹，无显著砂眼、流坠、起疙、溅沫并保持洁净。采用目测和手感方法验收。木质天花或石膏板天花应先作防锈处理后方可进行抹灰工序。 </p>
  裱糊(布)的要求：色泽一致无明显色差、花纹图案吻合、与顶角线，踢脚板拼接应紧密无缝隙，粘贴牢固、不得有漏贴、补贴和脱层，阴阳转角应棱角分明，表面无皱折，斑污，翘边防波纹起伏。&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td></tr><tr><td height="45" align="center">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr class="diy_link_but">
      <td align="center"><a href="javascript:history.back(1);">&nbsp;&nbsp;不同意&nbsp;&nbsp;</a></td>
      <td align="center">&nbsp;</td>
      <td align="center"><a href="?action=deel.read.ok">&nbsp;&nbsp;我同意以上协议&nbsp;&nbsp;</a></td>
      </tr>
    </table></td></tr> </form></table>    
<div class="clear"></div></div><div class="clear"></div></div></div></div>
<div class="clear"></div></div></div>
<?php $this->load->view('public/footer');?>
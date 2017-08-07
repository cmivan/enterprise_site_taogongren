<?php
$lang['order_link'] = '<a href="{order_url}" target=_blank>{orderid}</a>';

//工人操作简化单
$lang['order_no_2e_msg']      = '用户 {user_w_links} 不同意退回上门单：{order_link} 的费用!';
$lang['order_no_2e_sms']      = '用户 {user_w} 不同意退回上门单：{orderid} 的费用，请尽快登陆淘工人网查看并处理!';
$lang['order_ok_balance_tip'] = '用户 {user_w_links} 同意退回上门单：{order_link} 的费用!';
$lang['order_ok_2e_msg']      = '用户 {user_w_links} 同意退回上门单：{order_link} 的费用 {cost} 元 !';
$lang['order_ok_2e_sms']      = '用户 {user_w} 同意退回上门单：{orderid} 的费用 {cost} 元，请尽快登陆淘工人网查看并处理!';

//业主操作简化单
$lang['order_2w_msg']          = '业主 {user_e_links} 对上门单：{order_link} 的费用【{order_tip}】';
$lang['order_2w_sms']          = '业主 {user_e} 对上门单：{orderid} 的费用【{order_tip}】，详情请登录淘工人网!';
$lang['order_2w_balance_tip1'] = "，该订单费用为<span class=chenghong>{cost}元</span>，其中的 {cost_rate}(<span class=chenghong>{cost_ser}</span> 元) 将自动存入你的信用账户!";
$lang['order_2w_balance_tip2'] = "你完成了订单:{order_link} （费用：<span class=chenghong>{cost}元</span>），系统自动将其中的 {cost_rate}(<span class=chenghong>{cost_ser}</span> 元) 转存入你的信用账户!";

//业主添加上门单
$lang['order_door_cost_tip']  = '成功把上门单下给用户：{user_w_links}，订单编号：{order_link} ，其中订单费用 {cost_this} 元，服务费 {cost_ser} 元，暂时支付到平台托管 !';

//$lang['order_door_msg_tip'] = '成功把上门单下给用户：{user_w_links}，订单编号：{order_link} ，其中订单费用 {$cost_this} 元，服务费 {$cost_ser} 元，暂时由第三方托管 !';

//$lang['order_door_sms_tip'] = '成功把上门单下给用户：{user_w_links}，订单编号：{order_link} ，其中订单费用 {$cost_this} 元，服务费 {$cost_ser} 元，暂时由第三方托管 !';

//业主添加简化单
$lang['order_simple_cost_tip']   = '成功下简化单给用户: {user_w_links}，订单编号：{order_link} ，其中订单费用 {cost_this} 元，服务费 {cost_ser} 元，暂时支付到平台托管 !';



//工人操作简化单时返回的提示
$lang['order_simple_cost_ok']    = '您同意业主 {user_e_links} 对订单: {order_link} 的验收申请！(<span class=chenghong> {c_r_cost_2} </span> 元)，其中有 <span class=chenghong>{cost_ser}</span> 元已存入你的信用账户！';

$lang['order_simple_cost_xy_ok'] = '你完成了订单: {order_link} ，费用为：<span class=chenghong>{c_r_cost_2}元</span>。<br>系统将把其中的 {cost_rate} (<span class=chenghong>{cost_ser}元</span>) 存入你的信用账户！';

$lang['order_simple_cost_ok_2e'] = '用户 {user_w_links} 同意了你对订单:{order_link} 的验收申请，系统将该订单的剩余的费用（<span class=chenghong>{c_r_cost_1}元</span>）返回到你到账户上。';


$lang['order_simple_ok_msg_2e'] = '用户 {user_w_links} 已同意了你对订单: {order_link} 的验收申请！可点击订单编号查看详情！';
$lang['order_simple_ok_sms_2e'] = '手机为{mobile2}的用户 {user_w} 已同意了你的验收申请，验收费用为 {c_r_cost_2}元。详情请登陆淘工人网！';


?>
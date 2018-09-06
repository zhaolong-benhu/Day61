<?php
/**
 * 酒店人公众号创建菜单
 */
$config = array(
	'appId'=>'wxadec56d0be885364',
	'appSecret'=>'380391c5476a9c66e681fafa15e0e017',
);
$menu = '{"button":[
			{"name":"经典内容","type":"view","url":"http://mp.weixin.qq.com/s?__biz=MjM5NzQ4NzQwMA==&mid=201963984&idx=1&sn=cab8a1e5ac7ff8d2c9efe65e4618d737&scene=18#rd"},
			{"name":"酒店社区","type":"view","url":"http://wx.wsq.qq.com/192217666?_wv=1"},
			{"name":"寻找童年","type":"click","key":"nvshen"}
]}';

include_once 'api/WechatApi.php';
WechatApi::getInstance($config)->buildCustomMenu($menu);
?>

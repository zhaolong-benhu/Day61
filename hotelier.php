<?php
/**
 * hotelier2014公众号开发模式下消息响应接口
 * 由微信服务器调用自定义响应用户行为
 * 如果不需要开发者模式请忽略
 * @see application.components.MessageResponse
 */
$config = array(
	'appId'=>'wxadec56d0be885364',
	'appSecret'=>'380391c5476a9c66e681fafa15e0e017',
);
require '../@yii.php';
require Yii::getPathOfAlias('application.components').'/MessageResponse.php';
require 'api/WechatApi.php';
//设置自定义菜单
$menuData = ' {
				 "button":[
					{
						"type":"view",
						"name":"经典内容",
						"url":"http://mp.weixin.qq.com/s?__biz=MjM5NzQ4NzQwMA==&mid=201963984&idx=1&sn=cab8a1e5ac7ff8d2c9efe65e4618d737&scene=18#rd"
					},
					{
						"type":"view",
						"name":"酒店社区",
						"url":"http://wx.wsq.qq.com/192217666?_wv=1"
					},
					{
						"type":"view",
						"name":"寻找童年",
						"url":"http://wams.veryeast.cn/activity/20150510/"
					},
			 }';
$class = new MessageResponse();
$class->token = 'hotelier2014';
$class->wechatApi = new WechatApi($config);
$class->wechatApi->buildCustomMenu($menuData);
//echo $class->wechatApi->_getAccessToken();
$class->db = Yii::app()->db->createCommand();
$class->index();

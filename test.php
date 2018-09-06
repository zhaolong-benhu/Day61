<?php
require __DIR__ . '/../@yii.php';
if(ENVIRONMENT == 'local'){
	$config = array(
			'db'=>array(
					'connectionString' => 'mysql:host=168.192.122.30;dbname=weixin_activities',
					'emulatePrepare' => false,
					'username' => 'efoncheng',
					'password' => 'efoncheng',
					'charset' => 'utf8',
					'tablePrefix' => 'wams_',
					'schemaCachingDuration' => 100,
					'autoConnect' => false,
					'enableProfiling'=>true,
			),
	);
	Yii::app()->setComponent('db',$config['db']);
}

/*$config = array(
	'test'=>array(
		'appId'=>'wx3ec603690e65f837',
		'appSecret'=>'1f6c6b5e5862fc33bc9ed1a80cf5152d',
	),
	'hotelier2014'=>array(
		'appId'=>'wxadec56d0be885364',
		'appSecret'=>'380391c5476a9c66e681fafa15e0e017',
	),
	'veryeast'=>array(
		'appId' => 'wx79d2d0883bd09bf7',
		'appSecret' => '8facb71c17feef00c4078cde5f2b38e7',
	),
);
require 'api/WechatApi.php';
$api = WechatApi::getInstance($config['veryeast']);
$userInfo = json_decode(file_get_contents('log.txt'),true);
$data = $api->getGrantedUserinfo($userInfo['openid'], $userInfo['access_token']);
print_r($data);exit;*/
$openid = 'manual_open_id_5577fd094bf3a';
$number = '701';
$fullname = '何琳';
$mobile = '13980696070';
$signature = '我就是我，不一样的烟火';
$cover = './upload/cover/1234567890220.jpg';
$picture = array(
		'./upload/picture/'.$openid.'/1234567890221.jpg',
		'./upload/picture/'.$openid.'/1234567890222.jpg',
		'./upload/picture/'.$openid.'/1234567890223.jpg',
		//'./upload/picture/'.$openid.'/1234567890224.jpg',
);
$picture = serialize($picture);
$time = time();
$insert = 'insert into wams_contest_user (openid,component_id,number,fullname,mobile,audit,signature,cover,picture,add_time,vote_show) values ';
$insert.="('{$openid}',26,'{$number}','{$fullname}','{$mobile}',1,'{$signature}','{$cover}','{$picture}',{$time},0)";
$dbCommand = Yii::app()->db->createCommand();
$af = $dbCommand->setText($insert)->execute();
print_r($af);

?>
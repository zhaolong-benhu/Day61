<?php
/**
 * 报名入口之二
 * 解决某些用户在index.php?a=signup报名不能上传图片
 */
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

if($_SERVER['REQUEST_METHOD']!=='POST'){
	$openid = !empty($_GET['openid'])?$_GET['openid']:'';
	if(isset($_GET['errMsg'])){
		$errorMsg = unserialize(urldecode($_GET['errMsg']));
	}
	$errorMsg = !empty($errorMsg)?$errorMsg:array();
}else{
	$errorMsg = array();
	$openid = !empty($_POST['openid'])?$_POST['openid']:uniqid('manual_open_id_');
	$uploadPath = './upload/';
	$insert = array();
	$dbCommand = Yii::app()->db->createCommand();
	require 'util/image.php';
	//数据验证
	if(!preg_match('/^([\x80-\xff]|[a-zA-Z0-9]|\.){1,20}$/i',trim($_POST['fullname']))){
		$errorMsg['fullname'] = '姓名格式不对';
	}
	if(!preg_match('/^1[\d]{10}$/',trim($_POST['mobile']))){
		$errorMsg['mobile'] = '手机号格式不对';
	}
	if(!preg_match('/^([\x80-\xff]|[a-zA-Z0-9]|\.){1,100}$/i',trim($_POST['signature']))){
		$errorMsg['signature'] = '参赛宣言格式不对';
	}
	if(empty($_FILES['cover']['name'])){
		$errorMsg['cover'] = '封面图片必须上传';
	}
	foreach(array('fullname','mobile','signature','cover') as $v){
		if(isset($errorMsg[$v])){
			header("Location:sign.php?openid=".$openid.'&errMsg='.urlencode(serialize($errorMsg)));
			exit;
		}
	}
	//先处理图片
	$savePath = $uploadPath.'cover/'.uniqid().'.jpg';
	if(move_uploaded_file($_FILES['cover']['tmp_name'], $savePath)){
    	Image::thumb($savePath,$savePath,'','400','600');
		$insert['cover'] = $savePath;
	}
	$picture = array();
	foreach(array('picture1','picture2','picture3','picture4') as $v){
		if(!empty($_FILES[$v]['name'])){
			$savePath = $uploadPath.'picture/'.$openid.'/';
			!is_dir($savePath) && mkdir($savePath,0777,true) &&chmod($savePath,0777);
			$savePath .= uniqid().'.jpg';
			if(move_uploaded_file($_FILES[$v]['tmp_name'], $savePath)){
				Image::thumb($savePath,$savePath,'','400','600');
				$picture[] = $savePath;
			}
		}
	}
	$insert['picture'] = serialize($picture);
	//然后处理其他字段
	$insert['openid'] = $openid;
	$insert['component_id'] = 26;
	$row = $dbCommand->select('id,max(number) as number')->from('wams_contest_user')->queryRow();
	if($row['number'] === false){
		$insert['number'] = '001';
	}else{
		$insert['number'] = str_pad($row['number']+1, 3,'0',STR_PAD_LEFT);
	}
	$insert['fullname'] = trim($_POST['fullname']);
	$insert['mobile'] = trim($_POST['mobile']);
	$insert['audit'] = 0;
	$insert['signature'] = trim($_POST['signature']);
	$insert['add_time'] = time();
	$insert['vote_show'] = 0;
	//报名成功
	if($dbCommand->insert('wams_contest_user',$insert)){
		alert("success...");
		// header("Location:index.php?a=signup&openid=".$openid);
		// exit;
	}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  	<meta charset="UTF-8">
  	<title>追忆最嗨学生时代</title>
	<meta name="apple-touch-fullscreen" content="yes" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="Expires" content="-1" />
	<meta http-equiv="pragram" content="no-cache" />
	<meta id="sharecontent" name="sharecontent" data-appid="" data-msg-img="" data-msg-title="dddd" data-msg-content="" data-line-link="" data-callback-link=""/>
	<script type="text/javascript" language="javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
	  if(/Android (\d+\.\d+)/.test(navigator.userAgent)){
	    var version = parseFloat(RegExp.$1);
	    if(version>2.3){
	      var phoneScale = parseInt(window.screen.width)/640;
	      document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phoneScale +', maximum-scale = '+ phoneScale +', target-densitydpi=device-dpi">');
	    }else{
	      document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
	    }
	  }else{
	    document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
	  }
	</script>
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/base.css" rel="stylesheet">
	<link href="css/common.css" rel="stylesheet">
</head>
<body>
	<div class="mw pb90 fl">
		<div class="contents_box pr32 fl box_s mt28 mb50 pl32 w_100">
			<div class="bgcol_02 b_rad8 box_s pl40 pr40 pr w_100 fl">
				<div class="page_box_top_l pa z1000 t0"></div>
				<div class="page_box_top"><span class="pa font34 line_h66 col_01 z1000 l55">参赛报名处</span></div>
				<div class="page_box_top_r pa z1000 t0"></div>
				<div class="join_page_main">
					<div class="font24 col_04 line_h90">上传学生年代的萌照片会增加插红旗的几率哦！</div>
					<form id="regForm" action="sign.php?a=signup" method="post" enctype="multipart/form-data">
						<input type="hidden" name="openid" value="<?php echo !empty($_GET['openid'])?$_GET['openid']:'';?>" />
						<div class="line_h65 font24 mb20">
							<span class="fonts_song col_04">* </span>姓<span class="font_w2 dis_lb"></span>名：
							<input name="fullname" type="text" placeholder="<?php echo isset($errorMsg['fullname'])?$errorMsg['fullname']:'填写姓名';?>" class="join_page_main_form_txt b_rad8 box_s col_05 font24 pl15 pr15" title="填写姓名" />
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04">* </span>手机号码：
							<input name="mobile" type="text" placeholder="<?php echo isset($errorMsg['mobile'])?$errorMsg['mobile']:'填写便于联系的手机号码';?>" class="join_page_main_form_txt b_rad8 box_s col_05 font24 pl15 pr15" title="填写便于联系的手机号码" />
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04">* </span>参赛宣言：
							<textarea name="signature" placeholder="<?php echo isset($errorMsg['signature'])?$errorMsg['signature']:'填写一段参赛口号、青春记忆等，限50字以内';?>" class="join_page_main_form_txt2 box_s b_rad8 w_100 col_05 font24 pl15 pr15 pt15 pb15" title="填写一段参赛口号"></textarea>
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04">* </span>封面照片：
							<input type="file" name="cover" class="join_page_main_form_txt" style="border:none;" />
						</div>
						<div class="line_h30 font18" style="background-color:orange;text-indent:1em;<?php if(!isset($errorMsg['cover'])){echo 'display:none';}?>">
							<?php echo isset($errorMsg['cover'])?$errorMsg['cover']:'';?>
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04"></span>展示照片1：
							<input type="file" name="picture1" class="join_page_main_form_txt" style="border:none;" />
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04"></span>展示照片2：
							<input type="file" name="picture2" class="join_page_main_form_txt" style="border:none;" />
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04"></span>展示照片3：
							<input type="file" name="picture3" class="join_page_main_form_txt" style="border:none;" />
						</div>
						<div class="line_h65 font24">
							<span class="fonts_song col_04"></span>展示照片4：
							<input type="file" name="picture4" class="join_page_main_form_txt" style="border:none;" />
						</div>
						<div class="mb15 box_s fl w_100" style="margin-top:50px;">
							<input type="submit" value="提交报名" class="b_rad8 h80 bgcol_03 tc font32 mb20 fl w_100 dis_b line_h80 col_01 ber_none" />
			           	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

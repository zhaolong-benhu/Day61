<!-- 需要瀑布流效果的页面专用布局文件 -->
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
	<style>
	.input-upload{z-index:999;width:100%;height:100%;position:absolute;margin-left:-35px;opacity:0;}
	.input-uploaded{z-index:999;width:100%;height:100%;position:absolute;margin-left:-120px;opacity:0;}
	</style>
	<script>
	var vdata = {
		'openid':'<?php echo $this->clips['publicData']['openid'];?>',
		'uploadPath':'<?php echo $this->clips['publicData']['uploadPath'];?>',
		'domain':'<?php echo Yii::app()->request->getHostInfo();?>'
	}
	</script>
</head>
<body>
	<div class="mw pb90 fl">
		<!-- top box -->
		<div class="top_box">
        	<!-- <div class="top_box_time pa pr20 pl20">
           		<?php echo $this->clips['duration'];?>
        	</div> -->
        	<ul class="mw top_box_ck_num pr32 pl32 box_s pa">
           		<?php echo $this->clips['statData'];?>
        	</ul>
        	<div class="top_box_ck_img pa"></div>
		</div>
		<!-- search box -->
     	<div class="search_box w_100 box_s pr32 pl32">
     		<form action="index.php" method="get">
     		<input type="hidden" name="a" value="detail" />
        	<input type="text" name="s" value="" placeholder="请输入姓名或编号进入插红旗" class="line_h68 font26 fl pr20 pl20 col_01 b_rad8TL b_rad8BL box_s w_100" >
        	<script>
				$(function(){
					var notexist = '<?php echo Yii::app()->request->getQuery('notexist','');?>';
					if(notexist!=''){
						show_tit_box_(3);
					}
				});
        	</script>
        	<input type="submit" style="cursor:pointer" value="搜&nbsp;索" class="fl font26 line_h72 pr22 pl22 col_01 pa r32">
        	</form>
     	</div>
     	<!-- main box -->
		<?php echo $content;?>
		<!-- 信息弹层 -->
		<div class="dis_n tit_box_1 t_50 pf z2000 tc w_100">
			<span class="dis_lb font32 line_h90 pl60 pr60 bgcol_08 b_rad5 col_01">插旗成功！</span>
		</div>
		<div class="dis_n tit_box_2 t_50 pf z2000 tc w_100">
			<span class="dis_lb font24 line_h90 pl60 pr60 bgcol_08 b_rad5 col_01">请勿重复为同一选手插红旗！</span>
		</div>
		<div class="dis_n tit_box_3 t_50 pf z2000 tc w_100">
	    	<span class="dis_lb font24 line_h90 pl60 pr60 bgcol_08 b_rad5 col_01">你居然敢把选手的编号（姓名）记错了？？</span>
	    </div>
	    <div class="dis_n tit_box_4 t_45 pf z2000 tc w_100">
	    	<span class="dis_lb font24 line_h45 pl60 pr60 pt15 pb15 bgcol_08 b_rad5 col_01">请先关注公众号“先之”<br>回复插红旗进入插红旗</span>
	    </div>
     	<a href="#" class="back_btn dis_b pf font24 line_h26 tc"><i class="fa fa-arrow-up line_h26 font24 mt10 ber_col_t01_2p"></i><br>顶部</a>
     	<!-- bottom box -->
     	<ul class="bottom_box w_100 pl32 pr32 pf box_s">
	    	<li><a href="index.php?a=index" class="font30 line_h42 col_01">首页</a></li>
	        <li><a onclick="checkSubscribeBeforeSignup(this)" data-url="index.php?a=signup" href="javascript:;" class="font30 line_h42 col_01">我要报名</a></li>
	        <li><a href="index.php?a=contestIntro" class="font30 line_h42 col_01">赛事说明</a></li>
	        <li><a href="index.php?a=rank" class="font30 line_h42 col_01">排行榜</a></li>
		</ul>
	</div>
</body>
<script type="text/javascript" language="javascript" src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" language="javascript" src="js/main.js"></script>
<script type="text/javascript" language="javascript" src="js/waterfall.js"></script>
</html>

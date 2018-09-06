
<style>
/*点击分享弹出遮罩*/
.alert-bgbox{position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.8);background-image:url(./images/share.png);background-repeat:no-repeat;background-position:70% 50px}
</style>
<div class="contents_box pr32 fl box_s mt28 mb50 pl32 w_100">
	<div class="bgcol_02 b_rad8 box_s pt18 pl18 pr18 w_100 fl">
		<div class="pl22 pr22 box_s fl w_100">
			<div class="line_h45 font22 col_03 fl"><span class="fonts_Arial font22 col_02"><?php echo $userDetail['number'];?></span>号：<?php echo $userDetail['fullname'];?></div>
			<div class="line_h45 font22 col_03 fr"> <span class="fonts_Arial font22 col_02"><?php echo $userDetail['voteCount'];?></span>旗</div>
		</div>
		<div class="pl22 pr22 box_s fl w_100">
			<div class="line_h45 font22 col_03 fl">排名：<span class="col_02">第<span class="fonts_Arial font22"><?php echo $userDetail['rank'];?></span>名</span></div>
		</div>
		<div class="contents_box_con b_rad8 box_s pt5 pb5 pl3 pr3 w_100 fl mt36 mb30 pr">
			<div class="tit_text02 pa l110 t-10"></div>
			<div class="tit_heart ml10 pa t-20 l5"></div>
			<div class="tit_text01 pa l110 t-10"></div>

			<div class="contents_box_con_ b_rad8 font22 col_03 line_h40 pl24 pr24 pt45 pb18"><?php echo $userDetail['signature'];?></div>
		</div>
		<img class="contents_box_img w_100" src="<?php echo $userDetail['cover'];?>" />
		<?php if(!empty($userDetail['picture'])){?>
			<?php foreach($userDetail['picture'] as $v){?>
				<img class="contents_box_img w_100" src="<?php echo $v;?>" />
			<?php }?>
		<?php }?>
		<div class="pl22 pr22 box_s mt45 mb15 fl w_100">
			<a href="javascript:;" onclick="" class="b_rad8 h80 bgcol_03 tc font32 mb20 fl w_100 dis_b line_h80 col_01">插红旗结束</a>
			<a href="javascript:;" id="share" class="b_rad8 h80 bgcol_04 tc font32 mb20 fl w_100 dis_b line_h80 col_01">告诉好友帮ta插红旗</a>
            <a href="index.php?a=index" class="b_rad8 h80 bgcol_05 tc font32 mb20 fl w_100 dis_b line_h80 col_01">查看其他选手</a>
		</div>
	</div>


	<div class="sponsor" align="center">
		<a class="teamprize" style="font-size:24px;color: #333333;">活动奖品由</a>
		<a class="xianzhiwang" href="http://m.9first.com/">先之网</a>
		<a class="teamprize" style="font-size:24px;color: #333333;margin-left:10px">赞助</a>
	</div>
</div>

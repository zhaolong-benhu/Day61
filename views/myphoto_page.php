
<style>
/*点击分享弹出遮罩*/
.alert-bgbox{position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.8);background-image:url(./images/share.png);background-repeat:no-repeat;background-position:70% 50px}
</style>
<div class="contents_box pr32 fl box_s mt28 mb50 pl32 w_100">
	<?php $audit = Yii::app()->request->getParam('audit');?>
	<?php if($audit == 0){?>
	<div class="remind_box bgcol_06 b_rad8 pl22 pr22 pt20 pb20 box_s mb30 fl w_100 line_h45 font26">
		您的提交已经成功啦！小的这就去给您审核。记得要来给自己拉票哦~么么哒！
	</div>
	
    <?php }elseif($audit == 2){?>
    <div class="remind_box bgcol_06 b_rad8 pl22 pr22 pt20 pb20 box_s mb30 fl w_100 line_h45 font26">
		亲，小的弱弱的通报您，提交没有通过审核呢。都是怪您过分美丽，所以小的只好决定把您永久的私藏在我心中。女王在上，请收下我的膝盖！<br>有问题可以联系小的微信哦~
	 </div>
    <?php }?>
	<div class="bgcol_02 b_rad8 box_s pt18 pl18 pr18 w_100 fl">
		<div class="pl22 pr22 box_s fl w_100">
			<div class="line_h45 font22 col_03 fl"><span class="fonts_Arial font22 col_02"><?php echo $model->number;?></span>号：<?php echo $model->fullname;?></div>
			<div class="line_h45 font22 col_03 fr">得票：<span class="fonts_Arial font22 col_02"><?php echo $rankInfo['voteCount'];?></span> 票</div>
		</div>
		<div class="pl22 pr22 box_s fl w_100">
			<div class="line_h45 font22 col_03 fl">红旗排名：<span class="col_02">第 <span class="fonts_Arial font22"><?php echo $rankInfo['rank'];?></span> 名</span></div>
			<a href="index.php?a=rank" class="line_h45 font22 col_07 fr">查看其它选手排行</a>
		</div>
        <div class="contents_box_con b_rad8 box_s pt5 pb5 pl3 pr3 w_100 fl mt36 mb30 pr">
			<div class="tit_heart ml10 pa t-20 l5"></div>
             <div class="tit_text01 pa l110 t-10"></div>
             <div class="contents_box_con_ b_rad8 font22 col_03 line_h40 pl24 pr24 pt45 pb18">
				<?php echo $model->signature;?>
             </div>
		</div>
		<img class="contents_box_img w_100" src="<?php echo $model['cover'];?>" />
		<?php if(!empty($model['picture'])){?>
		<?php foreach($model['picture'] as $v){?>
		<img class="contents_box_img w_100" src="<?php echo $v;?>" />
		<?php }?>
		<?php }?>
		<div class="pl22 pr22 box_s mt45 mb15 fl w_100">
			<a id="share" href="javascript:;" class="<?php if($shareAble==0){echo 'dis_n';}?> b_rad8 h80 bgcol_03 tc font32 mb20 fl w_100 dis_b line_h80 col_01">我要拉票</a>
			<a href="index.php?a=index" class="b_rad8 h80 bgcol_05 tc font32 mb20 fl w_100 dis_b line_h80 col_01">查看其他选手</a>
		</div>
	</div>
</div>

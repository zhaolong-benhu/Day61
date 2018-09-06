<script>
//服务器端验证提示
$(function(){
	if('<?php echo $model->getError('fullname');?>'){
		$('input[name="fullname"]').css('background-color','orange');
	}
	if('<?php echo $model->getError('mobile');?>'){
		$('input[name="mobile"]').css('background-color','orange');
	}
	if('<?php echo $model->getError('signature');?>'){
		$('textarea[name="signature"]').css('background-color','orange');
	}
	if('<?php echo $model->getError('cover');?>'){
		$('form[target="hiframe"] a').eq(0).css('background-color','orange');
	}
});
</script>
<div class="contents_box pr32 fl box_s mt28 mb50 pl32 w_100">
	<div class="bgcol_02 b_rad8 box_s pl40 pr40 pr w_100 fl">
		<div class="page_box_top_l pa z1000 t0"></div>
		<div class="page_box_top"><span class="pa font34 line_h66 col_01 z1000 l55">参赛报名处</span></div>
		<div class="page_box_top_r pa z1000 t0"></div>
		<div class="join_page_main">
			<div class="font20 col_04 line_h90">上传学生年代的萌照片会被增加插红旗的几率哦！</div>
				<!-- reg form -->
				<form id="regForm" action="index.php?a=editProfile&id=<?php echo $model->id;?>" method="post">
				<input type="hidden" name="p_img1" value="<?php echo $model->cover;?>" />
				<input type="hidden" name="p_img2" value="<?php echo isset($model->picture[0])?$model->picture[0]:'';?>" />
				<input type="hidden" name="p_img3" value="<?php echo isset($model->picture[1])?$model->picture[1]:'';?>" />
				<input type="hidden" name="p_img4" value="<?php echo isset($model->picture[2])?$model->picture[2]:'';?>" />
				<input type="hidden" name="p_img5" value="<?php echo isset($model->picture[3])?$model->picture[3]:'';?>" />
				<div class="line_h65 font24 mb20">
					<span class="font_w1 dis_lb"></span>编<span class="font_w2 dis_lb"></span>号：
					<input name="number" value="<?php echo $model->number;?>" disabled type="text" class="join_page_main_form_txt b_rad8 box_s col_05 font24 pl15 pr15" title="" />
				</div>
				<div class="line_h65 font24 mb20">
					<span class="fonts_song col_04">* </span>姓<span class="font_w2 dis_lb"></span>名：
					<input name="fullname" type="text" class="join_page_main_form_txt b_rad8 box_s col_05 font24 pl15 pr15" title="" value="<?php echo $model->fullname;?>" />
				</div>
				<div class="line_h65 font24">
					<span class="fonts_song col_04">* </span>手机号：
					<input name="mobile" type="text" class="join_page_main_form_txt b_rad8 box_s col_05 font24 pl15 pr15" title="" value="<?php echo $model->mobile;?>"/>
				</div>
           		<div class="line_h65 font24">
              		<span class="fonts_song col_04">* </span>参赛宣言：
              		<textarea name="signature" class="join_page_main_form_txt2 box_s b_rad8 w_100 col_05 font24 pl15 pr15 pt15 pb15" title=""><?php echo $model->signature;?></textarea>
           		</div>
           		</form>
           		<div class="line_h45 fl font24 mb20">
					<span class="fonts_song col_04">* </span>上传照片（不超过五张）：
					<iframe name="hiframe" src="" style="display:none;"></iframe>
					<div class="w_100 fl">
						<form target="hiframe" action="index.php?a=upload" method="post" enctype="multipart/form-data">
						<a class="upload_btn2 oh box_s tc dis_lb mt20 mr20 fl pr">
	                 		<input class="input-uploaded" type="file" name="img1" onchange="upload(this)" />
	                 		<i class="fa fa-plus font60 line_h120 col_06 dis_n"></i>
	                 		<div class="pr">
	                 			<img src="<?php echo $model->cover;?>" class="upload_btn_img" />
	                            <i onclick="cancelUpload('img1')" style="cursor:pointer" class="fa fa-close font16 col_01 t0 pa r0"></i>
	                 		</div>
	                 	</a>
						</form>
						<?php for($i=0;$i<4;$i++){?>
						<?php if(isset($model->picture[$i])){?>
						<form target="hiframe" action="index.php?a=upload" method="post" enctype="multipart/form-data">
	                 	<a class="upload_btn2 oh box_s tc dis_lb mt20 mr20 fl pr">
	                 		<input class="input-uploaded" type="file" name="img<?php echo $i+2;?>" onchange="upload(this)" />
	                 		<i class="fa fa-plus font60 line_h120 col_06 dis_n"></i>
	                 		<div class="pr">
	                 			<img src="<?php echo $model->picture[$i];?>" class="upload_btn_img" />
	                 			<i onclick="cancelUpload('img<?php echo $i+2;?>')" style="cursor:pointer" class="fa fa-close font16 col_01 t0 pa r0"></i>
	                 		</div>
	                 	</a>
	                 	</form>
	                 	<?php }else{?>
	                 	<form target="hiframe" action="index.php?a=upload" method="post" enctype="multipart/form-data">
	                 	<a class="upload_btn oh box_s tc dis_lb mt20 mr20 fl pr">
	                 		<input class="input-upload" type="file" name="img<?php echo $i+2;?>" onchange="upload(this)" />
	                 		<i class="fa fa-plus font60 line_h120 col_06"></i>
	                 		<div class="pr dis_n">
	                 			<img src="" class="upload_btn_img" />
	                 			<i onclick="cancelUpload('img<?php echo $i+2;?>')" style="cursor:pointer" class="fa fa-close font16 col_01 t0 pa r0"></i>
	                 		</div>
	                 	</a>
	                 	</form>
	                 	<?php }?>
	                 	<?php }?>
					</div>
              		<div class="w_100 line_h30 col_05 fl font20 mt20">
                 		注：如遇无法上传照片的情况，可以将照片，姓名，手机号，通过微信公众号（先之）发给我们！
					</div>
				</div>
				<div class="mb15 box_s fl w_100">
              		<input onclick="$('#regForm').submit();" type="submit" value="保存" class="b_rad8 h80 bgcol_03 tc font32 mb20 fl w_100 dis_b line_h80 col_01 ber_none" />
              		<a href="" class="b_rad8 h80 bgcol_05 tc font32 mb20 fl w_100 dis_b line_h80 col_01">查看我的作品</a>
           		</div>

		</div>
	</div>
</div>

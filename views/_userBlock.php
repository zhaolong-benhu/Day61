
<!-- 首页瀑布html -->
<li class="b_rad8 ipb_con fl mb30">
	<a href="index.php?a=detail&id=<?php echo $userInfo['id'];?>"><img src="<?php echo $userInfo['cover'];?>" /></a>
    <div class="ipb_con box_s pr20 pl20 mt10 fl">
		<div class="line_h45 font22 fl"><span class="fonts_Arial font22 line_h45"><?php echo $userInfo['number'];?></span>号</div>
		<div class="line_h45 font22 fr"><?php echo $userInfo['fullname'];?></div>
    </div>
    <div class="ipb_con box_s pr20 pl20 mb25 fl">
        <a onclick="giveAVote('<?php echo $userInfo['number'];?>',this)" href="javascript:;" class="vote pr20 pl20 pt10 pb10 col_01 dis_lb font22 bgcol_01 fl" style="width:95px">
       		插红旗
       	</a>

        <?php if($userInfo['isVoted'] == 1){?><img src="images/img_06.png" style="width:32px;heigth:26px;margin-left:-35px;margin-top:12px;"></img><?php }?>
				<?php if($userInfo['isVoted'] == 0){?><img src="images/img_04.png" style="width:32px;heigth:26px;margin-left:-35px;margin-top:12px;"></img><?php }?>

				<!-- <img src="images/img_04.png" style="width:32px;heigth:26px;margin-left:-35px;margin-top:12px;"></img>
				<img src="images/img_06.png" style="width:32px;heigth:26px;margin-left:-35px;margin-top:12px;"></img> -->
       <div class="line_h45 font22 fr"><span class="fonts_Arial font22 line_h45"><?php echo $userInfo['voteCount'];?></span>旗</div>
    </div>
</li>
<script>
$(".vote").click(function(){
    $(this).find("i").css("color","#9a0668");
});
</script>

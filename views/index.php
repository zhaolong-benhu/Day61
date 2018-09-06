
<ul id="J_waterfall" data-uri="index.php?a=getUserList" class="index_pic_box w_100 fl box_s pr32 pl32 mt30">
  <?php foreach($userList as $v){?>
  <li class="b_rad8 ipb_con fl mb30">
    <a href="index.php?a=detail&id=<?php echo $v['id'];?>"><img src="<?php echo $v['cover'];?>" /></a>
    <div class="ipb_con box_s pr20 pl20 mt10 fl">
      <div class="line_h45 font22 fl"><span class="fonts_Arial font22 line_h45"><?php echo $v['number'];?></span>号</div>
      <div class="line_h45 font22 fr"><?php echo $v['fullname'];?></div>
    </div>
    <div class="ipb_con box_s pr20 pl20 mb25 fl">
      <a onclick="" href="javascript:;" class="vote pr20 pl20 pt10 pb10 col_01 dis_lb font22 bgcol_01 fl">
        已结束
      </a>
      <div class="line_h45 font22 fr"><span class="fonts_Arial font22 line_h45"><?php echo $v['voteCount'];?></span>旗</div>
    </div>
  </li>
  <?php }?>
</ul>
<script>
var WATERFALL_CONFIG = {
  'item_unit':'#J_waterfall li',
  'spage_max':'500',//首页加载次数
}
</script>

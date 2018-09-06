
<div class="w_100 mt28 mb50 fl box_s pr32 pr pl32">
	<div class="crown_img pa"></div>
	<table cellpadding="0" id="rank_tab" cellspacing="0" border="0" class="rank_tab ber_col_02_1p w_100">
		<thead>
			<tr class="bgcol_04 w_100">
			<th class="w_25 line_h75 tc font25 col_01">排行</th>
			<th class="w_25 line_h75 tc font25 col_01">编号</th>
			<th class="w_25 line_h75 tc font25 col_01">姓名</th>
			<th class="w_25 line_h75 tc font25 col_01">红旗数</th>
        	</tr>
		</thead>
		<tbody data-uri="index.php?a=getRankList" id="J_waterfall">
			<?php foreach($rankList as $v){?>
	        <tr>
	           <td class="tc line_h70 font22 col_03"><?php echo $v['rank'];?></td>
	           <td class="tc line_h70 font22 col_03"><?php echo $v['number'];?></td>
	           <td class="tc line_h70 font22 col_03"><a href="index.php?a=detail&id=<?php echo $v['id'];?>" class="col_07"><?php echo $v['fullname'];?></a></td>
	           <td class="tc line_h70 font22 col_03"><?php echo $v['voteCount'];?></td>
	        </tr>
	        <?php }?>
        </tbody>
	</table>
</div>
<script>
var WATERFALL_CONFIG = {
	'item_unit':'#J_waterfall li',
	'spage_max':'100',//
}
</script>

<!-- 排行页瀑布加载 -->
<tr>
	<td class="tc line_h70 font22 col_03"><?php echo $rankInfo['rank'];?></td>
	<td class="tc line_h70 font22 col_03"><?php echo $rankInfo['number'];?></td>
    <td class="tc line_h70 font22 col_03"><a href="index.php?a=detail&id=<?php echo $rankInfo['id'];?>" class="col_07"><?php echo $rankInfo['fullname'];?></a></td>
    <td class="tc line_h70 font22 col_03"><?php echo $rankInfo['voteCount'];?></td>
</tr>
<script>
$(".rank_tab tbody tr:odd").addClass("bgcol_02");
$(".rank_tab tbody tr:even").addClass("bgcol_07");
</script>
<tr>									      
<td><?php echo $data['id'];?></td>
<td><?php echo $data['cgh_date'];?></td>
<td><?php
if($data['cgh_type'] == 0){
	echo '店铺首次使用优惠卡';
}else{
	$type = ServiceType::model()->findByPk($data['cgh_type']);
	if (isset($type)) {
		echo '其它' ;
	}else {
		
		echo $type['st_name'];
	}
	
	
// 	echo '洗车';
// }else if ($data['cgh_type'] == 3) {
// 	echo '打蜡';
// }else if ($data['cgh_type'] == 5) {
// 	echo '精洗';
// }else{
// 	echo '其它' ;
}

?></td>
<td><?php echo $data['cgh_count'];?></td>
<td><?php echo $data['cgh_guarantee'];?></td>
<td><?php echo $data['cgh_value'];?></td>
<td>
<?php if ($data['cgh_state'] == 0):?>
<small class="badge bg-default">申请已提交</small>
<?php elseif ($data['cgh_state'] == 1):?>
<small class="badge bg-default">申请已确认</small>
<?php elseif ($data['cgh_state'] == 2):?>
<small class="badge bg-default">制作中</small>
<?php elseif ($data['cgh_state'] == 3):?>
<small class="badge bg-red">已发出</small>
<?php elseif ($data['cgh_state'] == 4):?>
<small class="badge bg-green">已激活</small>
<?php endif;?>

</td>

<td>
<?php if($data['cgh_state']==3):?>
		<button type="button" class="btn btn-primary btn-sm" onclick="ackCard(<?php echo $data['id'].',4';?>)">确认收到</button>
<?php endif;;?>
</td>
</tr>
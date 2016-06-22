<tr>									      
<td><?php echo $data['id'];?></td>
<td><?php echo $data->cghUser['u_name'];?></td>
<td><?php echo $data->cghShop['ws_name'];?></td>
<td><?php echo $data['cgh_date'];?></td>
<td><?php
if($data['cgh_type'] == 0){
	echo '店铺首次使用优惠卡';
}else{
	$type = ServiceType::model()->findByPk($data['cgh_type']);
	if (is_null($type)) {
		echo '其它' ;
	}else {
		
		echo $type['st_name'];
	}
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
<?php if ($data['cgh_state'] == 0):?>
	<button type="button" class="btn btn-danger btn-sm" onclick="ackCard(<?php echo $data['id'].',1';?>)">财务确认</button>
<?php elseif ($data['cgh_state'] == 1):?>
	<button type="button" class="btn btn-primary btn-sm" onclick="ackCard(<?php echo $data['id'].',2';?>)">制作确认</button>
<?php elseif ($data['cgh_state'] == 2):?>
	<button type="button" class="btn btn-success btn-sm" onclick="ackCard(<?php echo $data['id'].',3';?>)">邮寄发放确认</button>
<?php elseif ($data['cgh_state'] == 3):?>
	
<?php elseif ($data['cgh_state'] == 4):?>
	
<?php endif;?>

</td>

</tr>
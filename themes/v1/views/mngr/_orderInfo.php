<?php
if (Yii::app ()->user->hasFlash ( 'commentError' )) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('commentError');?></div>
<?php endif;?>
<tr class="active">
	<td colspan="14" style="text-align: left;">订单编号：<?php echo $data['oh_no'];?>&nbsp;&nbsp;    下单时间：
	<?php
	if (date ( 'Y', strtotime ( $data->oh_date_time ) ) < date ( 'Y' )) {
		echo $data ['oh_order_date_time'];
	} else {
		echo date ( 'n月j日 H:i:s', strtotime ( $data ['oh_order_date_time'] ) );
	}
	?></td>
</tr>
<tr>
<td>
<?php 
$orderShop = $data->ohWashShop;
echo $orderShop->province['p_name'];
?>
</td>
<td>
<?php 
echo $orderShop->city['c_name'];
?>

</td>
	<td>
<?php
if ($data->oh_type > 0) {
	echo ServiceType::model ()->findByPk ( $data->oh_type )['st_name'];
} else {
	echo '自助服务';
}
?> 
</td>
<td>
<?php 
echo $orderShop['ws_name'];
?>
</td>

<td>
<?php

// CHtmlPurifier
echo User::model()->findByPk($data['oh_user_id'])['u_nick_name'];
?>
</td>
	<td>
<?php
if (date ( 'Y', strtotime ( $data->oh_date_time ) ) < date ( 'Y' )) {
	$startTime = date ( 'Y-m-d H:i', strtotime ( $data->oh_date_time ) );
} else {
	$startTime = date ( 'n月j日 H:i', strtotime ( $data->oh_date_time ) );
}

$endTime = date ( '-H:i', strtotime ( $data->oh_date_time_end ) );
echo $startTime . $endTime;
?>
</td>
	<td><?php echo $data['oh_value'];?></td>
	<td><?php echo $data['oh_value_discount'];?>
	</td>
	<td>
<?php if ($data->oh_state >=2): ?>
<span class="text-success">成功</span>
<?php elseif ($data->oh_state == 0) :?>
  <span class="text-default" disabled="disabled">已取消</span>
<?php elseif ($data->oh_state == -2) :?>
  <span class="text-muted" disabled="disabled">客户违约</span>
<?php elseif ($data->oh_state == 1 && $data->oh_user_ack == 0 && $data->oh_boss_ack ==0):?>
  <span id="spanState<?php echo $data->id;?>" class="text-danger">预约中</span>
 <?php elseif ($data->oh_state == 1 && $data->oh_user_ack == 1 && $data->oh_boss_ack ==0):?>
<span id="spanState<?php echo $data->id;?>" class="text-primary">车主已确认</span>
  <?php else:?>
      <span class="text-warning">状态更新中</span>
<?php endif;?>
</td>
	<td>
<?php
if (false && $data->oh_state == 1 && $data->oh_boss_ack == 0 && strtotime ( $data ['oh_date_time'] ) < time ()) :
	?>
 <button class="btn btn-success btn-sm"
			onclick="$('#orderAck<?php echo $data['id'];?>').show();">确认</button>

 <button id="acan<?php echo $data['id'];?>"
			class="btn btn-danger btn-sm"
			onclick="$('#orderCancel<?php echo $data['id'];?>').show();">违约</button>	

<?php endif;?>

	</td>
</tr>

<?php
if ($data->oh_state == 1 && $data->oh_boss_ack == 0 && strtotime ( $data ['oh_date_time_end'] ) < time ()) :
	?>

<?php
//  echo $this->renderPartial('_orderAckOk',array('data'=>$data));
 ?>	

<?php 
// echo $this->renderPartial('_orderAckCancel',array('data'=>$data));
?>	


<?php endif;?>




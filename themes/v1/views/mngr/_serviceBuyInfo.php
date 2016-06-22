<tr>
<td><?php echo $data['id'];?></td>
<td><?php echo  CHtml::decode( $data->spShop['ws_name']);?></td>
<td><?php echo $data['sp_datetime'];?></td>
<td><?php
switch ($data['sp_type']){
			case 0: echo '体验卡';break;
			case 1: echo '银卡';break;
			case 2: echo '金卡';break;
			case 3: echo '钻石卡';break;
			default: echo '体验卡';break;
		}
?></td>
<td><?php 
echo $data['sp_value'];
?></td>
<td><?php echo $data['sp_date_long'];?>天</td>
<td><?php echo $data['sp_name'];?></td>
<td><?php echo $data['sp_tel'];?></td>

<td><?php if ($data['sp_state'] == 0):?>
<small class="badge bg-default">申请已提交</small>
<?php elseif ($data['sp_state'] == 1):?>
<small class="badge bg-red">财务已确认</small>
<?php elseif ($data['sp_state'] == 2):?>
<small class="badge bg-green">已发放</small>
<?php elseif ($data['sp_state'] == 3):?>
<small class="badge bg-green">已激活</small>
<?php endif;?></td>
<td>
<?php if ($data['sp_state'] == 0):?>
	<button type="button" class="btn btn-danger btn-sm" onclick="ackServiceBuy(<?php echo $data['id'].',1';?>)">财务确认</button>
<?php elseif ($data['sp_state'] == 1):?>
	<button type="button" class="btn btn-primary btn-sm" onclick="ackServiceBuy(<?php echo $data['id'].',2';?>)">发放确认</button>
<?php elseif ($data['sp_state'] == 2):?>
	
<?php endif;?>
</td>

</tr>
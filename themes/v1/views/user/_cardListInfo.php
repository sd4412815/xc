<tr>									      
<td><?php 

echo sprintf("%08d",$data['ci_sn']);

?></td>
<td>
<a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$data->ciShop['id']));?>"><?php echo $data->ciShop['ws_name'];?></a>

</td>
<td>


<?php
$type =  $data->ciGenHistory['cgh_type'];
if($type == 0){
	echo '店铺首次使用优惠卡';
}else{
	
	echo '次卡';


	
}

?></td>
<td>

<?php

if($type == 0){
	echo '不限';
}else {
	$st = ServiceType::model()->findByPk($type);
if (!isset($st)) {
	echo '其它' ;
}else {

	echo $st['st_name'];
}
}
?>
</td>

<td>
<?php 
echo $data['ci_value'];
?>
</td>
<td>
<?php 
if (empty($data['ci_date_end'])) {
	echo '长期';
}else {
	echo date('Y-m-d',strtotime($data['ci_date_end'])) ;
}
?>
</td>
<td>
<?php if ( strtotime($data['ci_date_end']) < time()):?>
<small class="badge bg-default">已过期</small>
<?php elseif ($data['ci_state'] == 2):?>
<small class="badge bg-green">已使用</small>
<?php else:?>
<small class="badge bg-red">未使用</small>
<?php endif;?>

</td>


</tr>
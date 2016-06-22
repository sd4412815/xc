<?php 
$isAvailable = false;
if (strtotime(date('Y-m-d ', strtotime ( '+ ' . $data['ot_bias'] . ' days ' ) ).$data['ot_date_time']) > time()+20*60 && $data['ot_state']==1) {
	$isAvailable = true;
}


?>
   <a class="btn btn-app" name="sdate" id="sTimeStr<?php echo $data['id'];?>" title="<?php echo "￥".$data->ot_value;?>"
   data-price="<?php echo $data->ot_value;?>" data-value="<?php echo $data['id'];?>"  data-discount="<?php echo $data->ot_discount; ?>"
<?php 
if ($isAvailable) {
// 	echo 'enabled';
} else {
	echo 'disabled';
}
?> >
<?php if ($data->ot_discount < 1):?>
  	<span class="badge bg-red">折</span>
<?php endif;?>
<?php
 if($data->ot_state == 0 &&  ( strtotime( $data->ot_date_time)< time()+20*60) ):
 ?>

<?php else: ?>

<?php if ($data->ot_state==0 || $data->ot_state==2 || $data->ot_state==3):?>
<?php if ($data->ot_discount < 1):?>
<span class="badge bg-red">折&nbsp;&nbsp;已约</span>
<?php endif;?>
<span class="badge bg-green" >已约</span>
<?php endif;?>

<?php endif; ?>

<?php echo substr($data['ot_date_time'],0,5) ;?></a>
	

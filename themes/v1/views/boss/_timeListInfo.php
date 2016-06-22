<?php 
$isOver = true;
if (strtotime(date('Y-m-d ', strtotime ( '+ ' . $data['ot_bias'] . ' days ' ) ).$data['ot_date_time']) > time()+60*60 ) {
	$isOver = false;
}


?>


<a style="padding: 2px;margin:2px 0px 0px 2px;" title='<?php echo CHtml::decode('&yen;'.$data->ot_value);?>'>
<label >
<input type="checkbox" id="sTime<?php echo $data['id'];?>" data-price="<?php echo $data->ot_value;?>" name="sdate" value="<?php echo $data['id'];?>"
 <?php 
if (!$isOver && ($data['ot_state']==0 || $data['ot_state']==1) ) {
	echo 'enabled';
} else {
	echo 'disabled';
}
?>
>
<span   id="sTimeStr<?php echo $data['id'];?>" class="btn btn-app" style="height:40px;
	 display:-moz-inline-box;  display:inline-block; ;margin:0px;padding-top:8px;font-size:15px;width:120px;">
<span
<?php if ($isOver && $data['ot_state']==2):?>
style="background-color:#FFB5B5;color:#D3D3D3;font-size:15px;">
<?php elseif ($isOver):?>
style="color:#D3D3D3;font-size:15px;">
<?php elseif ($data['ot_state']==2):?>
style="background-color:#FFB5B5;font-size:15px;">
<?php elseif ($data['ot_state']==3):?>
style="color:#FFB5B5;font-size:15px;">
<?php elseif($data['ot_state']==0) :?>
style="color:#2828FF;">
<?php else:?>
style="color:#007500;">
<?php endif;?>

<?php 
echo substr($data['ot_date_time'],0,5) .'-'.substr($data['ot_date_time_end'],0,5);
?>

<span class="text-muted"><?php echo '('.$data['ot_value'].')';?></span>

</span>  
<?php if ($data->ot_discount < 1):?>
  	<span class="badge bg-red" >折</span>
<?php endif;?>

</span>



</label>	
</a>		

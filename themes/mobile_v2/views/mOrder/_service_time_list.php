<?php 
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/loaders.css.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/flavr.min.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END );
foreach ($timeList as $key=>$time):

$availableStatus=FALSE;

if ($time['ot_state'] == OrderTemp::STATE_READY 
		
		&& ($time['ot_position']-$time['ot_order_count'] > 0)){
	
	if ($time['ot_bias'] ==0 ){
		if($time['ot_date_time']>date('H:i', time()+20*60)){
			$availableStatus = TRUE;
		}

	}else {
		$availableStatus = TRUE;
	}
	
	
}

?>
<a name="sTime" data-value="<?php echo $time['id'] ;?>"
<?php if($time['ot_gift']>0):?>
 class="btn btn-item time-info free-stick <?php echo $availableStatus?'':'disabled';?>" data-text="礼" title="赠送精品好礼">
<?php else :?>
 class="btn btn-item time-info <?php echo $availableStatus?'':'disabled';?>">
<?php endif;?>
<?php echo  substr($time['ot_date_time'], 0,5) ;?>

<?php if ($time['ot_value']<5 && $time['ot_value_discount']>0):?>
<span class="zhe-box" data-text=""><i class="fa fa-jpy"></i><?php

if ($time['ot_value'] < 1 ){
	echo number_format($time['ot_value'],2) ;
}else{
	echo number_format($time['ot_value'],0) ;
}

 ?></span>
<?php elseif($time['ot_value_discount']>0):?>
<span class="zhe-stick" data-text="折"></span>
<?php endif;?>

<?php if($time['ot_state'] == OrderTemp::STATE_ORDERED || ($time['ot_position']-$time['ot_order_count'] == 0)):?>
<span class="ding-box">满</span>
<?php elseif($time['ot_state'] == OrderTemp::STATE_BOSS_DISABLED):?>
<span class="liu-box">留</span>
<?php endif;?>
<?php if($time['ot_order_count']>0):?>
<span class="ding-count-box"><?php echo $time['ot_order_count']; ?></span>
<?php endif;?>


</a>
<?php endforeach;?>

<?php
Yii::app ()->clientScript->registerScript ( 'time_list', ' 
set_time_change_ini();  
       		
			', CClientScript::POS_READY );
?>
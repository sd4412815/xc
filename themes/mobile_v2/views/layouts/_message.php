<?php
$msgs = Message::model ()->getLateastMessage ( $userId, 3 );

foreach ( $msgs as $key => $msg ) :
	?>
<li><a href="#" onclick="showMsgModal(<?php echo $msg['id'];?>)">
<?php
switch ($msg['m_type']){
	case 0: $mtype='fa-info-circle';break;
	case 1: $mtype='fa-gift';break;
	default: $mtype = 'fa-bullhorn';break;
}

switch ($msg['m_level']):?>
<?php case 0:?>
<i class="fa <?php echo $mtype?>"></i>
<?php break; ?>
<?php case 1:?>
<i class="fa <?php echo $mtype?> success "></i>
<?php break; ?>
<?php case 2:?>
<i class="fa <?php echo $mtype?> warning"></i>
<?php break; ?>
<?php case 3:?>
<i class="fa <?php echo $mtype?> danger"></i>
<?php break; ?>
<?php default: ?>
<i class="fa <?php echo $mtype?> info"></i>
<?php break; ?>

<?php endswitch;?>

											<p class="pull-right text-blue">
												<small style="padding-right: 15px;"> <i
													class="fa fa-clock-o"></i> 
<?php
	$msgTime = strtotime ( $msg ['m_datetime'] );
	$current = time ();
	$jg = ( int ) (($current - $msgTime) / 60);
	if ($jg < 60) {
		echo $jg . '分钟前';
	} else if ($jg < 60 * 6) {
		echo (( int ) ($jg / 60)) . '小时前';
	} else if ($msgTime > strtotime ( date ( 'Y-m-d' ) )) {
		echo '今天';
	} else if ($msgTime > strtotime ( date ( 'Y-m-d' ) . ' - 1 days' )) {
		echo '昨天';
	} else {
		echo date ( 'm月d日', $msgTime );
	}
	?></small>
											</p>
<?php
	$this->beginWidget ( 'CHtmlPurifier' );
	if (strlen ( $msg ['m_content'] ) <= 48) {
		echo $msg ['m_content'];
	} else {
		echo mb_substr ( $msg ['m_content'], 0, 48 ) . '…………';
	}
	$this->endWidget ();
	?>
</a></li>						
<?php
endforeach
;
?>
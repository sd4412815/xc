<?php

$msg = $data;
	?>
<tr>
<td class="col-xs-3 col-sm-2 col-lg-1">
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
	} else if(date('Y') == date('Y',$msgTime)){
		echo date ( 'm月d日', $msgTime );
	}else{
		echo date ( 'Y-m-d', $msgTime );
	}
	?>
</td>
<td class="col-xs-7 col-sm-9 col-lg-10 ">
<?php 
if ($msg['m_status'] == 0):
?><a href="#" onclick="readmsg(<?php echo $msg['id'];?>)"><span class="text-red">
<?php endif;?>
<?php
	$this->beginWidget ( 'CHtmlPurifier' );
	if (strlen ( $msg ['m_content'] ) <= 480) {
		echo $msg ['m_content'];
	} else {
		echo mb_substr ( $msg ['m_content'], 0, 48 ) . '…………';
	}
	$this->endWidget ();
	?>
<?php 	
if ($msg['m_status'] == 0):?>
</span></a>
<?php endif;?>
</td>
<td class="col-xs-2 col-sm-1">
<?php 
if ($msg['m_status'] == 0):
?><a href="#" onclick="showMsgModal(<?php echo $msg['id'];?>)"><span class="text-red">未读</span>					
</a>

<?php elseif ($msg['m_status'] ==1):?>
<span class="text-muted">已读</span>
<?php endif;?>
</td>
</tr>						

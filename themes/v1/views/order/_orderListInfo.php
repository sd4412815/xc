
<tr>

	<td>
<?php
if ($data->oh_type > 0) {
    echo ServiceType::model()->findByPk($data->oh_type)['st_name'];
} else {
    echo '自助服务';
}
?> 
</td>


	<td>
<?php

// CHtmlPurifier
// echo User::model()->findByPk($data['oh_user_id'])['u_nick_name'];
$user =  User::model()->findByPk($data['oh_user_id']);
$userTel = $user['u_tel'];

if(substr($userTel, -4,4) == $user['u_nick_name']){

	echo substr($userTel, 0,2).'***'.substr($userTel, -2,2);
}
else{
	echo $user['u_nick_name'];

}
// $userTel = User::model()->findByPk($data['oh_user_id'])['u_tel'];
// echo substr($userTel, 0,2).'***'.substr($userTel, -2,2);
?>
</td>
	<td>
<?php
if (date('Y', strtotime($data->oh_order_date_time)) < date('Y')) {
    $startTime = date('Y-m-d H:i', strtotime($data->oh_order_date_time));
} else {
    $startTime = date('n月j日 H:i', strtotime($data->oh_order_date_time));
}

// $endTime = date ( '-H:i', strtotime ( $data->oh_date_time_end ) );
echo $startTime;
?>
</td>
	<td><?php echo $data['oh_value'];?>
<?php

if ($data['oh_discount'] < 1) :
    ?>	
<span class="label label-danger" style="font-size: 12px;">折</span>
<?php endif;?>
	</td>
	<td>
	 <?php

 $this->widget('star.starWidget',array('score'=> $data ['oh_score'])); ?>	
	</td>



</tr>




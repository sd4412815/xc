                         
<?php 
$isOver = true;
if (strtotime($data['oh_date_time_end']) > time()) {
	$isOver = false;
}

$state = 0;
if ($isOver) {
	;
}
?>

<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3"> 
<div class="box box-solid  <?php
if( time()> strtotime($data['oh_date_time']) &&  time() < strtotime($data['oh_date_time_end'])) {
	echo ' bg-yellow ';
}elseif ($data['oh_state']==1) {
	echo 'box-primary';
}else if ($data['oh_state']==2) {
	echo 'box-success';
}else if( time()> strtotime($data['oh_date_time']) &&  time() < strtotime($data['oh_date_time_end'])) {echo ' bg-warning ';} ?>">
	<div class="box-header ">
    	<h2 class="box-title"><?php echo substr($data['oh_date_time'],11,5).'-'.substr($data['oh_date_time_end'],11,5);

    	?>
     </h2>
        <div class="box-tools pull-right">
      	 <small class="label label-default"><?php 
      	 $orderDay = strtotime(substr($data['oh_date_time'],0,10))    ;
      	 $today = strtotime(date('Y-m-d'))    ;
      	 
      	 switch (floor(($orderDay-$today)/24/3600)){
      	 		case 0:echo '今';break;
      	 	case 1:echo ' 明';break;
      	 	case 2:echo ' 后';break;
      	 } 
	 
      	?></small>
      	<small class="label label-default"><?php  echo $data['oh_position'];  	  ?></small>
      	 <small class="label label-default"><?php echo Yii::app()->params['carType'][$data['oh_car_type']];?></small>
        </div>
   </div>
   <div class="box-body" >
   
   <div class="small-box" >
      <div class="inner">
      <div class="row">
    		     <div class="col-xs-12 col-sm-6  text-center">
     	<div class="h2" ><strong><code>
<?php echo  $data->serviceType['st_name'];
     	?></code></strong>  	
</div>
     </div>
      <div class="col-xs-12 col-sm-6  text-center">
           <span class="h1">
            <sup style="font-size: 15px"><i class="fa fa-jpy"></i></sup><strong><?php echo $data['oh_value']-$data['oh_value_discount'];?></strong>                       
			<?php if ($data['oh_discount']<1):?>
		 		<sup style="font-size: 10px"><span class="badge bg-red" >折</span></sup>	
			<?php endif;?>
         </span>
      </div> 
    
      </div>
<div class="row">
         <div class="col-xs-6  text-center">累计
		<small class="label label-primary">
<?php 
$countRlt = OrderHistory::model()->getOrderCountByUserFromShop($data['oh_user_id'], $data['oh_wash_shop_id'],'2015-01-01','2015-10-31',$data['oh_type'],FALSE);
// $countRlt = OrderHistory::model()->getOrderCountByUserFromShop($data['oh_user_id'], $data['oh_wash_shop_id']);
if ($countRlt['status']){
	echo $countRlt['data'];
}
		
?></small>  </div>
        <div class="col-xs-6  text-center">用户 <small class="label label-primary"">
<?php
echo User::model()->findByPk($data['oh_user_id'])['u_nick_name'];
?></small>
         </div>
</div>

      </div>
      <div class="icon"></div>
     </div>
   
    </div><!-- /.box-body -->
<?php if($isOver) :?>
	<div class="overlay"></div>
<?php endif;;?>                           
                                <!-- end loading -->
</div><!-- /.box -->
 
</div>
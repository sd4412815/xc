<?php
if (Yii::app ()->user->hasFlash ( 'commentError' )) :
	?>
<div class="alert alert-danger" role="alert"><?php echo Yii::app()->user->getFlash('commentError');?></div>
<?php endif;?>


<div class="box box-warning box-solid">
    <div class="box-header with-border">
      <h3 class="box-title" style="font-size: 14px;">预约时间：
                <?php
                if (date ( 'Y', strtotime ( $data->oh_date_time ) ) < date ( 'Y' )) {
                	$startTime = date ( 'Y-m-d H:i', strtotime ( $data->oh_date_time ) );
                } else {
                	$startTime = date ( 'n月j日 H:i', strtotime ( $data->oh_date_time ) );
                }
                
                $endTime = date ( '-H:i', strtotime ( $data->oh_date_time_end ) );
                echo $startTime . $endTime;
                ?>
      </h3>
      <div class="box-tools pull-right">
<!--         <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
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
      </div>     
    </div>    
    <div class="box-body">
           <small>订单编号：<?php echo $data['oh_no'];?></small>
	       <br>
	       <small>订单详情：
	       <?php
                if ($data->oh_type > 0) {
                	echo ServiceType::model ()->findByPk ( $data->oh_type )['st_name'];
                } else {
                	echo '自助服务';
                }
                ?> 
                
          : ￥<?php echo $data['oh_value'];?>元 &nbsp;&nbsp;&nbsp;&nbsp;
		        优惠：<?php echo $data['oh_value_discount'];?>元 &nbsp;&nbsp;&nbsp;&nbsp;
		        车主：<?php
            echo User::model()->findByPk($data['oh_user_id'])['u_nick_name'];
            ?>
		 </small>
		 <br>
		 <small>
		   下单时间：
        	<?php
        	if (date ( 'Y', strtotime ( $data->oh_date_time ) ) < date ( 'Y' )) {
        		echo $data ['oh_order_date_time'];
        	} else {
        		echo date ( 'n月j日 H:i:s', strtotime ( $data ['oh_order_date_time'] ) );
        	}
        	?>
		 </small>
    </div>
</div>
          
          


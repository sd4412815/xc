<tr>
 
                                            <th><?php
// echo substr($data_>no,0,16);
echo CHtml::encode($data->oh_no);
?></th>
       <th>
<?php 
if ($data->oh_type > 0) {
echo ServiceType::model()->findByPk($data->oh_type)['st_name'];
}
else {
echo '自助服务';
}
?>                                            
                                        
                                            
                                            </th>
                                            <th>
                                               <?php 
                               
//                                             $shop =	WashShop::model()->findByPk($data['oh_wash_shop_id']);
//                                             echo $shop['ws_name'];
                                            ?>
                                           <a href="<?php echo  Yii::app()->createUrl('order/new&id='.$data->oh_wash_shop_id); ?>" target="_blank">
                                           <?php echo WashShop::model()->findByPk($data['oh_wash_shop_id'])['ws_name']; ?>
                                           </a> 
                                         
                                            
                                            		
                                            </th>
                                            <th><?php
echo CHtml::encode($data->oh_date_time);
?></th>
                                            <th>
                                            <?php if ($data->oh_state >=2): ?>
                                        <span class="text-success">已成功完成</span>
                                            <?php
elseif($data->oh_state ==0):
?>
  <span class="text-default" disabled="disabled">已取消</span>
<?php elseif ($data->oh_state == 1 && $data->oh_user_ack == 0 && $data->oh_staff_ack == 0 && $data->oh_boss_ack ==0):?>
  <span id="spanState<?php echo $data->id;?>" class="text-danger">预约中</span>
  <?php elseif ($data->oh_state == 1 && $data->oh_user_ack == 0 && $data->oh_staff_ack == 1 && $data->oh_boss_ack ==0):?>

    <span id="spanState<?php echo $data->id;?>" class="text-primary">您已确认</span>
      <?php elseif ($data->oh_state == 1 && $data->oh_user_ack == 1 && $data->oh_staff_ack == 0 && $data->oh_boss_ack ==0):?>

    <span id="spanState<?php echo $data->id;?>" class="text-info">车主已确认</span>
  <?php else:?>
      <span class="text-warning">状态更新中</span>
<?php endif;?>
                                            </th>
                                     
                                            <th>
                                       <?php 
//                                        echo CHtml::activeCheckBox($data,'oh_user_ack');
                                       if ($data->oh_state == 1  && $data->oh_staff_ack ==0) :
                                       ?>
                                        <button class="btn btn-success btn-sm" onclick="$('#orderAck<?php echo $data['id'];?>').show();">确认</button> 
                                   <div id="orderAck<?php echo $data['id'];?>" style="display:none;">
 <br />
    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
          <b>确认订单!</b>                         
<p>
     请在车主到店消费后及时确认订单，还可以赚取积分奖励哦！

    </p>

      <button class="btn btn-success" onclick="orderAck(<?php echo $data['id'];?>,1)">确认完成</button> 
     <button class="btn btn-primary"  onclick="$('#orderAck<?php echo $data['id'];?>').hide();">返回</button>
                           
                                    </div>
 </div>

 
 
 <?php elseif ($data->oh_state >=2) :?>

                                       <?php endif;?>
                                        <a target="_blank" href="<?php echo Yii::app()->createUrl('orderHistory/orderView',array('id'=>$data->id));?>" class="btn btn-primary btn-sm">查看</a>
                                            </th>
                                        </tr>

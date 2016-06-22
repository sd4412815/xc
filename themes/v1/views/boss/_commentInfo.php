 <li class="list-group-item">
<p><?php echo $data['oc_comment'];?></p>
<p>
<?php echo $data->User['u_nick_name'];?>
<span class="pull-right" style="color:#888888;">预约单号：<?php echo $data->Order['oh_no'];?> 
服务：<?php echo  $data->Order->serviceType['st_name'];?>&nbsp&nbsp 
评价时间：<?php echo $data['oc_datetime'];?></span></p>
<?php
$rc  = OrderComments::model()->findByAttributes(array('oc_related_id'=>$data['id']));
if(isset($rc)):?>
<p>【店主回复】<?php echo $rc['oc_comment'];?><span class="pull-right" style="color:#888888;">回复时间：<?php echo $rc['oc_datetime'];?></span></p>
<p style="text-align:right;"><button class="btn btn-success btn-sm" onclick="disUpdateComment('<?php echo Yii::app()->createUrl('OrderComments/disUpdateComment',array('id'=>$rc['id'],'new'=>'0'));?>')">修改</button></p>
<?php else:?>
<p style="text-align:right;">
<button class="btn btn-danger btn-sm" onclick="disUpdateComment('<?php echo Yii::app()->createUrl('OrderComments/disUpdateComment',array('id'=>$data['id'],'new'=>'1'));?>')">回复</button>
</p>

<?php endif;?>			
									  </li>
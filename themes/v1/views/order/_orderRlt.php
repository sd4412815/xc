<div class="row">
	<div class="col-sm-12">
		<div class="box box-danger">
			<div class="box-header">
				<h3 class="box-title"></h3>
			</div>
			<div class="box-body">
				<h3 class="text-red text-center">车位预定成功！</h3>
				<br>
				<h4 class="text-center">
					订单编号：
					<code><?php echo $order['oh_no'];?></code>
					服务：<span class="text-blue"> <?php
					
if ($order->oh_type > 0) {
						echo ServiceType::model ()->findByPk ( $order->oh_type )['st_name'];
					} else {
						echo '自助服务';
					}
					?> </span> &nbsp;&nbsp;
				</h4>
				<h4 class="text-center">
					洗车行：<a
						href="<?php echo  Yii::app()->createUrl('order/new',array('id'=>$order->oh_wash_shop_id)); ?>"
						target="_blank"><span class="text-blue"> <?php echo WashShop::model()->findByPk($order['oh_wash_shop_id'])['ws_name']; ?> </span>

					</a> &nbsp;&nbsp;预约时间：<span class="text-blue">
<?php echo date('m月d日 H:i',strtotime($order['oh_date_time'])).date('-H:i',strtotime($order['oh_date_time_end']));?>
</span>
					&nbsp;&nbsp;到店支付： <span class="text-red"><?php echo $order['oh_value']-$order['oh_value_discount'];?>元 </span>
				</h4>
				<h4 class="text-center">车位保留5分钟，如行程有变，请提前取消订单!</h4>
				<br>
				<p class="text-center">
					<a class="btn btn-danger"
						href="<?php echo Yii::app()->createUrl('user/list');?>">查看订单</a> <a
						class="btn btn-danger"
						href="<?php echo Yii::app()->createUrl('site/index');?>">返回首页</a>
				</p>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
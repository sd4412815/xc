

	<div class="row">

		<div class="col-sm-12">

		<div class="box box-warning">
				<div class="box-header">
					<i class="fa fa-bullhorn"></i>
					<h3 class="box-title">上线须知</h3>
				</div>
				
				<div class="box-body">
<?php if ($shop['ws_state'] == 2):?>
<div class="callout callout-info">
<p>您已开通
<?php 
$services = WashShopService::model()->getServices($shop['id'])['data'];

// WashShopService::model()->findAllByAttributes(array('wss_ws_id'=>$shop['id']));

foreach ($services as $key=>$value):
?>
<small class="badge bg-yellow"><?php echo $value->wssSt['st_name'];?></small>
<?php endforeach;?>服务
</p>
<p>
<code>各项服务标准（用时，价格等）</code>是根据各个车行自助设置的，现在就去看看吧<code></code><a href="<?php echo Yii::app()->createUrl('boss/serviceSet');?>" class="btn btn-primary btn-sm">查看</a> <a href="<?php echo Yii::app()->createUrl('boss/serviceSet');?>" class="btn btn-warning btn-lg">去设置</a></p>
<p>
	</div>
<?php endif;?>					
						
<?php if ($shop['ws_level'] == 0 && 0):?>
<div class="callout callout-danger">
<p>
<code>收费版</code>提供更高效的营销服务，可以获得更好的经营效果 <a href="<?php echo Yii::app()->createUrl('boss/service');?>" class="btn btn-primary btn-sm">了解更多</a> <a href="<?php echo Yii::app()->createUrl('boss/service');?>" class="btn btn-warning btn-lg">去购买</a></p>
<p>
	</div>
<?php endif;?>
						
				
				
						
<?php if ($shop['ws_level'] == 0):?>
	<div class="callout callout-info">
<p>
立即上线体验一下效果吧 
<?php
		
		echo CHtml::link ( CHtml::encode ( '免费上线' ), array (
				'WashShop/online' 
		), array (
				'submit' => array (
						'WashShop/online' 
				),
				'class' => 'btn btn-success btn-lg',
				'confirm' => '上线前必须设置好各项服务标准，确认上线么?' 
		) );
		?></p>	</div>
<?php endif;?>

						

						
				
				</div>
			</div>		
			
		</div>

	</div>

	<!-- /.row -->






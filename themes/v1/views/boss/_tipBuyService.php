<section class="content-header">
<h1><?php
// header("Content-Type:text/html;   charset=utf-8");
echo $serviceName; ?><small>
</small> </h1> 
 <ol class="breadcrumb hidden-xs">
 <li><a href="<?php echo Yii::app()->createUrl('boss/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
<li class="active">服务未开通</li>
</ol>
</section>
<section class="content">
<div class="row">

		<div class="col-sm-12">
			<div class="box box-warning">
				<div class="box-header">
					<i class="fa fa-bullhorn"></i>
					<h3 class="box-title">服务购买提示</h3>
<!-- 					<div class="pull-right box-tools"> -->
<!-- 						<button class="btn btn-info btn-sm" data-widget="remove" -->
<!-- 							data-toggle="tooltip" title data-original-title="隐藏"> -->
<!-- 							<i class="fa fa-times"></i> -->
<!-- 						</button> -->
<!-- 					</div> -->
				</div>

				<div class="box-body">
				
<?php if ($shop['ws_level'] == 0):?>	<div class="callout callout-danger">
						<p>
							当前账户未开通<small class="badge bg-success"><?php echo $serviceName; ?></small>服务，<code>收费版</code>
							提供更高效的营销服务，可以获得更好的经营效果 <a
								href="<?php echo Yii::app()->createUrl('boss/service');?>"
								class="btn btn-primary btn-sm">了解更多</a> <a
								href="<?php echo Yii::app()->createUrl('boss/service');?>"
								class="btn btn-warning btn-sm">去购买</a>
						</p>
						<p>
					
					</div>
<?php endif;?>

				
					

				</div>
			</div>


		</div>

	</div>
</section>

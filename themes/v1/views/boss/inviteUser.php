<?php
$this->pageTitle = '会员邀请';
?>
<section class="content-header">
	<h1>
		会员邀请 <small><?php
		
		?></small>
	</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('boss/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">会员邀请</li>
	</ol>
</section>
<section class="content">
<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="box  box-warning">

				<div class="box-body" id="inviteUser">
<?php
$this->renderPartial ( '_inviteUser', array (
		'model' => $model 
) );
?>			
	
			<!-- /.box-body -->

				</div>
				<!-- /.box -->
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="box  box-warning">

				<div class="box-body">
				<div class="callout callout-info">
					
							<p>
							累计订单<code>
<?php 
$rlt = OrderHistory::model()->getBossTotalCount($boss['b_user_id']);
if ($rlt['status']){
	echo $rlt['data'];
}else{
	echo '0';
}				
// echo CJSON::encode($rlt);			
							?></code>
							
						</p>
							<p>
							历史车主<code>
<?php 
$rlt = OrderHistory::model()->getBossTotalUser($boss['b_user_id']);
if ($rlt['status']){
	echo $rlt['data'];
}else{
	echo '0';
}				
// echo CJSON::encode($rlt);			
							?></code>
							
						</p>
						<p>
							会员数量<code>
<?php 
$rlt = OrderHistory::model()->getBossTotalMember($boss['b_user_id']);
if ($rlt['status']){
	echo $rlt['data'];
}else{
	echo '0';
}				
// echo CJSON::encode($rlt);			
							?>							</code>
							
						</p>
					</div>

	


				</div>
				
			</div>
		</div>
		</div>

</section>
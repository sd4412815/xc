<?php
$this->pageTitle =  $atype;
UTool::setCsrfValidator();
UTool::checkRepeatActionReset();
unset(Yii::app()->session['resetStep']);
unset(Yii::app()->session['resetOkOn']);

?>
    <div class="row"> 
    	<div class="col-md-offset-2  col-md-8" >
		<div class="box  box-warning" style="z-index:50;">
			<div class="box-header">
				<h3 class="box-title text-center text-yellow "><?php echo $atype;?></h3>
			</div>
			<div >
				 <ul id="progressbar">
				<li class="active">填写账号</li>
				<li class="active">验证身份</li>
				<li class="active">设置新密码</li>
				<li class="active">完成</li>
			</ul>
			</div>
			<!-- /.box-header -->
				<div class="box-body">
					 <h3 class="text-success text-center">新密码设置成功！</h3>
			 <p class="text-center">请牢记您新设置的密码 <a href="<?php echo Yii::app()->createUrl('site/login');?>" class="text-primary">马上去登陆</a></p>

			<!-- /.box-body -->
			
		</div>
		<!-- /.box -->
	</div>
        
   </div><!-- row -->
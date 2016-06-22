<?php
$this->pageTitle = '基本信息维护';
?>
<?php 
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-timepicker.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ichecksquare/green.css" );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-timepicker.min.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD );

?>
<style type="text/css">
	table,tr,td{
		margin: 0;
		padding: 0;
	}
	table img {
		margin-left: 10%;
		width: 25px;
		height: 25px;
	}
	.service-img{
		width: 10%;
		text-align: right;
	}
	.service-name{
		text-align: right;
		width: 23%;
	}
	.service-input input,.service-input,.service-input textarea,.service-input select{
		text-align: left;
		margin: 0;
		padding:0;
	}
	.service-table tr{
		border-bottom: 2px solid #fabf87;
		line-height: 50px;
	}
	.yuan{ 
		-ms-transform: scale(2); /* IE */
		-moz-transform: scale(2); /* FireFox */
		-webkit-transform: scale(2); /* Safari and Chrome */
		-o-transform: scale(2); /* Opera */
	}
</style>


<?php
	if (Yii::app ()->user->hasFlash ( 'info' )) :
?>
	<div class="alert alert-danger" role="alert" style="text-align:center;">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span style="font-size:16px;"><?php echo Yii::app()->user->getFlash('info');?></span>
	</div>
<?php endif;?>

				<?php
				$form = $this->beginWidget ( 'CActiveForm', array (
						'action'=>$this->CreateUrl('MWeiXinEntConfig/basicInfo'),
						'id' => 'ws-form',
						'enableAjaxValidation'=>true, //是否启用ajax验证
						'enableClientValidation' => true,
						'clientOptions' => array (
								'validateOnSubmit' => true ,
								'validateOnChange'=>true, //输入框值改变时验证
						),
						'htmlOptions' => array (
						// 				'enctype' => 'multipart/form-data',
								'class' => 'form-horizontal'
						)
				) );?>

					<div style="margin:0;border-top:5px solid #f58320;width:100%;">
						<table style="width:100%" class="service-table">
								<!-- <tr>
									<td class="service-img"><img src="<?php //echo Yii::app()->theme->baseUrl?>/img/basicInfo/num.png" alt=""> </td>
									<td class="service-name"><label for="inputEmail3" class="col-sm-2 control-label">加盟号</label></td>
									<td><p class="form-control-static">&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $model['ws_no'];?></p></td>
								</tr>
 -->
							<!-- 	<tr>
									<td class="service-img"><img src="<?php //echo Yii::app()->theme->baseUrl?>/img/basicInfo/name.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">
											<span class="text-red">*</span>
											车行名称
										</label>
									</td>

									<td  class="service-input">
										<div class="col-sm-8">
											<?php //echo $form->textField($model,'ws_name',array("class"=>"form-control",'disabled'=>'disabled'));?>
										</div>
									</td>
								</tr> -->

								<tr>
									<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/add.png" alt=""> </td>
									<td class="service-name">
										<label for="inputPassword3" class="col-sm-2 control-label">
											<span class="text-red">*
											</span>关键字
										</label>
									</td>
									<td  class="service-input" style="margin:0">
										<div class="col-sm-8">
											<?php echo $form->textField($model,'ws_key_words',array("class"=>"form-control"));?>
										</div>
									</td>
								</tr>

								

								<!-- <tr>
									<td class="service-img"><img src="<?php //echo Yii::app()->theme->baseUrl?>/img/basicInfo/boss.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">
											<span class="text-red">*</span>
											店长
										</label>
									</td>
									<td  class="service-input">
										<div class="col-sm-8">
											<?php //echo $form->textField($boss,'b_real_name',array("class"=>"form-control"));?>
										</div>
									</td>
								</tr>
 -->
								<tr>
									<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/tel.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">
											<span class="text-red">*</span>
											电话
										</label>
									</td>
									<td  class="service-input">
										<div class="col-sm-8">
											<?php echo $form->textField($user,'u_tel',array("class"=>"form-control",'disabled'=>'disabled'));?>
										</div>
									</td>
								</tr>

								<tr>
									<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/num1.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">车位个数</label>
									</td>
									<td  class="service-input">
										<div class="col-sm-8">
											<input type="text" class="form-control" placeholder="2" disabled>
										</div>
									</td>
								</tr>

								<tr>
									<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/service.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">服务类型</label>
									</td>
									<td  class="service-input">

										<?php
											$sts = ServiceType::model ()->findAll (array('order'=>'st_flag ASC'));
											$shopsts =  WashShopService::model()->getServices($model['id'])['data'];
											$stids = array ();
											$availableStids=array();
											foreach ( $shopsts as $shopst ) {
												array_push ( $stids, $shopst ['wss_st_id'] );
												if ($shopst['wss_state']==1) {
													array_push ( $availableStids, $shopst ['wss_st_id'] );
												}
											}
											foreach ( $sts as $key => $st ) :
											?>

										    <input type="checkbox" class="yuan" style="margin:10px;" name="stype" value="<?php echo $st['id'];?>"
												<?php
													if (in_array ( $st ['id'], $stids ) ) {
														if ($editable=='disabled' && in_array ( $st ['id'], $availableStids )){
															echo 'checked';
														}
														if( $editable=='' ){
															echo 'checked';
														}
													} else {
														echo $editable;
													}
												?>
											> 
											<?php echo $st['st_name']?> 
											<?php endforeach;?>
									</td>
								</tr>

								<tr>
									<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/time1.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">营业时间</label>
									</td>
									<td>
										<div>
											<span>
												<input id="appTime" class="" type="text" name="appTime" readonly="" value="16:43">
												<?php //echo $form->textField($model,'ws_open_time',array('class'=>'col-xs-3'));?>
												<?php //echo $form->textField($model,'ws_close_time',array('class'=>'col-xs-3'));?>
											</span>	
										</div>
									</td>
								</tr>

								<!-- <tr>
									<td class="service-img"><img src="<?php //echo Yii::app()->theme->baseUrl?>/img/basicInfo/service1.png" alt=""> </td>
									<td class="service-name">
										<label for="inputEmail3" class="col-sm-2 control-label">特色服务</label>
									</td>
									<td  class="service-input">
										<div class="col-sm-8">
											<p>
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option1" checked disabled>WIFI
											</label> 
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option2" checked disabled> 赠饮
											</label> 
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option3" checked disabled> 休息室
											</label>
											</p> 
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option4" checked disabled> 电视
											</label> 
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option5" disabled> 电脑
											</label> 
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option6" disabled> 麻将棋牌
											</label> 
											<label class="checkbox-inline"> 
												<input type="checkbox" value="option7" disabled> 免费停车
											</label> 
											<label class="checkbox-inline"> 
													<input type="checkbox" value="option8" disabled> 刷卡
											</label>
										</div>
									</td>
								</tr> -->

								<!-- <tr>
									<td class="service-img"><img src="<?php //echo Yii::app()->theme->baseUrl?>/img/basicInfo/bank.png" alt=""> </td>
									<td class="service-name"><label for="inputEmail3" class="col-sm-2 control-label">银行账户</label></td>
									<td class="service-input">
										<div class="col-sm-8">
											<input type="text" class="form-control"
												placeholder="暂不可用，敬请期待" disabled>
										</div>
									</td>
								</tr> -->

								<tr>
									<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/info.png" alt=""> </td>
									<td class="service-name">
										<label for="inputPassword3" class="col-sm-2 control-label">车行描述</label>
									</td>
									<td  class="service-input">
										<div class="col-sm-8">
											<?php echo $form->textarea($model,'ws_desc',array("class"=>"form-control",'rows'=>"4",'style'=>'height:120px;'));?>
										</div>
									</td>
								</tr>

						</table>

						<div class="form-group" style="margin-left:30%;padding-top:20px;">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn" style="width:40%;height:50px;background:#f2851c;color:#fff;"><b>确定修改</b></button>
							</div>
						</div>
					</div>
					<?php $this->endWidget();?>



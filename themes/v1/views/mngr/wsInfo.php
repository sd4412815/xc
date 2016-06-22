<section class="content-header">
	<h1>车行信息维护</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="wno" class="col-sm-2 control-label">加盟号</label>
							<div class="col-sm-8">
								<input id="wno" type="text" class="form-control" data-inputmask="'mask':'9', 'repeat': 10, 'greedy' : false"
									value="<?php echo $model['ws_no'];?>" <?php echo $editable;?>>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span
								class="text-red">*</span>车行名称</label>
							<div class="col-sm-8">
								<input id="wname" type="text" class="form-control"
									value="<?php echo $model['ws_name'];?>" <?php echo $editable;?>>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label"><span
								class="text-red">*</span>车行地址</label>
							<div class="col-sm-8">
								<input id="waddress" type="text" class="form-control"
									value="<?php echo $model['ws_address'];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="keywords" class="col-sm-2 control-label"><span
								class="text-red">*</span>商圈关键字</label>
							<div class="col-sm-8">
								<input id="keywords" type="text" class="form-control"
									value="<?php echo $model['ws_key_words'];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">车行描述</label>
							<div class="col-sm-8">
								<textarea id="wdesc" class="form-control" rows="3"><?php echo $model['ws_desc'];?></textarea>

							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span
								class="text-red">*</span>店长</label>
							<div class="col-sm-8">
								<input id="wowner" type="text" class="form-control"
									value="<?php echo $boss['b_real_name'];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span
								class="text-red">*</span>电话</label>
							<div class="col-sm-8">
								<input id="wtel" type="text" class="form-control"
									value="<?php echo $user['u_tel'];?>" <?php echo $editable;?>>
							</div>
						</div>
					
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">洗车档口个数</label>
							<div class="col-sm-8">
								<input id="wnum" type="text" class="form-control"
									value="<?php echo $model['ws_num'];?>" <?php echo $editable;?>>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">服务类型</label>
							<div class="col-sm-8 icheck">
										<?php
										$sts = ServiceType::model ()->findAll (array('order'=>'st_flag ASC'));
										if ($editable == '') {

$shopsts =  WashShopService::model()->getServices($model['id'])['data'];
// 											$shopsts = WashShopService::model ()->findAllByAttributes ( array (
// 													'wss_ws_id' => $model ['id'] 
// 											) );
										} else {
$shopsts =  WashShopService::model()->getServices($model['id'])['data'];
// 											$shopsts = WashShopService::model ()->findAllByAttributes ( array (
// 													'wss_ws_id' => $model ['id'] 
// 											), 'wss_state >= 0', array () );
											// $shopsts = WashShopService::model()->findAllByAttributes(array('wss_ws_id'=>$model['id']));
										}
										
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
										
										    <label class="checkbox-inline"> <input type="checkbox"
									name="stype" value="<?php echo $st['id'];?>"
									<?php
									
											if (in_array ( $st ['id'], $stids ) ) {
												if ($editable=='disabled' && in_array ( $st ['id'], $availableStids )){
												echo 'checked';}
											
												if( $editable=='' ){
													echo 'checked';
												}
												
												
											} else {
												echo $editable;
											}
											?>> <?php echo $st['st_name']?> 
											</label>
											
											<?php endforeach;?>
										
										</div>
						</div>
									  <?php
// 											$xiche = WashShopService::model ()->findByAttributes ( array (
// 													'wss_ws_id' => $model ['id'],
// 													'wss_st_id' => '1' 
// 											) );
											
// 											$dala = WashShopService::model ()->findByAttributes ( array (
// 													'wss_ws_id' => $model ['id'],
// 													'wss_st_id' => '3' 
// 											) );
// 											$jingxi = WashShopService::model ()->findByAttributes ( array (
// 													'wss_ws_id' => $model ['id'],
// 													'wss_st_id' => '5' 
// 											) );
											?>
						

								  
									  <div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">营业时间</label>
							<div class="col-sm-8">

								<input type="text"
									value="<?php echo date('H:i',strtotime($model['ws_open_time'])).'-'.date('H:i',strtotime($model['ws_close_time']));?>"
									class="form-control pull-left" id="daterange" />
	<?php
	Yii::app ()->clientScript->registerScript ( 'stimep', "
		setWSInfoTimeP();
		", CClientScript::POS_READY );
	?>	
								 
										 
										</div>

						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">特色服务</label>
							<div class="col-sm-8 icheck">
										<?php
										$features = ShopFeature::model ()->findAll ();
										
										$shopFeatures = WashShopFeature::model ()->findAllByAttributes ( array (
												'wsf_ws_id' => $model ['id'] 
										) );
										$sfs = array ();
										foreach ( $shopFeatures as $sf ) {
											array_push ( $sfs, $sf ['wsf_sf_id'] );
										}
										
										foreach ( $features as $key => $f ) :
											?>
										   <label class="checkbox-inline"> <input type="checkbox"
									name='sfeatures' value="<?php echo $f['id'];?>"
									<?php if (in_array($f['id'], $sfs)){ echo 'checked';}?>
									<?php echo $editable;?>> <?php echo $f['sf_code'];?>
											</label>
										<?php endforeach;?>  
										</div>
						</div>
						<div class="form-group">
							<label for="waccount" class="col-sm-2 control-label">银行账户</label>
							<div class="col-sm-8">
								<input id="waccount" type="text" class="form-control"
									value="<?php echo $boss['b_account'];?>"
									<?php echo $editable;?>>
							</div>
						</div>
						<div class="form-group">
							<label for="waccountOwner" class="col-sm-2 control-label">开户行</label>
							<div class="col-sm-8">
								<input id="waccountOwner" type="text" class="form-control"
									value="<?php echo $boss['b_account_owner'];?>"
									<?php echo $editable;?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button class="btn btn-primary"
									onclick="UpdateWsInfo('<?php echo Yii::app()->createUrl('washShop/UpdateWSs')."',".$model['id'];?>)">修改</button>

							</div>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<!-- /.content -->



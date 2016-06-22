<?php
$this->pageTitle = '基本信息维护';
?>
<?php
	Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/js/mobiscroll/css/mobiscroll.custom.min.css" );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/mobiscroll/js/mobiscroll.custom.min.js", CClientScript::POS_END );
?>
<style type="text/css">
	.yuan{ 
		-ms-transform: scale(2); /* IE */
		-moz-transform: scale(2); /* FireFox */
		-webkit-transform: scale(2); /* Safari and Chrome */
		-o-transform: scale(2); /* Opera */
	}
	.service-img{
		width: 10%;
		text-align: right;
	}
	table img {
		margin-left: 10%;
		width: 25px;
		height: 25px;
	}
	table,tr,td{
		margin: 0;
		padding: 0;
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
</style>
<div style="100%">

			<table style="width:100%" class="service-table">
				<tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/add.png" alt=""> </td>
					<td class="service-name">
						<span class="text-red">*</span>商圈关键字
					</td>
					<td  class="service-input" style="margin:0">
						<div class="col-sm-8">
							<input id="keywords" type="text" class="form-control" placeholder="设置关键字，可以让车主快速搜索到哦！" value="<?php echo $model['ws_key_words'];?>">
						</div>
					</td>
				</tr>

				<tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/tel.png" alt=""> </td>
					<td class="service-name">
						<span class="text-red">*</span>电话</label>
					</td>
					<td  class="service-input" style="margin:0">
						<div class="col-sm-8">
							<!-- <?php //echo $form->textField($model,'ws_key_words',array("class"=>"form-control"));?> -->
							<input id="wtel" type="text" class="form-control" value="<?php echo $user['u_tel'];?>" <?php echo $editable;?>>
						</div>
					</td>
				</tr>
				

				<tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/num1.png" alt=""> </td>
					<td class="service-name">
						车位个数
					</td>
					<td  class="service-input" style="margin:0">
						<div class="col-sm-8">
							<input id="wnum" type="text" class="form-control" value="<?php echo $model['ws_num'];?>" <?php echo $editable;?>>
						</div>
					</td>
				</tr>
				

				<tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/service.png" alt=""> </td>
					<td class="service-name">
						服务类型
					</td>
					<td  class="service-input" style="margin:0">
						<div class="col-sm-8">
							<?php
									$sts = ServiceType::model ()->findAll (array('order'=>'st_flag ASC'));
								if ($editable == '') {
									$shopsts =  WashShopService::model()->getServices($model['id'])['data'];
								} else {
									$shopsts =  WashShopService::model()->getServices($model['id'])['data'];
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
								   
								    <input type="checkbox" name="stype" style="margin:10px;" class="yuan" value="<?php echo $st['id'];?>"
							<?php
									if (in_array ( $st ['id'], $stids ) ) {
										if ($editable=='disabled' && in_array ( $st ['id'], $availableStids )){
										echo 'checked';}
										if( $editable=='' ){
											echo 'checked';
										}
									} else {
//										echo $editable;
									}
									?>> <?php echo $st['st_name']?> 
							<?php endforeach;?>
						</div>
					</td>
				</tr>

				<tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/time1.png" alt=""> </td>
					<td class="service-name">
						营业时间
					</td>
					<td  class="service-input" style="padding-left:4%;">
						<!-- <input type="text" value="<?php //echo date('H:i',strtotime($model['ws_open_time'])).'-'.date('H:i',strtotime($model['ws_close_time']));?>" class="form-control pull-left" id="daterange" /> -->
							
							    <input class="input-sm" style="width:35%;font-size:16px;" readonly="reanonly" id="date1" value="<?php echo date('H:i',strtotime($model['ws_open_time']))?>" /> 						
							-
							    <input class="input-sm" style="width:35%;font-size:16px;" readonly="reanonly" id="date2" value="<?php echo date('H:i',strtotime($model['ws_close_time']))?>" />
						
					</td>
				</tr>


				<!-- <tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/add.png" alt=""> </td>
					<td class="service-name">
						特色服务
					</td>
					<td  class="service-input" style="margin:0">
						<div class="col-sm-8">
						<?php
							//$features = //ShopFeature::model ()->findAll ();
							
						// 	$shopFeatures = WashShopFeature::model ()->findAllByAttributes ( array (
						// 			'wsf_ws_id' => $model ['id'] 
						// 	) );
						// 	$sfs = array ();
						// 	foreach ( $shopFeatures as $sf ) {
						// 		array_push ( $sfs, $sf ['wsf_sf_id'] );
						// 	}
							
						// 	foreach ( $features as $key => $f ) :
						// 		?>
						// 	   <label class="checkbox-inline"> <input type="checkbox"
						// name='sfeatures' value="<?php //echo $f['id'];?>"
						// <?php //if (in_array($f['id'], $sfs)){ echo 'checked';}?>
						// <?php //echo $editable;?>> <?php //echo $f['sf_code'];?>
						// 		</label>
						// 	<?php //endforeach;?>  
					</td>
				</tr> -->

				<tr>
					<td class="service-img"><img src="<?php echo Yii::app()->theme->baseUrl?>/img/basicInfo/info.png" alt=""> </td>
					<td class="service-name">
						车行描述
					</td>
					<td  class="service-input" style="margin:0">
						<div class="col-sm-8">
							<textarea id="wdesc" class="form-control" placeholder="填写描述有利于车主更多的了解您的车行！赶快填写吧！" style="margin:5px 0;" rows="4"><?php echo $model['ws_desc'];?></textarea>
						</div>
					</td>
				</tr>
			</table>


		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn" style="width:40%;height:50px;background:#f2851c;color:#fff;margin-left:30%;margin-top:25px; "
					onclick="UpdateWsInfo('<?php echo Yii::app()->createUrl('mweixinentconfig/UpdateWSs')."',".$model['id'];?>)">修改</button>

			</div>
		</div>
</div>
 
<script>  
$(function () {  
     var opt = {
     	//theme: 'android-ics light',
        timeFormat:'HH:ii',
        display: 'modal', //显示方式 
        mode : 'scroller', //日期选择模式 
        minute:'30',
        amText:'上午',
        pmText:'下午',
        setText: '确定', 
        cancelText: '取消',
        steps:{
        	minute:30,
        	second:5,
        	zeroBased:true,
        }
    };

     $("#date1").mobiscroll().time(opt);
     $("#date2").mobiscroll().time(opt);
})   
</script>  
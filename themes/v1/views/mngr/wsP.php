

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-xs-12 col-sm-3">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">右侧地图选取位置</h3>
				</div>
				<!-- /.box-header -->

				<div>
					<div class="box-body">
						<div class="form-group">
							<label for="wsp">坐标</label> <input type="email"
								class="form-control" id="wsp"
								value="<?php echo $model['ws_position'];?>">
						</div>
						<div class="form-group">
							<label for="address">地址</label> <input type="text"
								class="form-control" id="address"
								value="<?php echo $model['ws_address'];?>">

						</div>

					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<div class="checkbox">
							<label> <input id='u_address' type="checkbox"> 更新地址
							</label>
							<button class="btn btn-primary" onclick="updateWP()">提交</button>
						</div>

					</div>
				</div>
			</div>
			<!-- /.box -->
		</div>

		<div class="col-xs-12 col-sm-9">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">地图</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="allmap" style="width: 100%; height: 500px;"></div>

				</div>
				<!-- /.box-body -->

			</div>
		</div>
		<!-- /.box -->

	</div>

	</div>
</section>

<?php
Yii::app ()->clientScript->registerScript ( 'updateWP', "
function updateWP(){
var loadi;
$.ajax({
	type:'POST',
	url:'" . Yii::app ()->createUrl ( 'WashShop/UpdatePosition' ) . "',
	data:{
		'id':" . $model ['id'] . ",
		'p':$('#wsp').val(),
		'YII_CSRF_TOKEN':'" . Yii::app ()->request->csrfToken . "',
	},
		'beforeSend':function(){ loadi = layer.load(" . Yii::app ()->params ['loadString'] . ");},
		'error':function(){ layer.msg('更新失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(html){layer.msg(html,2,1);}
});
};               		
	function loadJScript() {
		var map = new BMap.Map(\"allmap\");
		var geoc = new BMap.Geocoder(); 
	map.centerAndZoom('".$model->city['c_name']."');
	function showInfo(e){
		$('#wsp').val(e.point.lng + \", \" + e.point.lat);
	
		geoc.getLocation(e.point, function(rs){
			var addComp = rs.addressComponents;
				$('#address').val(addComp.province + \", \" + addComp.city +\", \" + addComp.district + \", \" + addComp.street + \", \" + addComp.streetNumber);
		});        
		
	}
	map.addEventListener(\"click\", showInfo);
	map.enableScrollWheelZoom();                 
		map.addControl(new BMap.NavigationControl()); 
	} 
		", CClientScript::POS_END );

?> 


<?php
Yii::app ()->clientScript->registerScriptFile ( "http://api.map.baidu.com/api?v=2.0\&ak=atV54I5hflatOH00IebtxSwR", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScript ( 'ready', "
     		
loadJScript();
		", CClientScript::POS_READY );

?> 
                    		
                    		

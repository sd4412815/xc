<section class="content">
<div class="row">

          <?php

echo CHtml::dropDownList ( 'idProvince', '', CHtml::listData ( Province::model ()->findAll (array(
	'order'=>'p_spell ASC',
)), 'id', 'p_name' ), array (
		'prompt' => '选择省份',
		'class'=>'col-md-1',
		
		'ajax' => array (
				'type' => 'POST',
				'url' => $this->createUrl ( 'city/updateCities' ),
				'async'=> false,
				'dataType' => 'json',
				'data' => array (
						'idProvince' => 'js:this.value'
				),
				'success' => 'function(data) { 

$("#idCity").html(data.dropDownCities); 


}'
				
		)
) );
?> 


                                  <?php

echo CHtml::dropDownList ( 'idCity', '', array (), array(
		'prompt' => '选择城市',
'class'=>'col-md-1',
		));

Yii::app()->clientScript->registerScript('idCityChange',"
		$('#idCity').on('change',function(evt,params){

	serviceTypeUpdataAjax();


});
		");

?> 

<select class="col-md-2" name="idServiceType" id="idServiceType">

<option value="1">洗车</option>
<option value="2">打蜡</option>
<option value="3">车内精洗</option>
</select> 


<?php 
Yii::app()->clientScript->registerScript('serviceTypeUpdataAjax',"
          		function serviceTypeUpdataAjax(){
if($('#idCity').val() > 0){
	
	$.ajax({
		type : 'POST',
		url:'".Yii::app()->createUrl('order/updateServiceType')."',
		dataType: 'json',
		async:false,
		data:{
idCity:$('#idCity').val(),
			idCarType:$('#idCarType').val(),

		},
		success:function(data) { 
// alert(data);
			$('#idServiceType').html(data.dropDownServiceTypes); 
		

	}

	}); // end ajax
}else{

}


}
          		
          		");

?>
<div class="col-md-1">
<button class="btn btn-primary btn-sm" id='searchSI' onclick="siSearch()">搜索</button>
<?php 
Yii::app()->clientScript->registerScript('searchSIBtn',"
          		function siSearch(){
          	$.ajax({
		type : 'POST',
		url:'".Yii::app()->createUrl('mngr/si')."',
		async:false,
		data:{
			idProvince:$('#idProvince').val(),
idCity:$('#idCity').val(),
			idCarType:$('#idCarType').val(),

		},
		success:function(data) { 
			$('#list').html(data); 
	}
	}); // end ajax	

			}",CClientScript::POS_END);

?>
</div>
<div class="col-md-1">
<input id="cbReset" type="checkbox">重置为模版内容
</div>
<div class="col-md-1">
<button class="btn btn-primary btn-sm" id='updateSIFromTempBtn' onclick="updateSIFromTemp()">从模版更新</button>
<?php 
Yii::app()->clientScript->registerScript('updateSIFromTempBtn',"
          		function updateSIFromTemp(){
          	$.ajax({
		type : 'POST',
		url:'".Yii::app()->createUrl('mngr/UpdateFromTemp')."',
		async:false,
		data:{
			idProvince:$('#idProvince').val(),
idCity:$('#idCity').val(),
			idCarType:$('#idCarType').val(),
reset:$('#cbReset').is(':checked'),
		},
		success:function(data) { 
			$('#list').html(data); 
	}
	}); // end ajax	

			}",CClientScript::POS_END);

?>
</div>
</div>
<div class="row">
	<div class="col-md-12">
	
                                  <div id="list" >
 <?php 
  $this->renderPartial('_silist',array(
 'dataProvider'=>$dataProvider,
 ));
 ?>
 </div>
 
 
 
	</div>
	<div class="col-md-12">
	<?php 
	$this->widget('zii.widgets.grid.CGridView',array(
'id'=>'ffgrid',
'dataProvider'=>ServiceItemTemplate::model()->search(),
// 'filter'=>$model,
'pager'=>array(
		'class'=>'CLinkPager',
		'nextPageLabel'=>'下一页',
		'prevPageLabel'=>'上一页',
		'header'=>'',
),
'summaryText'=>'<font color=#0066A4>显示{start}-{end}条.共{count}条记录,当前第{page}页</font>',
'columns'=>array(
		array(
'header'=>'编号',
				'name'=>'id',
				'htmlOptions'=>array('width'=>'25'),
				'sortable'=>false,
		),

'sit_name',
'sit_desc',
'sit_value',
'sit_score',
'sit_time',
'sit_state',
	
),
));
	?>

	
	</div>
</div>

                    
</section>
<?php 
Yii::app()->clientScript->registerScript('updateSIBtn',"
          		function siUpdate(id){
          	$.ajax({
		type : 'POST',
		url:'".Yii::app()->createUrl('mngr/si')."',
		async:false,
		data:{
siid:id,
sivalue:$('#value'+id).val(),
siscore:$('#score'+id).val(),
sitime:$('#time'+id).val(),
sistate:$('#state'+id).val(),
sicity:$('#city'+id).val(),
},
		success:function(data) {
			$('#list').html(data); 
	}
	}); // end ajax	

			}",CClientScript::POS_END);

?>
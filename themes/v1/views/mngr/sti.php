<div class="container">

<div class="row">

          <?php
$st = new ServiceType();
echo CHtml::dropDownList ( 'idST', '', CHtml::listData (ServiceType::model ()->findAll (array(
	'order'=>'st_city_id ASC, st_name ASC',
)), 'id', function($st) {
	$city = City::model()->findByPk($st['st_city_id']);
	return CHtml::encode($city['c_name'].'--'.$st->st_name.' ('.$st->st_desc.')');} ), array (
		'prompt' => '选择服务',
		'class'=>'col-md-3',
) );
?> 

<div class="col-md-1">
<button class="btn btn-primary btn-sm" id='searchSTI' onclick="stiSearch()">搜索当前服务小项</button>
<?php 
Yii::app()->clientScript->registerScript('searchSTIBtn',"
          		function stiSearch(){
          	$.ajax({
		type : 'GET',
		url:'".Yii::app()->createUrl('mngr/stItems')."',
		async:false,
		dataType:'json',
		data:{
			idST:$('#idST').val(),
		},
		success:function(data) { 
			$('#stItems').html(data.stItems); 
			$('#siItems').html(data.siItems); 
	}
	}); // end ajax	

			}",CClientScript::POS_END);

?>
</div>


</div>

<div class="row">

<div class="col-md-3" >
<div class="panel panel-success">
 <div class="panel-heading">当前服务小项</div>
  <div class="panel-body">
  
<select id="stItems" multiple="MULTIPLE" class="form-control" size="15" >
                                       
                                            </select>
  </div>
</div>


</div>

<div class="col-md-1">
<br />
<br />
<br />
<button id="removeFromSTIBtn" onclick="removeFromSTI()" class="btn"> >> </button>
<button id="addToSTIBtn" onclick="addFromSTI()" class="btn"> << </button>
<?php 
Yii::app()->clientScript->registerScript('removeFromSTIBtn',"
          		
          		function removeFromSTI(){
      
          		 	$.ajax({
		type : 'GET',
		url:'".Yii::app()->createUrl('mngr/stItemsRemove')."',
		async:false,
		dataType:'json',
		data:{
			idST:$('#idST').val(),
			stItems:$('#stItems').val(),
		},
		success:function(data) { 
			$('#stItems').html(data.stItems); 
			$('#siItems').html(data.siItems); 
	}
	}); // end ajax	

			}",CClientScript::POS_END);

?>
<?php 

Yii::app()->clientScript->registerScript('addFromSTIBtn',"
          		
          		function addFromSTI(){
          		
          		 	$.ajax({
		type : 'GET',
		url:'".Yii::app()->createUrl('mngr/stItemsAdd')."',
		async:false,
		dataType:'json',
		data:{
			idST:$('#idST').val(),
			siItems:$('#siItems').val(),
		},
		success:function(data) { 
			$('#stItems').html(data.stItems); 
			$('#siItems').html(data.siItems); 
	}
	}); // end ajax	

			}",CClientScript::POS_END);

?>
</div>

<div class="col-md-3">
<div class="panel panel-info">
 <div class="panel-heading">可用服务小项</div>
  <div class="panel-body">
<select id="siItems" multiple="MULTIPLE" class="form-control" size="15" >
                                       
                                            </select>
  </div>
</div>



</div>
</div>
</div>
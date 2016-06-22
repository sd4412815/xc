<?php
$this->pageTitle = '加盟费管理';
?>
<section class="content-header">
	<h1>
		加盟费管理 <small>已开通<span class="badge"><?php
echo City::model()->countByAttributes(array(), 'c_state>=:state', array(
    ':state' => 0
));
?></span>城市
		</small>
	</h1>
	<ol class="breadcrumb hidden-xs">
		<li><a href="<?php echo Yii::app()->createUrl('mngr/Profile');?>"><i
				class="fa fa-dashboard"></i> 我的账户</a></li>
		<li class="active">加盟费管理</li>
	</ol>
</section>

<section class="content">
<div class="row">
<div class="col-xs-6 col-sm-3">

							 <?php
$critetia_p = new CDbCriteria();
$critetia_p->addCondition('p_state>=0');
$critetia_p->order = 	'p_spell ASC';		
// CHtml::activeDropDownList($model, $attribute, $data)				 
echo CHtml::DropDownList ( 'pid','1', CHtml::listData ( Province::model ()->findAll ($critetia_p), 'id', 'p_name' ), array (
		'prompt' => '选择省份',
		'class'=>'form-control ',
//     'onchange'=>''
		'ajax' => array (
				'type' => 'POST',
				'url' => $this->createUrl ( 'city/updateCities' ),
'async'=> false,
				'dataType' => 'json',
				'data' => array (
						'idProvince' => 'js:this.value' 
				),
				'success' => 'function(data) { 
$("#cid").html(data.dropDownCities); 
// $("#joinStd").html(); 
// $("#pid").trigger("change");
}' 
		) 
) );
?> 

</div>

	<div class=" col-xs-6 col-sm-3">			
		       <?php

echo CHtml::dropDownList ('cid', '1', CHtml::listData(City::model()->findAllByAttributes(array('c_province_id'=>1)), 'id', 'c_name'), array (
		'prompt' => '选择区域' ,
'class'=>'form-control',
    	'ajax' => array (
				'type' => 'GET',
				'url' => $this->createUrl ( 'city/UpdateJoinForm' ),
'async'=> false,
// 				'dataType' => 'json',
				'data' => array (
						'cid' => 'js:this.value' 
				),
				'success' => 'function(data) { 
    	   
$("#joinStd").html(data); 
}' 
		) 
) );
?> 
	
	</div>		

</div>
<div class="row">
<div class="col-sm-12" id="joinStd">
<?php 
echo $this->renderPartial('_joinStdForm',array('model'=>$model));
?>
</div>

</div>
</section>
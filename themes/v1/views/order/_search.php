<?php
$searchForm = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'search-form',
		'focus' => array (
				$searchModel,
				'q' 
		),
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true,
				'validateOnChange' => true 
		),
		'htmlOptions' => array (
				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal' 
		) 
) );
?>

<div class="row">
	<div class="col-xs-12">

		<div class="form-group">
<?php
echo $searchForm->labelEx ( $searchModel, 'q', array (
		'class' => 'hidden-xs col-sm-2 control-label' 
) );
?>
	<div class="col-xs-10 col-sm-9">
<?php
echo $searchForm->textField ( $searchModel, 'q', array (
		'placeholder' => '关键词',
		'class' => 'form-control' 
) );

?>
<?php

echo $searchForm->error ( $searchModel, 'q' );
?>	

    </div>
			<div class="col-xs-2 col-sm-1">
<?php
echo CHtml::ajaxSubmitButton ( '搜索', '', array (
		// 'data'=>"$('#search-form').serialize()",
		'success' => "$.fn.yiiListView.update(
            'ajaxRltList', {data: $('#search-form').serialize()})" 
), array (
		'class' => 'btn btn-warning',
		'id' => 'btn_search' 
) );

?>
</div>
		</div>
	</div>
</div>
<!-- /.row -->
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading"></div>
			  <div class="panel-body">
				<p>...</p>
			  </div> -->

			<ul class="list-group">
				<li class="list-group-item">
					<ul class="list-inline icheck  allAreas">
						<li>区域：</li>
						<?php
$areas = Area::model()->findAllByAttributes(array('a_city_id'=>UPlace::getCityId()),array('order'=>'a_spell ASC') );
$areasArray=array();
// $areasArray[]='全部';
// $areasArray
// array_unshift($array, $var)
$areasArray[0]='全部';
foreach ($areas as $key=>$value){
	$areasArray[$value['id']]=$value['a_name'];
}

// $areasArray = CHtml::listData($areas,'id','a_name');
// $areasArray = array_merge(array(0=>'全部'),$areasArray);
// array_unshift($areasArray, '全部');
// echo CJSON::encode($areasArray);
// array_push($array, $var)
// echo var_dump(CHtml::listData($areas,'id','a_name'));
// $searchModel['areas']=CHtml::listData($areas,'id','id');
// CHtml::radioButtonList($name, $select, $data)
$searchModel['areas']=0;
echo $searchForm->radioButtonList ( $searchModel, 'areas', 
$areasArray, array (
		'separator' => ' '
) );
?>
				
					</ul>

				
				</li>
				<li class="list-group-item">
					<ul class="list-inline icheck">
						<li>时间：</li>
<?php
echo $searchForm->radioButtonList ( $searchModel, 'bias', array (
		0 => date ( 'm月d日' ),
		1 => date ( 'm月d日', time () + 24 * 60 * 60 ),
		2 => date ( 'm月d日', time () + 48 * 60 * 60 ) 
), array (
		'separator' => ' ' 
// 'labelOptions' => array (
// 'style' => "display: inline-block;"
// )
) );

?>

					</ul>


				</li>

				<li class="list-group-item">
					<ul class="list-inline">
						<li>特色：</li>
						<li id="selectedFeatures"></li>
						<li class="pull-right"><a
							class="btn btn-warning btn-xs text-right" data-toggle="collapse"
							href="#collapseFeatures" aria-expanded="false"
							aria-controls="collapseExample2"> 多选</a></li>
					</ul>
					<div class="collapse" id="collapseFeatures">
						<div class="well icheck allFeatures">
							<ul class="list-inline ">
<?php
$features = ShopFeature::model ()->findAllByAttributes ( array (
		'sf_search_state' => 1 
) );
foreach ( $features as $key => $value ) {
	if ($value ['sf_type'] == 1) {
		$fdata [$value ['id']] = $value ['sf_code'];
	} else {
		
		$fdata [$value ['id']] = '<img src="' . Yii::app ()->theme->baseUrl . '/img/ico/' . $value ['sf_img_name'] . '" title=' . $value ['sf_desc'] . '/>';
	}
}

echo $searchForm->checkBoxList ( $searchModel, 'features', $fdata, array (
		'separator' => ' ' 
) );

?>
						</ul>
							<a class="btn btn-warning btn-xs text-right"
								data-toggle="collapse" href="#collapseFeatures"
								aria-expanded="false" aria-controls="collapseFeatures"> 确定</a>
						</div>
					</div>
				</li>
			</ul>
		</div>

	</div>
</div>
<!-- /.row -->

<?php $this->endWidget(); ?>

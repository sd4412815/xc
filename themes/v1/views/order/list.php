<?php $this->pageTitle = '车行列表'; ?>
<?php
// WashShop::model()->deleteOrderTempTable(1, 0);
// $rlt = WashShop::model()->generateOrderTempTable(1,0);
// $this->pageTitle = $rlt['data'];
// WashShop::model()->getBasicInfobyType(1, 1, 0);

// WashShop::model()->deleteOrderTempTable(1, 0);
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/AdminLTE.css");
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/font-awesome.min.css");
// // Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/chosen.css");
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . "/js/chosen.jquery.js", CClientScript::POS_HEAD);

?>
<br>
<section class="hidden-xs col-sm-2 col-lg-offset-1 ">
<?php
$this->renderPartial ( '_suggestList', array (
		'dataProvider' => $dataProvider 
) );
?>
</section>
<section class="col-sm-10 col-lg-8">

<?php 
echo $this->renderPartial('_search',array('searchModel'=>$searchModel));
?>

	

<div class="row">
	<div class="col-xs-12">
		
		<div id="rltList">
<?php

// echo CJSON::encode($dataProvider->getData());

$this->renderPartial ( '_rltList', array (
		'model' => $model,
		'dataProvider' => $dataProvider,
		'searchModel' => $searchModel 
) );
?>
</div>

</div>
	</div>
	<!-- /.row -->



</section>

<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
$('#mlist').addClass('active');
		$('input[name=\"SearchForm[bias]\"]').on('ifChecked', function(event){
	$('#btn_search').click();
});	
", CClientScript::POS_READY );
?>
 








<?php
$this->pageTitle = '喜车惠';
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/mobile.css" );
?>
<div class="row">

<?php
$huiImgUrl = Yii::app ()->request->hostInfo . Yii::app ()->baseUrl . '/images/hui/' . $hui ['id'] . '/h' . $hui ['id'] . '.jpg';
?>
<img alt="<?php echo  $hui['h_name'];?>" src="<?php echo $huiImgUrl;?>"
			class="img-responsive center-block" style="width:100%;">


</div>
	<div class="row text-center">

 <?php
 	
	$this->renderPartial ( '_list',array('shopList'=>$shopList) );
	?>
</div>



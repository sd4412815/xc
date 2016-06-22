<?php /* @var $this Controller */ ?>
<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-datetimepicker.min.css" );

Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ichecksquare/green.css" );

// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/jquery.raty.css" );
// Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ystep.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/style.css" );
Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD );

Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );

// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-datetimepicker.min.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/laydate/laydate.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.pin.js", CClientScript::POS_END );
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/ystep.js", CClientScript::POS_END );

?>
</head>
<body>
<div class="container">
<div>
<?php
echo $content;
?>
</div>
</div><!-- end of container -->
</body>
</html>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo CHtml::encode($this->pageTitle.'-'.Yii::app ()->name); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php 
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/mod.udatas.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
    // Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-datetimepicker.min.css" );

    //Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
    // Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ichecksquare/green.css" );
    // Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrapValidator.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/jquery.raty.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ystep.css" );
    // Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/style.css" );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.raty.js", CClientScript::POS_HEAD );

    // Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );

    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-datetimepicker.min.js", CClientScript::POS_HEAD );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_HEAD );
    // Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/laydate/laydate.js", CClientScript::POS_END );
    // Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrapValidator.min.js", CClientScript::POS_END );
    // Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/language/zh_CN.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.easing.min.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/zzsc.js", CClientScript::POS_END );
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/ystep.js", CClientScript::POS_END );



//   Bootstrap 3.3.5
//   Font Awesome
//   Ionicons
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ionicons.min.css" );
//   AdminLTE
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/skin-yellow-light.min.css" );  
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-timepicker.css" );
//   jQuery 2.1.4
  Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
//   SlimScroll
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/slimScroll/jquery.slimscroll.min.js", CClientScript::POS_END );
//   FastClick
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/fastclick/fastclick.js", CClientScript::POS_END );
//   AdminLTE App
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/app.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/demo.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-timepicker.js", CClientScript::POS_END );
  

  ?>


</head>
<body>

<?php 
echo $content;
?>  
</body>
</html>
<?php //Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END );?>


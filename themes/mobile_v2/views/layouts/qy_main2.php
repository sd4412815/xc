<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <?php //echo CHtml::encode($this->pageTitle.'-'.Yii::app ()->name); ?>
  <title><?php echo Yii::app ()->name; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php 
  
//   Bootstrap 3.3.5
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" ); 
//   Font Awesome
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
//   Yii::app ()->clientScript->registerCssFile ("https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" );
//   Ionicons
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ionicons.min.css" );
  //   Yii::app ()->clientScript->registerCssFile ("https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" );
//   AdminLTE
  
//   Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/_all-skins.min.css" );
   // Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/skin-yellow-light.min.css" );  
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/plugins/daterangepicker/daterangepicker-bs3.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/js/mobiscroll/css/mobiscroll.custom.min.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.min.css" );
  
//   jQuery 2.1.4
  Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
//   Bootstrap 3.3.5
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/jQuery/jQuery-2.1.4.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
//   SlimScroll
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/slimScroll/jquery.slimscroll.min.js", CClientScript::POS_END );
//   FastClick
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/fastclick/fastclick.js", CClientScript::POS_END );
//   AdminLTE App
 
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/input-mask/jquery.inputmask.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/input-mask/jquery.inputmask.date.extensions.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/input-mask/jquery.inputmask.extensions.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/daterangepicker/moment.js", CClientScript::POS_END );
  
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/daterangepicker/daterangepicker.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/mobiscroll/js/mobiscroll.custom.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/app.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/demo.js", CClientScript::POS_END );


  ?>
  
  <style>
       body,h3,h4{	    
         font-family: 'Microsoft Yahei', sans-serif;
        }
        body{
	       background-color:#f6f3ef;
        }
       
  </style>
</head>
<body>

<?php 
echo $content;
?> 

</body>
</html>

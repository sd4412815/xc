<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo CHtml::encode($this->pageTitle.''.Yii::app ()->name); ?></title>
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
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.min.css" );
//   Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/_all-skins.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/skin-yellow-light.min.css" );  
//     dropdown
//     Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/dropdown/jquery.dropdown.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/loaders.min.css" );
    //     selectFx
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-select.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-skin-elastic.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-skin-elastic-list.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-skin-elastic-service.css" );
//     flavr
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/animate.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/flavr.css" );
    
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
  
//   jQuery 2.1.4
  Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END );
//   Bootstrap 3.3.5
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
//   SlimScroll
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/slimScroll/jquery.slimscroll.min.js", CClientScript::POS_END );

  //   dropdown
  //   Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.dropdown.js", CClientScript::POS_END );
  //   selectFx
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/classie.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/selectFx.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/loaders.css.js", CClientScript::POS_END );
//   lazy load xt
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.lazyloadxt.min.js", CClientScript::POS_END );
  
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/flavr.min.js", CClientScript::POS_END );
  
//   notie
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/notie.js", CClientScript::POS_END );
//   AdminLTE App
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/app.min.js", CClientScript::POS_END );

  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/modernizr.custom.63321.js", CClientScript::POS_END );

  //   FastClick
    Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/fastclick/fastclick.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom.js", CClientScript::POS_END );
  ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<?php 
echo $content;
?> 
</html>
<?php  
Yii::app()->clientScript->registerScript(
'notifyMessage',
'  var AdminLTEOptions = {
    sidebarExpandOnHover: true,
    enableBoxRefresh: true,
    enableBSToppltip: true
  };',
CClientScript::POS_END
);
?>
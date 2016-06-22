<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Yii::app ()->name; ?> - 全国洗车位预定平台</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php 
  
//   Bootstrap 3.3.5
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap.min.css" ); 
//   Font Awesome
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/font-awesome.min.css" );
//   Ionicons
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/ionicons.min.css" );
//   AdminLTE
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
  //     selectFx
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-select.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-skin-elastic.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-skin-elastic-list.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/selectFx/css/cs-skin-elastic-service.css" );
//   Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/_all-skins.min.css" );
    Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/skin-yellow-light.min.css" );  
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-timepicker.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/loaders.min.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/animate.css" );
  Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/flavr.css" );


  
//   jQuery 2.1.4
  Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/jquery.cookie.js", CClientScript::POS_END );
  //   Bootstrap 3.3.5
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.js", CClientScript::POS_END );

//   SlimScroll
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/slimScroll/jquery.slimscroll.min.js", CClientScript::POS_END );
  //   selectFx
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/classie.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/selectFx.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/loaders.css.js", CClientScript::POS_END );
//   FastClick
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/fastclick/fastclick.js", CClientScript::POS_END );
//   AdminLTE App
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/app.min.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/demo.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-timepicker.js", CClientScript::POS_END );
//  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom1.js", CClientScript::POS_END );
  Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer_mobile/layer.js", CClientScript::POS_END );




  ?>
</head>
<body>

    <div class="box box-widget widget-user-2" style="margin:0;">
        <div class="widget-user-header bg-yellow" style="height:100px;">
            <div class="widget-user-image">
                <img class="img-circle" src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo Yii::app()->session['shop']->id ?>/shop<?php  echo Yii::app()->session['shop']->id ?>.jpg" alt="" style="width:75px;height:75px;">
            </div>
          <h3 class="widget-user-username" style="color:#f4f4f4;position:absolute;right:20px;top:20px;"><?php echo CHtml::encode($this->pageTitle) ?></h3>
          <h5 class="widget-user-desc" style="color:#f4f4f4;position:absolute;right:20px;top:65px;font-size:14px;"><?php echo Yii::app()->session['shop']->ws_name ?></h5>
        </div>
    </div>


<?php
echo $content;
?>  
</body>
</html>
<!-- CHtml::encode($this->pageTitle -->
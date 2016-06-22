<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>我洗车 - 全国洗车位预定平台</title>
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
	Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/AdminLTE.css" );
	//   Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/_all-skins.min.css" );
	Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/skins/skin-yellow-light.min.css" );
	Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/custom.css" );
	Yii::app ()->clientScript->registerCssFile ( Yii::app ()->theme->baseUrl . "/css/bootstrap-timepicker.css" );

	//   jQuery 2.1.4
	Yii::app ()->clientScript->registerCoreScript ( 'jquery' );
	//   Bootstrap 3.3.5
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap.min.js", CClientScript::POS_END );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/icheck.min.js", CClientScript::POS_END );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/layer/layer.min.js", CClientScript::POS_END );
	//   SlimScroll
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/slimScroll/jquery.slimscroll.min.js", CClientScript::POS_END );
	//   FastClick
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/plugins/fastclick/fastclick.js", CClientScript::POS_END );
	//   AdminLTE App
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/app.min.js", CClientScript::POS_END );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/demo.js", CClientScript::POS_END );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/bootstrap-timepicker.js", CClientScript::POS_END );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/custom1.js", CClientScript::POS_END );
	Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/selectFx.js", CClientScript::POS_END );
?>
</head>
<body>
<div style="width:100%;">
	<div class="box box-widget widget-user-2" style="margin:0;">
		<div class="widget-user-header bg-yellow" style="height:100px;">
			<div class="widget-user-image">
				<img class="img-circle" src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $shop->id ?>/shop<?php  echo $shop->id ?>.jpg" alt="" style="width:75px;height:75px;">
			</div>
			<h3 class="widget-user-username" style="color:#f4f4f4;position:absolute;right:20px;top:10px;">评论管理</h3>
			<h4 class="widget-user-desc"></h4>
			<h5 class="widget-user-desc" style="position:absolute;right:20px;bottom:25px;">
				<span style="color:#f4f4f4;font-size:14px;"><?php echo $shop->ws_name ?></span>
			</h5>
			<h5 style="position:absolute;right:20px;bottom:0;>
				<span style="font-size: 12px;">综合评分：</span>
				<span style="font-size:20px;color:red;">
					<?php
						if($shop->ws_score==5){
							echo $shop->ws_score.'.0';
						}else{
							echo substr($shop->ws_score,0,3);
						}
					?>
				</span>
			</h5>
		</div>
	</div>

<!-- Main content -->
<!--<div class="box box-widget widget-user-2">-->
	<div class="box-footer">
		<div>
			<div class="col-xs-4 border-right">
				<div class="description-block" style="background-color: #fc2f2f;border-radius:8px;">
					<span class="description-text">
						<img style="width: 35px;margin-top: 5px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/ding.png" >
					</span>                
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">好评</span>
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">
						<?php //score
							$shopid = Yii::app()->session['shop']->id;
						    $criteria = new CDbCriteria ();
						    $criteria->addCondition ( 'oh_wash_shop_id = :shopId' );
						    $criteria->params [':shopId'] = $shopid;
					        $criteria->addCondition ( 'oh_score>=4' );
                            $member=OrderHistory::model()->findAll($criteria);
                            $count=count($member);
                            echo $count;
						?>
					</span>
				</div>
			</div>
								
			<div class="col-xs-4 border-right">
				<div class="description-block" style="background-color: #52b0d7;border-radius:8px;">
					<span class="description-text">
						<img style="width: 35px;margin-top: 5px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/middle.png" >
					</span>                
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">中评</span>
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">
                        <?php //score
							$shopid = Yii::app()->session['shop']->id;
						    $criteria = new CDbCriteria ();
						    $criteria->addCondition ( 'oh_wash_shop_id = :shopId' );
						    $criteria->params [':shopId'] = $shopid;
					        $criteria->addCondition ( 'oh_score<4' );
					        $criteria->addCondition ( 'oh_score>=2' );
                            $member=OrderHistory::model()->findAll($criteria);
                            $count=count($member);
                            echo $count;
						?>
					</span>
				</div>
			</div>
                <div class="col-xs-4 border-right">
                    <div class="description-block" style="background-color: #999;border-radius:8px;">
                        <span class="description-text">
                            <img style="width: 35px;margin-top: 5px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/cha.png" >
                        </span>
                        <br>
                        <span class="description-text" style="color: #fff;font-size:12px;">差评</span>
                        <br>
                        <span class="description-text" style="color: #fff;font-size:12px;">
                            <?php //score
                            $shopid = Yii::app()->session['shop']->id;
                            $criteria = new CDbCriteria ();
                            $criteria->addCondition ( 'oh_wash_shop_id = :shopId' );
                            $criteria->params [':shopId'] = $shopid;
                            $criteria->addCondition ( 'oh_score<2' );
                            $member=OrderHistory::model()->findAll($criteria);
                            $count=count($member);
                            echo $count;
                            ?>
                        </span>
                    </div>
                </div>
		</div>
	</div>
<!--</div>-->



	<div class="panel panel-default">
		<ul class="list-group" style="background:#ddd">
			<?php
				$this->renderPartial('_commentList',array('dataProvider'=>$dataProvider));
			?>
		</ul>
	</div>
</div>
</body>
</html>
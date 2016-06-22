<?php
$this->pageTitle = Yii::app ()->name . ' - 车行管理';

?>


<h1>车行管理</h1>
<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'primary',
			'label'=>'更新时间段状态',
        	'url'=>array('/order/bossNew'),
		))?>
		<br />
<?php 

$timeList = WashShop::model()->getAvailableTime(1,1,-8);
// echo var_dump(json_encode($timeList));

echo CHtml::checkBoxList('timeList', '', CHtml::listData($timeList, 'timeIndex', 'timeStr'),array(
	'disabled'=>false,
));

// $client=new SoapClient('http://localhost:8080/xc/index.php?r=boss/APIs');
// echo var_dump( $client->orderUpdate(array('1'=>true,'2'=>false)));
echo WashShop::model()->getTotalParkingCount('02');
// echo var_dump(Yii::app()->user->id);
// echo var_dump(Yii::app()->user->name);
// echo var_dump(Boss::model()->orderUpdate(array()));
// echo Boss::model()->orderUpdate(array(1=>true),Yii::app()->user->Id,1,1);
// echo var_dump(Yii::app()->user->tel);
?>


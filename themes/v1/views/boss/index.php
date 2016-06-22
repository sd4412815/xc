<?php
/* @var $this BossController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bosses',
);

$this->menu=array(
	array('label'=>'Create Boss', 'url'=>array('create')),
	array('label'=>'Manage Boss', 'url'=>array('admin')),
);
?>

<h1>老板</h1>
<a href="/boss/login">登录</a>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

First Name:
<input type="text" id="txt1"
onkeyup="showHint(this.value)">


<p>Suggestions: <span id="txtHint"></span></p>


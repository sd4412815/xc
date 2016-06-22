<?php
$this->pageTitle = '';
$this->renderPartial ( '/layouts/_menu_order_list' );

$this->renderPartial ( '_list', array (
		"dataProvider" => $dataProvider,
		'serviceTypeList' => $serviceTypeList ,
		'params'=>$params
) );
?>


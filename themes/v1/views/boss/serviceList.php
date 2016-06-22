
<section class="content-header">
	<h1>购买记录</h1>
</section>

<!-- Main content -->
<section class="content">
<?php
$this->renderPartial ( '_serviceBuyList', array (
		'model' => $model,
		'dataProvider' => $dataProvider 
), false, true );
?>
                
                
</section>
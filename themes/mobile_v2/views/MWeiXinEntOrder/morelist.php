<?php
$this->pageTitle = '更多订单';
?>
<div class="container">
    <div class="row">
    		<div class="col-xs-12">	
        		
                 <?php
                	$this->renderPartial ( '_morelist', array (
                			'dataProvider' => $dataProvider 
                	) );
                	?>
               
            </div>
    </div>
</div>
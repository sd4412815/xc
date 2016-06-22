<?php
$this->pageTitle = '本季订单';
?>

<div class="container">   
    <div class="row">
        <div class="col-xs-12">
             <h4> 您好！<?php         
            //print_r(Yii::app()->session['shopId']);
            $shopid = Yii::app()->session['shopId'] ;
            $name = WashShop::model()->find('id=:id',array(":id"=>$shopid))->ws_name;
            echo $name;
            ?></h4>
        </div>
    </div>
    
    <div class="row">
    		<div class="col-xs-12">	
    		<h4 class="text-yellow">本季订单</h4>
        		<div id="list">	
                 <?php
                	$this->renderPartial ( '_seasonlist', array (
                			'dataProvider' => $dataProvider 
                	) );
                	?>
                </div>	
            </div>
    </div>
</div>
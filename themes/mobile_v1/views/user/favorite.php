<?php
$this->pageTitle = '我的收藏';
$user = User::model ()->findByPk ( Yii::app ()->user->id );
?>


<div class="row">
	 <div class="col-xs-12">
            <?php     
            $favoriates = User::model ()->findByPk ( Yii::app ()->user->id )->favoriateShops;
            foreach ( $favoriates as $key => $fs ):    
                   $shop = $fs->fsShop;
            ?>	    
	      <div class="box box-warning">
            	<div class="box-header">
            		<h4 class="box-title"><a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']));?>">
					           <?php echo $shop['ws_name'];?></a>
					</h4>
            		<div class="box-tools pull-right">
            		    <a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$shop['id']))?>"
								class="btn btn-warning btn-sm">预定</a>
                                <?php echo CHtml::link(CHtml::encode('删除'),
                                		array('FavoriteShop/delete','id'=>$fs['id']),
                                		array(
                                'submit'=>array('FavoriteShop/delete','id'=>$fs['id']),
                                				'class'=>'btn btn-danger btn-sm','confirm'=>'确认删除该收藏?'));?>
            			<!-- <button class="btn btn-warning btn-xs">预订</button>
            		    <button class="btn btn-danger btn-xs">删除</button> -->
            		</div>
            	</div>
            	<div class="box-body">
            		<p><?php echo $shop['ws_address'];?>
            		</p>
            	</div><!-- /.box-body -->
            </div><!-- /.box -->
	      
	       <?php endforeach;; ?>
      </div>
</div>
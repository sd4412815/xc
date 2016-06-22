
<a class="text-yellow" href="#"><b><?php  echo $shop['ws_name'];?></b></a>
<p>
	<img style="width: 100%; height: 140px;"
		src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $shop['id'];?>/shop<?php echo $shop['id'];?>.jpg"
		alt="<?php echo $shop->ws_name;?>" />
</p>
<p>评价:  <?php

 $this->widget('star.starWidget',array('score'=> $shop['ws_score'])); ?>	<?php echo round( $shop['ws_score'],2);?> 
</p>
<p>
	可用车位: <span id="availableCount"
		style="color: #ff9900; font-weight: bold; font-size: 16px;">0</span>
	总数:<span id="totalCount">0</span>
</p>
<p>可发优惠卡：<?php echo $shop->ws_count_remain;?>张</p>
<p>

	<span style="font-weight: bold; color: #ff9900;">附近：</span>
					  <?php
    
    $keywords = split('[; ,]', $shop->ws_key_words);
    ?>
					<?php foreach ($keywords as $key=>$value):?>
					  <span class="label label-primary" style="font-size: 11px;"><?php echo $value;?></span> 
					  <?php endforeach;?>
</p>
<p>地址：<?php echo $shop->ws_address;?></p>

<?php
$showAddFavorite = TRUE; 

if (!Yii::app()->user->isGuest){
	$favorite = FavoriteShop::model()->findByAttributes(array('fs_shop_id'=>$shop['id'],'fs_user_id'=>Yii::app()->user->id));
	if(isset($favorite)){$showAddFavorite=FALSE;}
}
if($showAddFavorite):
?>
		<button class="btn btn-danger btn-lg"
					onclick="add2Fav('<?php
					echo Yii::app ()->createAbsoluteUrl ( 'favoriteShop/add', array (
							'id' => $shop ['id'] 
					) );
					?>')">收藏</button>
<?php else:?>
<button class="btn btn-danger btn-lg " disabled="disabled">已收藏</button>
<?php endif;?>
	 <hr />		
		<p>
					 
			
<?php

$features = $shop->washShopFeatures;
?>	
<?php
foreach ( $features as $key => $value ) :
	if ($value ['sf_type'] == 0) :
		?>	
		<p>			
<img
								src="<?php echo Yii::app()->theme->baseUrl.'/img/ico/'.$value->sf_img_name;?>"
								title="<?php echo  $value->sf_desc;?>" />	<?php echo $value->sf_name;?> </p>
<?php elseif ($value['sf_type']==1):?>
<p>
<?php echo CHtml::decode($value['sf_code']); echo $value['sf_name'];?>	</p>
<?php endif;?>
<?php endforeach;?>			
			</p>
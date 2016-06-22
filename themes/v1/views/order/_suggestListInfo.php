  <p><a href="<?php echo Yii::app()->createUrl('order/new',array('id'=>$data['id']));?>"><span style="color:#ff9900;font-weight:bold;">
  <?php echo $data->ws_name;?><br />
  <img width="100%" src="<?php echo Yii::app()->baseUrl;?>/images/shops/<?php echo $data->id;?>/shop<?php echo $data->id;?>.jpg" alt="<?php echo $data->ws_name;?>"  />
  </span></a>
</p>
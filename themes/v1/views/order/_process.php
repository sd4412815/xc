  <ul  class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
           <?php
			switch ($sType){
				case 1: echo '洗车';break;
				case 3: echo '打蜡';break;
				case 5: echo '精洗';break;
				default: echo '洗车';
			}
           ?>服务流程
        </span>
    </li>
    
  <?php 
  Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/admin/css/AdminLTE.css");
  $sum = 0;
  $index=0;
//   Yii::log(CJSON::encode($processList),'error','_process');
  if (!isset($processList)) {
  	return ;
  }
  
  foreach ($processList as $k=>$p):

  ?>
  
  <?php 
  $si = ServiceItem::model()->findByPk($p['sti_si_id']);
  $sit= ServiceItemTemplate::model()->findByPk($si['si_sit_id']);
  ?>
    <li>
        <!-- timeline icon -->
        <i class="fa  bg-blue"><?php
$sum+= $sit['sit_time'];
        echo CHtml::encode($sum);?>'</i>
       
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?php $index++; echo CHtml::encode('第'.$index.'步');?></span>

            <h3 class="timeline-header"><?php echo CHtml::encode($sit['sit_name']);?></h3>

          
        </div>
    </li>
    <?php 
    
  endforeach;
    ?>
    
    </ul>
  
  
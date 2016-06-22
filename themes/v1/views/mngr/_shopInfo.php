
    <tr>
   
   
    <td>
  <?php 
  echo $data->ws_no;
  ?>
  </td> 

      <td>
  <?php 
  echo $data->province->p_name;
  ?>
  </td> 
      <td>
  <?php 
  echo $data->city->c_name;
  ?>
  </td> 
      <td>
  <?php 
  echo $data->ws_name;
  ?>
  </td> 
      <td class="visible-lg">
  <?php 
  echo $data->ws_address;
  ?>
  </td> 
    <td class="visible-lg">
  <?php 
  echo $data->ws_score;
  ?>
  </td> 
    <td>
  <?php 
  echo UWashShop::getLevel($data['ws_level']);
  ?>
  </td> 

   
    <td>
  <?php 
echo UWashShop::getStatus($data['ws_state']);
//   switch ($data->ws_state){
//   	case 0: echo '申请中';break;
//   	case 1: echo '正常'; break;
//   	case 2: echo '考核通过';break;
//   	case -10: echo '永久屏蔽'; break;
//   	case -20: echo '已删除';break;
//   	default: echo '临时';break;
//   }
  ?>
  </td>
    <td>
  <?php 
  $joinDate = strtotime( $data['ws_join_date']) ;
  if (  date('Y',$joinDate) < date('Y') ){
      echo date('Y-m-d',$joinDate);
  }else{
     echo  date('m月d日',$joinDate);
  }
  ?>
  </td> 
            <td>
  <?php 
  $start = strtotime($data['ws_start_date']);
  $end = strtotime($data['ws_date_end']);
  if (!empty($data['ws_start_date'])){
      echo date('Y/m/d',$start);
  }

  
  echo '至'.date('Y/m/d',$end);

  ?>
  </td>  
  
     <td>
 
      <a class="btn btn-warning btn-xs" href="<?php echo Yii::app()->createUrl('mngr/wsP',array('id'=>$data->id));?>" >定位</a>  
         <a class="btn btn-primary btn-xs" href="<?php echo Yii::app()->createUrl('mngr/wsInfo',array('id'=>$data->id));?>" >详情</a>
 <?php if ($data['ws_state']==0):?>
 <button class="btn btn-success btn-xs" onclick="shopOper(<?php echo $data['id'].',2';?>)" >考核通过</button>
 <?php endif;?>
          
          <button class="btn btn-danger btn-xs" onclick="shopOper(<?php echo $data['id'].',-20';?>)" >删除</button> 
  </td>                     
                                        </tr>

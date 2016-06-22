<tr>
<td><?php echo $data['id'];?></td>
<td><?php 
$sit = ServiceItemTemplate::model()->findByPk($data['si_sit_id']);
echo $sit['sit_name'];?></td>
<td>
<?php echo $sit['sit_desc'] ;?>
</td>
<td>
<?php echo CHtml::textField('value'.$data['id'],$data['si_value']) ;?>
</td>
<td>
<?php echo CHtml::textField('score'.$data['id'],$data['si_score']) ;?>
</td>
<td>
<?php echo CHtml::textField('time'.$data['id'],$data['si_time']);?>
</td>
<td>
<?php echo CHtml::textField('order'.$data['id'],$data['si_order']);?>
</td>
<td>
<?php
// echo CHtml::checkBox($name)
echo CHtml::checkBox('state'.$data['id'],$data['si_state']) ;?>
</td>
<td>
<?php 
echo CHtml::dropDownList ( 'city'.$data['id'], $data['si_city_id'], CHtml::listData ( City::model ()->findAll (array(
	'order'=>'c_spell ASC',
)), 'id', 'c_name' ), array (
		'prompt' => '选择城市',
// 		'class'=>'col-md-1',
) );
// echo CHtml::textField('city'.$data['id'],$data['si_city_id']);
?>
</td>
<th>
<button class="btn btn-primary btn-sm" onclick="siUpdate(<?php echo $data['id'];?>)">更新</button>
</th>

</tr>
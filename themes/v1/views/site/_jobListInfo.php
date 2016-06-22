<?php if ($data['s_state']==0):?>
<tr >
<?php else:?>
<tr class="success">
<?php endif;?>
<td class="col-md-2">
<?php echo substr($data->staffUser['u_tel'],0,2).'**';?> 
</td>
<td class="col-md-2">
	<?php echo $data->staffCity['c_name'];?>
</td>
<td class="col-md-2">
<?php echo substr($data['s_apply_date'],0,16);?>
</td>
<td class="col-md-4"><?php echo $data['s_desc'];?>
</td>
<td class="col-md-2">
<?php if ($data['s_state']==0):?>
<span class="label label-warning">求职中</span>
<?php else:?>
<span class="label label-success">已入职</span>
<?php endif;?>
</td>
</tr>

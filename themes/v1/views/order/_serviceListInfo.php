<label><input type="radio" name="sType" value="<?php echo  $data['id'];?>" 
 <?php if ($data['wss_state']==1){
 echo 'available';}
 ?>>
<span id="sTypeRatioStr3"
 <?php if ($data['wss_state']!=1):?>
style="color: #D3D3D3;"
<?php endif;?>>
<?php echo  $data->wssSt['st_name'];?>
</span></label>

  <div class="col-md-12" style="font-size:12px;font-weight:bold;">
  <label>
  <input type="checkbox" name="staffCheckbox" id="scb<?php echo $data['otu_user_id'];?>"
   value="<?php echo $data['otu_user_id'];?>" 
  	<?php if ($data['otu_state'] != 1) {
  		echo 'disabled';
  	}?>
   >
  
    
  <span style="font-size:11px;" class="label label-warning">

  <?php echo $data->otuUser->u_name;?>
</span>
<?php 

if ($data->otuUser->u_sex == 1) {
	echo '男';
}else {
	echo '女';

}
?>
<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ico/female.png" title="<?php echo $data->otuUser->u_name;?>" /></label>
							   <span>
                                               满意度：<span id="starStaff<?php echo $data->otu_user_id;?>"></span>

 <?php 
 Yii::app()->clientScript->registerScript('staffStar'.$data->otu_user_id,"

         $('#starStaff".$data->otu_user_id."').raty({
half:true,
  		readOnly: true,
	  score: ".$data->otuStaff->s_score." });           		
                    		
                    		",CClientScript::POS_READY);
 ?>    
 
                                                    </span>
 <span>
                                              经验值：<span id="expStaff<?php echo $data->otu_user_id;?>"></span>

 <?php 
 Yii::app()->clientScript->registerScript('expStaff'.$data->otu_user_id,"

         $('#expStaff".$data->otu_user_id."').raty({
half:true,
  		readOnly: true,
	  score: ".$data->otuStaff->s_exp." });           		
                    		
                    		",CClientScript::POS_READY);
 ?>    
 
                                                    </span>                                                   
							 
							
							 
</div>

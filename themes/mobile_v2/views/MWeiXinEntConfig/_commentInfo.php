<style type="text/css">
	.score{
		position: absolute;
		right:5px;
		top:30%;
	}
    p{
        margin:0;
        padding:0;
    }
</style>

<li class="list-group-item box box-warning box-solid tab-content" style="margin: 0; padding:0;margin-bottom: 8px;">
	<div style="background: #F39C12;height:50px;padding: 5px;">
		<div style="color:#fff;" class="col-xs-8">
			<p>订单号：<?php echo $data->Order['oh_no'];?></p>
			<p>评价时间：<?php echo substr($data['oc_datetime'],0,16);?></p>
		</div>
		<div class="pull-right text-danger" style="margin-right: 2%;margin-top:10px;">
            <b><?php echo  $data->Order->serviceType['st_name'];?></b>
        </div>
	</div>
	<div>
		<p style="margin-top:5px; ">
			<span style="color:orange;font-size:16px;margin-left:5px;">
				<?php echo $data->User['u_nick_name'];?>
			</span>:&nbsp;
			<?php echo $data['oc_comment'];?>
			<?php 
				$score=$data->Order['oh_score'];
                for($i=0;$i<$score;$i++){?>
                    <span class="fa fa-star text-yellow pull-right" style="margin-right: 5px;"></span>
               <?php }?>
        </p>
	</div>
	<?php
        $rc  = OrderComments::model()->findByAttributes(array('oc_related_id'=>$data['id']));
        if(isset($rc)):
    ?><br />
    	<p style="border-top: 1px dashed #bbb;margin-top:5px; padding-top:5px;">
    		<span style="color: red;">
    			<b>【店主回复】</b>
    		</span>
    		<?php echo $rc['oc_comment'];?>
    	</p>
    		<span class="pull-left" style="color:#888888;margin-left:5px;">
    			回复时间：<?php echo substr($rc['oc_datetime'],0,10);?>
    		</span>
		<p style="text-align:right;">
		<button class="btn btn-success btn-sm" style="margin-right:10px;margin-bottom: 10px;" onclick="disUpdateComment('<?php echo Yii::app()->createUrl('MWeiXinEntConfig/disUpdateComment',array('id'=>$rc['id'],'new'=>'0'));?>')">修改</button></p>
	<?php else:?>
		<p style="text-align:right;">
			<button class="btn btn-danger btn-sm" style="margin-right:10px;margin-bottom: 10px;" onclick="disUpdateComment('<?php echo Yii::app()->createUrl('MWeiXinEntConfig/disUpdateComment',array('id'=>$data['id'],'new'=>'1'));?>')">回复</button>
		</p>

	<?php endif;?>			
									  
</li>

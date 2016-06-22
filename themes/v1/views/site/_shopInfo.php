
                    <div class="content col-md-3 col-sm-12">



                                        <div class="inner">



                                            <a class="thumbnailz" href="<?php echo  Yii::app()->createUrl('order/new',array('id'=>$data->id));?>">

                                                <img src="images/shops/<?php echo $data->id;?>/shop<?php echo $data->id;?>.jpg" alt="<?php echo $data->ws_name;?>" class="responsive-image" />

                                                <span class="overlay">Details</span>

                                            </a>



                                            <div class="entry">



                                                <article class="entry-content">

                                                    <h2 class="post-title"><a href="<?php echo  Yii::app()->createUrl('order/new',array('id'=>$data->id));?>" title="<?php echo $data->ws_name;?>"><?php echo $data->ws_name;?></a></h2>



                                                    <span class="price"><span class="higlight emphasize value">
                                                    剩余<?php 
                                                    echo $data->getServiceCount($data->id,false,true)['data'];
                                                    ?>
                                                    </span> /共<?php echo $data->ws_count;?></span><br />



                                                    <p><?php echo $data->ws_address;?></p>
                                                    <p>
                                                     <span class="review">服务满意度</span> 
                                                      <div class="star-holder">
                                                 <div id="star<?php echo $data->id;?>"></div>

 <?php 
 Yii::app()->clientScript->registerScript('idstar'.$data->id,"

         $('#star".$data->id."').raty({
half:true,
	  score: ".$data->ws_score." });           		
                    		
                    		",CClientScript::POS_READY);
 ?>    
 
                                                    </div>
                                                    </p>
                                                    <br />
                                                           <p>
                                                     <span class="review">车行经验值</span> 
                                                      <div class="star-holder">
                                                 <div id="exp<?php echo $data->id;?>"></div>

 <?php 
 Yii::app()->clientScript->registerScript('idexp'.$data->id,"

         $('#exp".$data->id."').raty({
half:true,
	  score: ".$data->ws_exp." });           		
                    		
                    		",CClientScript::POS_READY);
 ?>    
 
                                                    </div>
                                                    </p>

                                       

                                                </article>



                                                <div class="entry-meta">


                                        <span class="button green wide-fat"><a href="<?php echo  Yii::app()->createUrl('order/new',array('id'=>$data->id));?>" style="color:white;">去预定</a></span>
          

                                                </div>	

                                        



                                            </div><!-- /.entry -->	



                                        </div>



                                    </div><!-- /.content -->

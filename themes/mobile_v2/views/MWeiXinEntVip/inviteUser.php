<?php
$this->pageTitle = '会员邀请';
?>

<div style="width:100%"> 
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/page1.jpg" alt=" ">
              <div class="carousel-caption">
               
              </div>
            </div>
            <div class="item">
              <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/page2.png" alt=" ">
              <div class="carousel-caption">
               
              </div>
            </div>
            
             <div class="item">
              <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/page3.jpg" alt=" ">
              <div class="carousel-caption">
               
              </div>
            </div>
            
          </div>
        
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div><!-- 轮播结束 -->
        
       
		<div class="box  box-default">

			<div class="box-body" id="inviteUser">
                <?php
                $this->renderPartial ( '_inviteUser', array (
                		'model' => $model 
                ) );
                ?>			
			</div>
		
		</div>
	
</div>   
      
      
   


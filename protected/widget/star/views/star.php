<?php 
$score_int = floor($score);
$score_half = ($score - $score_int)>0?true:false;
for ($i=0;$i<$score_int;$i++):
?>			
<i class="fa fa-star text-yellow"></i>
<?php endfor;?>
<?php if($score_half):?>
<i class="fa fa-star-half-o text-yellow"></i>
<?php
$score_int+=1;
endif;?>
<?php 
for ($i=$score_int;$i<5;$i++):
?>			
<i class="fa fa-star-o"></i>
<?php endfor;?>
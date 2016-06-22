 <tr>
<th><?php echo substr($data['sh_date_time'],0,16);?></th><th>
 <?php
if ($data['sh_score']>=0) {
	echo '+'.$data['sh_score'];
}else {
	echo '-'.$data['sh_score'];
}
?>
 </th>
   <th><?php 
                                            
 echo $data['sh_desc'];            
?></th>
         </tr>                                  
                                         
                          
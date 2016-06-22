<tr>
 
                                            <th><?php
// echo substr($data_>no,0,16);
echo $data->s_name;

?></th>
    <th>
       <?php 
    echo $data->s_tel;
       ?>
       
       </th>
           <th>
       <?php 
   
       echo $data->s_tag;
       ?>
       
       </th>
          <th>
       <?php 
   if ($data->s_sex == 1) {
   	echo '男';
   }else 
   {
   	echo '女';
   }
    
       ?>
       
       </th>
          <th>
       <?php 
   
       echo $data->s_exp;
       ?>
       
       </th>
          <th>
       <?php 
   
       echo $data->s_score;
       ?>
       
       </th>
            <th>
         <button class="btn btn-danger btn-sm" onclick="staffWSUpdate(<?php echo $data['id'];?>)">辞退</button> 
       
       </th>

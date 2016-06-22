
<tr>
	<th><?php
	$scoretime = strtotime ( $data ['sh_date_time'] );
	if (date ( 'Y' ) > date ( 'Y', $scoretime )) {
		echo date ( 'Y-m-d H:i', $scoretime );
	} else {
		echo date ( 'm月d日 H:i', $scoretime );
	}
	?></th>
	<th>
 <?php
	if ($data ['sh_score'] >= 0) {
		echo '+' . $data ['sh_score'];
	} else {
		echo '-' . $data ['sh_score'];
	}
	?>
 </th>
	<th><?php
	
	echo $data ['sh_desc'];
	?></th>
</tr>


<label><input type="checkbox" name="cards"
	data-price="<?php echo $data['ci_value'];?>"
	data-state="<?php echo '1'; ;?>"
	data-type="<?php echo $data['ci_type']; ?>"
	value="<?php echo $data['id'];?>">
<?php

if ($data['ci_type'] == 0) {
    echo '店铺首次使用优惠卡';
} else {
    $type = ServiceType::model()->findByPk($data['ci_type']);
    if (! isset($type) || empty($type)) {
        echo '其它';
    } else {
        echo $type['st_name'] . '次卡';
    }
}
?>
<?php echo $data['ci_value'];?>元
有效期 <?php
if (isset($data['ci_date_end'])) {
    echo date('Y-m-d', strtotime($data['ci_date_end']));
    // echo $data['ci_date_end'];
} else {
    echo '长期';
}
?> </label>
<br>
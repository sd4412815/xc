<?php
$cid = UPlace::getCityId();
Yii::import('select2.Select2');
echo  Select2::dropDownList('autoCity',$cid, CHtml::listData ( City::model ()->findAll ('c_state>0', array (
		'order' => ' c_spell ASC'
) ), 'id', 'c_name' ),array(
		'select2Options'=>array('matcher'=>'js:function(term, text) {
            var mod=ZhToPinyin(text);
            var tf1=mod.a.toUpperCase().indexOf(term.toUpperCase())==0;
            var tf2=mod.b.toUpperCase().indexOf(term.toUpperCase())==0;
            return (tf1||tf2);
        }  '),
		'onChange'=>"jQuery.cookie('_ucid', this.value);location.reload()",
) );
?>
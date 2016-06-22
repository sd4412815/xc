<?php
echo 'dd';
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'shop-grid',
		'dataProvider'=>WashShop::model()->search(),
		'htmlOptions'=>array('style'=>'width:740px'),
		'pager'=>array(  
            'class'=>'CLinkPager',  
            'nextPageLabel'=>'下一页',  
            'prevPageLabel'=>'上一页',  
            'header'=>'dd',
    ),
// 		'summaryText'=>'<font color=#0066A4>显示{start}-{end}条.共{count}条记录,当前第{page}页</font>',
		'columns'=>array(
				  array(  
				 'header'=>'编号',
                'name'=>'id',  
                'htmlOptions'=>array('width'=>'50'),  
                'sortable'=>true,  
        ),  
				'ws_no',
				'ws_name',
				'ws_address',
				'ws_score',
				'ws_exp',
				),
));?>
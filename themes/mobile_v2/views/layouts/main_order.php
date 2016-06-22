<?php $this->beginContent('/layouts/_root'); ?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-yellow-light layout-top-nav" >

<div class="wrapper">
<?php
$this->renderPartial ( '/layouts/_menu_order',array('shopName'=>$this->shopName) );		
?>  
  
<div class="content-wrapper" style="z-index: 100;">
<?php 
echo $content;
?>  
</div>
<?php
$this->renderPartial ( '/layouts/_footer_order' );	
?>

</div>

</body>

<?php $this->endContent(); ?>



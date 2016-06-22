<?php 
$this->pageTitle = '';
?>
<script>
if(self != top){
	top.location="<?php echo $callback;?>";
	top.flavr_obj.closeAll(); 
}
</script>


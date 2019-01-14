<?php
$head = array('title' => __('Confirmation Error'));
echo head($head);
?>
<div class="container content">
	<h2><?php echo $head['title']?></h2>
	
	<div id='primary'>
	<?php echo flash(); ?>
	</div>
</div>
<?php echo foot(); ?>
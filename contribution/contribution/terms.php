<?php 
$head = array('title' => __('Contribution Terms of Service'));
echo head($head);
?>
<div class="container content">
	<div id="primary">
	<h2><?php echo $head['title']; ?></h2>
	<?php echo get_option('contribution_consent_text'); ?>
	</div>
</div>
<?php echo foot(); ?>
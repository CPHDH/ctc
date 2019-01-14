<?php
$title = __('Browse Exhibits by Tag');
echo head(array('title' => $title, 'bodyclass' => 'exhibits tags'));
?>
<div class="container content">
	<h2><?php echo $title; ?></h2>

	<nav class="navigation secondary-nav exhibit-tags">
	    <?php echo dc_secondary_nav('exhibits');?>
	</nav>	
	
	<?php echo tag_cloud($tags, 'exhibits/browse'); ?>
</div>
<?php echo foot(); ?>

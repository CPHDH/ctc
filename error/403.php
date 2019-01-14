<?php
$pageTitle = __('403 Page Forbidden');
echo head(array('title' => $pageTitle));
?>

<div class="container content">
	<h2><?php echo $pageTitle; ?></h2>
	<p><?php echo __('You do not have permission to access this page.'); ?></p>
</div>

<?php echo foot(); ?>

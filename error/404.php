<?php
$pageTitle = __('404 Page Not Found');
echo head(array('title'=>$pageTitle));
?>

<div class="container content">
	<h2><?php echo $pageTitle; ?></h2>
	<p><?php echo __('%s is not a valid URL.', html_escape($badUri)); ?></p>
</div>

<?php echo foot(); ?>

<?php
$pageTitle = __('405 Method Not Allowed');
echo head(array('title'=>$pageTitle));
?>

<div class="container content">
	<h2><?php echo $pageTitle; ?></h2>
	<p><?php echo __('The method used to access this URL (%s) is not valid.', html_escape($this->method)); ?></p>
</div>

<?php echo foot(); ?>

<?php
$pageTitle = __('Items Search');
echo head(array('title' => $pageTitle,
           'bodyclass' => 'items advanced-search'));
?>
<div class="container content">
<h2><?php echo $pageTitle; ?></h2>

<nav class="items-nav navigation secondary-nav">
    <?php echo dc_secondary_nav('search-results'); ?>
</nav>

<div class="primary">

	<?php echo $this->partial('items/search-form.php',
	    array('formAttributes' =>
	        array('id'=>'advanced-search-form'))); ?>
</div> <!-- end primary-->

</div>
<?php echo foot(); ?>

<?php
$pageTitle = __('Item Tags');
echo head(array('title'=>$pageTitle, 'bodyclass'=>'items tags'));
?>
<div class="container content">
<h2><?php echo $pageTitle; ?></h2>

<nav class="navigation items-nav secondary-nav">
    <?php echo dc_secondary_nav(); ?>
</nav>
<?php
$sortLinks[__('Count')] = 'count';
$sortLinks[__('Name')] = 'name';
?>
<div id="sort-links">
<div class="sort-browse sort">
    <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>
</div>

<div class="primary">
	<?php echo tag_cloud($tags, 'items/browse'); ?>
</div> <!-- end primary-->


<?php echo foot(); ?>

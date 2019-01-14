<?php
$title = __('Browse Exhibits');
echo head(array('title' => $title, 'bodyclass' => 'exhibits browse'));
?>
<div class="container content">
	<h2><?php echo $title; ?> <?php echo __(': %s', $total_results); ?></h2>
	<?php if (count($exhibits) > 0): ?>
	
	<nav class="navigation secondary-nav">
	    <?php echo dc_secondary_nav('exhibits');?>
	</nav>
	
	<?php echo pagination_links(); ?>
	<?php echo item_search_filters(); ?>
	
	<?php $exhibitCount = 0; ?>
	<?php foreach (loop('exhibit') as $exhibit): ?>
	    <?php $exhibitCount++; ?>
	    <div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
		<div class="exhibits flex-browse">
			<div class="col">
		        <?php if ($exhibitImage = record_image($exhibit)): ?>
		            <?php echo exhibit_builder_link_to_exhibit($exhibit, $exhibitImage, array('class' => 'exhibit-img')); ?>
		        <?php endif; ?>
			</div>
			<div class="col">
				<h3><?php echo link_to_exhibit(); ?></h3>
		        <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
		        	<div class="description"><?php echo $exhibitDescription; ?></div>
		        <?php endif; ?>
		        <?php if ($exhibitTags = tag_string('exhibit', 'exhibits')): ?>
		        	<p class="tags"><?php echo $exhibitTags; ?></p>
		        <?php endif; ?>
			</div>
	    </div>
	<?php endforeach; ?>
	
	<?php echo pagination_links(); ?>
	
	<?php else: ?>
	<p><?php echo __('There are no exhibits available yet.'); ?></p>
	<?php endif; ?>
</div>
<?php echo foot(); ?>

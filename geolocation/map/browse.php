<?php 
queue_css_file('geolocation-items-map');

$title = __('Items Map') . ': ' . __('%s', $totalItems);
echo head(array('title' => $title, 'bodyclass' => 'map browse'));
?>

<div class="container content">
<h2><?php echo $title; ?></h2>


<div id="geolocation-browse">
	<figure id="items-map" >
	<?php echo get_view()->shortcodes('[geolocation]'); ?>
	</figure>
</div>
</div>

<?php echo foot(); ?>

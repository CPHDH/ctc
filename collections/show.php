<?php
$collectionTitle = metadata('collection', array('Dublin Core', 'Title'),'all');
?>

<?php echo head(array('title'=> strip_tags($collectionTitle[0]), 'bodyclass' => 'collections show')); ?>
<div class="container content">
	<article>
		<h2><?php echo $collectionTitle[0]; echo $collectionTitle[1] ? ' / '.$collectionTitle[1] : null ;?></h2>
		<div id="collection-header-meta">
			<span><?php echo link_to_items_browse(__('<span class="count">%s</span> items', 
				metadata('collection', 'total_items')),
				array('collection' => metadata('collection', 'id'))); ?></span>
			<span><?php echo ($c=metadata('collection', array('Dublin Core','Creator'))) ? ' / '.$c : null;?></span>
		</div>	
		<?php echo the_description($collection);?>
	</article>
<!--
	<div class="flex-3">
		<?php
		//$items=get_records('Item',array('sort_field' => 'added', 'sort_dir' => 'd', 'collection'=>metadata('collection', 'id')), 3);
		//if($items){
		//foreach($items as $item){ 
			//flex_grid_item($item);
			//} 
		//} 		
		?>
		<div class="col"></div>
		<div class="col"></div>
	</div>
-->
	
	<?php echo link_to_items_browse(__('Browse all %s items in this collection', 
	metadata('collection', 'total_items')),
	array('collection' => metadata('collection', 'id')),
	array('class'=>'button')); ?>
	
</div>
<?php echo foot(); ?>

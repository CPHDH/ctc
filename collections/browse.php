<?php
$pageTitle = __('Browse Collections');
echo head(array('title'=>$pageTitle,'bodyclass' => 'collections browse'));
?>
<div class="container content">
	<h2><?php echo $pageTitle; ?><?php echo __(': %s ', $total_results); ?></h2>
	<?php echo pagination_links(); ?>
	
	<?php
	$sortLinks[__('Title')] = 'Dublin Core,Title';
	$sortLinks[__('Date Added')] = 'added';
	?>
	<div id="sort-links">
	<div class="sort-browse sort">
	    <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
	</div>
	</div>
	<?php echo item_search_filters(); ?>
	
	<?php foreach (loop('collections') as $collection): ?>
	<div class="collection flex-browse">
		<div class="col">
			<?php
			$items=get_records('Item', array('collection'=>$collection,'hasImg'=>true,'sort_field' => 'added', 'sort_dir' => 'd'),1);
			foreach($items as $item){
				//$img=item_image('square_thumbnail',array(),0,$item);
				$hero = get_hero_for_item($item,'square_thumbnail');
				echo '<a class="collection-img" href="'.record_url($collection).'"><img src="'.$hero.'"/></a>';
			}
			?>			
		</div>
		<div class="col">					
	    <h3><?php echo link_to_collection(); ?></h3>
	    
	    <p><?php echo snippet(metadata('collection', array('Dublin Core', 'Description')),0,250);?></p>
	
	    <?php echo link_to_items_browse(__('View the items in %s', 
		    metadata('collection', array('Dublin Core', 'Title'))), 
		    array('collection' => metadata('collection', 'id')),array('class'=>'button')); ?>
	
	    <?php fire_plugin_hook('public_collections_browse_each', array('view' => $this, 'collection' => $collection)); ?>
		</div>
	    
	</div><br><br>	    
	<?php endforeach; ?>
	
	<?php echo pagination_links(); ?>
	
	<?php fire_plugin_hook('public_collections_browse', array('collections'=>$collections, 'view' => $this)); ?>
</div>
<?php echo foot(); ?>

<?php
$pageTitle = __('Browse Items');
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>
<div class="container content">
	<h2><?php echo $pageTitle;?> <?php echo __(': %s ', $total_results); ?></h2>
	
	<nav class="items-nav navigation secondary-nav">
	    <?php echo dc_secondary_nav(); ?>
	</nav>
	
	<?php echo pagination_links(); ?>
	
	<?php if ($total_results > 0): ?>
	
		<div id="sort-links">
			

			<!--div class="sort-browse facet">
				<?php echo browse_by_item_type();?>
			</div-->

  
		    <div class="sort-browse sort">
				<?php
				$sortLinks[__('Title')] = 'Dublin Core,Title';
				$sortLinks[__('Creator')] = 'Dublin Core,Creator';
				$sortLinks[__('Date Added')] = 'added';
				?>
			    <span><?php echo __('Sort by:'); ?></span><?php echo browse_sort_links($sortLinks); ?>
		    </div>
		</div>	
	
	<?php endif; ?>
	
	<?php echo item_search_filters(); ?>
	
	<div class="flex">
		<?php foreach (loop('items') as $item){
			flex_grid_item($item);
		}?>
		<!-- insert empty columns to keep orphan items from getting stretched -->
		<div class="col"></div>
		<div class="col"></div>
	</div> <!-- end primary-->
	
	<div class="clearfix"></div>
	
	<?php echo pagination_links(); ?>
	
	<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>
</div>
<?php echo foot(); ?>

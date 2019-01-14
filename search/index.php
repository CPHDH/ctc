<?php
$pageTitle = $_SERVER['QUERY_STRING'] ? __('Search Results: %s',$total_results) : __('Site Search');
echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
$searchRecordTypes = get_search_record_types();
?>
<div class="container content">
	<h2><?php echo $pageTitle; ?></h2>
	<nav class="items-nav navigation secondary-nav">
	    <?php echo dc_secondary_nav('search-results'); ?>
	</nav>
	
	<div id="sort-links">
	    <div class="sort-browse sort">
			<?php
			$sortLinks[__('Title')] = 'Dublin Core,Title';
			$sortLinks[__('Date Added')] = 'added';
			?>
		    <span><?php echo __('Sort by:'); ?></span><?php echo browse_sort_links($sortLinks); ?>
	    </div>
	</div>		
	
	<?php echo $_SERVER['QUERY_STRING'] ? search_filters() : null; ?>
	
	<?php if ($total_results): ?>
		<?php echo pagination_links(); ?>
		<div class="clearfix"></div>
	        <?php $filter = new Zend_Filter_Word_CamelCaseToDash; ?>
	        <?php foreach (loop('search_texts') as $searchText): ?>
                <?php $record = get_record_by_id($searchText['record_type'], $searchText['record_id']); ?>
                <?php $recordType = $searchText['record_type']; ?>
                <?php set_current_record($recordType, $record); ?>
                <?php $title = $searchText['title'] ? $searchText['title'] : '[Unknown]';?>


	
                    <div class="flex">
	                    
	                    <?php if($recordType=='Item'):?> 
	                    
	                    	<?php echo flex_grid_item($record);?>
	                    
	                    <?php else:?>
							
							<?php echo flex_grid_other_search_results($record,$recordType);?>
                        
                        <?php endif;?>
                    
                    </div>
	        <?php endforeach; ?>
		<?php echo pagination_links(); ?>
		
	<?php else: ?>
	
		<div id="no-results">
		    <p><?php echo $_SERVER['QUERY_STRING'] ? '<strong>'.__('Your query returned no results.').'</strong>' : null;?></p>
		
			<div class="search-container-inline">
				<?php echo search_form(array('show_advanced' => true,'form_attributes'=>array('id'=>'search-results-query'))); ?>
			</div>
		
		</div>
	
	<?php endif; ?>
	
</div>
<?php echo foot(); ?>
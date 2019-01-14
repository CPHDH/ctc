<?php 
$bodyclass="items show";
$type = $item->getItemType()['name'];
if($type){
	$bodyclass .= ' '.strtolower(str_replace(' ', '-', $type));
}
echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => $bodyclass)); 
?>
<div class="container content">
    		
	<article>
	    <h2 class="item-title"><?php echo metadata('item', array('Dublin Core','Title')); ?></h2>
		<div id="item-header-meta">
			<?php 
			$headmeta=array();
			if($date=metadata('item', array('Dublin Core','Date'))){
				$headmeta[]='<span class="item-date">'.$date.'</span>';
			}
			if($creator=metadata('item', array('Dublin Core','Creator'))){
				$headmeta[]='<span class="item-creator">'.$creator.'</span>';
			}
			if($publisher=metadata('item', array('Dublin Core','Publisher'))){
				$headmeta[]='<span class="item-publisher">'.$publisher.'</span>';
			}				
			if($collection=metadata('item','Collection Name')){
				$headmeta[]='<span class="item-collection">Collection: '.link_to_collection_for_item().'</span>';
			}

			echo implode(' &middot;&middot;&middot; ', $headmeta);								
			?>


		</div>	
		<?php
		// Get Files
		$f = loop('files', $item->Files);
		$files=[];
		$docs=[];
		foreach ($f as $file){
		    if(isDocsViewer($file)){
			    $filename=$file->original_filename;
			    $docs[]=$file;
		    }else{
			   $files[]=$file; 
		    }  
		}
		// Include Main Template (switchable based on $type)
		if($type=='Hyperlink'){
			include('template-item_hyperlink.php'); 
		}else{
			include('template-item_default.php'); 
		}
		?>		
	</article>

</div> 
<div class="container">
	<ul class="item-pagination navigation item-pagination-bottom">
	    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
	    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
	</ul>
</div>
<div id="item-tags">	
	<?php
	if (metadata('item','has tags')){
		echo '<div class="container content"><span class="item-tags-list"><strong><i class="fa fa-tag hcard"></i> Filed under:</strong> '.tag_string('item','items/browse',', ').'</span></div>';
	}
	?>	
</div>
<div id="item-metadata">

	<div class="container content">
    	<?php echo all_element_texts('item'); ?>	
	</div>
	
</div>

<div class="container">
	<ul class="item-pagination navigation item-pagination-bottom">
	    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
	    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
	</ul>
</div>
<!-- whitelisted plugins -->

<?php if( plugin_is_active('DisqusEngage') && get_option('de_shortname') ){ ?>
<div class="container content">
	<h3>Comments</h3>
	<figure id="item-comments">
		<?php echo get_view()->shortcodes('[disqus]'); ?>
	</figure>
	<br>
</div>
<?php } ?>

<!-- end plugins -->
	
<?php if($type!=='Hyperlink'){
	echo photoswipe_markup();
}?>
<?php echo foot(); ?>


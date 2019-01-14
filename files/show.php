<?php
    $fileTitle = metadata('file', array('Dublin Core', 'Title')) ? strip_formatting(metadata('file', array('Dublin Core', 'Title'))) : metadata('file', 'original filename');
?>
<?php echo head(array('title' => $fileTitle, 'bodyclass'=>'files show primary-secondary')); ?>

	<div class="content container">
		
		<article>
			<h2><?php echo $fileTitle; ?></h2>
			<?php 
			$record=get_record_by_id('Item', $file->item_id);
			$title=metadata($record,array('Dublin Core','Title'));
			?> 
			<?php echo file_markup($file, array('imageSize'=>'fullsize')); ?>	
			<div>
			    <?php 
				echo link_to_item('This file appears in item: <em>'.$title.'</em>', 
					array('class'=>'view-button'), 
					'show', $record);
				?> 
			    <?php echo all_element_texts('file'); ?>      
			</div>
		</article>
	</div>
</div>


<?php echo foot();?>

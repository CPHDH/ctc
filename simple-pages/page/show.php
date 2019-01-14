<?php echo head(array(
    'title' => metadata('simple_pages_page', 'title'),
    'bodyclass' => 'page simple-page',
    'bodyid' => metadata('simple_pages_page', 'slug')
)); ?>
<div class="container content">
	<?php echo '<span class="item-type"></span>';?>
	<div class="primary">
		<article>
	    
	    <h2><?php echo metadata('simple_pages_page', 'title'); ?></h2>
	    
	    <?php
	    $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
	    if (metadata('simple_pages_page', 'use_tiny_mce')) {
	        echo $text;
	    } else {
	        echo eval('?>' . $text);
	    }
	    ?>
		</article>
	</div>
</div>
<?php echo foot(); ?>

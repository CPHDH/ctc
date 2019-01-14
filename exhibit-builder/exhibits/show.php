<?php
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
?>
<div class="container content">
	<h2 class="exhibit-page-title"><span class="exhibit-page"><?php echo metadata('exhibit_page', 'title'); ?></span></h2>
	<div id="exhibit-header-meta"><?php echo str_replace('<br>','', exhibit_builder_link_to_exhibit($exhibit).exhibit_builder_page_trail());?></div>
	
	<div id="exhibit-blocks">
	<?php exhibit_builder_render_exhibit_page(); ?>
	</div>
	
	<br><br>
	
	<nav id="exhibit-pages">
		<h3><?php echo exhibit_builder_link_to_exhibit($exhibit); ?></h3>
	    <?php echo exhibit_builder_page_tree($exhibit, $exhibit_page); ?>
	</nav>
	<div id="exhibit-page-navigation">
	    <?php if ($prevLink = exhibit_builder_link_to_previous_page('&larr; Previous Page')): ?>
		    <div id="exhibit-nav-prev">
		    	<?php echo $prevLink; ?>
		    </div>
	    <?php endif; ?>
	    <?php if ($nextLink = exhibit_builder_link_to_next_page('Next Page &rarr;')): ?>
		    <div id="exhibit-nav-next">
		    	<?php echo $nextLink; ?>
		    </div>
	    <?php endif; ?>
	</div>

</div>
<?php echo foot(); ?>

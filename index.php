<?php echo head(array('bodyid'=>'home')); ?>


<section>
	<div class="content container">
		<?php if(get_theme_option('homepage_text_header')): ?>	
			<h2><?php echo strip_tags(get_theme_option('homepage_text_header'),'<strong><em><b><i><span>');?></h2>
		<?php endif;?>
		<?php if(get_theme_option('homepage_text')): ?>	
			<?php echo text_to_paragraphs(get_theme_option('homepage_text'));?>
		<?php endif;?>
		<a href="/contact" class="button button-primary">Submit a new resource</a>&nbsp;&nbsp; <a href="/curriculum" class="button">View curriculum info</a>
	</div>
</section>

<?php echo foot(); ?>
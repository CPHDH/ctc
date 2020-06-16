<?php echo head(array('bodyid'=>'home')); ?>


<section>
	<div class="content container">
		<?php if(get_theme_option('homepage_text_header')): ?>	
			<h2><?php echo strip_tags(get_theme_option('homepage_text_header'),'<strong><em><b><i><span>');?></h2>
		<?php endif;?>
		<?php if(get_theme_option('homepage_text')): ?>	
			<?php echo text_to_paragraphs(get_theme_option('homepage_text'));?>
		<?php endif;?>
		
		<?php 
		if( ($cta_body_text1=get_theme_option('homepage_cta_button_text_1')) && 
		($cta_body_url1=get_theme_option('homepage_body_cta_button_url_1'))){
			echo '<a href="'.$cta_body_url1.'" class="button button-primary">'.$cta_body_text1.'</a>&nbsp;&nbsp;';
		}
		if( ($cta_body_text2=get_theme_option('homepage_cta_button_text_2')) && 
		($cta_body_url2=get_theme_option('homepage_body_cta_button_url_2'))){
			echo '<a href="'.$cta_body_url2.'" class="button">'.$cta_body_text2.'</a>&nbsp;&nbsp;';
		}		
		?>
		
	</div>
</section>

<?php echo foot(); ?>
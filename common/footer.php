</div> <!-- end #content -->

<footer style="<?php echo ($img=get_theme_option('footer_img')) ? 'background-image: url('.WEB_ROOT.'/files/theme_uploads/'.$img.');' : '' ;?>);">
    <div class="container">
	
	<div class="footer-nav flex-2">

		<!-- #mmenu list is cloned for off-canvas nav menu -->
		<!-- data attribute is used to hide inline menu only if javascript is available -->
		<div class="col site-map-container" data-show-footer-navigation="<?php echo (get_theme_option('show_footer_navigation'));?>">
		<nav id="mmenu">
			<h4>Site Map</h4>
		   <?php echo public_nav_main(); ?>
		</nav>
		</div>

		<div class="col">
			<div id="footer-search">
				<h4>Site Search</h4>
				<?php echo search_form(array('show_advanced' => false,'form_attributes'=>array('id'=>'footer-query'))); ?>
			</div>
			
			<div id="footer-contact">
				<h4>Contact Info</h4>
				<?php echo contact_info_formatted();?>
			</div>
		</div>			
		
	</div>
	
	<div class="footer-colophon">
	    <br><div>&copy; <?php echo date('Y').' <strong>'.option('copyright').'</strong>';?></div>
	</div>
        
    </div><!-- end footer-content -->

    <?php fire_plugin_hook('public_footer', array('view'=>$this)); ?>
	 
</footer>

<?php echo google_analytics();?>

</div> <!-- end #everything -->
</body>

</html>

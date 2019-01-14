<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes" />
    <?php if ($description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>

    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    if($siteauthor=option('author')){
	    $titleParts[] = $siteauthor; // make sure to enter the Site Author name in Admin > Settings
    }
    
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <?php fire_plugin_hook('public_head',array('view'=>$this)); ?>
    
    <!-- Stylesheets -->
    <?php
	queue_css_file('normalize');
    queue_css_file('skeleton');
    queue_css_file('styles');
    queue_css_file('jquery.mmenu.all','all',false,'javascripts/jquery.mmenu');
    if(isset($item) && $item->getItemType()['name'] == 'Hyperlink'){
    	queue_css_file('photoswipe','all',false,'javascripts/photoswipe');
		queue_css_file('default-skin','all',false,'javascripts/photoswipe/default-skin');
	}
    echo head_css();
    ?>  
    
    <!-- JavaScripts -->
    <?php 
	queue_js_file('globals');
    queue_js_file('jquery.mmenu/jquery.mmenu.all');
    if(isset($item) && $item->getItemType()['name'] == 'Hyperlink'){
	    queue_js_file('photoswipe/photoswipe.min');
	    queue_js_file('photoswipe/photoswipe-ui-default.min');
	    queue_js_file('item');	    
    }
    echo head_js(); 
    ?>
	
	<!-- Font Awesome icon fonts -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	
	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo img('icons/favicon.ico');?>">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo img('icons/favicon_57.png');?>" />
	<link rel="apple-touch-icon" sizes="72X72" href="<?php echo img('icons/favicon_72.png');?>" />
	<link rel="apple-touch-icon" sizes="114X114" href="<?php echo img('icons/favicon_114.png');?>" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo img('icons/favicon_144.png');?>" />
</head>

<?php 
@$bodyclass .=(is_allowed('Items', 'showNotPublic')!==true) ? ' logged-out ' : ' logged-in ';
echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>

<div id="everything"> 

<?php fire_plugin_hook('public_body', array('view'=>$this)); ?>	

<header id="main">       
	<div class="header-container">           
		<?php echo link_to_home_page('<div class="site-title"><h1><strong>'.option('site_title').'</strong></h1></div>');?>
		<nav id="primary-nav">
			<a href="/items/browse" class="button">Browse</a>
			<a href="/contact" class="button">Submit</a>
			<a id="search-open" title="search menu" href="#footer-search"><i class="button fa fa-search"></i></a>
			<a id="menu-open" title="navigation menu" href="#mmenu"><i class="button fa fa-bars"></i></a>
		</nav>
	</div>
</header>

<div id="header-search">
	<?php //echo search_form(array('show_advanced' => true,'form_attributes'=>array('id'=>'header-query'))); ?>
	<?php echo search_form(array('show_advanced' => false,'form_attributes'=>array('id'=>'header-query'))); ?>
<!-- 	<div>&hellip;or go to <a href="/items/search">Advanced Item Search</a> or <a href="/search">Site Search</a></div> -->
</div>

<?php if(is_current_url('/')): ?>
	<div id="banner" style="<?php echo ($img=get_theme_option('homepage_cta_img')) ? 'background-image: url('.WEB_ROOT.'/files/theme_uploads/'.$img.');' : '' ;?>">
		<!-- Homepage Call to Action -->
		<div class="container content"><br>
		<?php 
		if( ($cta_text=get_theme_option('homepage_cta_text')) && 
		($cta_button=get_theme_option('homepage_cta_button_text')) && 
		($cta_url=get_theme_option('homepage_cta_button_url')) && 
		($cta_header=get_theme_option('homepage_cta_header'))
		){
			echo '<article>';
			echo '<h2>'.strip_tags($cta_header,'<strong><em><b><i><span>').'</h2>';
			echo '<p>'.strip_tags($cta_text).'</p>';
			echo '<a class="button button-primary" href="'.$cta_url.'">'.strip_tags($cta_button).'</a>';
			echo '</article>';
		}
		?>
		<br></div>
	</div> 
<?php endif;?>
	
<div id="content">
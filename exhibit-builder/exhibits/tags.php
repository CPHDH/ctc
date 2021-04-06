<?php
$title = __("Exhibit Tags");
echo head(["title" => $title, "bodyclass" => "exhibits tags"]);
?>

<div id="banner">
	<div class="container content"><br>
	<article>
		<h2><?php echo $title; ?>: <strong><?php echo __(
  " %s ",
  count($tags)
); ?></strong></h2>
<nav class="items-nav navigation secondary-nav">
	<?php echo dc_secondary_nav("exhibits"); ?>
</nav>	

	</article>		
</div>
	
</div>

<div class="container content">
	<?php echo tag_cloud($tags, "exhibits/browse"); ?>
</div>
<?php echo foot();
?>

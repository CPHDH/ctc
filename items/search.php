<?php
$pageTitle = $_SERVER["QUERY_STRING"]
  ? __("Search Results") . ": <strong>" . $total_results . "</strong>"
  : __("Advanced Item Search");
echo head(["title" => $pageTitle, "bodyclass" => "items advanced-search"]);
?>

<div id="banner">
	<div class="container content"><br>
	<article><?php echo $_SERVER["QUERY_STRING"] ? search_filters() : null; ?>
		<h2><?php echo $pageTitle; ?></h2>
		<nav class="items-nav navigation secondary-nav">
			<?php echo dc_secondary_nav("search-results"); ?>
		</nav>
	</article>		
</div>
	
</div>

<div class="container content">
<h2><?php echo __("Search"); ?></h2>

<nav class="items-nav navigation secondary-nav">
    <?php echo dc_secondary_nav("search-results"); ?>
</nav>

<div class="primary">

	<?php echo $this->partial("items/search-form.php", [
   "formAttributes" => ["id" => "advanced-search-form"],
 ]); ?>
</div> <!-- end primary-->

</div>
<?php echo foot();
?>

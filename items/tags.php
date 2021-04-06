<?php
$pageTitle = __("Item Tags");
echo head(["title" => $pageTitle, "bodyclass" => "items tags"]);
?>
<div id="banner">
    <div class="container content"><br>
    <article>
        <h2><?php echo $pageTitle; ?>: <strong><?php echo __(
  " %s ",
  count($tags)
); ?></strong></h2>
        <nav class="items-nav navigation secondary-nav">
            <?php echo dc_secondary_nav(); ?>
        </nav>	
    </article>		
</div>
    
</div>

<div class="container content">

<?php
$sortLinks[__("Count")] = "count";
$sortLinks[__("Name")] = "name";
?>
<div id="sort-links">
<div class="sort-browse sort">
    <span class="sort-label"><?php echo __(
      "Sort by: "
    ); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>
</div>

<div class="primary">
	<?php echo tag_cloud($tags, "items/browse"); ?>
</div> <!-- end primary-->


<?php echo foot();
?>

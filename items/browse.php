<?php
$ref = $_SERVER["HTTP_REFERER"];
$isSearchResults = $ref == "https://dev-omeka.cleteaching.org/items/search";
$secondaryNav = $isSearchResults ? "search-results" : "items";
$pageTitle = $isSearchResults ? __("Search Results") : __("Browse Resources");
echo head(["title" => $pageTitle, "bodyclass" => "items browse"]);
?>
<div id="banner">
    <div class="container content"><br>
        <article><?php echo item_search_filters(); ?>
            <h2><?php echo $pageTitle; ?>: <strong><?php echo __(" %s ", $total_results); ?></strong> </h2>

            <nav class="items-nav navigation secondary-nav">
                <?php echo dc_secondary_nav($secondaryNav); ?>
            </nav>
        </article>
    </div>

</div>
<div class="container content">


    <?php if ($total_results > 0): ?>

    <div id="sort-links">

        <div class="sort-browse sort">
            <?php
                $sortLinks[__("Title")] = "Dublin Core,Title";
                $sortLinks[__("Creator")] = "Dublin Core,Creator";
                $sortLinks[__("Date Added")] = "added";
                ?>
            <span><?php echo __("Sort by:"); ?>
            </span>
            <?php echo browse_sort_links(
                    $sortLinks
                ); ?>
        </div>

    </div>

    <?php endif; ?>

    <?php if (!$total_results && $_SERVER["QUERY_STRING"]) {
                    echo "<h2>" . _("No Results. Try again.") . "</h2>";
                    echo $this->partial("items/search-form.php", [
      "formAttributes" => ["id" => "advanced-search-form"],
    ]);
                } ?>

    <div class="flex">
        <?php foreach (loop("items") as $item) {
                    flex_grid_item($item);
                } ?>
        <!-- insert empty columns to keep orphan items from getting stretched -->
        <div class="col"></div>
        <div class="col"></div>
    </div> <!-- end primary-->

    <div class="clearfix"></div>

    <?php echo pagination_links(); ?>

    <?php fire_plugin_hook("public_items_browse", [
    "items" => $items,
    "view" => $this,
 ]); ?>
</div>
<?php echo foot();
?>
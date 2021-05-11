<?php
$pageTitle = __("Browse Collections");
echo head(["title" => $pageTitle, "bodyclass" => "collections browse"]);
?>
<div id="banner">
    <div class="container content"><br>
        <article>
            <h2><?php echo $pageTitle; ?>: <strong><?php echo __(
    " %s ",
    $total_results
); ?></strong></h2>
            <nav class="items-nav navigation secondary-nav">
                <?php echo dc_secondary_nav("collections"); ?>
            </nav>

        </article>
    </div>

</div>


<div class="container content">


    <?php
 $sortLinks[__("Title")] = "Dublin Core,Title";
 $sortLinks[__("Date Added")] = "added";
 ?>
    <div id="sort-links">
        <div class="sort-browse sort">
            <span class="sort-label"><?php echo __(
     "Sort by: "
 ); ?>
            </span>
            <?php echo browse_sort_links($sortLinks); ?>
        </div>
    </div>

    <?php foreach (loop("collections") as $collection): ?>
    <div class="collection flex-browse">
        <div class="col">
            <?php
     $items = get_records(
     "Item",
     [
             "collection" => $collection,
             "hasImg" => true,
             "sort_field" => "modified",
             "sort_dir" => "d",
         ],
     1
 );
     foreach ($items as $item) {
         //$img=item_image('square_thumbnail',array(),0,$item);
         $hero = get_hero_for_item($item, "square_thumbnail");
         echo '<a class="collection-img" href="' .
             record_url($collection) .
             '"><img src="' .
             $hero .
             '"/></a>';
     }
     ?>
        </div>
        <div class="col">
            <h3><?php echo link_to_collection(); ?></h3>

            <?php
    $abstract =
        element_exists("Dublin Core", "Abstract") &&
        metadata("collection", ["Dublin Core", "Abstract"])
            ? metadata("collection", ["Dublin Core", "Abstract"])
            : "Abstract is not available";

    $d = metadata("collection", ["Dublin Core", "Description"])
        ? metadata("collection", ["Dublin Core", "Description"])
        : $abstract;
    ?>
            <p><?php echo snippet($d, 0, 250); ?></p>

            <?php echo link_to_collection("View Collection", array("class"=>"button button-primary")); ?>

            <?php echo link_to_items_browse(
        __(
            "View Resources"
        ),
        ["collection" => metadata("collection", "id")],
        ["class" => "button"]
    ); ?>



            <?php fire_plugin_hook("public_collections_browse_each", [
             "view" => $this,
             "collection" => $collection,
         ]); ?>
        </div>

    </div><br><br>
    <?php endforeach; ?>

    <?php echo pagination_links(); ?>

    <?php fire_plugin_hook("public_collections_browse", [
     "collections" => $collections,
     "view" => $this,
 ]); ?>
</div>
<?php echo foot();
?>
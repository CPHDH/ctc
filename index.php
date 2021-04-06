<?php echo head(["bodyid" => "home"]); ?>


<section>
    <div class="content container">
        <?php if (get_theme_option("homepage_text_header")): ?>
        <h2><?php echo strip_tags(
    get_theme_option("homepage_text_header"),
    "<strong><em><b><i><span>"
); ?></h2>
        <?php endif; ?>
        <?php if (get_theme_option("homepage_text")): ?>
        <?php echo text_to_paragraphs(get_theme_option("homepage_text")); ?>
        <?php endif; ?>

        <?php
        if (
          ($cta_body_text1 = get_theme_option("homepage_cta_button_text_1")) &&
          ($cta_body_url1 = get_theme_option("homepage_body_cta_button_url_1"))
        ) {
            echo '<a href="' .
            $cta_body_url1 .
            '" class="button button-primary">' .
            $cta_body_text1 .
            "</a>&nbsp;&nbsp;";
        }
        if (
          ($cta_body_text2 = get_theme_option("homepage_cta_button_text_2")) &&
          ($cta_body_url2 = get_theme_option("homepage_body_cta_button_url_2"))
        ) {
            echo '<a href="' .
            $cta_body_url2 .
            '" class="button">' .
            $cta_body_text2 .
            "</a>&nbsp;&nbsp;";
        }
        ?>

    </div>
</section>

<section>
    <div class="content container">
        <h2>Featured <strong>Collections</strong></h2>
        <?php
        $_collections = get_records(
            "Collection",
            ["sort_field" => "added", "sort_dir" => "d", "featured" => true],
            3
        );
        if ($_collections) {
            foreach ($_collections as $collection) {
                flex_grid_collection($collection);
            }
            echo '<a href="/collections/browse" class="button button-primary">Browse All Collections</a>';
        } else {
            echo "No featured collections found!";
        }
        ?>
    </div>
</section>

<section>
    <div class="content container">
        <h2>Recently Added <strong>Items</strong></h2>

        <?php
            $_items = get_records(
            "Item",
            ["public" => true, "sort_field" => "added", "sort_dir" => "d"],
            4
        );
            if ($_items) {
                echo '<div class="flex">';
                foreach ($_items as $i) {
                    flex_grid_item($i);
                }
                echo '</div>';
                echo '<a href="/items/browse" class="button button-primary">Browse All Items</a>';
            } else {
                echo "No recent items found!";
            }
            ?>


    </div>
</section>

<section>
    <div class="content container">
        <h2>Featured <strong>Exhibits</strong></h2>
        <?php echo '<a href="/exhibits/browse" class="button button-primary">Browse All Exhibits</a>'; ?>
    </div>
</section>
<?php echo foot();
?>
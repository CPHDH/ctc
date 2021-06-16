<?php
function dc_secondary_nav($type = "items")
{
    if ($type == "items") {
        $links = [
            [
                "label" => "All Resources",
                "class" => "browse button",
                "uri" => "/items/browse",
            ],
            [
                "label" => "Resource Tags",
                "class" => "tags button",
                "uri" => "/items/tags",
            ],
        ];
    } elseif ($type == "collections") {
        $links = [
            [
                "label" => "All Collections",
                "class" => "browse button",
                "uri" => "/collections/browse",
            ],
        ];
    } elseif ($type == "exhibits") {
        $links = [
            [
                "label" => "All Exhibits",
                "class" => "exhibits button",
                "uri" => "/exhibits/browse",
            ],
            [
                "label" => "Exhibit Tags",
                "class" => "exhibit-tags button",
                "uri" => "/exhibits/tags",
            ],
        ];
    } elseif ($type == "search-results") {
        $links = [
            [
                "label" => "Site Search",
                "class" => "active button",
                "uri" => "/search",
            ],
            [
                "label" => "Resource Search",
                "class" => "search button",
                "uri" => "/items/search",
            ],
        ];
    } elseif ($type == "item-map") {
        $links = [
            ["label" => "Items Map", "class" => "map button", "uri" => "/items/map"],
            [
                "label" => "All Resources",
                "class" => "map button",
                "uri" => "/items/browse",
            ],
        ];
    } else {
        $links = [
            ["label" => "Browse All", "class" => "browse button", "uri" => "#"],
        ];
    }
    return nav($links);
}
// Quick links
// do_quick_link(get_theme_option('quicklinks_1'));
function do_quick_link($option = null)
{
    if ($option) {
        switch ($option) {
            case "items":
                return '<a href="/items/browse/" class="button quick-link">' .
                    __("Items") .
                    "</a>";
            case "collections":
                return '<a href="/collections/browse/" class="button quick-link">' .
                    __("Collections") .
                    "</a>";
            case "exhibits":
                return '<a href="/exhibits/browse/" class="button quick-link">' .
                    __("Exhibits") .
                    "</a>";
            case "map":
                return '<a href="/items/map/" class="button quick-link">' .
                    __("Map") .
                    "</a>";
            case "about":
                return '<a href="/about/" class="button quick-link">' .
                    __("About") .
                    "</a>";
            case "contact":
                return '<a href="/contact/" class="button quick-link">' .
                    __("Contact") .
                    "</a>";
            case "contribute":
                return '<a href="/contribution/" class="button quick-link">' .
                    __("Contribute") .
                    "</a>";
            default:
                return null;
        }
    }
}
function the_description($record)
{
    $abstract =
        element_exists("Dublin Core", "Abstract") &&
        metadata($record, ["Dublin Core", "Abstract"], ["all" => true])
            ? metadata($record, ["Dublin Core", "Abstract"], ["all" => true])
            : null;

    $d = metadata($record, ["Dublin Core", "Description"], ["all" => true])
        ? metadata($record, ["Dublin Core", "Description"], ["all" => true])
        : ($record->type == "item" &&
        metadata($record, ["Item Type Metadata", "Text"], ["all" => true])
            ? metadata($record, ["Item Type Metadata", "Text"], ["all" => true])
            : $abstract);

    $i = 1;
    if ($d) {
        $html = "";
        foreach ($d as $description) {
            $html .= '<p class="description-' . $i . '">' . $description . "</p>";
            $i++;
        }
    } else {
        $html = null; //'<p class="no-description"><em>Description not available</em></p>';
    }
    return $html;
}

function the_hyperlink($record, $markup = true)
{
    $user_url = metadata($record, ["Item Type Metadata", "URL"]);
    $url = $user_url ? trim(strip_tags($user_url)) : null;
    $hostname = parse_url($url, PHP_URL_HOST);
    if ($url && $hostname) {
        $html =
            '<a class="button button-primary" target="_blank" href="' .
            $url .
            '">' .
            "View @ " .
            $hostname .
            "</a><div>Or scroll down for additional info</div>";
    } else {
        $html = "<p><pre>Error: URL not available.</pre></p>";
    }
    if ($markup == true) {
        return $html;
    } elseif ($url) {
        return $url;
    } else {
        return null;
    }
}

/* Check for some specific mime types */

function isImg($mime)
{
    $img = ["image/jpeg", "image/jpg", "image/png", "image/jpeg", "image/gif"];
    $test = in_array($mime, $img);
    return $test;
}

function isVideoJS($mime)
{
    $video = [
        "video/mp4",
        "video/mpeg",
        "video/ogg",
        "video/quicktime",
        "video/webm",
    ];
    $test = in_array($mime, $video);
    return $test;
}

function isMP3($mime)
{
    $audio = [
        "audio/mp3",
        "audio/mp4",
        "audio/mpeg",
        "audio/mpeg3",
        "audio/mpegaudio",
        "audio/mpg",
        "audio/x-mp3",
        "audio/x-mp4",
        "audio/x-mpeg",
        "audio/x-mpeg3",
        "audio/x-mpegaudio",
        "audio/x-mpg",
        "audio/x-mp3",
        "audio/x-mp4",
        "audio/x-mpeg",
        "audio/x-mpeg3",
        "audio/x-mpegaudio",
        "audio/x-mpg",
    ];
    $test = in_array($mime, $audio);
    return $test;
}

function isDocsViewer($file)
{
    $ext = strtolower(pathinfo($file->filename, PATHINFO_EXTENSION));

    $doc = [
        "doc",
        "docx", // Microsoft Word
        "ppt",
        "pptx", // Microsoft PowerPoint
        "xls",
        "xlsx", // Microsoft Excel
        "tif",
        "tiff", // Tagged Image File Format
        "eps",
        "ps", // PostScript
        "pdf", // Adobe Portable Document Format
        "pages", // Apple Pages
        "ai", // Adobe Illustrator
        "psd", // Adobe Photoshop
        "dxf", // Autodesk AutoCad
        "svg", // Scalable Vector Graphics
        "ttf", // TrueType
        "xps", // XML Paper Specification);
    ];
    $test = in_array($ext, $doc);
    return $test;
}

/*
 ** Get URL of the first image for the item
 ** Used for responsive image areas
 ** Example: get_hero_for_item($item,$size='square_thumbnails')
 */
function get_hero_for_item($item, $size)
{
    $i = 0;
    foreach (loop("files", $item->Files) as $file) {
        $mime = metadata($file, "mime_type");

        if (isImg($mime) == true && $i == 0) {
            $url = $file->getWebPath($size);
            $i++;
            return $url;
        } elseif (isVideoJS($mime) == true && $i == 0) {
            $url = img("video.png", "images/fallbacks");
            //$url = $file->getWebPath('thumbnail');
            $i++;
            return $url;
        } elseif (isMP3($mime) == true && $i == 0) {
            $url = img("audio.png", "images/fallbacks");
            $i++;
            return $url;
        } elseif (isDocsViewer($file) == true && $i == 0) {
            $url = img("file.png", "images/fallbacks");
            //$url = $file->getWebPath('thumbnail');
            $i++;
            return $url;
        }
    }
}

function get_the_authors($item)
{
    if (!$item) {
        $item = get_current_record("item");
    }
    if (
        $creators = metadata($item, ["Dublin Core", "Creator"], ["all" => true])
    ) {
        $authArray = [];
        $authTotal = count($creators);
        foreach ($creators as $creator) {
            $authArray[] = $creator;
        }

        switch ($authTotal) {
            case 1:
                $authors = '<span class="auth">' . $authArray[0] . "</span>";
                break;

            case 2:
                $authors =
                    '<span class="auth">' .
                    $authArray[0] .
                    '</span> <span class="amp">&amp;</span> <span class="auth">' .
                    $authArray[1] .
                    "</span>";
                break;

            default:
                $authors =
                    '<span class="auth">' .
                    $authArray[0] .
                    '</span>, <span class="auth">' .
                    $authArray[1] .
                    "</span>, et al.";
        }

        return '<div class="creator">by ' . $authors . "</div>";
    }
}

function link_to_item_type_by_name(
    $linkText = "View All",
    $props = [],
    $typeName
) {
    $type = get_db()
        ->getTable("ItemType")
        ->findByName($typeName);
    if ($type) {
        return link_to_items_with_item_type($linkText, $props, "browse", $type);
    }
}

function icon_font_for_type($type)
{
    switch ($type) {
        case "Website":
            return ' <i class="fa fa-external-link-square"></i>';
            break;
        case "Still Image":
            return ' <i class="fa fa-camera-retro"></i>';
            break;
        case "Sound":
            return ' <i class="fa fa-microphone"></i>';
            break;
        case "Oral History":
            return ' <i class="fa fa-microphone"></i>';
            break;
        case "Moving Image":
            return ' <i class="fa fa-youtube-play"></i>';
            break;
        case "Tour":
            return ' <i class="fa fa-map"></i>';
            break;
        case "Item":
            return ' <i class="fa fa-bookmark"></i>';
            break;
        case "File":
            return ' <i class="fa fa-file"></i>';
            break;
        case "Collection":
            return ' <i class="fa fa-clone"></i>';
            break;
        case "Exhibit":
            return ' <i class="fa fa-folder"></i>';
            break;
        default:
            return ' <i class="fa fa-bookmark"></i>';
            break;
    }
}

function icon_font_if_featured($item)
{
    if ($item->featured) {
        return '<span>Featured</span> <i class="fa fa-star"></i>';
    }
}

function homepage_grid_recent_items($num = 10)
{
    $items = get_records(
        "Item",
        ["sort_field" => "added", "sort_dir" => "d"],
        $num
    );
    if ($items) {
        foreach ($items as $item) {
            flex_grid_item($item);
        }
    }
}
function homepage_grid_featured_collections($num = 1)
{
    $collections = get_records(
        "Collection",
        ["sort_field" => "added", "sort_dir" => "d", "featured" => true],
        $num
    );
    if ($collections) {
        $i = 1;
        foreach ($collections as $collection) {
            flex_grid_collection($collection, $i);
            $i++;
            if ($i > 3) {
                $i = 1;
            }
        }
    }
}
function homepage_grid_featured_exhibit($num = 1)
{
    if (plugin_is_active("ExhibitBuilder")) {
        $exhibits = get_records(
            "Exhibit",
            ["sort_field" => "added", "sort_dir" => "d", "featured" => true],
            $num
        );
        if ($exhibits) {
            $i = 1;
            foreach ($exhibits as $exhibit) {
                flex_grid_exhibit($exhibit, $i);
                $i++;
                if ($i > 3) {
                    $i = 1;
                }
            }
        }
    }
}
function flex_grid_item($item)
{
    if (!$item) {
        $item = get_current_record("Item");
    } else {
        set_current_record("Item", $item);
    }
    $creator = metadata($item, ["Dublin Core", "Creator"]);
    $interviewee = metadata($item, ["Item Type Metadata", "Interviewee"]);
    $creator = $interviewee ? $interviewee : $creator;
    $date = metadata($item, ["Dublin Core", "Date"]);
    $hero = get_hero_for_item($item, "fullsize");
    $typeName = $item->getItemType()["name"];
    $itemclass = "";
    $itemclass .= $typeName
        ? " " . strtolower(str_replace(" ", "-", $typeName))
        : null;
    $itemclass .= $hero ? " has-image" : null;
    if ($hero) {
        $subject = $hero;
        $pattern = "/fallbacks/";
        preg_match($pattern, substr($subject, 0), $matches, PREG_OFFSET_CAPTURE, 3);
        $itemclass .= $matches[0] ? " fallback" : "";
    } ?>
<div class="col">
    <article class="grid item<?php echo $itemclass; ?>">
        <div class="inner flex-2">

            <a class="thumbnail" href="<?php echo record_url(
        $item
    ); ?>"><?php echo ($img = item_image("square_thumbnail", [], 0, $item)) ? $img : null; ?></a>

            <div class="item-info">
                <h3><a href="<?php echo record_url(
        $item
    ); ?>"><?php echo metadata($item, ["Dublin Core", "Title"]); ?></a></h3>


                <div class="item-bottom">
                    <?php
                                        $headmeta = [];
    // if ($date = metadata($item, ["Dublin Core", "Date"])) {
    //   $headmeta[] = '<span class="item-date">' . $date . "</span>";
    // }
    if (
                                            $creator = metadata($item, ["Dublin Core", "Creator"])
                                        ) {
        $headmeta[] =
                                                '<span class="item-creator">' . $creator . "</span>";
    }
    if (
                                            $publisher = metadata($item, ["Dublin Core", "Publisher"])
                                        ) {
        $headmeta[] =
                                                '<span class="item-publisher">' .
                                                $publisher .
                                                "</span>";
    }
    if ($collection = metadata($item, "Collection Name")) {
        $headmeta[] =
                                                '<span class="item-collection">Collection: ' .
                                                link_to_collection_for_item() .
                                                "</span>";
    }
    // if (metadata($item, "has tags")) {
    //   $headmeta[] =
    //     '<span class="item-meta-tags">Filed under: ' .
    //     tag_string($item, "items/browse", ", ") .
    //     "</span>";
    // }

    echo implode(" | ", $headmeta); ?>
                </div>
            </div>
        </div>
    </article>
</div>
<?php
}

function flex_grid_other_search_results($record, $recordType)
{
    if (isset($recordType)):
        if ($recordType == "Collection") {
            $iconclass = "fa fa-archive";
        } else {
            $iconclass = "fa fa-file";
        } ?>
<div class="col">
    <article class="grid item<?php echo strtolower($recordType); ?>">
        <div class="inner flex-2">

            <a class="thumbnail thumbnail-other-result"><i class="<?php echo $iconclass; ?>"></i></a>

            <div class="item-info">
                <h3><a href="<?php echo record_url(
            $record
        ); ?>"><?php echo metadata($record, [
    "Dublin Core",
    "Title",
]); ?></a></h3>


                <div class="item-bottom">
                    <?php echo "Type: " . $recordType; ?>
                </div>
            </div>
        </div>
    </article>
</div>
<?php
    endif;
}

function flex_grid_collection($collection)
{
    $item = get_record("Item", [
        "hasImage" => true,
        "collection" => $collection,
        "sort_field" => "modified",
        "sort_dir" => "d",
    ]);
    $title = metadata($collection, ["Dublin Core", "Title"]);
    $abstract =
        element_exists("Dublin Core", "Abstract") &&
        metadata($collection, ["Dublin Core", "Abstract"])
            ? metadata($collection, ["Dublin Core", "Abstract"])
            : "Abstract is not available";

    $d = metadata($collection, ["Dublin Core", "Description"])
        ? metadata($collection, ["Dublin Core", "Description"])
        : $abstract; ?>
<article class="collection">
    <div class="collections-outer">
        <?php echo '<h3><a href="' .record_url($collection) .'">' .$title ."</a></h3>" ; ?>
        <div class="collections-inner">
            <?php echo "<div><div class=\"item-count\"><strong>".__('%s Resources', $collection->totalItems())."</strong></div>" .snippet($d, 0, 400, "... ") ."</div>"; ?>
            <?php echo '<a class="collection-img" href="' .record_url($collection) .'">' .item_image("square_thumbnail", [], 0, $item) ."</a>"; ?>
        </div>
    </div>
</article>
<?php
}

function flex_grid_exhibit($exhibit, $i)
{
    //var_dump();
    $title = exhibit_builder_link_to_exhibit($exhibit);
    $description = ($exhibitDescription = metadata($exhibit, "description", [
        "no_escape" => true,
    ]))
        ? $exhibitDescription
        : null;
    $snippet = snippet($description, 0, 400, "... ");
    $exhibitCoverImageFile = ($id = $exhibit->cover_image_file_id)
        ? get_record_by_id("File", $id)
        : null;
    $text =
        "<h3>" .
        $title .
        "</h3>" .
        "<p>" .
        $snippet .
        "</p>" .
        '<a href="' .
        record_url($exhibit) .
        '" class="button">View Exhibit</a>'; ?>
<article class="collection">
    <div class="flex-2">
        <div class="col"><?php echo $text; ?></div>
        <div class="col">
            <?php echo $exhibitCoverImageFile
                            ? '<a class="collection-img" href="' .
                                record_url($exhibit) .
                                '">' .
                                record_image($exhibitCoverImageFile, "fullsize") .
                                "</a>"
                            : null; ?>
        </div>
    </div>
</article>
<?php
}

function footer_text_snippets($length = 250)
{
    ?>
<div class="col">
    <h2><span>About</span> This</h2>
    <article>
        <?php if ($about = get_theme_option("footer_about_text")) {
        $about = snippet($about, 0, $length, "...");
        echo "<p>" .
                        $about .
                        '</p><a class="read-more button" href="' .
                        WEB_ROOT .
                        '/about">Read More</a>';
    } else {
        echo "<p>You have not entered any text in theme settings.</p>";
    } ?>
    </article>
</div>

<div class="col">
    <h2><span>About</span> That</h2>
    <article>
        <?php if ($sponsorAbout = get_theme_option("footer_sponsor_text")) {
        $sponsorAbout = snippet($sponsorAbout, 0, $length, "...");
        echo "<p>" .
                        $sponsorAbout .
                        '</p><a class="read-more button" href="#">Visit Our Homepage</a>';
    } else {
        echo "<p>You have not entered any text in theme settings.</p>";
    } ?>
    </article>
</div>
<?php
}

function gallery_script($num = 6)
{
    echo js_tag("jquery.event.move.min");
    echo js_tag("jquery.event.swipe.min");
    echo js_tag("unslider.min");
    $items = get_records(
        "Item",
        [
            "sort_field" => "modified",
            "sort_dir" => "d",
            "featured" => true,
            "hasImage" => true,
        ],
        $num
    );
    if ($items) {
        $itemsArray = [];
        foreach ($items as $item) {
            if ($img = get_hero_for_item($item, "fullsize")) {
                $itemsArray[] = [
                    "url" => WEB_ROOT . "/items/show/" . $item->id,
                    "fullsize" => $img,
                    "title" => ($title = metadata($item, ["Dublin Core", "Title"]))
                        ? $title
                        : "No Title",
                    "creator" => ($creator = metadata($item, ["Dublin Core", "Creator"]))
                        ? $creator
                        : "Creator Unknown",
                    "date" => ($date = metadata($item, ["Dublin Core", "Date"]))
                        ? $date
                        : "Date Unknown",
                    "collection" => ($collection = get_collection_for_item($item))
                        ? link_to($collection, "show", "View Collection", [
                            "class" => "cta",
                        ])
                        : "",
                ];
            }
        }
        if (count($itemsArray) > 0) { ?>
<div class="banner">
    <ul>
        <?php foreach ($itemsArray as $i) { ?>
        <li>
            <div class="slide-container" style="background:url(<?php echo $i[
                            "fullsize"
                        ]; ?>) no-repeat;background-size: cover;background-position: center">
                <div class="slide-info">
                    <h1><?php echo '<a href="' .
                                            $i["url"] .
                                            '">' .
                                            $i["title"] .
                                            "</a>"; ?></h1>
                    <h2><?php echo $i["date"]; ?> / <?php echo $i[
     "creator"
 ]; ?></h2>
                    <a class="cta" href="<?php echo $i["url"]; ?>">View Item</a>
                    <?php echo $i["collection"]; ?>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<a href="#" class="unslider-arrow prev">Previous slide</a>
<a href="#" class="unslider-arrow next">Next slide</a>
<script>
var unslider = jQuery('.banner').unslider({
    //speed:800,
    delay: 7000,
    fluid: true,
});

data = unslider.data('unslider');
data.dots();

var slides = jQuery('.banner'),
    i = 0;

slides
    .on('swiperight', function(e) {
        data.prev();
    })
    .on('swipeleft', function(e) {
        data.next();
    })
    .on('movestart', function(e) {
        // disable swipe up/down events to allow for normal scrolling
        if ((e.distX > e.distY && e.distX < -e.distY) ||
            (e.distX < e.distY && e.distX > -e.distY)) {
            e.preventDefault();
        }
    });

jQuery('.unslider-arrow').click(function() {
    var fn = this.className.split(' ')[1];

    //  Either do unslider.data('unslider').next() or .prev() depending on the className
    unslider.data('unslider')[fn]();
});
</script>
<?php }
    }
}

function browse_by_item_type()
{
    $types = get_records("ItemType", [], 0);
    $opts = [];
    foreach ($types as $type) {
        $total = $type->totalItems();
        if ($total > 0) {
            $opts[$type->name] =
                '<option value="' .
                $type->id .
                '">' .
                $type->name .
                " (" .
                $total .
                ")</option>";
        }
    }
    ksort($opts);

    $html = '<select id="item-type-browse">';
    $html .= '<option value="0">Browse by item type...</option>';
    $html .= '<option value="">All Types (Reset)</option>';
    foreach ($opts as $key => $value) {
        $html .= $value;
    }
    $html .= "</select>";

    $html .= '<script>
        // Submit item type selection
        jQuery("#item-type-browse").on("change",function(){
                var typeid=jQuery(this).val();
                window.location="/items/browse?search=&advanced[0][element_id]=&advanced[0][type]=&advanced[0][terms]=&type="+typeid;
        });
        </script>';
    return $html;
}

function random_item_link($text = null, $class = "show")
{
    if (!$text) {
        $text = __("View a Random Item");
    }
    $link = "";
    $randitems = get_records(
        "Item",
        ["sort_field" => "random", "hasImage" => true],
        1
    );
    $linkclass = "random-story-link " . $class;

    if (count($randitems) > 0) {
        $link = link_to($randitems[0], "show", $text, ["class" => $linkclass]);
    } else {
        $link = link_to("items", "browse", "Browse Items", ["class" => $linkclass]);
    }
    return $link;
}

function get_img_files($item, $custom_url = null)
{
    $html = null;
    $index = 0;

    foreach (loop("files", $item->Files) as $file) {
        $mime = metadata($file, "MIME Type");
        // if the file is an image, proceed...
        if (isImg($mime) !== false) {
            $index++;

            $html .=
                '<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
            $html .=
                '<a href="' .
                ($custom_url ? $custom_url : file_display_url($file, "fullsize")) .
                '" itemprop="contentUrl" data-size="" ' .
                ($custom_url ? 'target="_blank"' : null) .
                ">";
            $html .=
                '<img src="' .
                file_display_url($file, "fullsize") .
                '" itemprop="thumbnail" alt="' .
                metadata($file, ["Dublin Core", "Title"]) .
                '" />';
            $html .= "</a>";
            $html .=
                '<figcaption itemprop="caption description">' .
                create_file_caption($file) .
                "</figcaption>";
            $html .= "</figure>";
        }
    }
    if ($html) {
        return '<div class="pswp-image-gallery" itemscope itemtype="http://schema.org/ImageGallery">' .
            $html .
            "</div>";
    } else {
        return null;
    }
}

function get_streaming_files($item)
{
    if (!$item) {
        $item = set_loop_records("Files", $item);
    }
    $index = 0;
    foreach (loop("files", $item->Files) as $file):
        //variables used to check mime types for VideoJS compatibility, etc.
        $mime = metadata($file, "MIME Type");
    $wma_video = ["audio/wma", "audio/x-ms-wma"];
    $wmv_video = [
            "video/avi",
            "video/msvideo",
            "video/x-msvideo",
            "video/x-ms-wmv",
        ];
    // VideoJS videos
    if (isVideoJS($mime) !== false) { ?>

<div class="video-container" id="v<?php echo $index; ?>">
    <video id="video_<?php echo $index; ?>" class="video-js vjs-default-skin video" controls playsinline preload="auto" data-setup="{}">
        <source src="<?php echo file_display_url(
        $file,
        "original"
    ); ?>" type='video/mp4' />
        Your browser doesn't support HTML &lt;video&rt;. <a href="<?php echo file_display_url(
        $file,
        "original"
    ); ?>">Download the file</a>.
    </video>
</div>

<?php } elseif (isMP3($mime) !== false) { ?>
<div class="audio-container" id="a<?php echo $index; ?>">
    <audio id="audio_<?php echo $index; ?>" class="htmlaudio" preload="auto" width="auto" height="20" controls>
        <source src='<?php echo file_display_url(
        $file,
        "original"
    ); ?>' type="<?php echo $mime; ?>" />

        Your browser doesn't support HTML &lt;audio&rt;.
        <a href="<?php echo file_display_url(
        $file,
        "original"
    ); ?>">Download the file</a>.
    </audio>
</div>
<?php }
    $index++;
    endforeach;
}

function create_file_caption($file)
{
    $captionTitle = metadata($file, ["Dublin Core", "Title"])
        ? "<strong>" . metadata($file, ["Dublin Core", "Title"]) . "</strong>"
        : "";
    $captionCreator = metadata($file, ["Dublin Core", "Creator"])
        ? metadata($file, ["Dublin Core", "Creator"])
        : "";
    $captionDate = metadata($file, ["Dublin Core", "Date"])
        ? metadata($file, ["Dublin Core", "Date"])
        : "";
    if ($captionCreator || $captionDate) {
        $captionTitle .= "<br>" . implode(" | ", [$captionCreator, $captionDate]);
    }
    $captionDescription = metadata($file, ["Dublin Core", "Description"])
        ? ": " . metadata($file, ["Dublin Core", "Description"])
        : "";
    $captionSource = metadata($file, ["Dublin Core", "Source"])
        ? "<div>Source: " . metadata($file, ["Dublin Core", "Source"]) . "</div>"
        : "";
    $captionLink = metadata($file, "id")
        ? '<div class="more-info">More Info: ' .
            link_to($file, "show", "View file metadata", [
                "class" => "view-file-record",
                "rel" => "nofollow",
            ]) .
            "</div>"
        : "";

    $caption =
        $captionTitle . $captionDescription . $captionSource . $captionLink;

    return $caption;
}

// File download table for items/show
function file_download_table($item = null, $html = null)
{
    if ($files = loop("files", $item->Files)) {
        $html .= '<table class="u-full-width">';
        $html .=
            "<thead><tr><th>" .
            __("Name") .
            "</th><th>" .
            __("Info") .
            "</th><th>" .
            __("Download") .
            "</th></tr></thead><tbody>";
        foreach ($files as $file) {
            $file_url = file_display_url($file, "original");
            $file_title = metadata($file, ["Dublin Core", "Title"])
                ? metadata($file, ["Dublin Core", "Title"])
                : $file->original_filename;
            $file_link =
                '<a class="button download-file-button" href="' .
                $file_url .
                '" download="' .
                $file->original_filename .
                '">Download</a>';
            $file_info =
                '<div class="download-file-info"><span>' .
                $file->getExtension() .
                "</span> / " .
                formatSizeUnits($file->size) .
                "</div>";
            $html .=
                "<tr><td>" .
                $file_title .
                "</td><td>" .
                $file_info .
                "</td><td>" .
                $file_link .
                "</td></tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    }
}

/* test if current url is an Omeka SimplePages page */
/* returns page id or false */
function is_simplepage($url)
{
    if (!$url) {
        $url = current_url();
    }
    $spinfo = [];
    $pages = get_db()
        ->getTable("SimplePagesPage")
        ->findAll();
    foreach ($pages as $page) {
        $spinfo[$page->id] = "/" . $page->slug;
    }
    return array_search($url, $spinfo);
}

/*
 ** https://stackoverflow.com/questions/5501427/php-filesize-mb-kb-conversion
 */
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . " GB";
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . " MB";
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . " kB";
    } elseif ($bytes > 1) {
        $bytes = $bytes . " bytes";
    } elseif ($bytes == 1) {
        $bytes = $bytes . " byte";
    } else {
        $bytes = "0 bytes";
    }

    return $bytes;
}
// Contact Info
// Uses HTML Microformats: https://microformats.io/
function contact_info_formatted($html = null, $includeSocial = true)
{
    $org_name = get_theme_option("org_name");
    $street_address_1 = get_theme_option("street_address_1");
    $street_address_2 = get_theme_option("street_address_2");
    $city = get_theme_option("city");
    $state = get_theme_option("state");
    $zip = get_theme_option("zip");
    $country = get_theme_option("country");
    $phone = get_theme_option("phone");

    $html .= $org_name
        ? '<strong><span class="p-name">' .
            strip_tags($org_name) .
            "</span></strong><br>"
        : null;
    $html .= $street_address_1
        ? '<span class="p-street-address">' .
            strip_tags($street_address_1) .
            "</span><br>"
        : null;
    $html .= $street_address_2
        ? '<span class="p-extended-address">' .
            strip_tags($street_address_2) .
            "</span><br>"
        : null;
    $html .= $city
        ? '<span class="p-locality">' . trim(strip_tags($city)) . "</span>"
        : null;
    $html .= $state
        ? ', <span class="p-region">' . trim(strip_tags($state)) . "</span>"
        : null;
    $html .= $zip
        ? ' <span class="p-postal-code">' . trim(strip_tags($zip)) . "</span>"
        : null;
    $html .= $country
        ? ' <span class="p-country-name">' . trim(strip_tags($country)) . "</span>"
        : null;
    $html .= $phone
        ? '<br><span class="p-tel">' . trim(strip_tags($phone)) . "</span>"
        : null;
    $html .= $includeSocial ? "<br>" . social_links_formatted() : null;

    return $html
        ? '<div class="h-card">' . $html . "</div>"
        : "Please enter your contact information in theme settings.";
}

// Social Media and Email Links
// Uses HTML Microformats: https://microformats.io/
function social_links_formatted($html = null)
{
    $email = get_theme_option("email_address");
    $facebook = get_theme_option("facebook_url");
    $twitter = get_theme_option("twitter_url");
    $instagram = get_theme_option("instagram_url");
    $youtube = get_theme_option("youtube_url");
    $pinterest = get_theme_option("pinterest_url");

    if ($email || $facebook || $twitter || $instagram || $youtube || $pinterest) {
        $html .= '<div class="social-media-links">';

        $html .= $email
            ? '<a target="_blank" title="Email" class="fa fa-envelope hcard" href="' .
                $email .
                '"></a>'
            : null;
        $html .= $facebook
            ? '<a target="_blank" title="Facebook" class="fab fa-facebook hcard" href="' .
                $facebook .
                '"></a>'
            : null;
        $html .= $twitter
            ? '<a target="_blank" title="Twitter" class="fab fa-twitter hcard" href="' .
                $twitter .
                '"></a>'
            : null;
        $html .= $instagram
            ? '<a target="_blank" title="Instagram" class="fab fa-instagram hcard" href="' .
                $instagram .
                '"></a>'
            : null;
        $html .= $pinterest
            ? '<a target="_blank" title="Pinterest" class="fab fa-pinterest hcard" href="' .
                $pinterest .
                '"></a>'
            : null;
        $html .= $youtube
            ? '<a target="_blank" title="Youtube" class="fab fa-youtube hcard" href="' .
                $youtube .
                '"></a>'
            : null;

        $html .= "</div>";
    }

    return $html;
}

// PhotoSwipe UI
function photoswipe_markup()
{
    ?>
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<?php
}

// Google Analytics
function google_analytics($webPropertyID = null)
{
    $webPropertyID = get_theme_option("google_analytics");
    if ($webPropertyID != null) {
        echo "<script type=\"text/javascript\">
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', '" .
            $webPropertyID .
            "']);
                _gaq.push(['_trackPageview']);
                (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
        </script>";
    }
}

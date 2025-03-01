<?php
if (!empty($formActionUri)):
  $formAttributes["action"] = $formActionUri;
else:
  $formAttributes["action"] = url([
    "controller" => "items",
    "action" => "browse",
  ]);
endif;
$formAttributes["method"] = "GET";
?>
<form <?php echo tag_attributes($formAttributes); ?>>
    <div id="search-keywords" class="field">
        <?php echo $this->formLabel(
          "keyword-search",
          __("Search for Keywords")
        ); ?>
        <div class="inputs">
        <?php echo $this->formText("search", @$_REQUEST["search"], [
          "id" => "keyword-search",
          "size" => "40",
        ]); ?>
        </div>
    </div>
    <div id="search-narrow-by-fields" class="field">
        <div class="label"><?php echo __("Narrow by Specific Fields"); ?></div>
        <div class="inputs">
        <?php
        // If the form has been submitted, retain the number of search
        // fields used and rebuild the form
        if (!empty($_GET["advanced"])) {
          $search = $_GET["advanced"];
        } else {
          $search = [["field" => "", "type" => "", "value" => ""]];
        }

        //Here is where we actually build the search form
        foreach ($search as $i => $rows): ?>
            <div class="search-entry">
                <?php
                //The POST looks like =>
                // advanced[0] =>
                //[field] = 'description'
                //[type] = 'contains'
                //[terms] = 'foobar'
                //etc
                echo $this->formSelect(
                  "advanced[$i][element_id]",
                  @$rows["element_id"],
                  [
                    "title" => __("Search Field"),
                    "id" => null,
                    "class" => "advanced-search-element",
                  ],
                  get_table_options("Element", null, [
                    "record_types" => ["Item", "All"],
                    "sort" => "orderBySet",
                  ])
                );
                echo $this->formSelect(
                  "advanced[$i][type]",
                  @$rows["type"],
                  [
                    "title" => __("Search Type"),
                    "id" => null,
                    "class" => "advanced-search-type",
                  ],
                  label_table_options([
                    "contains" => __("contains"),
                    "does not contain" => __("does not contain"),
                    "is exactly" => __("is exactly"),
                    "is empty" => __("is empty"),
                    "is not empty" => __("is not empty"),
                  ])
                );
                echo $this->formText("advanced[$i][terms]", @$rows["terms"], [
                  "size" => "20",
                  "title" => __("Search Terms"),
                  "id" => null,
                  "class" => "advanced-search-terms",
                ]);
                ?>
                <button type="button" class="remove_search" disabled="disabled" style="display: none;"><?php echo __(
                  "Remove field"
                ); ?></button>
            </div>
        <?php endforeach;
        ?>
        </div>
        <button type="button" class="add_search"><?php echo __(
          "Add a Field"
        ); ?></button>
    </div>

    <div id="search-by-range" class="field">
        <?php echo $this->formLabel(
          "range",
          __("Search by a range of ID#s (example: 1-4, 156, 79)")
        ); ?>
        <div class="inputs">
        <?php echo $this->formText("range", @$_GET["range"], [
          "size" => "40",
        ]); ?>
        </div>
    </div>

    <div class="field">
        <?php echo $this->formLabel(
          "collection-search",
          __("Search By Collection")
        ); ?>
        <div class="inputs">
        <?php echo $this->formSelect(
          "collection",
          @$_REQUEST["collection"],
          ["id" => "collection-search"],
          get_table_options("Collection")
        ); ?>
        </div>
    </div>

    <div class="field">
        <?php echo $this->formLabel(
          "item-type-search",
          __("Search By Type")
        ); ?>
        <div class="inputs">
        <?php echo $this->formSelect(
          "type",
          @$_REQUEST["type"],
          ["id" => "item-type-search"],
          get_table_options("ItemType")
        ); ?>
        </div>
    </div>

    <?php if (is_allowed("Users", "browse")): ?>
    <div class="field">
    <?php echo $this->formLabel("user-search", __("Search By User")); ?>
        <div class="inputs">
        <?php echo $this->formSelect(
          "user",
          @$_REQUEST["user"],
          ["id" => "user-search"],
          get_table_options("User")
        ); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="field">
        <?php echo $this->formLabel("tag-search", __("Search By Tags")); ?>
        <div class="inputs">
        <?php echo $this->formText("tags", @$_REQUEST["tags"], [
          "size" => "40",
          "id" => "tag-search",
        ]); ?>
        </div>
    </div>


    <?php if (is_allowed("Items", "showNotPublic")): ?>
    <div class="field">
        <?php echo $this->formLabel("public", __("Public/Non-Public")); ?>
        <div class="inputs">
        <?php echo $this->formSelect(
          "public",
          @$_REQUEST["public"],
          [],
          label_table_options([
            "1" => __("Only Public Items"),
            "0" => __("Only Non-Public Items"),
          ])
        ); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="field">
        <?php echo $this->formLabel("featured", __("Featured/Non-Featured")); ?>
        <div class="inputs">
        <?php echo $this->formSelect(
          "featured",
          @$_REQUEST["featured"],
          [],
          label_table_options([
            "1" => __("Only Featured Items"),
            "0" => __("Only Non-Featured Items"),
          ])
        ); ?>
        </div>
    </div>


    <div><br>
        <?php if (!isset($buttonText)) {
          $buttonText = __("Search for items");
        } ?>
        <input type="submit" class="submit button-primary" name="submit_search" id="submit_search_advanced" value="<?php echo $buttonText; ?>">
    </div>
    
</form>
<?php echo js_tag("items-search"); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();
    });
</script>

<?php echo $this->form("search-form", $options["form_attributes"]); ?>
    <?php echo $this->formText("query", $filters["query"], [
      "title" => __("Search"),
      "placeholder" => __("Enter a search term"),
    ]); ?>
    <?php if ($options["show_advanced"]): ?>
    <div id="advanced-form" class="flex-3">
	    <div class="col">
	        <fieldset id="query-types">
	            <legend><?php echo __("Search using this query type:"); ?></legend>
	            <?php $t = $this->formRadio(
               "query_type",
               $filters["query_type"],
               null,
               $query_types
             ); ?>
	            <?php echo str_replace(["<br>", "<br/>"], " ", $t); ?>
	        </fieldset>
	    </div>
	    <div class="col">
	        <?php if ($record_types): ?>
	        <fieldset id="record-types">
	            <legend><?php echo __(
               "Search only these record types:"
             ); ?></legend>
	            <?php foreach ($record_types as $key => $value): ?>
	            	<div class="record-type-option">
		            	<?php echo $this->formCheckbox("record_types[]", $key, [
                 "checked" => in_array($key, $filters["record_types"]),
                 "id" => "record_types-" . $key,
               ]); ?> <?php echo $this->formLabel(
   "record_types-" . $key,
   $value
 ); ?>
		            </div>
	            <?php endforeach; ?>
	        </fieldset>
	        <?php elseif (is_admin_theme()): ?>
	            <p><a href="<?php echo url(
               "settings/edit-search"
             ); ?>"><?php echo __(
  "Go to search settings to select record types to use."
); ?></a></p>
	        <?php endif; ?>
        </div>
        <div class="col"></div>
    </div>
    
    <?php else: ?>
        <?php echo $this->formHidden("query_type", $filters["query_type"]); ?>
        <?php foreach ($filters["record_types"] as $type): ?>
        <?php echo $this->formHidden("record_types[]", $type); ?>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <div>
	    <div>
	    <?php echo $this->formButton("submit_search", $options["submit_value"], [
       "type" => "submit",
       "class" => "button button-primary",
     ]); ?>
	    </div>
	    

    </div>
</form>

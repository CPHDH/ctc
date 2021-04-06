<?php echo head(["bodyclass" => "contact"]); ?>

<div id="banner">
  <div class="container content"><br>
  <article>
      <h2><?php echo html_escape(
        get_option("simple_contact_form_thankyou_page_title")
      ); ?></h2>

  </article>		
</div>
  
</div>
<div class="container content">
<?php echo get_option("simple_contact_form_thankyou_page_message");
// HTML
?>
</div>

<?php echo foot();
?>

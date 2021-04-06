<?php echo head(["bodyclass" => "contact"]); ?>
<div id="banner">
    <div class="container content"><br>
    <article>
        <h2><?php echo html_escape(
          get_option("simple_contact_form_contact_page_title")
        ); ?></h2>

    </article>		
</div>
    
</div>

<div class="container content">
<div id="simple-contact">
    <div id="form-instructions">
        <?php echo get_option("simple_contact_form_contact_page_instructions");
// HTML
?>
    </div>
    <?php echo flash(); ?>
    <form name="contact_form" id="contact-form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">

        <div class="field">
        <?php echo $this->formLabel("name", "Your Name: "); ?>
            <div class='inputs'>
            <?php echo $this->formText("name", $name, [
              "class" => "textinput",
            ]); ?>
            </div>
        </div>
        
        <div class="field">
            <?php echo $this->formLabel("email", "Your Email: "); ?>
            <div class='inputs'>
                <?php echo $this->formText("email", $email, [
                  "class" => "textinput",
                ]); ?>
            </div>
        </div>
        
        <div class="field">
          <?php echo $this->formLabel("message", "Your Message: "); ?>
          <div class='inputs'>
          <?php echo $this->formTextarea("message", $message, [
            "class" => "textinput",
            "rows" => "10",
          ]); ?>
          </div>
        </div>
        
        <?php if ($captcha): ?>
        <div class="field">
            <?php echo $captcha; ?>
        </div>
        <?php endif; ?>
		<br>
        <div class="field">
          <?php echo $this->formSubmit("send", "Send Message"); ?>
        </div>
    </form>

</div>

</div>
<?php echo foot();

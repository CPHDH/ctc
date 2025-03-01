<?php
/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Contribution
 */

queue_js_file('contribution-public-form');
$contributionPath = get_option('contribution_page_path');
if (!$contributionPath) {
    $contributionPath = 'contribution';
}
queue_css_file('form');

//load user profiles js and css if needed
if (get_option('contribution_user_profile_type') && plugin_is_active('UserProfiles')) {
    queue_js_file('admin-globals');
    queue_js_file('tinymce.min', 'javascripts/vendor/tinymce');
    queue_js_file('elements');
    queue_css_string("input.add-element {display: block}");
}

$head = array('title' => 'Contribute',
              'bodyclass' => 'contribution');
echo head($head); ?>
<script type="text/javascript">
// <![CDATA[
enableContributionAjaxForm( <?php echo js_escape(url($contributionPath.'/type-form')); ?> );
// ]]>
</script>


<div id="banner">
    <div class="container content"><br>
        <article>
            <h2><?php echo $head['title']; ?></h2>

        </article>
    </div>

</div>



<div class="container content">
    <div id="primary">
        <?php echo flash(); ?>

        <?php if (! ($user = current_user())
                  && !(get_option('contribution_open'))
                ):
        ?>
        <?php $session = new Zend_Session_Namespace();
                  $session->redirect = absolute_url();
            ?>
        <p>You must <a href='<?php echo url('guest-user/user/register'); ?>'>create an account</a> or <a href='<?php echo url('guest-user/user/login'); ?>'>log in</a> before contributing. You can still leave your identity to site visitors anonymous.</p>
        <?php else: ?>
        <form method="post" action="" enctype="multipart/form-data">
            <fieldset id="contribution-item-metadata">
                <div class="inputs">
                    <label for="contribution-type"><?php echo __("What type of item do you want to contribute?"); ?></label>
                    <?php $options = get_table_options('ContributionType'); ?>
                    <?php $typeId = isset($type) ? $type->id : '' ; ?>
                    <?php echo $this->formSelect('contribution_type', $typeId, array('multiple' => false, 'id' => 'contribution-type'), $options); ?>
                    <input type="submit" name="submit-type" id="submit-type" value="Select" />
                </div>
                <br>
                <div id="contribution-type-form">
                    <?php if (isset($type)) {
                include('type-form.php');
            }?>
                </div>
            </fieldset>

            <?php if (isset($captchaScript)): ?>
            <div id="captcha" class="inputs"><?php echo $captchaScript; ?></div>
            <?php endif; ?><br>

            <fieldset id="contribution-confirm-submit" <?php if (!isset($type)) {
                echo 'style="display: none;"';
            }?>>

                <div class="inputs">
                    <?php $public = isset($_POST['contribution-public']) ? $_POST['contribution-public'] : 0; ?>
                    <?php echo $this->formCheckbox('contribution-public', $public, null, array('1', '0')); ?>
                    <?php echo $this->formLabel('contribution-public', __('Publish my contribution on the web.')); ?>
                </div>
                <div class="inputs">
                    <?php $anonymous = isset($_POST['contribution-anonymous']) ? $_POST['contribution-anonymous'] : 0; ?>
                    <?php echo $this->formCheckbox('contribution-anonymous', $anonymous, null, array(1, 0)); ?>
                    <?php echo $this->formLabel('contribution-anonymous', __("Keep identity private.")); ?>
                </div>
                <!-- 	                <p><?php echo __("In order to contribute, you must read and agree to the %s", "<a href='" . contribution_contribute_url('terms') . "' target='_blank'>" . __('Terms and Conditions') . ".</a>"); ?></p> -->
                <div class="inputs">
                    <?php $agree = isset($_POST['terms-agree']) ? $_POST['terms-agree'] : 0 ?>
                    <?php echo $this->formCheckbox('terms-agree', $agree, null, array('1', '0')); ?>
                    <?php echo html_entity_decode($this->formLabel('terms-agree', __('I have read and agree to the %s', '<a href="' . contribution_contribute_url('terms') . '" target="_blank">Terms and Conditions</a>'))); ?>
                </div>
                <br><?php echo $this->formSubmit('form-submit', __('Contribute'), array('class' => 'submitinput button-primary')); ?>
            </fieldset>
            <?php echo $csrf; ?>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php echo foot();

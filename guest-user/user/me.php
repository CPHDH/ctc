<?php
$user = current_user();
$pageTitle =  get_option('guest_user_dashboard_label');
echo head(array('title' => $pageTitle));
?>
<div class="container content">
	<h2><?php echo $pageTitle; ?></h2>
	
	<?php echo flash(); ?>
	<!-- Original -->
	<!--
	<?php// foreach($widgets as $index=>$widget): ?>
	<div class='guest-user-widget <?php if($index & 1): ?>guest-user-widget-odd <?php else:?>guest-user-widget-even<?php endif;?>'>
	<?php// echo GuestUserPlugin::guestUserWidget($widget); ?>
	</div>
	<?php// endforeach; ?>
	-->
	<!-- End Original -->
	
	<!-- Custom -->
	<div class="display-table-vertical">
		<div class="trow"><span class="theading">Username: </span><span class="tval"><?php echo $user->username;?></span></div>
		<div class="trow"><span class="theading">Display Name: </span><span class="tval"><?php echo $user->name;?></span></div>
		<div class="trow"><span class="theading">Email: </span><span class="tval"><?php echo $user->email;?></span></div>
		<div class="trow"><span class="theading">Password: </span><span class="tval">&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</span></div>
	</div>
	<br>
	<div class="guest-user-account-buttons">
		<a class="button" href="<?php echo url('guest-user/user/update-account');?>">Update Account Settings</a><br>
		<a class="button" href="<?php echo contribution_contribute_url('my-contributions');?>">My Contributions</a><br>
		<a class="button button-primary" href="<?php echo contribution_contribute_url();?>">Contribute</a>
	</div>
	<!-- End Custom -->
	
</div>
<?php echo foot(); ?>

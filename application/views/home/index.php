<div class="jumbotron" text-align="center">
	<h1>Mahila PG College Bahraich</h1>

	<h3>College Management System</h3>

	<?php if (isset($current_user->email)) : ?>
		<a href="<?php echo site_url(SITE_AREA) ?>" class="btn btn-large btn-success">Go to Backend area</a>
	<?php else :?>
		<a href="<?php echo site_url(LOGIN_URL); ?>" class="btn btn-large btn-primary"><?php echo lang('bf_action_login'); ?></a>
	<?php endif;?>
</div>